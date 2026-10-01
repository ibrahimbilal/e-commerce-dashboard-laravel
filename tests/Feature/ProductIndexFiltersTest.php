<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductLocale;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductIndexFiltersTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_published_filter_and_counts(): void
    {
        $published = Product::query()->create(['sku' => 'PUB-1', 'quantity' => 1, 'status' => 'published']);
        ProductLocale::query()->create(['product_id' => $published->id, 'locale' => 'en', 'name' => 'Published One']);
        $draft = Product::query()->create(['sku' => 'DRF-1', 'quantity' => 1, 'status' => 'draft']);
        ProductLocale::query()->create(['product_id' => $draft->id, 'locale' => 'en', 'name' => 'Draft One']);

        $response = $this->actingAs($this->admin)->get(route('products.index', ['status' => 'published']));

        $response->assertOk();
        $response->assertViewHas('counts', fn (array $counts) => ($counts['published'] ?? 0) === 1 && ($counts['draft'] ?? 0) === 1);
        $response->assertViewHas('filters', fn (array $filters) => ($filters['status'] ?? null) === 'published');
        $response->assertSee('Published One');
        $response->assertDontSee('Draft One');
    }

    public function test_search_and_pagination_keeps_query_string(): void
    {
        $match = Product::query()->create(['sku' => 'FIND-ME', 'quantity' => 1, 'status' => 'published']);
        ProductLocale::query()->create(['product_id' => $match->id, 'locale' => 'en', 'name' => 'Findable Widget']);

        Product::query()->create(['sku' => 'OTHER', 'quantity' => 1, 'status' => 'published']);

        $response = $this->actingAs($this->admin)->get(route('products.index', ['search' => 'Findable']));

        $response->assertOk();
        $response->assertViewHas('filters', fn (array $filters) => ($filters['search'] ?? null) === 'Findable');
        $response->assertSee('Findable Widget');
    }
}
