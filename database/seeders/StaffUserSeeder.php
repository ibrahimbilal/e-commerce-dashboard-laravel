<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $manager = User::factory()->create([
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Demo',
            'last_name' => 'Manager',
            'gender' => 'male',
            'role_name' => 'manager',
            'status' => 'active',
            'language' => 'en',
        ]);
        $manager->markEmailAsVerified();
        $manager->assignRole('manager');
        $manager->forceFill(['role_name' => 'manager'])->save();

        $viewer = User::factory()->create([
            'email' => 'viewer@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Demo',
            'last_name' => 'Viewer',
            'gender' => 'female',
            'role_name' => 'viewer',
            'status' => 'active',
            'language' => 'en',
        ]);
        $viewer->markEmailAsVerified();
        $viewer->assignRole('viewer');
        $viewer->forceFill(['role_name' => 'viewer'])->save();
    }
}
