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

class UsersFormRoleSelectRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_create_and_edit_render_role_and_status_controls(): void
    {
        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $other = User::factory()->create(['email' => 'other-user@example.com', 'status' => 'verified']);
        $other->assignRole('viewer');

        $create = $this->actingAs($admin)->get(route('users.create'));
        $create->assertOk();
        $create->assertSee('id="user-role"', false);
        $create->assertSee('name="role_name"', false);
        $create->assertSee('name="is_active"', false);
        $this->assertGreaterThan(0, substr_count($create->getContent(), '<option'));

        $edit = $this->actingAs($admin)->get(route('users.edit', $other));
        $edit->assertOk();
        $edit->assertSee('id="user-role"', false);
        $edit->assertSee('id="user-status"', false);
        $edit->assertSee('name="is_active"', false);

        $selfEdit = $this->actingAs($admin)->get(route('users.edit', $admin));
        $selfEdit->assertRedirect(route('users.profile'));
    }
}
