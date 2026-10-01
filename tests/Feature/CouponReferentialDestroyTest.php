<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponReferentialDestroyTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_coupon_used_on_order_cannot_be_soft_deleted(): void
    {
        $coupon = Coupon::query()->create([
            'title' => 'Used',
            'code' => 'USED1',
            'discount' => 5,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'active' => true,
        ]);

        $customer = Customer::query()->create(['email' => 'c@example.com', 'password' => bcrypt('x')]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Home']);
        $status = OrderStatus::query()->create(['title' => 'Pending']);

        Order::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'amount' => 100,
            'order_status_id' => $status->id,
            'coupon_id' => $coupon->id,
            'updated_by' => $this->admin->id,
        ]);

        $this->actingAs($this->admin)
            ->from(route('coupons.index'))
            ->delete(route('coupons.destroy', $coupon))
            ->assertRedirect(route('coupons.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('coupons', ['id' => $coupon->id, 'deleted_at' => null]);
    }

    public function test_coupon_used_on_order_cannot_be_force_deleted_when_trashed(): void
    {
        $coupon = Coupon::query()->create([
            'title' => 'Trashed Used',
            'code' => 'TRSH1',
            'discount' => 5,
            'type' => 'percent',
            'usage_limit' => 0,
            'usage_per_customer' => 0,
            'active' => true,
        ]);

        $customer = Customer::query()->create(['email' => 'c2@example.com', 'password' => bcrypt('x')]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Home']);
        $status = OrderStatus::query()->create(['title' => 'Pending']);

        Order::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'amount' => 50,
            'order_status_id' => $status->id,
            'coupon_id' => $coupon->id,
            'updated_by' => $this->admin->id,
        ]);

        $coupon->delete();

        $this->actingAs($this->admin)
            ->from(route('coupons.index', ['trashed' => 1]))
            ->delete(route('coupons.force-delete', $coupon->id))
            ->assertRedirect(route('coupons.index', ['trashed' => 1]))
            ->assertSessionHas('status');

        $this->assertSoftDeleted('coupons', ['id' => $coupon->id]);
    }
}
