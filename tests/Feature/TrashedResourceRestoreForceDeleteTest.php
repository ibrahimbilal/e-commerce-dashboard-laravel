<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Gallery;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TrashedResourceRestoreForceDeleteTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class, RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->viewer = User::factory()->create([
            'email' => 'viewer-trash@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->viewer->markEmailAsVerified();
        $this->viewer->assignRole('viewer');
    }

    /**
     * @dataProvider trashedResourceProvider
     */
    public function test_admin_can_restore_trashed_row(string $prefix, string $indexRoute, callable $createTrashed): void
    {
        $model = $createTrashed($this->admin);
        $model->delete();
        $this->assertSoftDeleted($model);

        $this->actingAs($this->admin)
            ->patch(route($prefix.'.restore', $model->getKey()))
            ->assertRedirect(route($indexRoute, ['trashed' => '1']))
            ->assertSessionHas('status');

        $this->assertNotSoftDeleted($model->fresh());
    }

    /**
     * @dataProvider trashedResourceProvider
     */
    public function test_admin_can_force_delete_trashed_row(string $prefix, string $indexRoute, callable $createTrashed): void
    {
        $model = $createTrashed($this->admin);
        $model->delete();

        $this->actingAs($this->admin)
            ->delete(route($prefix.'.force-delete', $model->getKey()))
            ->assertRedirect(route($indexRoute, ['trashed' => '1']))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing($model->getTable(), ['id' => $model->getKey()]);
    }

    /**
     * @dataProvider trashedResourceProvider
     */
    public function test_viewer_forbidden_on_restore_and_force_delete(string $prefix, string $indexRoute, callable $createTrashed): void
    {
        $model = $createTrashed($this->admin);
        $model->delete();

        $this->actingAs($this->viewer)
            ->patch(route($prefix.'.restore', $model->getKey()))
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->delete(route($prefix.'.force-delete', $model->getKey()))
            ->assertForbidden();
    }

    public function test_restore_returns_404_when_row_is_not_trashed(): void
    {
        $tag = Tag::query()->create([
            'title' => 'Live',
            'locale' => 'en',
            'tag_slug' => 'live-tag',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('tags.restore', $tag->id))
            ->assertNotFound();
    }

    public function test_product_on_order_cannot_be_force_deleted(): void
    {
        $product = Product::query()->create(['sku' => 'FK-P', 'quantity' => 1, 'status' => 'published']);
        $attribute = \App\Models\Attribute::query()->create(['attribute_key' => 'Size', 'attribute_value' => 'M']);
        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $attribute->id,
            'attribute_2_id' => $attribute->id,
        ]);
        $customer = Customer::query()->create(['email' => 'fk-p@example.com', 'password' => bcrypt('x')]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Home']);
        $status = OrderStatus::query()->create(['title' => 'Pending']);
        $order = Order::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'amount' => 10,
            'order_status_id' => $status->id,
            'updated_by' => $this->admin->id,
        ]);
        OrderItem::query()->create([
            'order_id' => $order->id,
            'product_attribute_id' => $variant->id,
            'quantity' => 1,
            'price' => 10,
        ]);

        $product->delete();

        $this->actingAs($this->admin)
            ->from(route('products.index', ['trashed' => 1]))
            ->delete(route('products.force-delete', $product->id))
            ->assertRedirect(route('products.index', ['trashed' => 1]))
            ->assertSessionHas('status');

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public static function trashedResourceProvider(): array
    {
        return [
            'products' => [
                'products',
                'products.index',
                fn (User $admin) => Product::query()->create(['sku' => 'TR-'.uniqid(), 'quantity' => 1, 'status' => 'draft']),
            ],
            'categories' => [
                'categories',
                'categories.index',
                fn (User $admin) => Category::query()->create(['title' => 'Trash Cat', 'locale' => 'en', 'category_slug' => 'trash-'.uniqid()]),
            ],
            'tags' => [
                'tags',
                'tags.index',
                fn (User $admin) => Tag::query()->create(['title' => 'Trash Tag', 'locale' => 'en', 'tag_slug' => 'trash-'.uniqid()]),
            ],
            'orders' => [
                'orders',
                'orders.index',
                function (User $admin) {
                    $customer = Customer::query()->create(['email' => 'ord-'.uniqid().'@example.com', 'password' => bcrypt('x')]);
                    $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Home']);
                    $status = OrderStatus::query()->create(['title' => 'Trash Status']);

                    return Order::query()->create([
                        'customer_id' => $customer->id,
                        'address_id' => $address->id,
                        'amount' => 1,
                        'order_status_id' => $status->id,
                        'updated_by' => $admin->id,
                    ]);
                },
            ],
            'customers' => [
                'customers',
                'customers.index',
                fn (User $admin) => Customer::query()->create(['email' => 'cust-'.uniqid().'@example.com', 'password' => bcrypt('x')]),
            ],
            'coupons' => [
                'coupons',
                'coupons.index',
                fn (User $admin) => Coupon::query()->create([
                    'title' => 'Trash Coupon',
                    'code' => strtoupper(substr(uniqid(), -5)),
                    'discount' => 5,
                    'type' => 'percent',
                    'usage_limit' => 0,
                    'usage_per_customer' => 0,
                    'active' => true,
                ]),
            ],
            'discounts' => [
                'discounts',
                'discounts.index',
                fn (User $admin) => Discount::query()->create([
                    'title' => 'Trash Discount',
                    'discount' => 5,
                    'type' => 'percent',
                    'active' => true,
                ]),
            ],
            'reviews' => [
                'reviews',
                'reviews.index',
                function (User $admin) {
                    $customer = Customer::query()->create(['email' => 'rev-'.uniqid().'@example.com', 'password' => bcrypt('x')]);
                    $product = Product::query()->create(['sku' => 'REV-'.uniqid(), 'quantity' => 1, 'status' => 'published']);

                    return Review::query()->create([
                        'customer_id' => $customer->id,
                        'product_id' => $product->id,
                        'rate' => 5,
                        'comment' => 'Nice',
                    ]);
                },
            ],
            'invoices' => [
                'invoices',
                'invoices.index',
                fn (User $admin) => Invoice::query()->create(['invoice_no' => random_int(1000, 9999)]),
            ],
            'users' => [
                'users',
                'users.index',
                function (User $admin) {
                    $user = User::factory()->create(['email' => 'trash-user-'.uniqid().'@example.com']);
                    $user->markEmailAsVerified();
                    $user->assignRole('viewer');

                    return $user;
                },
            ],
            'order-statuses' => [
                'order-statuses',
                'order-statuses.index',
                fn (User $admin) => OrderStatus::query()->create(['title' => 'Trash OS '.uniqid()]),
            ],
            'gallery' => [
                'gallery',
                'gallery.index',
                fn (User $admin) => Gallery::query()->create([
                    'url' => 'demo/trash.png',
                    'user_id' => $admin->id,
                ]),
            ],
            'addresses' => [
                'addresses',
                'customers.index',
                function (User $admin) {
                    $customer = Customer::query()->create(['email' => 'addr-'.uniqid().'@example.com', 'password' => bcrypt('x')]);

                    return Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Trash']);
                },
            ],
        ];
    }
}
