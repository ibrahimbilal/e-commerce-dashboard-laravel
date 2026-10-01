<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductLocale;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
        $product = Product::create($this->productAttributesFromRequest($request));

        $this->syncProductRelations($product, $request);

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
        $product->update($this->productAttributesFromRequest($request));

        $this->syncProductRelations($product, $request);

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
            'attributes' => Attribute::orderBy('attribute_key')->orderBy('attribute_value')->get(),
            'langs' => Lang::query()->where('active', true)->orderBy('id')->get(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function productAttributesFromRequest(Request $request): array
    {
        $validated = $request->validate([
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
        ]);

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

    private function syncProductRelations(Product $product, Request $request): void
    {
        $request->validate([
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
        ]);

        $categoryIds = $request->input('category_ids', []);
        $product->categories()->sync($categoryIds);

        $tagIds = $request->input('tag_ids', $request->input('product_tags', []));
        $product->tags()->sync($tagIds);

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

            if ($payload === []) {
                continue;
            }

            if (empty($payload['name'])) {
                continue;
            }

            ProductLocale::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'locale' => substr((string) $localeCode, 0, 10),
                ],
                $payload
            );
        }
    }
}
