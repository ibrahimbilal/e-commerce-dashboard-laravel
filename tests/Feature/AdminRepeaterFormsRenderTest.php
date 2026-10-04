<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\Customer;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRepeaterFormsRenderTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    /**
     * @return array<int, string>
     */
    private function repeaterFormRoutes(): array
    {
        $customer = Customer::query()->firstOrFail();
        $attribute = Attribute::query()->firstOrFail();

        return [
            route('admin.customers.create'),
            route('admin.customers.edit', $customer),
            route('admin.attributes.create'),
            route('admin.attributes.edit', $attribute),
        ];
    }

    public function test_repeater_pages_include_script_template_and_indexed_names(): void
    {
        foreach ($this->repeaterFormRoutes() as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertOk();
            $response->assertSee('assets/js/repeater.js', false);
            $response->assertSee('data-repeater-template', false);
            if (str_contains($url, '/customers/')) {
                $response->assertSee('id="customer-address-row-template"', false);
            } else {
                $response->assertSee('id="attribute-term-row-template"', false);
            }
        }

        $customerCreate = $this->actingAs($this->admin)->get(route('admin.customers.create'));
        $customerCreate->assertSee('name="addresses_sync"', false);
        $customerCreate->assertSee('data-error-for="addresses"', false);
        $customerCreate->assertSee('name="addresses[0][address_title]"', false);
        $customerCreate->assertDontSee('disabled="disabled"', false);

        $attributeCreate = $this->actingAs($this->admin)->get(route('admin.attributes.create'));
        $attributeCreate->assertSee('data-error-for="terms"', false);
        $attributeCreate->assertSee('name="terms[0][title]"', false);
        $attributeCreate->assertSee('name="terms[0][type]"', false);
        $attributeCreate->assertSee('name="terms[0][value]"', false);
    }
}
