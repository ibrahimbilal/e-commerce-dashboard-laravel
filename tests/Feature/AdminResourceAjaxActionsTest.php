<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AdminResourceAjaxActionsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_soft_delete_returns_json_counts_when_requested(): void
    {
        $product = Product::factory()->create();

        $this->actingAs($this->admin)
            ->deleteJson(route('admin.products.destroy', $product))
            ->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure(['message', 'counts' => ['all', 'trashed']]);

        $this->assertSoftDeleted($product);
    }

    public function test_restore_returns_json_counts_when_requested(): void
    {
        $product = Product::factory()->create();
        $product->delete();

        $this->actingAs($this->admin)
            ->patchJson(route('admin.products.restore', $product->getKey()))
            ->assertOk()
            ->assertJson(['success' => true])
            ->assertJsonStructure(['counts' => ['trashed']]);
    }

    public function test_product_featured_toggle_returns_json_counts(): void
    {
        $product = Product::factory()->create(['featured' => false]);

        $this->actingAs($this->admin)
            ->patchJson(route('admin.products.toggle', $product->getKey()), ['field' => 'featured', 'value' => true])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'field' => 'featured',
                'value' => true,
            ])
            ->assertJsonStructure(['counts' => ['featured']]);

        $this->assertTrue($product->fresh()->featured);
    }

    public function test_discount_active_toggle_returns_json_counts(): void
    {
        $discount = Discount::query()->create([
            'title' => 'Toggle me',
            'discount' => 10,
            'type' => 'percent',
            'active' => false,
        ]);

        $this->actingAs($this->admin)
            ->patchJson(route('admin.discounts.toggle', $discount->getKey()), ['field' => 'active'])
            ->assertOk()
            ->assertJsonPath('value', true)
            ->assertJsonStructure(['counts' => ['active', 'inactive']]);
    }
}
