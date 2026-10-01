<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductLocale;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StorefrontResourceCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PermissionsSeeder::class,
            LangSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
        ]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_admin_can_create_update_and_delete_resource(string $resource, string $payloadMethod): void
    {
        [$create, $update, $modelClass] = $this->{$payloadMethod}();

        $createResponse = $this->actingAs($this->admin)->post(route($resource.'.store'), $create);
        $createResponse->assertRedirect();
        $createResponse->assertSessionHas('status');

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

    public function resourceProvider(): array
    {
        return [
            'categories' => ['categories', 'categoryCrudPayloads'],
            'tags' => ['tags', 'tagCrudPayloads'],
            'attributes' => ['attributes', 'attributeCrudPayloads'],
            'products' => ['products', 'productCrudPayloads'],
            'customers' => ['customers', 'customerCrudPayloads'],
            'order-statuses' => ['order-statuses', 'orderStatusCrudPayloads'],
            'coupons' => ['coupons', 'couponCrudPayloads'],
            'discounts' => ['discounts', 'discountCrudPayloads'],
            'reviews' => ['reviews', 'reviewCrudPayloads'],
            'orders' => ['orders', 'orderCrudPayloads'],
            'invoices' => ['invoices', 'invoiceCrudPayloads'],
            'users' => ['users', 'userCrudPayloads'],
            'roles' => ['roles', 'roleCrudPayloads'],
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function categoryCrudPayloads(): array
    {
        return [
            ['title' => 'Cat A', 'locale' => 'en', 'category_slug' => 'cat-a'],
            ['title' => 'Cat B', 'locale' => 'en', 'category_slug' => 'cat-b'],
            Category::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function tagCrudPayloads(): array
    {
        return [
            ['title' => 'Tag A', 'locale' => 'en', 'tag_slug' => 'tag-a'],
            ['title' => 'Tag B', 'locale' => 'en', 'tag_slug' => 'tag-b'],
            Tag::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function attributeCrudPayloads(): array
    {
        return [
            ['attribute_key' => 'Material', 'attribute_value' => 'Cotton'],
            ['attribute_key' => 'Material', 'attribute_value' => 'Wool'],
            Attribute::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function productCrudPayloads(): array
    {
        return [
            ['sku' => 'CRUD-1', 'quantity' => 2, 'locales' => ['en' => ['name' => 'Crud', 'product_slug' => 'crud']]],
            ['sku' => 'CRUD-2', 'quantity' => 3, 'locales' => ['en' => ['name' => 'Crud2', 'product_slug' => 'crud2']]],
            Product::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function customerCrudPayloads(): array
    {
        return [
            ['email' => 'crud-customer@example.com', 'password' => 'password123', 'first_name' => 'Crud'],
            ['email' => 'crud-customer@example.com', 'first_name' => 'Updated'],
            Customer::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function orderStatusCrudPayloads(): array
    {
        return [
            ['title' => 'Awaiting'],
            ['title' => 'Awaiting Updated'],
            OrderStatus::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function couponCrudPayloads(): array
    {
        return [
            [
                'title' => 'CRUD Coupon',
                'code' => 'CRUD10',
                'discount' => 10,
                'type' => 'percent',
                'usage_limit' => 0,
                'usage_per_customer' => 0,
                'active' => true,
            ],
            [
                'title' => 'CRUD Coupon Updated',
                'code' => 'CRUD10',
                'discount' => 15,
                'type' => 'percent',
                'usage_limit' => 0,
                'usage_per_customer' => 0,
                'active' => true,
            ],
            Coupon::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function discountCrudPayloads(): array
    {
        return [
            [
                'title' => 'CRUD Discount',
                'discount' => 10,
                'type' => 'percent',
                'active' => true,
            ],
            [
                'title' => 'CRUD Discount Updated',
                'discount' => 12,
                'type' => 'percent',
                'active' => true,
            ],
            Discount::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function reviewCrudPayloads(): array
    {
        $customer = Customer::query()->create([
            'email' => 'review-crud@example.com',
            'password' => bcrypt('password'),
        ]);
        $product = Product::query()->create(['sku' => 'REV-1', 'quantity' => 1, 'status' => 'published']);
        ProductLocale::query()->create([
            'product_id' => $product->id,
            'locale' => 'en',
            'name' => 'Review Product',
        ]);

        return [
            [
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'comment' => 'Great product',
                'rate' => 5,
            ],
            [
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'comment' => 'Updated review',
                'rate' => 4,
            ],
            Review::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function orderCrudPayloads(): array
    {
        $fixtures = $this->orderFixtures();

        return [
            [
                'customer_id' => $fixtures['customer_id'],
                'address_id' => $fixtures['address_id'],
                'order_status_id' => $fixtures['order_status_id'],
                'coupon_id' => $fixtures['coupon_id'],
                'items' => [
                    [
                        'product_attribute_id' => $fixtures['variant_id'],
                        'quantity' => 2,
                    ],
                ],
            ],
            [
                'customer_id' => $fixtures['customer_id'],
                'address_id' => $fixtures['address_id'],
                'order_status_id' => $fixtures['order_status_id'],
                'coupon_id' => $fixtures['coupon_id'],
                'items' => [
                    [
                        'product_attribute_id' => $fixtures['variant_id'],
                        'quantity' => 3,
                    ],
                ],
            ],
            Order::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function invoiceCrudPayloads(): array
    {
        $fixtures = $this->orderFixtures();

        $order = Order::query()->create([
            'customer_id' => $fixtures['customer_id'],
            'address_id' => $fixtures['address_id'],
            'amount' => 1000,
            'order_status_id' => $fixtures['order_status_id'],
            'coupon_id' => null,
            'updated_by' => $this->admin->id,
        ]);

        return [
            ['invoice_no' => 9001, 'order_id' => $order->id],
            ['invoice_no' => 9002, 'order_id' => $order->id],
            Invoice::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function userCrudPayloads(): array
    {
        return [
            [
                'email' => 'crud-user@example.com',
                'password' => 'password123',
                'first_name' => 'Crud',
                'last_name' => 'User',
                'roles' => ['viewer'],
            ],
            [
                'email' => 'crud-user@example.com',
                'first_name' => 'Crud',
                'last_name' => 'Updated',
                'roles' => ['manager'],
            ],
            User::class,
        ];
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, mixed>, 2: class-string}
     */
    private function roleCrudPayloads(): array
    {
        $name = 'crud-role-'.uniqid();

        return [
            [
                'name' => $name,
                'permissions' => ['view products', 'view orders'],
            ],
            [
                'name' => $name.'-updated',
                'permissions' => ['view products', 'view customers'],
            ],
            Role::class,
        ];
    }

    /**
     * @return array{customer_id: int, address_id: int, order_status_id: int, coupon_id: int, variant_id: int}
     */
    private function orderFixtures(): array
    {
        $customer = Customer::query()->create([
            'email' => 'order-crud-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);

        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Ship',
        ]);

        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $coupon = Coupon::query()->create([
            'title' => 'Order CRUD',
            'code' => strtoupper(substr(uniqid(), -6)),
            'discount' => 10,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'active' => true,
        ]);

        $product = Product::query()->create([
            'sku' => 'ORD-'.uniqid(),
            'quantity' => 5,
            'regular_price' => 500,
            'sale_price' => 400,
            'status' => 'published',
        ]);

        $color = Attribute::query()->create(['attribute_key' => 'Color', 'attribute_value' => 'Blue']);
        $size = Attribute::query()->create(['attribute_key' => 'Size', 'attribute_value' => 'L']);

        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $color->id,
            'attribute_2_id' => $size->id,
        ]);

        return [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'coupon_id' => $coupon->id,
            'variant_id' => $variant->id,
        ];
    }
}
