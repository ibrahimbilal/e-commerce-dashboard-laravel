<?php

use App\Models\Setting;
use App\Support\AdminSettingDefaults;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Setting::query()->where('setting_key', 'mobile_logo_height')->exists()) {
            return;
        }

        $now = now();

        DB::table('settings')->insert([
            'setting_key' => 'mobile_logo_height',
            'setting_value' => AdminSettingDefaults::theme()['mobile_logo_height'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        // Non-destructive: leave inserted key in place.
    }
};
