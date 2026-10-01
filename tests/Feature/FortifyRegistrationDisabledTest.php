<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FortifyRegistrationDisabledTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_routes_are_not_available(): void
    {
        $countBefore = User::query()->count();

        $this->get('/register')->assertNotFound();

        $this->post('/register', [
            'first_name' => 'Evil',
            'last_name' => 'Admin',
            'email' => 'evil-admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'roles' => ['admin'],
        ])->assertNotFound();

        $this->assertSame($countBefore, User::query()->count());
        $this->assertDatabaseMissing('users', ['email' => 'evil-admin@example.com']);
    }
}
