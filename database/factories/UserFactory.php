<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
			'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
			'email' => fake()->safeEmail(),
			'password' => Hash::make('password'),
			'mobile' => fake()->e164PhoneNumber(),
			'birth_date' => fake()->date('Y-m-d', '-18 years'),
			'gender' => fake()->randomElement(['male', 'female']),
			'role_id' => fake()->numberBetween(9, 12),
			'status' => 'not_verified',
			'language' => 'en',
			'profile_picture' => fake()->imageUrl(500, 500, 'animals', true),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
