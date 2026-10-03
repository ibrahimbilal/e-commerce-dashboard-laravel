<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DashboardStaffPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_and_viewer_have_view_dashboard_after_full_seed(): void
    {
        $this->seed(DatabaseSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['manager@example.com', 'viewer@example.com'] as $email) {
            $this->flushSession();

            $user = User::query()->where('email', $email)->firstOrFail();
            $user->load('roles.permissions');

            $this->assertTrue(
                $user->hasPermissionTo('view dashboard'),
                "{$email} should have view dashboard after seeding."
            );

            $response = $this->actingAs($user)->get(route('admin.dashboard'));

            $this->assertFalse(
                $response->isRedirect(route('login')),
                "{$email} should not be redirected to login when accessing admin.dashboard."
            );
            $this->assertNotSame(403, $response->getStatusCode(), "{$email} should not be forbidden on admin.dashboard.");
        }
    }
}
