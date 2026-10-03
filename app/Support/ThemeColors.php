<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ThemeColors
{
    public const CACHE_KEY = 'admin.theme_css_variables';

    /**
     * @return array{light: array<string, string>, dark: array<string, string>}
     */
    public static function cssVariables(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::buildCssVariables(self::resolvedColorSettings());
        });
    }

    public static function forgetCached(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return array<string, string>
     */
    private static function resolvedColorSettings(): array
    {
        $defaults = AdminSettingDefaults::themeColorDefaults();
        $keys = array_keys($defaults);

        $loaded = Setting::query()
            ->whereIn('setting_key', $keys)
            ->pluck('setting_value', 'setting_key')
            ->all();

        $merged = [];

        foreach ($defaults as $key => $defaultHex) {
            $raw = array_key_exists($key, $loaded) ? (string) $loaded[$key] : $defaultHex;
            $merged[$key] = self::normalizeHex($raw) ?? $defaultHex;
        }

        return $merged;
    }

    /**
     * @param  array<string, string>  $settingsByKey
     * @return array{light: array<string, string>, dark: array<string, string>}
     */
    private static function buildCssVariables(array $settingsByKey): array
    {
        $map = AdminSettingDefaults::themeColorKeyToCssVariableMap();
        $light = [];
        $dark = [];

        foreach ($settingsByKey as $key => $hex) {
            if (! isset($map[$key])) {
                continue;
            }

            $variable = $map[$key];
            $normalized = self::normalizeHex($hex) ?? $hex;

            if (str_starts_with($key, 'dark_')) {
                $dark[$variable] = $normalized;
            } else {
                $light[$variable] = $normalized;
            }
        }

        return [
            'light' => $light,
            'dark' => $dark,
        ];
    }

    public static function normalizeHex(string $value): ?string
    {
        $value = trim($value);

        if (! preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $value, $matches)) {
            return null;
        }

        $hex = $matches[1];

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return '#'.strtoupper($hex);
    }
}
