<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsIndexAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_roles_gets_forbidden_on_products_index(): void
    {
        $this->seed([PermissionsSeeder::class, UserSeeder::class]);

        $user = User::query()->whereDoesntHave('roles')->first();
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertForbidden();
    }
}
