<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserStoreVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, RoleSeeder::class, UserSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_admin_user_store_creates_unverified_user_and_returns_json_redirect(): void
    {
        Event::fake([Registered::class]);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $payload = [
            'first_name' => 'New',
            'last_name' => 'Staff',
            'email' => 'newstaff@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gender' => 'male',
            'role_name' => 'viewer',
            'language' => 'en',
        ];

        $response = $this->actingAs($admin)->post(route('users.store'), $payload, [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'redirect' => route('users.index'),
        ]);

        $created = User::query()->where('email', 'newstaff@example.com')->first();
        $this->assertNotNull($created);
        $this->assertNull($created->email_verified_at);
        $this->assertTrue($created->hasRole('viewer'));
        $this->assertSame('viewer', $created->role_name);

        Event::assertDispatched(Registered::class, fn (Registered $event) => $event->user->is($created));
    }
}
