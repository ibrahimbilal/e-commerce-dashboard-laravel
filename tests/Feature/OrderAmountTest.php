<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAmountTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_order_amount_uses_server_price_and_rejects_foreign_address(): void
    {
        $customer = Customer::query()->create([
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
        ]);
        $otherCustomer = Customer::query()->create([
            'email' => 'other@example.com',
            'password' => bcrypt('password'),
        ]);

        $address = Address::query()->create([
            'customer_id' => $customer->id,
            'address_title' => 'Home',
        ]);
        $foreignAddress = Address::query()->create([
            'customer_id' => $otherCustomer->id,
            'address_title' => 'Elsewhere',
        ]);

        $status = OrderStatus::query()->create(['title' => 'Pending']);

        $product = Product::query()->create([
            'sku' => 'P1',
            'quantity' => 10,
            'regular_price' => 1000,
            'sale_price' => 800,
        ]);
        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $this->createAttribute('Color', 'Red'),
            'attribute_2_id' => $this->createAttribute('Size', 'M'),
        ]);

        $this->actingAs($this->admin)->post(route('orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $foreignAddress->id,
            'order_status_id' => $status->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 2, 'price' => -500],
            ],
        ])->assertSessionHasErrors('address_id');

        $this->actingAs($this->admin)->post(route('orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 2, 'price' => -500],
            ],
        ])->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'amount' => 1600,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_attribute_id' => $variant->id,
            'quantity' => 2,
            'price' => 800,
        ]);
    }

    private function createAttribute(string $key, string $value): int
    {
        return (int) \App\Models\Attribute::query()->create([
            'attribute_key' => $key,
            'attribute_value' => $value,
        ])->id;
    }
}
