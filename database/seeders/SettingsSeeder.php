<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
			'site_title' => 'Admin Panel',
			'tagline' => 'Site Tagline',
			'site_description' => 'In A Few Words, Explain What This Site Is About.',
			'site_url' => 'http://localhost',
			'timezone' => 'Europe/Amsterdam',
			'date_formate' => 'F j, Y',
			'time_formate' => 'g:i A',
			'time_formate_custom' => '',
			'date_formate_custom' => '',
		];

		foreach( $settings as $key => $value ) {
			Setting::create(['setting_key' => $key, 'setting_value' => $value]);
		}
    }
}
