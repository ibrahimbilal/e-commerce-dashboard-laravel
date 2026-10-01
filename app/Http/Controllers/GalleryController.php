<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view gallery', ['only' => ['index']]);
        $this->middleware('permission:delete gallery', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('gallery.index');
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
