<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Coupon;
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

class OrderCouponDiscountTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_percent_coupon_reduces_order_amount_from_subtotal(): void
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
            'regular_price' => 1000,
            'sale_price' => null,
        ]);
        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $this->createAttribute('Color', 'Red'),
            'attribute_2_id' => $this->createAttribute('Size', 'M'),
        ]);

        $coupon = Coupon::query()->create([
            'title' => 'Ten off',
            'code' => 'TENOFF',
            'discount' => 10,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'active' => true,
        ]);

        $this->actingAs($this->admin)->post(route('admin.orders.store'), [
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'order_status_id' => $status->id,
            'coupon_id' => $coupon->id,
            'items' => [
                ['product_attribute_id' => $variant->id, 'quantity' => 2],
            ],
        ])->assertRedirect();

        // Subtotal 2000; 10% off → 1800
        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'coupon_id' => $coupon->id,
            'amount' => 1800,
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
