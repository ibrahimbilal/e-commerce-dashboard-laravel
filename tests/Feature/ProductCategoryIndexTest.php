<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCategoryIndexTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_products_and_categories_index_return_ok_when_records_exist(): void
    {
        $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'title' => 'Index Category',
            'locale' => 'en',
            'category_slug' => 'index-category',
        ])->assertRedirect();

        $categoryId = Category::query()->where('category_slug', 'index-category')->value('id');

        $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'sku' => 'IDX-1',
            'quantity' => 1,
            'regular_price' => 500,
            'status' => 'published',
            'category_ids' => [$categoryId],
            'locales' => [
                'en' => [
                    'name' => 'Index Product',
                    'product_slug' => 'index-product',
                ],
            ],
        ])->assertRedirect();

        $this->actingAs($this->admin)->get(route('admin.products.index'))->assertOk()->assertViewIs('admin.products.index');
        $this->actingAs($this->admin)->get(route('admin.categories.index'))->assertOk()->assertViewIs('admin.categories.index');
    }
}
