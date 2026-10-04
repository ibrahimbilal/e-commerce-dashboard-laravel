<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserStatusToggleTest extends TestCase
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

    public function test_is_active_toggle_deactivates_and_activates_user(): void
    {
        $user = User::factory()->create([
            'email' => 'toggle-target@example.com',
            'status' => 'verified',
            'is_active' => true,
        ]);
        $user->assignRole('viewer');

        $this->actingAs($this->admin)
            ->patchJson(route('users.toggle', $user->getKey()), ['field' => 'is_active', 'value' => false])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'field' => 'is_active',
                'value' => false,
            ])
            ->assertJsonStructure(['message', 'counts' => ['all', 'active', 'inactive', 'blocked', 'trashed']]);

        $this->assertFalse($user->fresh()->is_active);
        $this->assertSame('verified', $user->fresh()->status);

        $this->actingAs($this->admin)
            ->patchJson(route('users.toggle', $user->getKey()), ['field' => 'is_active'])
            ->assertOk()
            ->assertJsonPath('value', true);

        $this->assertTrue($user->fresh()->is_active);
    }

    public function test_user_cannot_deactivate_own_account(): void
    {
        $this->actingAs($this->admin)
            ->patchJson(route('users.toggle', $this->admin->getKey()), ['field' => 'is_active', 'value' => false])
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'You cannot deactivate your own account.',
            ]);

        $this->assertTrue($this->admin->fresh()->is_active);
    }

    public function test_cannot_deactivate_last_active_admin(): void
    {
        $editor = User::factory()->create([
            'email' => 'users-editor@example.com',
            'status' => 'verified',
            'is_active' => true,
        ]);
        $editor->givePermissionTo('edit users');

        $this->actingAs($editor)
            ->patchJson(route('users.toggle', $this->admin->getKey()), ['field' => 'is_active', 'value' => false])
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot deactivate the last active admin account.',
            ]);

        $this->assertTrue($this->admin->fresh()->is_active);
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => Hash::make('password'),
            'status' => 'verified',
            'is_active' => false,
        ])->assignRole('viewer');

        $this->post('/admin/login', [
            'email' => 'inactive@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_blocked_user_cannot_log_in(): void
    {
        User::factory()->create([
            'email' => 'blocked@example.com',
            'password' => Hash::make('password'),
            'status' => 'blocked',
            'is_active' => true,
        ])->assignRole('viewer');

        $this->post('/admin/login', [
            'email' => 'blocked@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_not_verified_user_can_still_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'not-verified@example.com',
            'password' => Hash::make('password'),
            'status' => 'not_verified',
            'is_active' => true,
            'email_verified_at' => null,
        ]);
        $user->assignRole('viewer');

        $this->post('/admin/login', [
            'email' => 'not-verified@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_update_user_request_accepts_verified_status_and_is_active(): void
    {
        $user = User::factory()->create([
            'email' => 'form-status@example.com',
            'status' => 'verified',
            'is_active' => true,
        ]);
        $user->assignRole('viewer');

        $this->actingAs($this->admin)
            ->patchJson(route('users.update', $user->getKey()), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'gender' => $user->gender,
                'role_name' => 'viewer',
                'status' => 'blocked',
                'is_active' => false,
                'language' => 'en',
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $user->refresh();
        $this->assertSame('blocked', $user->status);
        $this->assertFalse($user->is_active);
    }
}
