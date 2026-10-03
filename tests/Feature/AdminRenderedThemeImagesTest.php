<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRenderedThemeImagesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_admin_pages_render_theme_images_under_public_images(): void
    {
        $category = Category::query()->firstOrFail();
        $tag = Tag::query()->firstOrFail();
        $product = Product::query()->firstOrFail();
        $customer = Customer::query()->firstOrFail();
        $order = Order::query()->firstOrFail();
        $invoice = Invoice::query()->firstOrFail();

        $pages = [
            route('admin.dashboard'),
            route('admin.categories.create'),
            route('admin.categories.edit', $category),
            route('admin.customers.create'),
            route('admin.customers.edit', $customer),
            route('admin.customers.index'),
            route('admin.customers.show', $customer),
            route('admin.invoices.show', $invoice),
            route('admin.orders.show', $order),
            route('admin.products.create'),
            route('admin.products.edit', $product),
            route('admin.products.index'),
            route('admin.tags.create'),
            route('admin.tags.edit', $tag),
        ];

        $checked = [];

        foreach ($pages as $page) {
            $response = $this->actingAs($this->admin)->get($page);
            $response->assertOk();

            $html = $response->getContent();
            preg_match_all('#(?:src|data-flag)=["\']([^"\']+)["\']#', $html, $matches);

            foreach ($matches[1] as $raw) {
                $path = parse_url($raw, PHP_URL_PATH) ?? $raw;
                if (! is_string($path) || ! str_starts_with($path, '/images/')) {
                    continue;
                }
                if ($path === false || $path === null || $path === '') {
                    continue;
                }

                if (isset($checked[$path])) {
                    continue;
                }
                $checked[$path] = true;

                $file = public_path(ltrim($path, '/'));
                $this->assertFileExists($file, "Missing public file for {$path} referenced on {$page}");
            }
        }

        $this->assertNotEmpty($checked);
    }
}
