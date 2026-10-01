<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\User;
use App\Support\DemoImageGenerator;
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

        $productSources = DemoImageGenerator::sortedThemeRelativePaths('products');
        $this->assertNotEmpty($productSources);

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

        $avatarSources = DemoImageGenerator::sortedThemeRelativePaths('avatars');
        $this->assertNotEmpty($avatarSources);
        $adminThemeSource = DemoImageGenerator::themeAssetAbsolutePath($avatarSources[0]);
        $adminBytes = Storage::disk('public')->get($adminRelative);
        $this->assertSame(file_get_contents($adminThemeSource), $adminBytes);
        $this->assertFalse(DemoImageGenerator::isFallbackPlaceholder($adminBytes));

        $products = Product::query()->whereNotNull('product_img')->get();
        $this->assertGreaterThan(0, $products->count());

        foreach ($products as $product) {
            $this->assertTrue(StoredMedia::hasValidImageExtension($product->product_img));
            $this->assertStringContainsString('demo/products/product-'.$product->id.'.', $product->product_img);

            $relative = StoredMedia::publicDiskRelativePath($product->product_img);
            $this->assertNotNull($relative);
            $this->assertTrue(
                Storage::disk('public')->exists($relative),
                'Missing public disk file for product #'.$product->id.': '.$relative
            );

            $sourceRelative = $productSources[($product->id - 1) % count($productSources)];
            $themeSource = DemoImageGenerator::themeAssetAbsolutePath($sourceRelative);
            $seededBytes = Storage::disk('public')->get($relative);
            $this->assertSame(file_get_contents($themeSource), $seededBytes);
            $this->assertFalse(DemoImageGenerator::isFallbackPlaceholder($seededBytes));
        }

        $galleries = Gallery::query()->orderBy('id')->get();
        $this->assertGreaterThan(0, $galleries->count());

        foreach ($galleries as $index => $gallery) {
            $n = $index + 1;
            $this->assertSame('demo/gallery-'.$n.'.jpg', $gallery->url);
            $this->assertTrue(StoredMedia::hasValidImageExtension($gallery->url));

            $relative = StoredMedia::publicDiskRelativePath($gallery->url)
                ?? ltrim($gallery->url, '/');

            $this->assertTrue(
                Storage::disk('public')->exists($relative),
                'Missing public disk file for gallery #'.$gallery->id.': '.$relative
            );

            $themeSource = DemoImageGenerator::themeAssetAbsolutePath('gallery/image-'.$n.'.jpg');
            $seededBytes = Storage::disk('public')->get($relative);
            $this->assertSame(file_get_contents($themeSource), $seededBytes);
            $this->assertFalse(DemoImageGenerator::isFallbackPlaceholder($seededBytes));
        }

        $customers = Customer::query()->whereNotNull('profile_picture')->get();
        $this->assertGreaterThan(0, $customers->count());

        $customerSources = DemoImageGenerator::sortedThemeRelativePaths('customers');
        $this->assertNotEmpty($customerSources);

        foreach ($customers as $customer) {
            $relative = StoredMedia::publicDiskRelativePath($customer->profile_picture);
            $this->assertNotNull($relative);
            $this->assertTrue(Storage::disk('public')->exists($relative));

            $sourceRelative = $customerSources[($customer->id - 1) % count($customerSources)];
            $themeSource = DemoImageGenerator::themeAssetAbsolutePath($sourceRelative);
            $seededBytes = Storage::disk('public')->get($relative);
            $this->assertSame(file_get_contents($themeSource), $seededBytes);
            $this->assertFalse(DemoImageGenerator::isFallbackPlaceholder($seededBytes));
        }
    }
}
