<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'title' => Str::limit($title, 50, ''),
            'description' => fake()->optional()->sentence(),
            'category_slug' => Str::slug($title),
            'cat_img' => null,
            'active' => true,
            'parent_id' => null,
            'locale' => 'en',
            'meta_title' => null,
            'meta_keywords' => null,
            'meta_description' => null,
            'deleted' => false,
        ];
    }
}
