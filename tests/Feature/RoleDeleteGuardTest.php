<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RoleDeleteGuardTest extends TestCase
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

    public function test_admin_role_delete_refused_as_json(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();

        $this->actingAs($this->admin)
            ->deleteJson(route('roles.destroy', $adminRole))
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => "The admin role can't be deleted.",
            ]);

        $this->assertDatabaseHas('roles', ['id' => $adminRole->id]);
    }

    public function test_admin_role_delete_refused_with_redirect_flash(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->firstOrFail();

        $response = $this->actingAs($this->admin)
            ->from(route('roles.index'))
            ->delete(route('roles.destroy', $adminRole));

        $this->assertTrue($response->isRedirect(), 'Expected redirect, got '.$response->status());
        $this->assertSame(route('roles.index'), $response->headers->get('Location'));
        $this->assertSame(
            ["The admin role can't be deleted."],
            $response->getSession()->get('errors')
        );
    }

    public function test_role_in_use_refused_with_user_count_in_message(): void
    {
        $managerRole = Role::query()->where('name', 'manager')->firstOrFail();

        User::factory()->create([
            'email' => 'extra-manager@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('manager');

        $expectedCount = $managerRole->users()->count();
        $this->assertGreaterThan(0, $expectedCount);

        $this->actingAs($this->admin)
            ->deleteJson(route('roles.destroy', $managerRole))
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => "This role is assigned to {$expectedCount} users. Change their role first, then delete it.",
            ]);
    }

    public function test_unused_role_can_be_deleted(): void
    {
        $role = Role::query()->create([
            'name' => 'temporary-role',
            'guard_name' => 'web',
        ]);

        $this->actingAs($this->admin)
            ->deleteJson(route('roles.destroy', $role))
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure(['title', 'text', 'redirect']);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
