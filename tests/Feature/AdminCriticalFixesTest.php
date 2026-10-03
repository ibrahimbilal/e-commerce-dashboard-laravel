<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\User;
use App\Support\AdminSettingDefaults;
use Database\Seeders\DemoDataSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffUserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminCriticalFixesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PermissionsSeeder::class,
            LangSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StaffUserSeeder::class,
        ]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_store_settings_page_returns_ok_for_roles_with_access(): void
    {
        AdminSettingDefaults::persistMissing();

        foreach (['admin@example.com', 'manager@example.com', 'viewer@example.com'] as $email) {
            $this->flushSession();
            $this->actingAs(User::query()->where('email', $email)->firstOrFail())
                ->get(route('store-settings.index'))
                ->assertOk()
                ->assertViewIs('admin.settings.store');
        }
    }

    public function test_store_settings_page_ok_when_share_on_is_empty_string(): void
    {
        AdminSettingDefaults::persistMissing();

        Setting::query()->updateOrCreate(
            ['setting_key' => 'share_on'],
            ['setting_value' => '']
        );

        $this->actingAs(User::query()->where('email', 'admin@example.com')->firstOrFail())
            ->get(route('store-settings.index'))
            ->assertOk();
    }

    public function test_general_settings_page_returns_ok(): void
    {
        AdminSettingDefaults::persistMissing();

        $this->actingAs(User::query()->where('email', 'admin@example.com')->firstOrFail())
            ->get(route('general-settings.index'))
            ->assertOk()
            ->assertViewIs('admin.settings.general');
    }

    public function test_staff_users_have_role_name_matching_spatie_role_after_seed(): void
    {
        $manager = User::query()->where('email', 'manager@example.com')->firstOrFail();
        $this->assertSame('manager', $manager->role_name);
        $this->assertSame('active', $manager->status);

        $viewer = User::query()->where('email', 'viewer@example.com')->firstOrFail();
        $this->assertSame('viewer', $viewer->role_name);
        $this->assertSame('active', $viewer->status);
    }

    public function test_gallery_get_metas_returns_success_for_seeded_image(): void
    {
        $this->seed([
            SettingsSeeder::class,
            DemoDataSeeder::class,
        ]);

        $gallery = Gallery::query()->firstOrFail();
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->postJson(route('get_metas'), ['id' => $gallery->id])
            ->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonStructure(['output']);

        $metas = $gallery->fresh()->metas;
        $this->assertArrayHasKey('name', $metas);
        $this->assertArrayHasKey('size', $metas);
        $this->assertArrayHasKey('width', $metas);
        $this->assertArrayHasKey('height', $metas);
        $this->assertArrayHasKey('title', $metas);
        $this->assertArrayHasKey('alt', $metas);
    }

    public function test_email_settings_store_accepts_seeded_defaults_unchanged(): void
    {
        AdminSettingDefaults::persistMissing();

        $payload = array_intersect_key(
            AdminSettingDefaults::email(),
            array_flip([
                'email_from_name',
                'email_from_address',
                'email_main_color',
                'email_bg_color',
                'email_body_bg_color',
                'email_text_color',
                'email_new_order',
                'new_order_recipients_type',
                'new_order_recipients',
                'email_out_of_stock',
                'out_of_stock_recipients_type',
                'out_of_stock_recipients',
                'email_order_canceled',
                'order_canceled_recipients_type',
                'order_canceled_recipients',
                'email_order_confirmed',
                'email_order_shipped',
                'email_order_completed',
                'email_order_refunded',
            ])
        );

        $payload['new_order_recipients'] = [];
        $payload['out_of_stock_recipients'] = [];
        $payload['order_canceled_recipients'] = [];

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('emails-settings.store'), $payload, [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ])
            ->assertOk()
            ->assertJson(['success' => true]);
    }

    public function test_scheduled_discount_appears_in_inactive_tab(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        Discount::query()->create([
            'title' => 'Scheduled Future',
            'discount' => 15,
            'type' => 'percent',
            'start_date' => now()->addWeek(),
            'end_date' => now()->addMonth(),
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.discounts.index', ['inactive' => '1']));

        $response->assertOk();
        $response->assertViewHas('counts', fn (array $counts) => ($counts['inactive'] ?? 0) >= 1);
        $response->assertSee('Scheduled Future');
    }
}
