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

class AdminDeleteConfirmScriptTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class, RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_admin_layout_includes_shared_delete_confirm_assets(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('assets/js/table-actions.js', false)
            ->assertSee('assets/js/delete-confirm.js', false)
            ->assertSee('AdminDeleteConfirmMessages', false)
            ->assertSee('AdminTableActionMessages', false);

        $tableActionsJs = file_get_contents(public_path('assets/js/table-actions.js'));
        $this->assertStringContainsString('AdminSwalSuccess', $tableActionsJs);
        $this->assertStringContainsString('timer: 1500', $tableActionsJs);
        $this->assertStringContainsString('timerProgressBar: true', $tableActionsJs);
        $this->assertStringContainsString('showConfirmButton: false', $tableActionsJs);
    }
}
