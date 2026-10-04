<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMovedFormAjaxRenderTest extends TestCase
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
    private function movedFormRoutes(): array
    {
        $category = Category::query()->firstOrFail();
        $tag = Tag::query()->firstOrFail();
        $product = Product::query()->firstOrFail();
        $customer = Customer::query()->firstOrFail();
        $coupon = Coupon::query()->firstOrFail();
        $discount = Discount::query()->firstOrFail();
        $attribute = Attribute::query()->firstOrFail();
        $orderStatus = OrderStatus::query()->firstOrFail();
        $order = Order::query()->firstOrFail();
        $invoice = Invoice::query()->firstOrFail();
        $review = Review::query()->firstOrFail();

        return [
            route('admin.attributes.create'),
            route('admin.attributes.edit', $attribute),
            route('admin.categories.create'),
            route('admin.categories.edit', $category),
            route('admin.coupons.create'),
            route('admin.coupons.edit', $coupon),
            route('admin.customers.create'),
            route('admin.customers.edit', $customer),
            route('admin.discounts.create'),
            route('admin.discounts.edit', $discount),
            route('admin.invoices.create'),
            route('admin.invoices.edit', $invoice),
            route('admin.order-statuses.create'),
            route('admin.order-statuses.edit', $orderStatus),
            route('admin.orders.create'),
            route('admin.orders.edit', $order),
            route('admin.products.create'),
            route('admin.products.edit', $product),
            route('admin.reviews.create'),
            route('admin.reviews.edit', $review),
            route('admin.tags.create'),
            route('admin.tags.edit', $tag),
        ];
    }

    public function test_moved_create_edit_forms_include_ajax_form_binding_and_script(): void
    {
        foreach ($this->movedFormRoutes() as $url) {
            $response = $this->actingAs($this->admin)->get($url);
            $response->assertOk();
            $response->assertSee('data-ajax-form', false);
            $response->assertSee('assets/js/ajax-form.js', false);
        }
    }

    public function test_products_create_shows_required_markers_and_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.create'));
        $response->assertOk();
        $response->assertSee('name="product_name"', false);
        $response->assertSee('required', false);
        $response->assertSee('name="status"', false);
        $response->assertSee('data-error-for="category_ids"', false);
        $response->assertSee('text-danger', false);
        $response->assertSee('name="regular_price"', false);
        $response->assertSee('step="0.01"', false);
    }
}
