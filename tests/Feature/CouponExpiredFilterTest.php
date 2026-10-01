<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponExpiredFilterTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_expired_tab_counts_only_past_end_date(): void
    {
        Coupon::query()->create([
            'title' => 'Inactive Future',
            'code' => 'INFUT',
            'discount' => 10,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'expired_at' => now()->addWeek(),
            'active' => false,
        ]);
        Coupon::query()->create([
            'title' => 'Expired',
            'code' => 'EXPD',
            'discount' => 10,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'expired_at' => now()->subDay(),
            'active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('coupons.index', ['expired' => '1']));

        $response->assertOk();
        $response->assertViewHas('counts', fn (array $counts) => ($counts['expired'] ?? 0) === 1);
        $response->assertSee('Expired');
        $response->assertDontSee('Inactive Future');
    }
}
