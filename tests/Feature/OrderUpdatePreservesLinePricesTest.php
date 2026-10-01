<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderUpdatePreservesLinePricesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_unchanged_order_lines_keep_stored_prices_after_catalog_price_changes(): void
    {
        [$order, $variant] = $this->createOrderWithLine(quantity: 2, unitPrice: 100);

        $this->assertSame(200, (int) $order->fresh()->amount);

        $variant->product->update(['regular_price' => 9999, 'sale_price' => null]);

        $this->actingAs($this->admin)->put(route('orders.update', $order), [
            'customer_id' => $order->customer_id,
            'address_id' => $order->address_id,
            'order_status_id' => $order->order_status_id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 2],
            ],
        ])->assertRedirect();

        $this->assertSame(200, (int) $order->fresh()->amount);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_attribute_id' => $variant->id,
            'quantity' => 2,
            'price' => 100,
        ]);

        $this->actingAs($this->admin)->put(route('orders.update', $order), [
            'customer_id' => $order->customer_id,
            'address_id' => $order->address_id,
            'order_status_id' => $order->order_status_id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 3],
            ],
        ])->assertRedirect();

        $this->assertSame(29997, (int) $order->fresh()->amount);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_attribute_id' => $variant->id,
            'quantity' => 3,
            'price' => 9999,
        ]);
    }

    /**
     * @return array{0: Order, 1: ProductAttribute}
     */
    private function createOrderWithLine(int $quantity, int $unitPrice): array
    {
        $customer = Customer::query()->create([
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Home',
        ]);

        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $product = Product::query()->create([
            'sku' => 'P1',
            'quantity' => 10,
            'regular_price' => $unitPrice,
            'sale_price' => null,
        ]);

        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $this->createAttribute('Color', 'Red'),
            'attribute_2_id' => $this->createAttribute('Size', 'M'),
        ]);

        $this->actingAs($this->admin)->post(route('orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => $quantity],
            ],
        ])->assertRedirect();

        $order = Order::query()->latest('id')->firstOrFail();

        return [$order, $variant];
    }

    private function createAttribute(string $key, string $value): int
    {
        return (int) \App\Models\Attribute::query()->create([
            'attribute_key' => $key,
            'attribute_value' => $value,
        ])->id;
    }
}
