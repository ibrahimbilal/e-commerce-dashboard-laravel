<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\AdminSettingDefaults;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminSettingsPagesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_email_and_theme_settings_return_ok_when_keys_missing_from_database(): void
    {
        $keys = array_merge(
            AdminSettingDefaults::emailPageKeys(),
            AdminSettingDefaults::themePageKeys(),
        );
        Setting::query()->whereIn('setting_key', $keys)->delete();

        $this->actingAs($this->admin)
            ->get(route('emails-settings.index'))
            ->assertOk()
            ->assertViewIs('admin.settings.email');

        $this->actingAs($this->admin)
            ->get(route('theme-settings.index'))
            ->assertOk()
            ->assertViewIs('admin.settings.theme');
    }

    public function test_email_and_theme_settings_return_ok_after_full_seed(): void
    {
        AdminSettingDefaults::persistMissing();

        $this->actingAs($this->admin)
            ->get(route('emails-settings.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('theme-settings.index'))
            ->assertOk()
            ->assertSee('name="logo_height"', false);
    }

    public function test_theme_store_persists_logo_height(): void
    {
        AdminSettingDefaults::persistMissing();

        $payload = array_intersect_key(
            AdminSettingDefaults::theme(),
            array_flip([
                'logo_width', 'logo_height', 'mobile_logo_width',
                'main_color', 'main_color_hover', 'box_bg_color', 'body_background',
                'menu_badge_bg', 'menu_active_bg', 'text_color',
                'dark_main_color', 'dark_main_color_hover', 'dark_box_bg_color',
                'dark_body_background', 'dark_menu_badge_bg', 'dark_menu_active_bg', 'dark_text_color',
            ])
        );
        $payload['logo_height'] = '55';

        $response = $this->actingAs($this->admin)->post(route('theme-settings.store'), $payload, [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $this->assertSame(
            '55',
            Setting::query()->where('setting_key', 'logo_height')->value('setting_value')
        );

        $this->actingAs($this->admin)
            ->get(route('theme-settings.index'))
            ->assertOk()
            ->assertSee('value="55"', false)
            ->assertSee('>55</output>', false);
    }
}
