<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Concerns\ManagesTrashedRecords;
use App\Models\Category;
use App\Support\IndexListing;
use App\Support\ReferentialDeleteGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    use ManagesTrashedRecords;

    public function __construct()
    {
        $this->middleware('permission:view categories', ['only' => ['index']]);
        $this->middleware('permission:add categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete categories', ['only' => ['destroy']]);
        $this->registerTrashedMiddleware('categories');
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'active'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Category::query()->count(),
            'active' => Category::query()->where('active', true)->count(),
            'inactive' => Category::query()->where('active', false)->count(),
            'trashed' => Category::query()->onlyTrashed()->count(),
        ];

        $query = Category::with(['parent', 'children'])->withCount('products');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($request->has('active')) {
            $query->where('active', $request->query('active') === '1');
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('category_slug', 'like', '%'.$search.'%');
            });
        }

        $categories = $query->latest('id')->get();

        return view('categories.index', compact('categories', 'counts', 'filters'));
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

        $this->assertValidCategoryParent(null, $data['parent_id'] ?? null);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'admin.products.locales']);

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

        $this->assertValidCategoryParent($category->id, $data['parent_id'] ?? null);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Request $request, Category $category)
    {
        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $category,
            'Cannot delete this category while products are assigned to it.'
        )) {
            return $blocked;
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category deleted.');
    }

    public function restore(Request $request, int $id)
    {
        $category = $this->findOnlyTrashed(Category::class, $id);
        $category->restore();

        return $this->trashedActionResponse($request, 'admin.categories.index', 'Category restored.');
    }

    public function forceDelete(Request $request, int $id)
    {
        $category = $this->findOnlyTrashed(Category::class, $id);

        if ($blocked = ReferentialDeleteGuard::blockIfInUse(
            $request,
            $category,
            'Cannot permanently delete this category while products are assigned to it.'
        )) {
            return $blocked;
        }

        $category->forceDelete();

        return $this->trashedActionResponse($request, 'admin.categories.index', 'Category permanently deleted.');
    }

    private function assertValidCategoryParent(?int $categoryId, ?int $parentId): void
    {
        if (! $parentId) {
            return;
        }

        if ($categoryId !== null && $parentId === $categoryId) {
            throw ValidationException::withMessages([
                'parent_id' => ['A category cannot be its own parent.'],
            ]);
        }

        if ($categoryId !== null && in_array($parentId, $this->categoryDescendantIds($categoryId), true)) {
            throw ValidationException::withMessages([
                'parent_id' => ['A category cannot be placed under one of its descendants.'],
            ]);
        }
    }

    /**
     * @return array<int, int>
     */
    private function categoryDescendantIds(int $categoryId): array
    {
        $ids = [];
        $queue = Category::query()->where('parent_id', $categoryId)->pluck('id')->all();

        while ($queue !== []) {
            $childId = array_shift($queue);
            $ids[] = $childId;
            $queue = array_merge(
                $queue,
                Category::query()->where('parent_id', $childId)->pluck('id')->all()
            );
        }

        return $ids;
    }
}
