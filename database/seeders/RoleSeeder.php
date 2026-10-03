<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => $guard]);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => $guard]);

        $managerPermissions = Permission::query()
            ->where('guard_name', $guard)
            ->where(function ($query) {
                $query->where('name', 'like', 'view %')
                    ->orWhere('name', 'like', 'add %')
                    ->orWhere('name', 'like', 'edit %')
                    ->orWhere('name', 'like', 'restore %');
            })
            ->where('name', 'not like', 'permanently_delete %')
            ->whereNotIn('name', [
                'view roles',
                'add roles',
                'edit roles',
                'add users',
                'edit users',
                'delete users',
                'permanently_delete users',
                'restore users',
            ])
            ->pluck('name');

        $manager->syncPermissions($managerPermissions);

        $viewerPermissions = Permission::query()
            ->where('guard_name', $guard)
            ->where('name', 'like', 'view %')
            ->pluck('name');

        $viewer->syncPermissions($viewerPermissions);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
