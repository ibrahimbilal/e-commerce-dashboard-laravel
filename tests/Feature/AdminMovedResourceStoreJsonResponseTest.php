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
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMovedResourceStoreJsonResponseTest extends TestCase
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
     * @dataProvider movedResources
     *
     * @param  callable(): array<string, mixed>  $payloadFactory
     * @param  callable(): array{message: string, redirect: string}  $expectationFactory
     */
    public function test_store_returns_json_success_shape_when_expecting_json(
        string $routeName,
        callable $payloadFactory,
        callable $expectationFactory
    ): void {
        $response = $this->actingAs($this->admin)->postJson(route($routeName), $payloadFactory());
        $expected = $expectationFactory();

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => $expected['message'],
            'redirect' => $expected['redirect'],
        ]);
        $response->assertJsonStructure(['success', 'message', 'redirect']);
    }

    /**
     * @dataProvider movedResources
     *
     * @param  callable(): array<string, mixed>  $payloadFactory
     * @param  callable(): array{message: string, redirect: string}  $expectationFactory
     */
    public function test_store_still_redirects_for_normal_post(
        string $routeName,
        callable $payloadFactory,
        callable $expectationFactory
    ): void {
        $response = $this->actingAs($this->admin)->post(route($routeName), $payloadFactory());

        $expected = $expectationFactory();

        $response->assertRedirect($expected['redirect']);
        $response->assertSessionHas('status', $expected['message']);
    }

    public function movedResources(): array
    {
        return [
            'attributes' => [
                'admin.attributes.store',
                fn () => ['attribute_key' => 'Color', 'attribute_value' => 'Red'],
                fn () => [
                    'message' => 'Attribute created.',
                    'redirect' => route('admin.attributes.index'),
                ],
            ],
            'categories' => [
                'admin.categories.store',
                fn () => [
                    'title' => 'Json Cat',
                    'locale' => 'en',
                    'category_slug' => 'json-cat-'.uniqid(),
                ],
                fn () => [
                    'message' => 'Category created.',
                    'redirect' => route('admin.categories.index'),
                ],
            ],
            'tags' => [
                'admin.tags.store',
                fn () => [
                    'title' => 'Json Tag',
                    'locale' => 'en',
                    'tag_slug' => 'json-tag-'.uniqid(),
                ],
                fn () => [
                    'message' => 'Tag created.',
                    'redirect' => route('admin.tags.index'),
                ],
            ],
            'coupons' => [
                'admin.coupons.store',
                fn () => [
                    'title' => 'Json Coupon',
                    'code' => strtoupper(substr(uniqid(), -6)),
                    'discount' => 10,
                    'type' => 'percent',
                    'usage_limit' => 0,
                    'usage_per_customer' => 0,
                    'active' => true,
                ],
                fn () => [
                    'message' => 'Coupon created.',
                    'redirect' => route('admin.coupons.index'),
                ],
            ],
            'discounts' => [
                'admin.discounts.store',
                fn () => [
                    'title' => 'Json Discount',
                    'discount' => 10,
                    'type' => 'percent',
                    'active' => true,
                ],
                fn () => [
                    'message' => 'Discount created.',
                    'redirect' => route('admin.discounts.index'),
                ],
            ],
            'customers' => [
                'admin.customers.store',
                fn () => [
                    'email' => 'json-customer-'.uniqid('', true).'@example.com',
                    'password' => 'password123',
                    'first_name' => 'Json',
                ],
                function () {
                    $customer = Customer::query()->latest('id')->firstOrFail();

                    return [
                        'message' => 'Customer created.',
                        'redirect' => route('admin.customers.show', $customer),
                    ];
                },
            ],
            'order-statuses' => [
                'admin.order-statuses.store',
                fn () => ['title' => 'Json Status '.uniqid()],
                fn () => [
                    'message' => 'Order status created.',
                    'redirect' => route('admin.order-statuses.index'),
                ],
            ],
            'products' => [
                'admin.products.store',
                function () {
                    $category = Category::query()->create([
                        'title' => 'Json Product Cat',
                        'locale' => 'en',
                        'category_slug' => 'json-prod-cat-'.uniqid(),
                    ]);

                    return [
                        'sku' => 'JSON-'.uniqid(),
                        'quantity' => 1,
                        'regular_price' => 100,
                        'status' => 'published',
                        'category_ids' => [$category->id],
                        'locales' => [
                            'en' => [
                                'name' => 'Json Product',
                                'product_slug' => 'json-product-'.uniqid(),
                            ],
                        ],
                    ];
                },
                function () {
                    $product = Product::query()->latest('id')->firstOrFail();

                    return [
                        'message' => 'Product created.',
                        'redirect' => route('admin.products.edit', $product),
                    ];
                },
            ],
            'reviews' => [
                'admin.reviews.store',
                function () {
                    $customer = Customer::query()->create([
                        'email' => 'json-review-'.uniqid('', true).'@example.com',
                        'password' => bcrypt('password'),
                    ]);
                    $product = Product::query()->create([
                        'sku' => 'REV-'.uniqid(),
                        'quantity' => 1,
                        'regular_price' => 50,
                        'status' => 'published',
                    ]);
                    ProductLocale::query()->create([
                        'product_id' => $product->id,
                        'locale' => 'en',
                        'name' => 'Review Target',
                    ]);

                    return [
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'comment' => 'Nice',
                        'rate' => 5,
                    ];
                },
                fn () => [
                    'message' => 'Review created.',
                    'redirect' => route('admin.reviews.index'),
                ],
            ],
            'orders' => [
                'admin.orders.store',
                fn () => self::orderStorePayload(),
                function () {
                    $order = Order::query()->latest('id')->firstOrFail();

                    return [
                        'message' => 'Order created.',
                        'redirect' => route('admin.orders.edit', $order),
                    ];
                },
            ],
            'invoices' => [
                'admin.invoices.store',
                function () {
                    $fixtures = self::orderFixtures();
                    $adminId = User::query()->where('email', 'admin@example.com')->value('id');
                    $order = Order::query()->create([
                        'customer_id' => $fixtures['customer_id'],
                        'address_id' => $fixtures['address_id'],
                        'amount' => 1000,
                        'order_status_id' => $fixtures['order_status_id'],
                        'coupon_id' => null,
                        'updated_by' => $adminId,
                    ]);

                    return [
                        'invoice_no' => random_int(10000, 99999),
                        'order_id' => $order->id,
                    ];
                },
                function () {
                    $invoice = Invoice::query()->latest('id')->firstOrFail();

                    return [
                        'message' => 'Invoice created.',
                        'redirect' => route('admin.invoices.show', $invoice),
                    ];
                },
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function orderStorePayload(): array
    {
        $fixtures = self::orderFixtures();

        return [
            'customer_id' => $fixtures['customer_id'],
            'address_id' => $fixtures['address_id'],
            'order_status_id' => $fixtures['order_status_id'],
            'coupon_id' => $fixtures['coupon_id'],
            'items' => [
                [
                    'product_attribute_id' => $fixtures['variant_id'],
                    'quantity' => 1,
                ],
            ],
        ];
    }

    /**
     * @return array{customer_id: int, address_id: int, order_status_id: int, coupon_id: int, variant_id: int}
     */
    private static function orderFixtures(): array
    {
        $customer = Customer::query()->create([
            'email' => 'json-order-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);

        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Ship',
        ]);

        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $coupon = Coupon::query()->create([
            'title' => 'Json Order Coupon',
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
