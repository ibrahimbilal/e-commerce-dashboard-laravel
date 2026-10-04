<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAddressRepeaterTest extends TestCase
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
     * @return array<string, mixed>
     */
    private function customerPayload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'addr-'.uniqid('', true).'@example.com',
            'password' => 'password123',
            'first_name' => 'Addr',
        ], $overrides);
    }

    public function test_store_creates_customer_addresses(): void
    {
        $this->actingAs($this->admin)->post(route('admin.customers.store'), $this->customerPayload([
            'addresses_sync' => 1,
            'addresses' => [
                ['address_title' => 'Home', 'city' => 'Cairo', 'postcode' => '12345'],
                ['address_title' => 'Work', 'city' => 'Alex'],
            ],
        ]))->assertRedirect();

        $customer = Customer::query()->latest('id')->firstOrFail();
        $this->assertCount(2, $customer->addresses);
    }

    public function test_update_syncs_addresses_and_soft_deletes_removed_rows(): void
    {
        $customer = Customer::query()->create([
            'email' => 'sync-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);
        $keep = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Keep', 'city' => 'A']);
        $remove = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Remove', 'city' => 'B']);

        $this->actingAs($this->admin)->put(route('admin.customers.update', $customer), $this->customerPayload([
            'email' => $customer->email,
            'addresses_sync' => 1,
            'addresses' => [
                ['id' => $keep->id, 'address_title' => 'Keep Updated', 'city' => 'C'],
            ],
        ]))->assertRedirect();

        $this->assertSame('Keep Updated', $keep->fresh()->address_title);
        $this->assertSoftDeleted('addresses', ['id' => $remove->id]);
    }

    public function test_addresses_sync_without_addresses_soft_deletes_all(): void
    {
        $customer = Customer::query()->create([
            'email' => 'clear-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Gone']);

        $this->actingAs($this->admin)->put(route('admin.customers.update', $customer), $this->customerPayload([
            'email' => $customer->email,
            'addresses_sync' => 1,
        ]))->assertRedirect();

        $this->assertSoftDeleted('addresses', ['id' => $address->id]);
    }

    public function test_update_without_addresses_or_sync_leaves_addresses_untouched(): void
    {
        $customer = Customer::query()->create([
            'email' => 'noop-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);
        $address = Address::query()->create(['customer_id' => $customer->id, 'address_title' => 'Stay']);

        $this->actingAs($this->admin)->put(route('admin.customers.update', $customer), $this->customerPayload([
            'email' => $customer->email,
            'first_name' => 'Changed',
        ]))->assertRedirect();

        $this->assertFalse($address->fresh()->trashed());
        $this->assertSame('Stay', $address->fresh()->address_title);
    }

    public function test_foreign_address_id_is_rejected_on_update(): void
    {
        $customer = Customer::query()->create([
            'email' => 'foreign-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);
        $other = Customer::query()->create([
            'email' => 'other-'.uniqid('', true).'@example.com',
            'password' => bcrypt('password'),
        ]);
        $foreign = Address::query()->create(['customer_id' => $other->id, 'address_title' => 'Foreign']);

        $this->actingAs($this->admin)->putJson(route('admin.customers.update', $customer), $this->customerPayload([
            'email' => $customer->email,
            'addresses_sync' => 1,
            'addresses' => [
                ['id' => $foreign->id, 'address_title' => 'Hack'],
            ],
        ]))->assertUnprocessable()->assertJsonValidationErrors(['addresses.0.id']);
    }

    public function test_postcode_max_five_characters(): void
    {
        $this->actingAs($this->admin)->postJson(route('admin.customers.store'), $this->customerPayload([
            'addresses_sync' => 1,
            'addresses' => [
                ['address_title' => 'Home', 'postcode' => '123456'],
            ],
        ]))->assertUnprocessable()->assertJsonValidationErrors(['addresses.0.postcode']);
    }
}
