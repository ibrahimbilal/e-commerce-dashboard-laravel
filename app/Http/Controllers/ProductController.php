<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => ['required', 'string'],
            'product_img' => ['nullable', 'string', 'max:191'],
            'regular_price' => ['nullable', 'integer'],
            'sale_price' => ['nullable', 'integer'],
            'schedule_sale' => ['nullable', 'string', 'max:191'],
            'quantity' => ['required', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:191'],
            'new' => ['sometimes', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
        ]);

        $product = Product::create($data);

        return redirect()->route('products.show', $product)->with('status', 'Product created.');
    }

    public function show(Product $product)
    {
        $product->load(['locales', 'categories', 'tags', 'productAttributes.attributeOne', 'productAttributes.attributeTwo', 'reviews.customer']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['locales', 'categories', 'tags']);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku' => ['required', 'string'],
            'product_img' => ['nullable', 'string', 'max:191'],
            'regular_price' => ['nullable', 'integer'],
            'sale_price' => ['nullable', 'integer'],
            'schedule_sale' => ['nullable', 'string', 'max:191'],
            'quantity' => ['required', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:191'],
            'new' => ['sometimes', 'boolean'],
            'featured' => ['sometimes', 'boolean'],
        ]);

        $product->update($data);

        return redirect()->route('products.show', $product)->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product deleted.');
    }
}
