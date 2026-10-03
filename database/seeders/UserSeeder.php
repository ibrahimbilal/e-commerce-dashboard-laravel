<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'gender' => 'male',
            'role_name' => 'admin',
            'status' => 'active',
            'language' => 'en',
        ]);

        $admin->markEmailAsVerified();
        $admin->assignRole('admin');
        $admin->forceFill(['role_name' => 'admin'])->save();
    }
}
