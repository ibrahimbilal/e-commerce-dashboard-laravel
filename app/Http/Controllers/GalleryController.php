<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Support\IndexListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view gallery', ['only' => ['index']]);
        $this->middleware('permission:add gallery', ['only' => ['store']]);
        $this->middleware('permission:edit gallery', ['only' => ['update']]);
        $this->middleware('permission:delete gallery', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed', 'selected'];
        $filters = IndexListing::activeFilters($request, $filterKeys);

        $counts = [
            'all' => Gallery::query()->count(),
            'trashed' => Gallery::query()->onlyTrashed()->count(),
        ];

        $query = Gallery::query();

        if ($request->query('trashed') === '1') {
            $query->onlyTrashed();
        }

        if ($search = $request->query('search')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('url', 'like', '%'.$search.'%')
                    ->orWhere('title', 'like', '%'.$search.'%')
                    ->orWhere('alt', 'like', '%'.$search.'%');
            });
        }

        $galleries = $query->latest('id')->paginate(20)->withQueryString();

        $selectedGallery = null;
        if ($request->filled('selected')) {
            $selectedGallery = Gallery::query()->find($request->query('selected'));
        }

        return view('gallery.index', compact('galleries', 'counts', 'filters', 'selectedGallery'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['nullable', 'image', 'max:10240'],
            'files' => ['nullable', 'array'],
            'files.*' => ['image', 'max:10240'],
        ]);

        $uploads = [];
        if ($request->hasFile('file')) {
            $uploads[] = $request->file('file');
        }
        foreach ($request->file('files', []) as $uploaded) {
            if ($uploaded) {
                $uploads[] = $uploaded;
            }
        }

        if ($uploads === []) {
            return response()->json([
                'success' => false,
                'errors' => ['file' => ['No image file was uploaded.']],
            ], 422);
        }

        $created = [];
        foreach ($uploads as $file) {
            $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
            $relative = 'demo/gallery/'.$filename;
            $file->storeAs('demo/gallery', $filename, 'public');

            $gallery = Gallery::query()->create([
                'url' => $relative,
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'alt' => '',
                'metas' => [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ],
                'sizes_url' => null,
                'user_id' => (int) $request->user()->id,
            ]);

            $created[] = $gallery;
        }

        return response()->json([
            'success' => true,
            'items' => $created,
        ]);
    }

    public function update(Request $request, Gallery $gallery): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:191'],
            'alt' => ['nullable', 'string', 'max:191'],
        ]);

        $gallery->update([
            'title' => $data['title'] ?? $gallery->title,
            'alt' => $data['alt'] ?? $gallery->alt,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'gallery' => $gallery->fresh(),
            ]);
        }

        return redirect()
            ->route('gallery.index', ['selected' => $gallery->id])
            ->with('status', 'Gallery image updated.');
    }

    public function destroy(Request $request, Gallery $gallery): JsonResponse|RedirectResponse
    {
        $storagePath = 'public/'.$gallery->url;

        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        if (is_array($gallery->sizes_url)) {
            foreach ($gallery->sizes_url as $sizePath) {
                if (! is_string($sizePath) || $sizePath === '') {
                    continue;
                }

                $sizeStoragePath = str_starts_with($sizePath, 'public/')
                    ? $sizePath
                    : 'public/'.$sizePath;

                if (Storage::exists($sizeStoragePath)) {
                    Storage::delete($sizeStoragePath);
                }
            }
        }

        $gallery->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'title' => __('alerts.images.response.delete.title'),
                'text' => __('alerts.images.response.delete.text'),
            ]);
        }

        return redirect()
            ->back(302, [], route('gallery.index'))
            ->with('status', 'Image deleted.');
    }
}
