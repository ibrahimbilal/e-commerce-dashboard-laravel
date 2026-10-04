<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_product_create_persists_sku_and_quantity_and_locale(): void
    {
        $category = Category::query()->create([
            'title' => 'Widgets',
            'locale' => 'en',
            'category_slug' => 'widgets',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'sku' => 'SKU-100',
            'quantity' => 12,
            'regular_price' => 1999,
            'status' => 'published',
            'category_ids' => [$category->id],
            'product_name' => 'Widget',
            'langs' => 'en',
            'locales' => [
                'en' => [
                    'name' => 'Widget',
                    'product_slug' => 'widget',
                ],
            ],
        ]);

        $response->assertRedirect();

        $product = Product::query()->where('sku', 'SKU-100')->first();
        $this->assertNotNull($product);
        $this->assertSame(12, $product->quantity);

        $this->assertDatabaseHas('product_locales', [
            'product_id' => $product->id,
            'locale' => 'en',
            'name' => 'Widget',
        ]);
    }

    public function test_updating_one_product_locale_does_not_change_another(): void
    {
        $first = Product::query()->create(['sku' => 'A', 'quantity' => 1]);
        $second = Product::query()->create(['sku' => 'B', 'quantity' => 1]);

        DB::table('product_locales')->insert([
            ['product_id' => $first->id, 'locale' => 'en', 'name' => 'One'],
            ['product_id' => $second->id, 'locale' => 'en', 'name' => 'Two'],
        ]);

        $category = Category::query()->create([
            'title' => 'Locale Cat',
            'locale' => 'en',
            'category_slug' => 'locale-cat',
        ]);
        $first->categories()->attach($category->id);

        $this->actingAs($this->admin)->put(route('admin.products.update', $first), [
            'sku' => 'A-updated',
            'quantity' => 5,
            'regular_price' => 10,
            'status' => 'published',
            'category_ids' => [$category->id],
            'product_name' => 'OneUpdated',
            'langs' => 'en',
            'locales' => [
                'en' => [
                    'name' => 'OneUpdated',
                    'product_slug' => 'one-updated',
                ],
            ],
        ])->assertRedirect();

        $this->assertSame('OneUpdated', DB::table('product_locales')
            ->where('product_id', $first->id)->value('name'));
        $this->assertSame('Two', DB::table('product_locales')
            ->where('product_id', $second->id)->value('name'));
        $this->assertSame('A-updated', $first->fresh()->sku);
    }
}
