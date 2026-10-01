<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Support\IndexListing;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view tags', ['only' => ['index', 'show']]);
        $this->middleware('permission:add tags', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit tags', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete tags', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Tag::query()->count(),
            'trashed' => Tag::query()->onlyTrashed()->count(),
        ];

        $query = Tag::with(['parent'])->withCount('products');

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('tag_slug', 'like', '%'.$search.'%');
            });
        }

        $tags = $query->latest('id')->get();

        return view('tags.index', compact('tags', 'counts', 'filters'));
    }

    public function create()
    {
        $parents = Tag::orderBy('title')->get();

        return view('tags.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'tag_slug' => ['nullable', 'string', 'max:191'],
            'parent_id' => ['nullable', 'integer', 'exists:tags,id'],
            'locale' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_keywords' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:191'],
            'deleted' => ['sometimes', 'boolean'],
        ]);

        Tag::create($data);

        return redirect()->route('tags.index')->with('status', 'Tag created.');
    }

    public function show(Tag $tag)
    {
        $tag->load(['parent', 'children', 'products.locales']);

        return view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        $parents = Tag::whereKeyNot($tag->id)->orderBy('title')->get();

        return view('tags.edit', compact('tag', 'parents'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'tag_slug' => ['nullable', 'string', 'max:191'],
            'parent_id' => ['nullable', 'integer', 'exists:tags,id'],
            'locale' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:191'],
            'meta_keywords' => ['nullable', 'string', 'max:191'],
            'meta_description' => ['nullable', 'string', 'max:191'],
            'deleted' => ['sometimes', 'boolean'],
        ]);

        $tag->update($data);

        return redirect()->route('tags.index')->with('status', 'Tag updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')->with('status', 'Tag deleted.');
    }
}
