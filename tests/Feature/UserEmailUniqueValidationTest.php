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

class UserEmailUniqueValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $userB;

    private User $userC;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->userB = User::factory()->create([
            'email' => 'userb@example.com',
            'role_name' => 'viewer',
        ]);
        $this->userB->assignRole('viewer');
        $this->userC = User::factory()->create([
            'email' => 'userc@example.com',
            'role_name' => 'viewer',
        ]);
        $this->userC->assignRole('viewer');
    }

    /**
     * @return array<string, mixed>
     */
    private function profilePayload(User $user, array $overrides = []): array
    {
        return array_merge([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'gender' => $user->gender,
            'language' => $user->language,
        ], $overrides);
    }

    /**
     * @return array<string, mixed>
     */
    private function adminUpdatePayload(User $user, array $overrides = []): array
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

    public function test_profile_update_with_another_users_email_returns_422_on_email(): void
    {
        $this->actingAs($this->admin)->postJson(route('users.update_profile'), $this->profilePayload($this->admin, [
            'email' => $this->userC->email,
        ]))->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }

    public function test_profile_update_keeping_own_email_succeeds(): void
    {
        $this->actingAs($this->admin)->postJson(route('users.update_profile'), $this->profilePayload($this->admin))
            ->assertOk()
            ->assertJson(['success' => true]);
    }

    public function test_admin_update_user_b_with_user_c_email_returns_422(): void
    {
        $this->actingAs($this->admin)->patchJson(route('users.update', $this->userB), $this->adminUpdatePayload($this->userB, [
            'email' => $this->userC->email,
        ]))->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }

    public function test_admin_update_user_b_keeping_b_email_succeeds(): void
    {
        $this->actingAs($this->admin)->patchJson(route('users.update', $this->userB), $this->adminUpdatePayload($this->userB, [
            'first_name' => 'User',
        ]))->assertOk()->assertJson(['success' => true]);

        $this->userB->refresh();
        $this->assertSame('User', $this->userB->first_name);
        $this->assertSame('userb@example.com', $this->userB->email);
    }

    public function test_admin_update_user_b_to_admin_email_returns_422(): void
    {
        $this->actingAs($this->admin)->patchJson(route('users.update', $this->userB), $this->adminUpdatePayload($this->userB, [
            'email' => $this->admin->email,
        ]))->assertUnprocessable()->assertJsonValidationErrors(['email']);
    }
}
