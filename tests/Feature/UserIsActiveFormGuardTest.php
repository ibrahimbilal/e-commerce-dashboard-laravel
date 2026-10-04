<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserIsActiveFormGuardTest extends TestCase
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

    /**
     * @return array<string, mixed>
     */
    private function updatePayload(User $user, array $overrides = []): array
    {
        return array_merge([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'gender' => $user->gender,
            'role_name' => $user->role_name,
            'status' => $user->status,
            'language' => $user->language,
        ], $overrides);
    }

    public function test_update_refuses_self_deactivation_via_json(): void
    {
        $this->actingAs($this->admin)
            ->patchJson(route('users.update', $this->admin->getKey()), $this->updatePayload($this->admin, [
                'is_active' => false,
            ]))
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'You cannot deactivate your own account.',
            ]);

        $this->assertTrue($this->admin->fresh()->is_active);
    }

    public function test_update_refuses_last_active_admin_via_json(): void
    {
        $editor = User::factory()->create([
            'email' => 'users-editor@example.com',
            'status' => 'verified',
            'is_active' => true,
        ]);
        $editor->givePermissionTo('edit users');

        $this->actingAs($editor)
            ->patchJson(route('users.update', $this->admin->getKey()), $this->updatePayload($this->admin, [
                'is_active' => false,
            ]))
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Cannot deactivate the last active admin account.',
            ]);

        $this->assertTrue($this->admin->fresh()->is_active);
    }

    public function test_update_can_deactivate_another_non_admin_user(): void
    {
        $viewer = User::factory()->create([
            'email' => 'deactivate-me@example.com',
            'status' => 'verified',
            'is_active' => true,
            'role_name' => 'viewer',
        ]);
        $viewer->assignRole('viewer');

        $this->actingAs($this->admin)
            ->patchJson(route('users.update', $viewer->getKey()), $this->updatePayload($viewer, [
                'is_active' => false,
            ]))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertFalse($viewer->fresh()->is_active);
    }
}
