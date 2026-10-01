<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserStoreVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_created_user_is_email_verified(): void
    {
        $this->seed([PermissionsSeeder::class, UserSeeder::class]);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)->post(route('users.store'), [
            'email' => 'verified-staff@example.com',
            'password' => 'password123',
            'first_name' => 'Staff',
            'last_name' => 'Member',
        ])->assertRedirect();

        $user = User::query()->where('email', 'verified-staff@example.com')->first();

        $this->assertNotNull($user);
        $this->assertNotNull($user->email_verified_at);
    }
}
