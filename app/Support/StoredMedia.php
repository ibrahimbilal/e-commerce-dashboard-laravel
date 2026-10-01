<?php

namespace App\Support;

class StoredMedia
{
    /**
     * Path stored on the product/user record (web-relative, includes storage/ prefix).
     */
    public static function databasePath(string $publicDiskRelativePath): string
    {
        return 'storage/'.ltrim($publicDiskRelativePath, '/');
    }

    /**
     * Normalize a stored path and fix common corruption (double storage/, suffix after extension).
     */
    public static function normalizeStoredPath(?string $path): ?string
    {
        if ($path === null || trim($path) === '') {
            return null;
        }

        $path = trim(str_replace('\\', '/', $path));

        if (preg_match('/^(.+\.(?:png|jpe?g|gif|webp))-\d+$/i', $path, $matches)) {
            $path = $matches[1];
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $path = preg_replace('#^(?:storage/)+#', 'storage/', $path) ?? $path;

        if (! str_starts_with($path, 'storage/')) {
            $path = self::databasePath($path);
        }

        return $path;
    }

    public static function publicDiskRelativePath(?string $storedPath): ?string
    {
        $normalized = self::normalizeStoredPath($storedPath);

        if ($normalized === null) {
            return null;
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return null;
        }

        return ltrim(str_replace('storage/', '', $normalized), '/');
    }

    public static function publicUrl(?string $storedPath): ?string
    {
        $normalized = self::normalizeStoredPath($storedPath);

        if ($normalized === null) {
            return null;
        }

        if (str_starts_with($normalized, 'http://') || str_starts_with($normalized, 'https://')) {
            return $normalized;
        }

        return asset($normalized);
    }

    public static function hasValidImageExtension(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return (bool) preg_match('/\.(?:png|jpe?g|gif|webp)$/i', $path);
    }
}
