<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class AdminSettingDefaults
{
    /**
     * @return array<string, string>
     */
    public static function all(): array
    {
        return array_merge(
            self::general(),
            self::theme(),
            self::email(),
            self::store(),
            self::currency(),
        );
    }

    /**
     * @return array<string, string>
     */
    public static function general(): array
    {
        return [
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
    }

    /**
     * @return array<string, string>
     */
    public static function theme(): array
    {
        return [
            'logo' => '',
            'dark_logo' => '',
            'logo_width' => '120',
            'logo_height' => '40',
            'mobile_logo' => '',
            'dark_mobile_logo' => '',
            'mobile_logo_width' => '80',
            'mobile_logo_height' => '30',
            'main_color' => '#2C2CCC',
            'main_color_hover' => '#2323A2',
            'box_bg_color' => '#FFFFFF',
            'body_background' => '#F5F5F5',
            'menu_badge_bg' => '#FF9F43',
            'menu_active_bg' => '#F3F3FF',
            'text_color' => '#333333',
            'dark_main_color' => '#675AD0',
            'dark_main_color_hover' => '#877BE6',
            'dark_box_bg_color' => '#1D1D1D',
            'dark_body_background' => '#121212',
            'dark_menu_badge_bg' => '#FF9F43',
            'dark_menu_active_bg' => '#3C3C3C',
            'dark_text_color' => '#E1E1E1',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function email(): array
    {
        return [
            'email_from_name' => 'Admin Panel',
            'email_from_address' => 'hello@example.com',
            'email_main_color' => '#2C2CCC',
            'email_bg_color' => '#F7F7F7',
            'email_body_bg_color' => '#FFFFFF',
            'email_text_color' => '#333333',
            'email_new_order' => '',
            'new_order_recipients_type' => '',
            'new_order_recipients' => '',
            'email_out_of_stock' => '',
            'out_of_stock_recipients_type' => '',
            'out_of_stock_recipients' => '',
            'email_order_canceled' => '',
            'order_canceled_recipients_type' => '',
            'order_canceled_recipients' => '',
            'email_order_confirmed' => '',
            'email_order_shipped' => '',
            'email_order_completed' => '',
            'email_order_refunded' => '',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function store(): array
    {
        return [
            'country' => '',
            'state' => '',
            'city' => '',
            'address_1' => '',
            'address_2' => '',
            'postcode' => '',
            'reviews' => '',
            'guest_reviews' => '',
            'guest_checkout' => '',
            'wishlist' => '',
            'compare' => '',
            'out_of_stock_products' => '',
            'social_share' => '',
            'share_on' => '',
            'recently_viewed' => '',
            'recommend' => '',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function currency(): array
    {
        return [
            'main_currency' => 'USD',
            'currency_position' => 'left',
            'thousand_sep' => ',',
            'decimal_sep' => '.',
            'num_decimals' => '2',
            'enable_multi_currencies' => '',
            'currencies_display' => '',
            'multi_currencies' => '',
        ];
    }

    /**
     * @param  array<string, mixed>  $loaded
     * @param  array<int, string>  $keys
     * @return array<string, mixed>
     */
    public static function mergeLoaded(array $loaded, array $keys): array
    {
        $defaults = self::all();
        $merged = [];

        foreach ($keys as $key) {
            $merged[$key] = array_key_exists($key, $loaded)
                ? $loaded[$key]
                : ($defaults[$key] ?? '');
        }

        return array_merge($loaded, $merged);
    }

    /**
     * @param  array<int, string>  $keys
     * @return array<int, string>
     */
    public static function emailPageKeys(): array
    {
        return array_keys(self::email());
    }

    /**
     * @param  array<int, string>  $keys
     * @return array<int, string>
     */
    public static function themePageKeys(): array
    {
        return array_keys(self::theme());
    }

    /**
     * @return array<int, string>
     */
    public static function emailRecipientKeys(): array
    {
        return [
            'new_order_recipients_type',
            'new_order_recipients',
            'out_of_stock_recipients_type',
            'out_of_stock_recipients',
            'order_canceled_recipients_type',
            'order_canceled_recipients',
        ];
    }

    /**
     * @return array<string, string> setting_key => default #RRGGBB
     */
    public static function themeColorDefaults(): array
    {
        return array_intersect_key(
            self::theme(),
            array_flip(array_keys(self::themeColorKeyToCssVariableMap()))
        );
    }

    /**
     * @return array<string, string> setting_key => CSS custom property name (with leading --)
     */
    public static function themeColorKeyToCssVariableMap(): array
    {
        return [
            'main_color' => '--main-color',
            'main_color_hover' => '--main-color-hover',
            'body_background' => '--body-background',
            'menu_active_bg' => '--menu-active-bg',
            'box_bg_color' => '--box-bg-color',
            'text_color' => '--text-color',
            'menu_badge_bg' => '--menu-badge-bg',
            'dark_main_color' => '--main-color',
            'dark_main_color_hover' => '--main-color-hover',
            'dark_body_background' => '--body-background',
            'dark_menu_active_bg' => '--menu-active-bg',
            'dark_box_bg_color' => '--box-bg-color',
            'dark_text_color' => '--text-color',
            'dark_menu_badge_bg' => '--menu-badge-bg',
        ];
    }

    /**
     * @return list<string>
     */
    public static function themeColorSettingKeys(): array
    {
        return array_keys(self::themeColorKeyToCssVariableMap());
    }

    /**
     * Pre-CSS-alignment defaults; used to upgrade seeded rows without touching user edits.
     *
     * @return array<string, string>
     */
    public static function legacyThemeColorDefaults(): array
    {
        return [
            'main_color' => '#2C2CCC',
            'main_color_hover' => '#1F1F99',
            'body_background' => '#F7F7F7',
            'menu_active_bg' => '#EDEDFF',
            'box_bg_color' => '#FFFFFF',
            'text_color' => '#333333',
            'menu_badge_bg' => '#E8E8FF',
            'dark_main_color' => '#6C6CFF',
            'dark_main_color_hover' => '#5252E0',
            'dark_body_background' => '#12121A',
            'dark_menu_active_bg' => '#2F2F48',
            'dark_box_bg_color' => '#1E1E2E',
            'dark_text_color' => '#EAEAEA',
            'dark_menu_badge_bg' => '#2A2A40',
        ];
    }

    /**
     * @return array<string, array{mode: string, var: string}>
     */
    public static function themeColorVariableMeta(): array
    {
        $meta = [];

        foreach (self::themeColorKeyToCssVariableMap() as $key => $variable) {
            $meta[$key] = [
                'mode' => str_starts_with($key, 'dark_') ? 'dark' : 'light',
                'var' => $variable,
            ];
        }

        return $meta;
    }

    public static function persistMissing(): void
    {
        $now = now();

        foreach (self::all() as $key => $value) {
            $exists = Setting::query()->where('setting_key', $key)->exists();
            if ($exists) {
                continue;
            }

            DB::table('settings')->insert([
                'setting_key' => $key,
                'setting_value' => $value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
