<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            LangSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StaffUserSeeder::class,
            SettingsSeeder::class,
            AdminAvatarSeeder::class,
            DemoDataSeeder::class,
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
