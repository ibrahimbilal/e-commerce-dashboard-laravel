<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            LangSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            SettingsSeeder::class,
            AdminAvatarSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
