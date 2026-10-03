<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
			'email' => fake()->unique()->numerify('user####').'@example.com',
			'email_verified_at' => now(),
			'password' => Hash::make('password'),
			'mobile' => substr(fake()->e164PhoneNumber(), 0, 20),
            'birth_date' => fake()->optional()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'role_name' => '',
            'status' => 'active',
            'language' => 'en',
			'profile_picture' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
