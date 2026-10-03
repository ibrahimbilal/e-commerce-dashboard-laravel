<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SkipsUntilAdminViewsMoved;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    use SkipsUntilAdminViewsMoved;

    public function test_admin_dashboard_renders_with_stats(): void
    {
        $this->skipUntilAdminViewsMoved();
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertViewHas('stats', function (array $stats) {
            foreach ([
                'orders', 'revenue', 'sales', 'customers', 'products', 'orders_today',
                'subscribers', 'customers_change', 'orders_change', 'sales_change', 'subscribers_change',
            ] as $key) {
                if (! array_key_exists($key, $stats)) {
                    return false;
                }
            }

            return true;
        });
        $response->assertViewHas('salesChartSeries');
        $response->assertViewHas('orderStatusStats');
        $response->assertViewHas('recentOrders');
        $response->assertViewHas('topProducts', function ($topProducts) {
            foreach ($topProducts as $row) {
                foreach (['product_id', 'name', 'quantity_sold', 'image_url', 'price', 'regular_price'] as $key) {
                    if (! array_key_exists($key, $row)) {
                        return false;
                    }
                }
            }

            return true;
        });
        $response->assertViewHas('recentProducts', function ($recentProducts) {
            if ($recentProducts->isEmpty()) {
                return false;
            }

            foreach ($recentProducts as $row) {
                foreach (['id', 'name', 'image_url', 'price', 'regular_price'] as $key) {
                    if (! array_key_exists($key, $row)) {
                        return false;
                    }
                }

                if ($row['image_url'] !== null && ! is_string($row['image_url'])) {
                    return false;
                }
            }

            return true;
        });

        $firstRecent = $response->viewData('recentProducts')->first();
        $this->assertArrayHasKey('image_url', $firstRecent);
        if ($firstRecent['image_url'] !== null) {
            $this->assertStringContainsString('/storage/demo/products/', $firstRecent['image_url']);
        }
    }
}
