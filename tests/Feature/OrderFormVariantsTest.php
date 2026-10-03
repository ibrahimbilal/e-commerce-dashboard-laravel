<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Attribute;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductLocale;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SkipsUntilAdminViewsMoved;
use Tests\TestCase;

class OrderFormVariantsTest extends TestCase
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

    public function test_order_create_and_edit_views_receive_product_variants(): void
    {
        $this->skipUntilAdminViewsMoved();
        $this->seedVariant();

        $create = $this->actingAs($this->admin)->get(route('admin.orders.create'));
        $create->assertOk();
        $create->assertViewHas('productVariants', fn ($variants) => $variants->count() >= 1);

        $order = $this->createOrderWithItem();

        $edit = $this->actingAs($this->admin)->get(route('admin.orders.edit', $order));
        $edit->assertOk();
        $edit->assertViewHas('productVariants', fn ($variants) => $variants->count() >= 1);
    }

    public function test_order_store_persists_line_items(): void
    {
        $variant = $this->seedVariant();
        $customer = Customer::query()->create([
            'email' => 'order-lines@example.com',
            'password' => bcrypt('password'),
        ]);
        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Home',
        ]);
        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 2],
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        $this->assertDatabaseHas('order_items', [
            'product_attribute_id' => $variant->id,
            'quantity' => 2,
        ]);
    }

    private function seedVariant(): ProductAttribute
    {
        $product = Product::query()->create([
            'sku' => 'ORD-VAR',
            'quantity' => 5,
            'regular_price' => 1000,
            'status' => 'published',
        ]);
        ProductLocale::query()->create([
            'product_id' => $product->id,
            'locale' => 'en',
            'name' => 'Variant Product',
        ]);
        $color = Attribute::query()->create(['attribute_key' => 'Color', 'attribute_value' => 'Red']);
        $size = Attribute::query()->create(['attribute_key' => 'Size', 'attribute_value' => 'M']);

        return ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $color->id,
            'attribute_2_id' => $size->id,
        ]);
    }

    private function createOrderWithItem()
    {
        $variant = $this->seedVariant();
        $customer = Customer::query()->create([
            'email' => 'existing-order@example.com',
            'password' => bcrypt('password'),
        ]);
        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Home',
        ]);
        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 1],
            ],
        ]);

        $orderId = \App\Models\Order::query()->latest('id')->value('id');

        return \App\Models\Order::query()->findOrFail($orderId);
    }
}
