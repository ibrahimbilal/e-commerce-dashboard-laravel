<?php

namespace App\Support;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StoredMediaCleanup
{
    public static function deleteProductImage(?Product $product): void
    {
        if (! $product) {
            return;
        }

        $relative = StoredMedia::publicDiskRelativePath($product->product_img);

        if ($relative && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }

    public static function deleteUserAvatar(?User $user): void
    {
        if (! $user) {
            return;
        }

        $relative = StoredMedia::publicDiskRelativePath($user->profile_picture);

        if ($relative && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }

    public static function deleteGalleryFiles(?Gallery $gallery): void
    {
        if (! $gallery) {
            return;
        }

        $storagePath = 'public/'.$gallery->url;

        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        if (! is_array($gallery->sizes_url)) {
            return;
        }

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
}
