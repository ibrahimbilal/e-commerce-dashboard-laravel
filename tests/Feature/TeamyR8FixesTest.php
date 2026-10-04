<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use App\Support\GalleryMetadataBackfill;
use Database\Seeders\DemoDataSeeder;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StaffUserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TeamyR8FixesTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seed_users_have_role_name_matching_spatie_role(): void
    {
        $this->seed([
            PermissionsSeeder::class,
            LangSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StaffUserSeeder::class,
            DemoDataSeeder::class,
        ]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        User::query()->each(function (User $user) {
            $role = $user->roles->first();
            if ($role === null) {
                return;
            }

            $this->assertSame($role->name, $user->role_name, "User {$user->email} role_name mismatch.");
        });
    }

    public function test_user_factory_mobile_passes_profile_digits_rule(): void
    {
        $user = User::factory()->make();
        $validator = Validator::make(
            ['mobile' => $user->mobile],
            ['mobile' => ['nullable', 'numeric', 'digits_between:9,15']]
        );

        $this->assertFalse($validator->fails(), json_encode($validator->errors()->all()));
    }

    public function test_inactive_user_login_shows_inactive_message_with_correct_password(): void
    {
        $this->seed([PermissionsSeeder::class, RoleSeeder::class]);

        User::factory()->create([
            'email' => 'inactive-r8@example.com',
            'password' => Hash::make('password'),
            'status' => 'verified',
            'is_active' => false,
        ])->assignRole('viewer');

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'inactive-r8@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            __('auth.inactive'),
            session('errors')->get('email')[0]
        );
        $this->assertGuest();
    }

    public function test_blocked_user_login_shows_blocked_message_with_correct_password(): void
    {
        $this->seed([PermissionsSeeder::class, RoleSeeder::class]);

        User::factory()->create([
            'email' => 'blocked-r8@example.com',
            'password' => Hash::make('password'),
            'status' => 'blocked',
            'is_active' => true,
        ])->assignRole('viewer');

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'blocked-r8@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(__('auth.blocked'), session('errors')->get('email')[0]);
        $this->assertGuest();
    }

    public function test_inactive_user_wrong_password_shows_failed_not_inactive(): void
    {
        $this->seed([PermissionsSeeder::class, RoleSeeder::class]);

        User::factory()->create([
            'email' => 'inactive-wrong@example.com',
            'password' => Hash::make('password'),
            'status' => 'verified',
            'is_active' => false,
        ])->assignRole('viewer');

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'inactive-wrong@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(__('auth.failed'), session('errors')->get('email')[0]);
    }

    public function test_gallery_metadata_backfill_fills_missing_metas(): void
    {
        $userId = User::factory()->create()->getKey();

        $gallery = Gallery::query()->create([
            'url' => 'missing/demo-image.jpg',
            'title' => 'Demo title',
            'alt' => 'Demo alt',
            'metas' => null,
            'sizes_url' => null,
            'user_id' => $userId,
        ]);

        GalleryMetadataBackfill::run();

        $metas = $gallery->fresh()->metas;
        $this->assertIsArray($metas);
        $this->assertSame('demo-image.jpg', $metas['name']);
        $this->assertSame('Demo title', $metas['title']);
        $this->assertSame('Demo alt', $metas['alt']);
        $this->assertArrayHasKey('size', $metas);
        $this->assertArrayHasKey('width', $metas);
        $this->assertArrayHasKey('height', $metas);
    }

    public function test_order_store_returns_single_customer_id_message_when_missing(): void
    {
        $this->seed([PermissionsSeeder::class, UserSeeder::class]);
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $status = \App\Models\OrderStatus::query()->create(['title' => 'Pending']);

        $response = $this->actingAs($admin)->postJson(route('admin.orders.store'), [
            'order_status_id' => $status->id,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['customer_id']);
        $this->assertArrayNotHasKey('customer', $response->json('errors'));
        $this->assertContains(
            __('validation.custom.customer_id.required'),
            $response->json('errors.customer_id')
        );
    }
}
