<?php

namespace Tests\Feature;

use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_admin_can_log_in(): void
    {
        $this->seed([PermissionsSeeder::class, UserSeeder::class]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs(
            \App\Models\User::query()->where('email', 'admin@example.com')->first()
        );
    }
}
