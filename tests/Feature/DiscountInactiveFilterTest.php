<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SkipsUntilAdminViewsMoved;
use Tests\TestCase;

class DiscountInactiveFilterTest extends TestCase
{
    use RefreshDatabase;
    use SkipsUntilAdminViewsMoved;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_inactive_tab_counts_only_inactive_not_expired(): void
    {
        $this->skipUntilAdminViewsMoved();
        Discount::query()->create([
            'title' => 'Inactive Running',
            'discount' => 10,
            'type' => 'percent',
            'end_date' => now()->addWeek(),
            'active' => false,
        ]);
        Discount::query()->create([
            'title' => 'Expired Inactive',
            'discount' => 10,
            'type' => 'percent',
            'end_date' => now()->subDay(),
            'active' => false,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.discounts.index', ['inactive' => '1']));

        $response->assertOk();
        $response->assertViewHas('counts', fn (array $counts) => ($counts['inactive'] ?? 0) === 1);
        $response->assertSee('Inactive Running');
        $response->assertDontSee('Expired Inactive');
    }
}
