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
            'main_color' => '#2C2CCC',
            'main_color_hover' => '#1F1F99',
            'box_bg_color' => '#FFFFFF',
            'body_background' => '#F7F7F7',
            'menu_badge_bg' => '#E8E8FF',
            'menu_active_bg' => '#EDEDFF',
            'text_color' => '#333333',
            'dark_main_color' => '#6C6CFF',
            'dark_main_color_hover' => '#5252E0',
            'dark_box_bg_color' => '#1E1E2E',
            'dark_body_background' => '#12121A',
            'dark_menu_badge_bg' => '#2A2A40',
            'dark_menu_active_bg' => '#2F2F48',
            'dark_text_color' => '#EAEAEA',
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
