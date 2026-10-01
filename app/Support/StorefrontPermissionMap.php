<?php

namespace App\Support;

class StorefrontPermissionMap
{
    /** @var array<string, string> */
    private const PREFIX_TO_SECTION = [
        'prod' => 'products',
        'attr' => 'attributes',
        'rev' => 'reviews',
        'cat' => 'categories',
        'tag' => 'tags',
        'disc' => 'discounts',
        'cust' => 'customers',
        'ord' => 'orders',
        'inv' => 'invoices',
        'anly' => 'analytics',
        'mkt' => 'marketing',
        'usr' => 'users',
        'role' => 'roles',
        'gal' => 'gallery',
        'lang' => 'languages',
        'set' => 'general_settings',
        'addr' => 'addresses',
    ];

    /** @var array<string, string> */
    private const ACTION_TO_VERB = [
        'view' => 'view',
        'edit' => 'edit',
        'create' => 'add',
        'del' => 'delete',
    ];

    /**
     * @param  array<int, string>  $slugsOrNames
     * @return array<int, string>
     */
    public static function toPermissionNames(array $slugsOrNames): array
    {
        return collect($slugsOrNames)
            ->map(fn (string $value) => self::slugToPermissionName($value) ?? $value)
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public static function slugToPermissionName(string $slug): ?string
    {
        if (str_contains($slug, ' ')) {
            return $slug;
        }

        if (! str_contains($slug, '_')) {
            return null;
        }

        [$prefix, $action] = explode('_', $slug, 2);
        $section = self::PREFIX_TO_SECTION[$prefix] ?? null;
        $verb = self::ACTION_TO_VERB[$action] ?? null;

        if (! $section || ! $verb) {
            return null;
        }

        return $verb.' '.$section;
    }

    /**
     * @param  array<int, string>  $permissionNames
     * @return array<int, string>
     */
    public static function toSlugs(array $permissionNames): array
    {
        return collect($permissionNames)
            ->map(fn (string $name) => self::permissionNameToSlug($name))
            ->filter()
            ->values()
            ->all();
    }

    public static function permissionNameToSlug(string $name): ?string
    {
        $parts = explode(' ', $name, 2);
        if (count($parts) !== 2) {
            return null;
        }

        [$verb, $section] = $parts;
        $prefix = array_search($section, self::PREFIX_TO_SECTION, true);
        $action = array_search($verb, self::ACTION_TO_VERB, true);

        if ($prefix === false || $action === false) {
            return null;
        }

        return $prefix.'_'.$action;
    }
}
