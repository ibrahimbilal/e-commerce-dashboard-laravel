<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Database\Seeders\LangSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryIndexTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionsSeeder::class, LangSeeder::class, UserSeeder::class]);
        $this->admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
    }

    public function test_admin_gallery_index_renders_with_seeded_rows(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Gallery::query()->create([
                'url' => 'demo/gallery-'.$i.'.jpg',
                'metas' => ['alt' => 'Gallery '.$i],
                'sizes_url' => null,
                'user_id' => $this->admin->id,
            ]);
        }

        $response = $this->actingAs($this->admin)->get(route('gallery.index'));

        $response->assertOk();
        $response->assertViewHas('galleries', fn ($galleries) => $galleries->total() === 20);
        $response->assertViewHas('counts', fn (array $counts) => ($counts['all'] ?? 0) === 20);
        $response->assertViewHas('filters');
    }
}
