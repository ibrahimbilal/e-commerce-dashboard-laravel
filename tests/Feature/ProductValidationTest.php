<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->category = Category::query()->create([
            'title' => 'Validation Cat',
            'locale' => 'en',
            'category_slug' => 'validation-cat',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'regular_price' => 100,
            'status' => 'published',
            'category_ids' => [$this->category->id],
            'product_name' => 'Valid Product',
            'locales' => [
                'en' => [
                    'name' => 'Valid Product',
                    'product_slug' => 'valid-product',
                ],
            ],
        ], $overrides);
    }

    public function test_store_requires_core_fields_together_in_one_response(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), []);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['message', 'errors']);
        $response->assertJsonValidationErrors(['product_name', 'regular_price', 'category_ids']);

        $errors = $response->json('errors');
        $this->assertContains('Price is required.', $errors['regular_price']);
        $this->assertContains('Please select at least one category.', $errors['category_ids']);
        $this->assertContains('Product name is required.', $errors['product_name']);
    }

    public function test_store_validation_messages_are_translated_in_arabic_locale(): void
    {
        app()->setLocale('ar');

        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), []);

        $response->assertUnprocessable();
        $this->assertContains('اسم المنتج مطلوب.', $response->json('errors.product_name'));
    }

    public function test_store_defaults_status_to_draft_when_missing(): void
    {
        $payload = $this->validPayload();
        unset($payload['status']);

        $this->actingAs($this->admin)->post(route('admin.products.store'), $payload)->assertRedirect();

        $this->assertSame('draft', Product::query()->latest('id')->value('status'));
    }

    public function test_update_preserves_status_when_missing(): void
    {
        $product = Product::query()->create([
            'sku' => 'VAL-STATUS',
            'regular_price' => 100,
            'quantity' => 1,
            'status' => 'published',
        ]);
        $product->categories()->attach($this->category->id);

        $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'regular_price' => 120,
            'category_ids' => [$this->category->id],
            'product_name' => 'Renamed',
        ])->assertRedirect();

        $this->assertSame('published', $product->fresh()->status);
    }

    public function test_store_requires_product_title(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), [
            'regular_price' => 100,
            'category_ids' => [$this->category->id],
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['product_name']);
    }

    public function test_store_rejects_sale_price_greater_or_equal_to_regular_price(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), $this->validPayload([
            'regular_price' => 50,
            'sale_price' => 50,
        ]));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['sale_price']);
    }

    public function test_store_requires_valid_schedule_sale_date_when_provided(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), $this->validPayload([
            'schedule_sale' => 'not-a-date',
        ]));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['schedule_sale']);
    }

    public function test_store_requires_last_sale_date_on_or_after_schedule_sale(): void
    {
        $response = $this->actingAs($this->admin)->postJson(route('admin.products.store'), $this->validPayload([
            'schedule_sale' => '2026-12-31',
            'last_sale_date' => '2026-01-01',
        ]));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['last_sale_date']);
    }

    public function test_update_validation_errors_redirect_back_with_input_for_normal_post(): void
    {
        $product = Product::query()->create([
            'sku' => 'VAL-1',
            'regular_price' => 100,
            'quantity' => 1,
            'status' => 'published',
        ]);
        $product->categories()->attach($this->category->id);

        $response = $this->actingAs($this->admin)->from(route('admin.products.edit', $product))
            ->put(route('admin.products.update', $product), [
                'regular_price' => -1,
                'status' => 'published',
                'category_ids' => [$this->category->id],
                'product_name' => 'Still Named',
            ]);

        $response->assertRedirect(route('admin.products.edit', $product));
        $response->assertSessionHasErrors(['regular_price']);
        $response->assertSessionHasInput('product_name', 'Still Named');
    }

    public function test_update_json_validation_returns_standard_422_shape(): void
    {
        $product = Product::query()->create([
            'sku' => 'VAL-2',
            'regular_price' => 100,
            'quantity' => 1,
            'status' => 'published',
        ]);
        $product->categories()->attach($this->category->id);

        $response = $this->actingAs($this->admin)->putJson(route('admin.products.update', $product), [
            'regular_price' => 100,
            'status' => 'invalid-status',
            'category_ids' => [$this->category->id],
            'product_name' => 'Named',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonStructure(['message', 'errors']);
        $response->assertJsonValidationErrors(['status']);
    }
}
