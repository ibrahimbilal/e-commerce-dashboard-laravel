<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\AdminSettingDefaults;
use App\Support\ThemeColors;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ThemeColorsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        ThemeColors::forgetCached();
    }

    public function test_theme_color_defaults_exist_for_every_color_setting_key(): void
    {
        $defaults = AdminSettingDefaults::themeColorDefaults();
        $map = AdminSettingDefaults::themeColorKeyToCssVariableMap();

        $this->assertEqualsCanonicalizing(array_keys($map), array_keys($defaults));

        foreach ($defaults as $key => $hex) {
            $this->assertMatchesRegularExpression('/^#[0-9A-F]{6}$/', $hex, $key);
            $this->assertSame($hex, ThemeColors::normalizeHex($hex));
        }
    }

    public function test_theme_store_rejects_invalid_hex_color(): void
    {
        AdminSettingDefaults::persistMissing();

        $payload = $this->themeStorePayload();
        $payload['main_color'] = 'not-a-color';

        $this->actingAs($this->admin)->post(route('theme-settings.store'), $payload, [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['main_color']);
    }

    public function test_saving_color_updates_theme_css_variables_on_admin_layout(): void
    {
        AdminSettingDefaults::persistMissing();
        ThemeColors::forgetCached();

        $payload = $this->themeStorePayload();
        $payload['main_color'] = '#AABBCC';

        $this->actingAs($this->admin)->post(route('theme-settings.store'), $payload, [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])->assertOk();

        $variables = ThemeColors::cssVariables();
        $this->assertSame('#AABBCC', $variables['light']['--main-color']);

        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk();

        $this->assertSame('#AABBCC', ThemeColors::cssVariables()['light']['--main-color']);
    }

    public function test_theme_settings_page_receives_color_defaults_for_reset(): void
    {
        AdminSettingDefaults::persistMissing();

        $response = $this->actingAs($this->admin)->get(route('theme-settings.index'));

        $response->assertOk();
        $expectedKeys = AdminSettingDefaults::themeColorSettingKeys();

        $response->assertViewHas('themeColorDefaults', function (array $defaults) use ($expectedKeys) {
            return array_keys($defaults) === array_keys($defaults)
                && count($defaults) === count($expectedKeys)
                && ($defaults['main_color'] ?? null) === AdminSettingDefaults::themeColorDefaults()['main_color']
                && ! array_diff_key($defaults, array_flip($expectedKeys));
        });

        $response->assertViewHas('themeColorVariables', function (array $variables) use ($expectedKeys) {
            return count($variables) === count($expectedKeys)
                && ($variables['main_color']['mode'] ?? null) === 'light'
                && ($variables['main_color']['var'] ?? null) === '--main-color'
                && ($variables['dark_main_color']['mode'] ?? null) === 'dark'
                && ($variables['dark_main_color']['var'] ?? null) === '--main-color'
                && ! array_diff_key($variables, array_flip($expectedKeys));
        });
    }

    public function test_migration_upgrades_legacy_default_color_without_touching_custom_value(): void
    {
        AdminSettingDefaults::persistMissing();

        Setting::query()->updateOrCreate(
            ['setting_key' => 'menu_badge_bg'],
            ['setting_value' => '#E8E8FF']
        );
        Setting::query()->updateOrCreate(
            ['setting_key' => 'main_color'],
            ['setting_value' => '#AABBCC']
        );

        $migration = require database_path('migrations/2026_10_04_010000_seed_theme_color_setting_defaults.php');
        $migration->up();

        $this->assertSame('#FF9F43', Setting::query()->where('setting_key', 'menu_badge_bg')->value('setting_value'));
        $this->assertSame('#AABBCC', Setting::query()->where('setting_key', 'main_color')->value('setting_value'));
    }

    public function test_setting_model_clears_theme_colors_cache_on_color_save(): void
    {
        AdminSettingDefaults::persistMissing();
        Cache::forever(ThemeColors::CACHE_KEY, ['light' => [], 'dark' => []]);

        Setting::query()->updateOrCreate(
            ['setting_key' => 'main_color'],
            ['setting_value' => '#010203']
        );

        $this->assertFalse(Cache::has(ThemeColors::CACHE_KEY));
    }

    /**
     * @return array<string, string>
     */
    private function themeStorePayload(): array
    {
        return array_intersect_key(
            AdminSettingDefaults::theme(),
            array_flip([
                'logo_width', 'logo_height', 'mobile_logo_width', 'mobile_logo_height',
                'main_color', 'main_color_hover', 'box_bg_color', 'body_background',
                'menu_badge_bg', 'menu_active_bg', 'text_color',
                'dark_main_color', 'dark_main_color_hover', 'dark_box_bg_color',
                'dark_body_background', 'dark_menu_badge_bg', 'dark_menu_active_bg', 'dark_text_color',
            ])
        );
    }
}
