<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Lang;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view products', ['only' => ['index']]);
        $this->middleware('permission:add products', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit products', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete products', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = Product::with(['locales', 'categories', 'tags'])
            ->latest('id')
            ->paginate(20);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', $this->productFormLookups());
    }

    public function store(Request $request)
    {
        $validated = $this->validateProductRequest($request);

        $product = DB::transaction(function () use ($request, $validated) {
            $product = Product::create($this->productDataFromValidated($request, $validated));
            $this->applyProductRelations($product, $request, $validated);

            return $product;
        });

        return redirect()->route('products.edit', $product)->with('status', 'Product created.');
    }

    public function show(Product $product)
    {
        $product->load(['locales', 'categories', 'tags', 'productAttributes.attributeOne', 'productAttributes.attributeTwo', 'reviews.customer']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['locales', 'categories', 'tags', 'productAttributes']);

        return view('products.edit', array_merge(
            compact('product'),
            $this->productFormLookups()
        ));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProductRequest($request);

        DB::transaction(function () use ($request, $product, $validated) {
            $product->update($this->productDataFromValidated($request, $validated));
            $this->applyProductRelations($product, $request, $validated);
        });

        return redirect()->route('products.edit', $product)->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product deleted.');
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
        return $request->validate([
            'sku' => ['nullable', 'string'],
            'product_sku' => ['nullable', 'string'],
            'product_img' => ['nullable', 'string', 'max:191'],
            'regular_price' => ['nullable', 'integer'],
            'sale_price' => ['nullable', 'integer'],
            'schedule_sale' => ['nullable', 'string', 'max:191'],
            'last_sale_date' => ['nullable', 'string', 'max:191'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'product_quantity' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:191'],
            'new' => ['sometimes', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
            'category_ids' => ['nullable', 'array'],
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
            'product_name' => ['nullable', 'string', 'max:100'],
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
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function productDataFromValidated(Request $request, array $validated): array
    {
        return [
            'sku' => $validated['sku'] ?? $validated['product_sku'] ?? '',
            'product_img' => $validated['product_img'] ?? null,
            'regular_price' => $validated['regular_price'] ?? null,
            'sale_price' => $validated['sale_price'] ?? null,
            'schedule_sale' => $validated['schedule_sale'] ?? $validated['last_sale_date'] ?? null,
            'quantity' => $validated['quantity'] ?? $validated['product_quantity'] ?? 0,
            'status' => $validated['status'] ?? null,
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
