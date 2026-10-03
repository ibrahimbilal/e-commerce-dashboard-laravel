<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserProfileSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_sessions_method_returns_placeholder_rows_when_database_driver_has_no_rows(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame('database', config('session.driver'));

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $request = Request::create('/admin/users/profile', 'GET');
        $request->setLaravelSession($this->app['session.store']);
        $request->setUserResolver(fn () => $admin);

        $sessions = app(UserController::class)->sessions($request);

        $this->assertFalse($sessions->isEmpty());

        $payload = array_to_object($sessions->all());
        $this->assertNotEmpty($payload);
        $this->assertObjectHasProperty('last_active_formated', $payload[0]);
        $this->assertObjectHasProperty('agent', $payload[0]);
    }
}
