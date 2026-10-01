<?php

namespace App\Support;

class ProductImage
{
    public static function url(?string $path): ?string
    {
        return StoredMedia::publicUrl($path);
    }

    public static function normalizeStoredPath(?string $path): ?string
    {
        return StoredMedia::normalizeStoredPath($path);
    }
}
