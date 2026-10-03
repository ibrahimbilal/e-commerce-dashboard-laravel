<?php

use App\Models\Setting;
use App\Support\AdminSettingDefaults;
use App\Support\ThemeColors;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $defaults = AdminSettingDefaults::themeColorDefaults();
        $legacy = AdminSettingDefaults::legacyThemeColorDefaults();

        foreach ($defaults as $key => $newValue) {
            $row = Setting::query()->where('setting_key', $key)->first();

            if ($row === null) {
                DB::table('settings')->insert([
                    'setting_key' => $key,
                    'setting_value' => $newValue,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                continue;
            }

            $stored = ThemeColors::normalizeHex((string) $row->setting_value);
            $legacyHex = isset($legacy[$key])
                ? ThemeColors::normalizeHex($legacy[$key])
                : null;

            if ($legacyHex !== null && $stored === $legacyHex) {
                DB::table('settings')
                    ->where('setting_key', $key)
                    ->update([
                        'setting_value' => $newValue,
                        'updated_at' => $now,
                    ]);
            }
        }

        ThemeColors::forgetCached();
    }

    public function down(): void
    {
        // Non-destructive: leave inserted/updated keys in place.
    }
};
