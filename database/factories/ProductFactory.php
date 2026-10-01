<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $regular = fake()->numberBetween(500, 50000);
        $onSale = fake()->boolean(35);

        return [
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####')),
            'product_img' => null,
            'regular_price' => $regular,
            'sale_price' => $onSale ? (int) round($regular * fake()->randomFloat(2, 0.5, 0.9)) : null,
            'schedule_sale' => null,
            'quantity' => fake()->numberBetween(0, 200),
            'status' => fake()->randomElement(['published', 'draft']),
            'new' => fake()->boolean(30),
            'featured' => fake()->boolean(25),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => 'published']);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }
}
