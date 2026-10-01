<?php

namespace Tests\Unit;

use App\Support\StoredMedia;
use Tests\TestCase;

class StoredMediaTest extends TestCase
{
    public function test_normalizes_corrupted_extension_suffix(): void
    {
        $normalized = StoredMedia::normalizeStoredPath('storage/demo/products/product-25.png-1');

        $this->assertSame('storage/demo/products/product-25.png', $normalized);
    }

    public function test_public_url_uses_asset_with_storage_prefix(): void
    {
        $url = StoredMedia::publicUrl('storage/avatars/admin.png');

        $this->assertStringContainsString('/storage/avatars/admin.png', $url);
    }
}
