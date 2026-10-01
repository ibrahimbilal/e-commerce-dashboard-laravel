<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    public function run(): void
    {
        Lang::query()->updateOrCreate(
            ['id' => 1],
            [
                'code' => 'en',
                'name' => 'English',
                'direction' => 'ltr',
                'active' => true,
            ]
        );
    }
}
