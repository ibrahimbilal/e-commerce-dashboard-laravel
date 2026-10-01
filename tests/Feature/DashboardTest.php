<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_with_stats(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats', function (array $stats) {
            foreach (['orders', 'revenue', 'customers', 'products', 'orders_today'] as $key) {
                if (! array_key_exists($key, $stats)) {
                    return false;
                }
            }

            return true;
        });
        $response->assertViewHas('recentOrders');
        $response->assertViewHas('topProducts');
    }
}
