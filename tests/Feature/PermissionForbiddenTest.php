<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionForbiddenTest extends TestCase
{
    use RefreshDatabase;

    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class, RoleSeeder::class]);
        $this->viewer = User::factory()->create(['email' => 'viewer-test@example.com']);
        $this->viewer->assignRole('viewer');
    }

    public function test_viewer_gets_403_on_order_store(): void
    {
        $this->actingAs($this->viewer)
            ->post(route('admin.orders.store'), [])
            ->assertForbidden();
    }

    public function test_viewer_gets_json_403_on_ajax_order_store(): void
    {
        $this->actingAs($this->viewer)
            ->postJson(route('admin.orders.store'), [])
            ->assertForbidden()
            ->assertJson(['responseStatus' => 403]);
    }
}
