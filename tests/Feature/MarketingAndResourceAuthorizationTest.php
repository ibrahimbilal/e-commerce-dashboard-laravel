<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Subscriber;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MarketingAndResourceAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class, RoleSeeder::class]);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->viewer = User::factory()->create(['email' => 'viewer-marketing@example.com']);
        $this->viewer->markEmailAsVerified();
        $this->viewer->assignRole('viewer');
    }

    public function test_viewer_forbidden_on_marketing_subscriber_mutations(): void
    {
        $subscriber = Subscriber::query()->create([
            'email' => 'existing@example.com',
            'is_subscriber' => true,
        ]);

        $this->actingAs($this->viewer)
            ->post(route('marketing.subscribers.store'), ['email' => 'blocked@example.com'])
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->put(route('marketing.subscribers.update', $subscriber), ['email' => 'blocked@example.com'])
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->delete(route('marketing.subscribers.destroy', $subscriber))
            ->assertForbidden();
    }

    public function test_admin_can_mutate_marketing_subscribers(): void
    {
        $this->actingAs($this->admin)
            ->post(route('marketing.subscribers.store'), ['email' => 'allowed@example.com'])
            ->assertRedirect(route('marketing.index'))
            ->assertSessionHas('status');

        $subscriber = Subscriber::query()->where('email', 'allowed@example.com')->firstOrFail();

        $this->actingAs($this->admin)
            ->put(route('marketing.subscribers.update', $subscriber), ['email' => 'updated@example.com'])
            ->assertRedirect(route('marketing.index'))
            ->assertSessionHas('status');

        $this->actingAs($this->admin)
            ->delete(route('marketing.subscribers.destroy', $subscriber))
            ->assertRedirect(route('marketing.index'))
            ->assertSessionHas('status');
    }

    public function test_user_without_view_analytics_gets_forbidden_on_overview(): void
    {
        $noAccess = User::factory()->create(['email' => 'no-analytics@example.com']);
        $noAccess->markEmailAsVerified();

        $this->actingAs($noAccess)
            ->get(route('analytics.overview'))
            ->assertForbidden();
    }

    public function test_admin_can_access_analytics_overview(): void
    {
        $this->actingAs($this->admin)
            ->get(route('analytics.overview'))
            ->assertOk();
    }

    public function test_viewer_forbidden_on_gallery_update(): void
    {
        $gallery = Gallery::query()->create([
            'url' => 'demo/gallery-auth.png',
            'title' => 'Before',
            'alt' => '',
            'metas' => null,
            'sizes_url' => null,
            'user_id' => $this->admin->id,
        ]);

        $this->actingAs($this->viewer)
            ->put(route('gallery.update', $gallery), ['title' => 'Blocked'])
            ->assertForbidden();
    }

    public function test_admin_can_update_gallery(): void
    {
        $gallery = Gallery::query()->create([
            'url' => 'demo/gallery-auth.png',
            'title' => 'Before',
            'alt' => '',
            'metas' => null,
            'sizes_url' => null,
            'user_id' => $this->admin->id,
        ]);

        $this->actingAs($this->admin)
            ->put(route('gallery.update', $gallery), [
                'title' => 'Updated title',
                'alt' => 'Updated alt',
            ])
            ->assertRedirect(route('gallery.index', ['selected' => $gallery->id]))
            ->assertSessionHas('status');

        $this->assertSame('Updated title', $gallery->fresh()->title);
    }
}
