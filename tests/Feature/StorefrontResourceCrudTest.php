<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontResourceCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_admin_can_create_update_and_delete_resource(string $resource, array $create, array $update): void
    {
        $createResponse = $this->actingAs($this->admin)->post(route($resource.'.store'), $create);
        $createResponse->assertRedirect();
        $createResponse->assertSessionHas('status');

        $modelClass = $create['__model'];
        unset($create['__model'], $update['__model']);
        $model = $modelClass::query()->latest('id')->first();
        $this->assertNotNull($model);

        $this->actingAs($this->admin)
            ->put(route($resource.'.update', $model), $update)
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->actingAs($this->admin)
            ->delete(route($resource.'.destroy', $model))
            ->assertRedirect()
            ->assertSessionHas('status');
    }

    public static function resourceProvider(): array
    {
        return [
            'categories' => [
                'categories',
                ['__model' => Category::class, 'title' => 'Cat A', 'locale' => 'en', 'category_slug' => 'cat-a'],
                ['__model' => Category::class, 'title' => 'Cat B', 'locale' => 'en', 'category_slug' => 'cat-b'],
            ],
            'tags' => [
                'tags',
                ['__model' => Tag::class, 'title' => 'Tag A', 'locale' => 'en', 'tag_slug' => 'tag-a'],
                ['__model' => Tag::class, 'title' => 'Tag B', 'locale' => 'en', 'tag_slug' => 'tag-b'],
            ],
            'attributes' => [
                'attributes',
                ['__model' => Attribute::class, 'attribute_key' => 'Material', 'attribute_value' => 'Cotton'],
                ['__model' => Attribute::class, 'attribute_key' => 'Material', 'attribute_value' => 'Wool'],
            ],
            'products' => [
                'products',
                ['__model' => Product::class, 'sku' => 'CRUD-1', 'quantity' => 2, 'locales' => ['en' => ['name' => 'Crud', 'product_slug' => 'crud']]],
                ['__model' => Product::class, 'sku' => 'CRUD-2', 'quantity' => 3, 'locales' => ['en' => ['name' => 'Crud2', 'product_slug' => 'crud2']]],
            ],
            'customers' => [
                'customers',
                ['__model' => Customer::class, 'email' => 'crud@example.com', 'password' => 'password123', 'first_name' => 'Crud'],
                ['__model' => Customer::class, 'email' => 'crud@example.com', 'password' => '', 'first_name' => 'Updated'],
            ],
            'order-statuses' => [
                'order-statuses',
                ['__model' => OrderStatus::class, 'title' => 'Awaiting'],
                ['__model' => OrderStatus::class, 'title' => 'Awaiting Updated'],
            ],
        ];
    }
}
