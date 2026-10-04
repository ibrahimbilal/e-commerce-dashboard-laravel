<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Lang;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Tag;
use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Http\Controllers\Concerns\TogglesAdminResourceFields;
use App\Support\AdminFormResponse;
use App\Support\AdminResourceCounts;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use App\Support\StoredMediaCleanup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    use ManagesTrashedRecords;
    use TogglesAdminResourceFields;

    public function __construct()
    {
        $this->middleware('permission:view products', ['only' => ['index']]);
        $this->middleware('permission:add products', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit products', ['only' => ['edit', 'update', 'toggle']]);
        $this->middleware('permission:delete products', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('products');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'status', 'trashed', 'featured', 'new', 'sale'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Product::query()->count(),
            'published' => Product::query()->where('status', 'published')->count(),
            'draft' => Product::query()->where('status', 'draft')->count(),
            'trashed' => Product::query()->onlyTrashed()->count(),
            'featured' => Product::query()->where('featured', true)->count(),
            'new' => Product::query()->where('new', true)->count(),
            'sale' => Product::query()
                ->whereNotNull('sale_price')
                ->whereColumn('sale_price', '<', 'regular_price')
                ->count(),
        ];

        $query = Product::with(['locales', 'categories', 'tags']);

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($request->query('featured') === '1') {
            $query->where('featured', true);
        }

        if ($request->query('new') === '1') {
            $query->where('new', true);
        }

        if ($request->query('sale') === '1') {
            $query->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'regular_price');
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('sku', 'like', '%'.$search.'%')
                    ->orWhereHas('locales', fn ($localeQuery) => $localeQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('product_slug', 'like', '%'.$search.'%'));
            });
        }

        $products = $query->latest('id')->get();

        return view('admin.products.index', compact('products', 'counts', 'filters'));
    }

    public function create()
    {
        return view('admin.products.create', $this->productFormLookups());
    }

    public function store(Request $request)
    {
        $validated = $this->validateProductRequest($request);

        $product = DB::transaction(function () use ($request, $validated) {
            $product = Product::create($this->productDataFromValidated($request, $validated, null));
            $this->applyProductRelations($product, $request, $validated);

            return $product;
        });

        return AdminFormResponse::saved(
            $request,
            'Product created.',
            fn () => redirect()->route('admin.products.edit', $product)
        );
    }

    public function show(Product $product)
    {
        $product->load(['locales', 'categories', 'tags', 'productAttributes.attributeOne', 'productAttributes.attributeTwo', 'reviews.customer']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['locales', 'categories', 'tags', 'productAttributes']);

        return view('admin.products.edit', array_merge(
            compact('product'),
            $this->productFormLookups()
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProductRequest($request);

        DB::transaction(function () use ($request, $product, $validated) {
            $product->update($this->productDataFromValidated($request, $validated, $product));
            $this->applyProductRelations($product, $request, $validated);
        });

        return AdminFormResponse::saved(
            $request,
            'Product updated.',
            fn () => redirect()->route('admin.products.edit', $product)
        );
    }

    public function destroy(Request $request, Product $product)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $product,
            'Cannot delete this product because it appears on order line items.'
        )) {
            return $blocked;
        }

        $product->delete();

        return $this->destroyActionResponse(
            $request,
            'admin.products.index',
            'Product deleted.',
            AdminResourceCounts::products()
        );
    }

    public function restore(Request $request, int $id)
    {
        $product = $this->findOnlyTrashed(Product::class, $id);
        $product->restore();

        return $this->trashedActionResponse(
            $request,
            'admin.products.index',
            'Product restored.',
            AdminResourceCounts::products()
        );
    }

    public function toggle(Request $request, int $id)
    {
        $product = Product::query()->findOrFail($id);

        return $this->toggleResourceField(
            $request,
            $product,
            AdminResourceCounts::toggleFieldWhitelist()['products'],
            fn () => AdminResourceCounts::products(),
            'admin.products.index'
        );
    }

    public function forceDelete(Request $request, int $id)
    {
        $product = $this->findOnlyTrashed(Product::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $product,
            'Cannot permanently delete this product because it appears on order line items.'
        )) {
            return $blocked;
        }

        StoredMediaCleanup::deleteProductImage($product);
        $product->forceDelete();

        return $this->trashedActionResponse(
            $request,
            'admin.products.index',
            'Product permanently deleted.',
            AdminResourceCounts::products()
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function productFormLookups(): array
    {
        return [
            'categories' => Category::with(['children.children'])
                ->whereNull('parent_id')
                ->orderBy('title')
                ->get(),
            'tags' => Tag::orderBy('title')->get(),
            'attributeList' => Attribute::orderBy('attribute_key')->orderBy('attribute_value')->get(),
            'langs' => Lang::query()->where('active', true)->orderBy('id')->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validateProductRequest(Request $request): array
    {
        return $request->validate(
            [
                'sku' => ['nullable', 'string'],
                'product_sku' => ['nullable', 'string'],
                'product_img' => ['nullable', 'string', 'max:191'],
                'regular_price' => ['required', 'numeric', 'min:0'],
                'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:regular_price'],
                'schedule_sale' => ['nullable', 'date'],
                'last_sale_date' => ['nullable', 'date', 'after_or_equal:schedule_sale'],
                'quantity' => ['nullable', 'integer', 'min:0'],
                'product_quantity' => ['nullable', 'integer', 'min:0'],
                'status' => ['nullable', 'string', Rule::in(['published', 'draft'])],
                'new' => ['sometimes', 'boolean'],
                'featured' => ['sometimes', 'boolean'],
                'category_ids' => ['required', 'array', 'min:1'],
                'category_ids.*' => ['integer', 'exists:categories,id'],
                'tag_ids' => ['nullable', 'array'],
                'tag_ids.*' => ['integer', 'exists:tags,id'],
                'product_tags' => ['nullable', 'array'],
                'product_tags.*' => ['integer', 'exists:tags,id'],
                'locales' => ['nullable', 'array'],
                'locales.*.name' => ['nullable', 'string', 'max:100'],
                'locales.*.description' => ['nullable', 'string'],
                'locales.*.product_slug' => ['nullable', 'string', 'max:191'],
                'locales.*.meta_title' => ['nullable', 'string', 'max:191'],
                'locales.*.meta_keywords' => ['nullable', 'string', 'max:191'],
                'locales.*.meta_description' => ['nullable', 'string', 'max:191'],
                'product_name' => ['required', 'string', 'max:100'],
                'product_slug' => ['nullable', 'string', 'max:191'],
                'description' => ['nullable', 'string'],
                'meta_title' => ['nullable', 'string', 'max:191'],
                'meta_keywords' => ['nullable', 'string', 'max:191'],
                'meta_description' => ['nullable', 'string', 'max:191'],
                'langs' => ['nullable', 'string', 'max:10'],
                'product_attributes' => ['nullable', 'array'],
                'product_attributes.*.id' => ['nullable', 'integer', 'exists:products_attributes,id'],
                'product_attributes.*.attribute_1_id' => ['required_with:product_attributes', 'integer', 'exists:attributes,id'],
                'product_attributes.*.attribute_2_id' => ['required_with:product_attributes', 'integer', 'exists:attributes,id'],
            ],
            [],
            $this->productValidationAttributeNames()
        );
    }

    /**
     * @return array<string, string>
     */
    private function productValidationAttributeNames(): array
    {
        return [
            'product_name' => __('validation.attributes.product_name'),
            'regular_price' => __('validation.attributes.regular_price'),
            'sale_price' => __('validation.attributes.sale_price'),
            'schedule_sale' => __('validation.attributes.schedule_sale'),
            'last_sale_date' => __('validation.attributes.last_sale_date'),
            'quantity' => __('validation.attributes.quantity'),
            'product_quantity' => __('validation.attributes.product_quantity'),
            'sku' => __('validation.attributes.sku'),
            'product_sku' => __('validation.attributes.product_sku'),
            'status' => __('validation.attributes.status'),
            'category_ids' => __('validation.attributes.category_ids'),
            'tag_ids' => __('validation.attributes.tag_ids'),
            'product_tags' => __('validation.attributes.product_tags'),
            'product_img' => __('validation.attributes.product_img'),
            'description' => __('validation.attributes.product_description'),
            'product_slug' => __('validation.attributes.product_slug'),
            'meta_title' => __('validation.attributes.meta_title'),
            'meta_keywords' => __('validation.attributes.meta_keywords'),
            'meta_description' => __('validation.attributes.meta_description'),
            'product_attributes.*.attribute_1_id' => __('validation.attributes.product_attribute_1'),
            'product_attributes.*.attribute_2_id' => __('validation.attributes.product_attribute_2'),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function productDataFromValidated(Request $request, array $validated, ?Product $existingProduct = null): array
    {
        if ($request->filled('status')) {
            $status = $validated['status'];
        } elseif ($existingProduct !== null) {
            $status = $existingProduct->status;
        } else {
            $status = 'draft';
        }

        return [
            'sku' => $validated['sku'] ?? $validated['product_sku'] ?? '',
            'product_img' => $validated['product_img'] ?? null,
            'regular_price' => $validated['regular_price'] ?? null,
            'sale_price' => $validated['sale_price'] ?? null,
            'schedule_sale' => $validated['schedule_sale'] ?? $validated['last_sale_date'] ?? null,
            'quantity' => $validated['quantity'] ?? $validated['product_quantity'] ?? 0,
            'status' => $status,
            'new' => $request->boolean('new'),
            'featured' => $request->boolean('featured'),
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function applyProductRelations(Product $product, Request $request, array $validated): void
    {
        if ($request->has('category_ids')) {
            $product->categories()->sync($request->input('category_ids', []));
        }

        if ($request->has('tag_ids') || $request->has('product_tags')) {
            $tagIds = $request->input('tag_ids', $request->input('product_tags', []));
            $product->tags()->sync($tagIds);
        }

        $locales = $request->input('locales', []);
        $activeLocale = $request->input('langs');

        if ($activeLocale) {
            $locales[$activeLocale] = array_merge($locales[$activeLocale] ?? [], array_filter([
                'name' => $request->input('product_name'),
                'description' => $request->input('description'),
                'product_slug' => $request->input('product_slug'),
                'meta_title' => $request->input('meta_title'),
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
            ], fn ($value) => $value !== null && $value !== ''));
        }

        foreach ($locales as $localeCode => $localeData) {
            if (! is_array($localeData)) {
                continue;
            }

            $payload = array_filter([
                'name' => $localeData['name'] ?? null,
                'description' => $localeData['description'] ?? null,
                'product_slug' => $localeData['product_slug'] ?? null,
                'meta_title' => $localeData['meta_title'] ?? null,
                'meta_keywords' => $localeData['meta_keywords'] ?? null,
                'meta_description' => $localeData['meta_description'] ?? null,
            ], fn ($value) => $value !== null && $value !== '');

            if ($payload === [] || empty($payload['name'])) {
                continue;
            }

            $locale = substr((string) $localeCode, 0, 10);

            DB::table('product_locales')->updateOrInsert(
                [
                    'product_id' => $product->id,
                    'locale' => $locale,
                ],
                $payload
            );
        }

        if ($request->has('product_attributes')) {
            $this->syncProductAttributes($product, $request->input('product_attributes', []));
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     */
    private function syncProductAttributes(Product $product, array $rows): void
    {
        $keepIds = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            if (! empty($row['id'])) {
                $existing = ProductAttribute::query()
                    ->where('product_id', $product->id)
                    ->whereKey($row['id'])
                    ->first();

                if ($existing) {
                    $existing->update([
                        'attribute_1_id' => $row['attribute_1_id'],
                        'attribute_2_id' => $row['attribute_2_id'],
                    ]);
                    $keepIds[] = $existing->id;

                    continue;
                }
            }

            $created = $product->productAttributes()->create([
                'attribute_1_id' => $row['attribute_1_id'],
                'attribute_2_id' => $row['attribute_2_id'],
            ]);
            $keepIds[] = $created->id;
        }

        $deleteQuery = $product->productAttributes();

        if ($keepIds !== []) {
            $deleteQuery->whereNotIn('id', $keepIds);
        }

        $idsToDelete = $deleteQuery->pluck('id');

        if ($idsToDelete->isNotEmpty() && OrderItem::query()->whereIn('product_attribute_id', $idsToDelete)->exists()) {
            throw ValidationException::withMessages([
                'product_attributes' => ['One or more variants are used on existing orders and cannot be removed.'],
            ]);
        }

        if ($keepIds === []) {
            $product->productAttributes()->delete();

            return;
        }

        $product->productAttributes()->whereNotIn('id', $keepIds)->delete();
    }
}
