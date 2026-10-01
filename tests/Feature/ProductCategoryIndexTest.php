<?php

namespace Tests\Feature;

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
        $this->actingAs($this->admin)->post(route('products.store'), [
            'sku' => 'IDX-1',
            'quantity' => 1,
            'locales' => [
                'en' => [
                    'name' => 'Index Product',
                    'product_slug' => 'index-product',
                ],
            ],
        ])->assertRedirect();

        $this->actingAs($this->admin)->post(route('categories.store'), [
            'title' => 'Index Category',
            'locale' => 'en',
            'category_slug' => 'index-category',
        ])->assertRedirect();

        $this->actingAs($this->admin)->get(route('products.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('categories.index'))->assertOk();
    }
}
