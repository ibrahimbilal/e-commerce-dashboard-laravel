<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferentialDestroyTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_attribute_in_use_cannot_be_deleted(): void
    {
        $attribute = Attribute::query()->create(['attribute_key' => 'Color', 'attribute_value' => 'Blue']);
        $product = Product::query()->create(['sku' => 'FK-1', 'quantity' => 1, 'status' => 'published']);
        $variant = ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $attribute->id,
            'attribute_2_id' => $attribute->id,
        ]);
        $customer = Customer::query()->create(['email' => 'fk@example.com', 'password' => bcrypt('x')]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Home']);
        $status = OrderStatus::query()->create(['title' => 'Pending']);
        $order = Order::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'amount' => 100,
            'order_status_id' => $status->id,
            'coupon_id' => null,
            'updated_by' => $this->admin->id,
        ]);
        OrderItem::query()->create([
            'order_id' => $order->id,
            'product_attribute_id' => $variant->id,
            'quantity' => 1,
            'price' => 100,
        ]);

        $this->actingAs($this->admin)
            ->from(route('admin.attributes.index'))
            ->delete(route('admin.attributes.destroy', $attribute))
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHasErrors('terms');

        $this->assertDatabaseHas('attributes', ['id' => $attribute->id]);
    }
}
