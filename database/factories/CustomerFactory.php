<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'gender' => fake()->randomElement(['male', 'female', null]),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->optional()->date(),
            'mobile' => substr(fake()->e164PhoneNumber(), 0, 20),
            'profile_picture' => null,
            'ip_address' => fake()->ipv4(),
            'deleted' => false,
        ];
    }
}
