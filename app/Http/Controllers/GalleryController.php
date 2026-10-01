<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Support\IndexListing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view gallery', ['only' => ['index']]);
        $this->middleware('permission:delete gallery', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $filterKeys = ['search', 'trashed'];
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
            $query->where('url', 'like', '%'.$search.'%');
        }

        $galleries = $query->latest('id')->paginate(20)->withQueryString();

        return view('gallery.index', compact('galleries', 'counts', 'filters'));
    }

    public function destroy(Gallery $gallery): JsonResponse
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

        return response()->json([
            'success' => true,
            'title' => __('alerts.images.response.delete.title'),
            'text' => __('alerts.images.response.delete.text'),
        ]);
    }
}
