<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ProfileSelfServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class, RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_viewer_can_update_own_profile_without_role_escalation(): void
    {
        Storage::fake('public');

        $viewer = $this->verifiedViewer();
        $this->assertFalse($viewer->hasRole('admin'));

        $this->actingAs($viewer)
            ->from(route('dashboard'))
            ->put(route('profile.update'), [
                'first_name' => 'Updated',
                'last_name' => 'Viewer',
                'email' => 'viewer-updated@example.com',
                'roles' => ['admin'],
                'email_verified_at' => now()->toDateTimeString(),
                'profile_picture' => UploadedFile::fake()->create('avatar.png', 10, 'image/png'),
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        $viewer->refresh();
        $this->assertSame('Updated', $viewer->first_name);
        $this->assertSame('viewer-updated@example.com', $viewer->email);
        $this->assertFalse($viewer->hasRole('admin'));
        $this->assertNotNull($viewer->profile_picture);
    }

    public function test_viewer_can_update_password_with_current_password(): void
    {
        $viewer = User::factory()->create([
            'email' => 'pwd-viewer@example.com',
            'password' => Hash::make('old-password-12'),
        ]);
        $viewer->markEmailAsVerified();
        $viewer->assignRole('viewer');

        $this->actingAs($viewer)
            ->from(route('dashboard'))
            ->put(route('profile.password'), [
                'current_password' => 'old-password-12',
                'password' => 'new-password-12',
                'password_confirmation' => 'new-password-12',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('new-password-12', $viewer->fresh()->password));
    }

    private function verifiedViewer(): User
    {
        $viewer = User::factory()->create([
            'email' => 'viewer-profile@example.com',
            'password' => Hash::make('password'),
        ]);
        $viewer->markEmailAsVerified();
        Role::findOrCreate('viewer', 'web');
        $viewer->assignRole('viewer');

        return $viewer;
    }
}
