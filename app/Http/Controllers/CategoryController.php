<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->latest('id')
            ->paginate(20);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('title')->get();

        return view('categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:150'],
            'category_slug' => ['nullable', 'string', 'max:191'],
            'cat_img' => ['nullable', 'string', 'max:191'],
            'active' => ['sometimes', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'locale' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_keywords' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:191'],
            'deleted' => ['sometimes', 'boolean'],
        ]);

        $category = Category::create($data);

        return redirect()->route('categories.show', $category)->with('status', 'Category created.');
    }

    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products.locales']);

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = Category::whereKeyNot($category->id)->orderBy('title')->get();

        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:150'],
            'category_slug' => ['nullable', 'string', 'max:191'],
            'cat_img' => ['nullable', 'string', 'max:191'],
            'active' => ['sometimes', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'locale' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_keywords' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:191'],
            'deleted' => ['sometimes', 'boolean'],
        ]);

        $category->update($data);

        return redirect()->route('categories.show', $category)->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted.');
    }
}
