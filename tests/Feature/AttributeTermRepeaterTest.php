<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttributeTermRepeaterTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_store_creates_one_row_per_term(): void
    {
        $this->actingAs($this->admin)->post(route('admin.attributes.store'), [
            'attribute_key' => 'Color',
            'terms' => [
                ['title' => 'Red', 'type' => 'color', 'value' => '#ff0000'],
                ['title' => 'Blue', 'type' => 'color', 'value' => '#0000ff'],
            ],
        ])->assertRedirect();

        $this->assertSame(2, Attribute::query()->where('attribute_key', 'Color')->count());
    }

    public function test_store_rejects_duplicate_attribute_key(): void
    {
        Attribute::query()->create([
            'attribute_key' => 'Size',
            'attribute_value' => 'M',
            'term_title' => 'M',
            'term_type' => 'text',
        ]);

        $this->actingAs($this->admin)->postJson(route('admin.attributes.store'), [
            'attribute_key' => 'Size',
            'terms' => [
                ['title' => 'L', 'type' => 'text', 'value' => 'L'],
            ],
        ])->assertUnprocessable()->assertJsonValidationErrors(['attribute_key']);
    }

    public function test_color_term_requires_valid_hex(): void
    {
        $this->actingAs($this->admin)->postJson(route('admin.attributes.store'), [
            'attribute_key' => 'Color',
            'terms' => [
                ['title' => 'Bad', 'type' => 'color', 'value' => 'red'],
            ],
        ])->assertUnprocessable()->assertJsonValidationErrors(['terms.0.value']);
    }

    public function test_update_can_rename_attribute_key_and_sync_terms(): void
    {
        $red = Attribute::query()->create([
            'attribute_key' => 'Colour',
            'attribute_value' => '#f00',
            'term_title' => 'Red',
            'term_type' => 'color',
        ]);
        Attribute::query()->create([
            'attribute_key' => 'Colour',
            'attribute_value' => 'navy',
            'term_title' => 'Navy',
            'term_type' => 'text',
        ]);

        $this->actingAs($this->admin)->put(route('admin.attributes.update', $red), [
            'attribute_key' => 'Color',
            'terms' => [
                ['id' => $red->id, 'title' => 'Red', 'type' => 'color', 'value' => '#f00'],
            ],
        ])->assertRedirect();

        $this->assertSame(1, Attribute::query()->where('attribute_key', 'Color')->count());
        $this->assertSame(0, Attribute::query()->where('attribute_key', 'Colour')->count());
    }

    public function test_update_blocks_removing_term_used_on_variants(): void
    {
        $keep = Attribute::query()->create([
            'attribute_key' => 'Size',
            'attribute_value' => 'M',
            'term_title' => 'M',
            'term_type' => 'text',
        ]);
        $drop = Attribute::query()->create([
            'attribute_key' => 'Size',
            'attribute_value' => 'L',
            'term_title' => 'L',
            'term_type' => 'text',
        ]);
        $product = Product::query()->create(['sku' => 'VAR-1', 'quantity' => 1, 'status' => 'published']);
        ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $drop->id,
            'attribute_2_id' => $keep->id,
        ]);

        $this->actingAs($this->admin)->putJson(route('admin.attributes.update', $keep), [
            'attribute_key' => 'Size',
            'terms' => [
                ['id' => $keep->id, 'title' => 'M', 'type' => 'text', 'value' => 'M'],
            ],
        ])->assertUnprocessable()->assertJsonValidationErrors(['terms']);
    }

    public function test_destroy_blocks_when_term_used_on_variants(): void
    {
        $term = Attribute::query()->create([
            'attribute_key' => 'Fabric',
            'attribute_value' => 'Cotton',
            'term_title' => 'Cotton',
            'term_type' => 'text',
        ]);
        $other = Attribute::query()->create([
            'attribute_key' => 'Fabric',
            'attribute_value' => 'Wool',
            'term_title' => 'Wool',
            'term_type' => 'text',
        ]);
        $product = Product::query()->create(['sku' => 'VAR-2', 'quantity' => 1, 'status' => 'published']);
        ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $term->id,
            'attribute_2_id' => $other->id,
        ]);

        $this->actingAs($this->admin)->deleteJson(route('admin.attributes.destroy', $term))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['terms']);

        $this->assertDatabaseHas('attributes', ['id' => $term->id]);
    }

    public function test_json_delete_unused_attribute_returns_success_with_counts(): void
    {
        $term = Attribute::query()->create([
            'attribute_key' => 'Finish',
            'attribute_value' => 'Matte',
            'term_title' => 'Matte',
            'term_type' => 'text',
        ]);

        $this->actingAs($this->admin)
            ->deleteJson(route('admin.attributes.destroy', $term), [], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Attribute deleted.',
            ])
            ->assertJsonStructure(['counts' => ['all']]);

        $this->assertDatabaseMissing('attributes', ['id' => $term->id]);
    }

    public function test_spoofed_delete_unused_attribute_returns_json_success(): void
    {
        $term = Attribute::query()->create([
            'attribute_key' => 'Finish',
            'attribute_value' => 'Gloss',
            'term_title' => 'Gloss',
            'term_type' => 'text',
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.attributes.destroy', $term), [
                '_method' => 'DELETE',
            ], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('attributes', ['id' => $term->id]);
    }

    public function test_spoofed_delete_in_use_attribute_returns_422_terms_error(): void
    {
        $keep = Attribute::query()->create([
            'attribute_key' => 'Edge',
            'attribute_value' => 'Soft',
            'term_title' => 'Soft',
            'term_type' => 'text',
        ]);
        $blocked = Attribute::query()->create([
            'attribute_key' => 'Edge',
            'attribute_value' => 'Sharp',
            'term_title' => 'Sharp',
            'term_type' => 'text',
        ]);
        $product = Product::query()->create(['sku' => 'VAR-3', 'quantity' => 1, 'status' => 'published']);
        ProductAttribute::query()->create([
            'product_id' => $product->id,
            'attribute_1_id' => $blocked->id,
            'attribute_2_id' => $keep->id,
        ]);

        $this->actingAs($this->admin)
            ->post(route('admin.attributes.destroy', $blocked), [
                '_method' => 'DELETE',
            ], [
                'Accept' => 'application/json',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['terms']);

        $this->assertDatabaseHas('attributes', ['id' => $blocked->id]);
    }
}
