<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\User;
use App\Support\StoredMedia;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeededMediaFilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_product_and_admin_images_exist_on_public_disk(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $this->assertNotNull($admin->profile_picture);
        $this->assertTrue(StoredMedia::hasValidImageExtension($admin->profile_picture));

        $adminRelative = StoredMedia::publicDiskRelativePath($admin->profile_picture);
        $this->assertNotNull($adminRelative);
        $this->assertTrue(Storage::disk('public')->exists($adminRelative));
        $this->assertSame(
            StoredMedia::publicUrl($admin->profile_picture),
            $admin->avatar_url
        );

        $products = Product::query()->whereNotNull('product_img')->get();
        $this->assertGreaterThan(0, $products->count());

        foreach ($products as $product) {
            $this->assertTrue(StoredMedia::hasValidImageExtension($product->product_img));
            $this->assertDoesNotMatchRegularExpression('/\.(?:png|jpe?g|gif|webp)-\d+$/i', $product->product_img);

            $relative = StoredMedia::publicDiskRelativePath($product->product_img);
            $this->assertNotNull($relative);
            $this->assertTrue(
                Storage::disk('public')->exists($relative),
                'Missing public disk file for product #'.$product->id.': '.$relative
            );
        }

        $galleries = Gallery::query()->get();
        $this->assertGreaterThan(0, $galleries->count());

        foreach ($galleries as $gallery) {
            $this->assertTrue(StoredMedia::hasValidImageExtension($gallery->url));

            $relative = StoredMedia::publicDiskRelativePath($gallery->url)
                ?? ltrim($gallery->url, '/');

            $this->assertTrue(
                Storage::disk('public')->exists($relative),
                'Missing public disk file for gallery #'.$gallery->id.': '.$relative
            );
        }
    }
}
