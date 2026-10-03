<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SkipsUntilAdminViewsMoved;
use Tests\TestCase;

class AnalyticsOverviewTest extends TestCase
{
    use RefreshDatabase;
    use SkipsUntilAdminViewsMoved;

    public function test_analytics_overview_renders_with_contract_variables(): void
    {
        $this->skipUntilAdminViewsMoved();
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('admin.analytics.overview', [
            'from' => now()->subDays(7)->toDateString(),
            'to' => now()->toDateString(),
            'compare' => 'previous_period',
        ]));

        $response->assertOk();
        $response->assertViewHas('range');
        $response->assertViewHas('analytics');
        $response->assertViewHas('analyticsSeries');
        $response->assertViewHas('topCategories');
        $response->assertViewHas('topProducts');
    }
}
