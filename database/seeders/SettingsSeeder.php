<?php

namespace Database\Seeders;

use App\Support\AdminSettingDefaults;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        AdminSettingDefaults::persistMissing();
    }
}
