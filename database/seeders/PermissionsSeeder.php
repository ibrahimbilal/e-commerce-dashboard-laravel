<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $sections = [
            'dashboard',
            'products',
            'attributes',
            'reviews',
            'categories',
            'tags',
            'discounts',
            'customers',
            'orders',
            'invoices',
            'addresses',
            'analytics',
            'marketing',
            'users',
            'roles',
            'gallery',
            'languages',
            'general_settings',
            'theme_settings',
            'store_settings',
            'currencies_settings',
            'emails_settings',
            'payment_settings',
        ];

        $permissions = [];

        foreach ($sections as $section) {
            $permissions[] = 'view '.$section;

            if (! in_array($section, [
                'dashboard',
                'analytics',
                'marketing',
                'roles',
                'general_settings',
                'theme_settings',
                'store_settings',
                'currencies_settings',
                'emails_settings',
                'payment_settings',
                'imports',
                'exports',
            ], true)) {
                $permissions[] = 'add '.$section;
                $permissions[] = 'edit '.$section;
                $permissions[] = 'delete '.$section;
                $permissions[] = 'permanently_delete '.$section;
                $permissions[] = 'restore '.$section;
            }

            if (in_array($section, [
                'general_settings',
                'theme_settings',
                'store_settings',
                'currencies_settings',
                'emails_settings',
                'payment_settings',
            ], true)) {
                $permissions[] = 'edit '.$section;
            }

            if ($section === 'roles') {
                $permissions[] = 'add '.$section;
                $permissions[] = 'edit '.$section;
                $permissions[] = 'permanently_delete '.$section;
            }
        }

        $permissions[] = 'imports';
        $permissions[] = 'exports';

        $permissions = array_values(array_unique($permissions));

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard,
        ]);

        $adminRole->syncPermissions(
            Permission::query()->where('guard_name', $guard)->pluck('name')
        );
    }
}
