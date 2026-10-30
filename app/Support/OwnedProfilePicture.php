<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Deletes profile picture files this app owns (storage/users/*, storage/customers/*).
 * Gallery, external and any other values are never touched.
 */
class OwnedProfilePicture
{
    private const OWNED_PREFIXES = ['storage/users/', 'storage/customers/'];

    public static function isOwned(?string $storedValue): bool
    {
        if (! is_string($storedValue) || $storedValue === '' || str_contains($storedValue, '..') || str_contains($storedValue, '\\')) {
            return false;
        }

        foreach (self::OWNED_PREFIXES as $prefix) {
            if (str_starts_with($storedValue, $prefix) && strlen($storedValue) > strlen($prefix)) {
                return true;
            }
        }

        return false;
    }

    public static function delete(?string $storedValue): void
    {
        if (! self::isOwned($storedValue)) {
            return;
        }

        Storage::disk('public')->delete(substr($storedValue, strlen('storage/')));
    }
}
