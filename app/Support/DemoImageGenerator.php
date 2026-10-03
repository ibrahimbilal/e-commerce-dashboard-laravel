<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DemoImageGenerator
{
    /**
     * @return string|null storage/demo/products/product-{id}.{ext}
     */
    public static function seedProductImage(int $productId): ?string
    {
        $sources = self::sortedThemeRelativePaths('products');

        if ($sources !== []) {
            $sourceRelative = $sources[($productId - 1) % count($sources)];
            $extension = strtolower(pathinfo($sourceRelative, PATHINFO_EXTENSION) ?: 'jpg');
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            $destRelative = 'demo/products/product-'.$productId.'.'.$extension;

            if (self::copyThemeAssetToPublicDisk($sourceRelative, $destRelative)) {
                return StoredMedia::databasePath($destRelative);
            }
        }

        return self::writeProductImage($productId, 'Demo Product '.$productId, $productId);
    }

    /**
     * @return string|null Public-disk relative path e.g. demo/gallery-{index}.jpg
     */
    public static function seedGalleryImage(int $index): ?string
    {
        $sourceRelative = 'gallery/image-'.$index.'.jpg';
        $destRelative = 'demo/gallery-'.$index.'.jpg';

        if (self::copyThemeAssetToPublicDisk($sourceRelative, $destRelative)) {
            return $destRelative;
        }

        $fallback = self::writeGalleryImage($index, 'Demo gallery '.$index);

        if ($fallback === null) {
            return null;
        }

        return StoredMedia::publicDiskRelativePath($fallback) ?? $destRelative;
    }

    /**
     * @return string|null storage/avatars/admin.{ext}
     */
    public static function seedAdminAvatar(): ?string
    {
        $sources = self::sortedThemeRelativePaths('avatars');

        if ($sources !== []) {
            $sourceRelative = $sources[0];
            $extension = strtolower(pathinfo($sourceRelative, PATHINFO_EXTENSION) ?: 'png');
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            $destRelative = 'avatars/admin.'.$extension;

            if (self::copyThemeAssetToPublicDisk($sourceRelative, $destRelative)) {
                return StoredMedia::databasePath($destRelative);
            }
        }

        return self::writeAdminAvatar();
    }

    /**
     * @return string|null storage/avatars/customer-{id}.{ext}
     */
    public static function seedCustomerPhoto(int $customerId): ?string
    {
        $sources = self::sortedThemeRelativePaths('customers');

        if ($sources === []) {
            return null;
        }

        $sourceRelative = $sources[($customerId - 1) % count($sources)];
        $extension = strtolower(pathinfo($sourceRelative, PATHINFO_EXTENSION) ?: 'jpg');
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $destRelative = 'avatars/customers/customer-'.$customerId.'.'.$extension;

        if (self::copyThemeAssetToPublicDisk($sourceRelative, $destRelative)) {
            return StoredMedia::databasePath($destRelative);
        }

        return null;
    }

    /**
     * @return string|null storage/avatars/user-{id}.{ext}
     */
    public static function seedUserAvatar(int $userId): ?string
    {
        $sources = self::sortedThemeRelativePaths('avatars');

        if ($sources === []) {
            return null;
        }

        $sourceRelative = $sources[($userId - 1) % count($sources)];
        $extension = strtolower(pathinfo($sourceRelative, PATHINFO_EXTENSION) ?: 'png');
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $destRelative = 'avatars/user-'.$userId.'.'.$extension;

        if (self::copyThemeAssetToPublicDisk($sourceRelative, $destRelative)) {
            return StoredMedia::databasePath($destRelative);
        }

        return null;
    }

    public static function themeAssetAbsolutePath(string $relativePath): string
    {
        return public_path('images/'.ltrim($relativePath, '/'));
    }

    /**
     * @return list<string> paths relative to public/images, sorted naturally
     */
    public static function sortedThemeRelativePaths(string $subdir): array
    {
        $directory = public_path('images/'.trim($subdir, '/'));

        if (! is_dir($directory)) {
            return [];
        }

        $files = File::files($directory);
        $relative = [];

        foreach ($files as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $extension = strtolower($file->getExtension());
            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
                continue;
            }

            $relative[] = trim($subdir, '/').'/'.$file->getFilename();
        }

        sort($relative, SORT_NATURAL);

        return array_values($relative);
    }

    public static function copyThemeAssetToPublicDisk(string $themeRelativePath, string $publicDiskRelativePath): bool
    {
        $source = self::themeAssetAbsolutePath($themeRelativePath);

        if (! is_readable($source)) {
            return false;
        }

        $contents = file_get_contents($source);

        if ($contents === false || $contents === '') {
            return false;
        }

        Storage::disk('public')->makeDirectory(dirname($publicDiskRelativePath));

        return Storage::disk('public')->put($publicDiskRelativePath, $contents);
    }

    public static function isFallbackPlaceholder(string $contents): bool
    {
        return hash('sha256', $contents) === hash('sha256', self::fallbackPng(0));
    }

    /**
     * @return string|null storage/demo/products/product-{id}.png
     */
    public static function writeProductImage(int $productId, string $label, int $seed = 0): ?string
    {
        $relative = 'demo/products/product-'.$productId.'.png';

        if (! self::writeImage($relative, 600, 600, $label, $seed !== 0 ? $seed : $productId)) {
            return null;
        }

        return StoredMedia::databasePath($relative);
    }

    /**
     * @return string|null storage/avatars/admin.png
     */
    public static function writeAdminAvatar(): ?string
    {
        $relative = 'avatars/admin.png';

        if (! self::writeImage($relative, 256, 256, 'Admin', 42)) {
            return null;
        }

        return StoredMedia::databasePath($relative);
    }

    /**
     * @return string|null storage/demo/gallery-{index}.png
     */
    public static function writeGalleryImage(int $index, string $label): ?string
    {
        $relative = 'demo/gallery-'.$index.'.png';

        if (! self::writeImage($relative, 800, 600, $label, $index * 13)) {
            return null;
        }

        return StoredMedia::databasePath($relative);
    }

    private static function writeImage(string $relativePath, int $width, int $height, string $label, int $seed): bool
    {
        Storage::disk('public')->makeDirectory(dirname($relativePath));

        if (extension_loaded('gd')) {
            $image = imagecreatetruecolor($width, $height);
            if ($image !== false) {
                [$r1, $g1, $b1, $r2, $g2, $b2] = self::palette($seed);
                for ($y = 0; $y < $height; $y++) {
                    $ratio = $height > 1 ? $y / ($height - 1) : 0;
                    $r = (int) ($r1 + ($r2 - $r1) * $ratio);
                    $g = (int) ($g1 + ($g2 - $g1) * $ratio);
                    $b = (int) ($b1 + ($b2 - $b1) * $ratio);
                    $line = imagecolorallocate($image, $r, $g, $b);
                    imageline($image, 0, $y, $width, $y, $line);
                }

                $accent = imagecolorallocatealpha($image, 255, 255, 255, 40);
                $size = (int) min($width, $height) * 0.35;
                imagefilledellipse($image, (int) ($width * 0.72), (int) ($height * 0.28), $size, $size, $accent);

                $textColor = imagecolorallocate($image, 255, 255, 255);
                $font = 5;
                $text = substr(preg_replace('/\s+/', ' ', $label) ?? $label, 0, 28);
                $textWidth = imagefontwidth($font) * strlen($text);
                $x = max(12, (int) (($width - $textWidth) / 2));
                $y = (int) ($height / 2 - imagefontheight($font) / 2);
                imagestring($image, $font, $x, $y, $text, $textColor);

                ob_start();
                imagepng($image);
                $binary = ob_get_clean();
                imagedestroy($image);

                if ($binary !== false && $binary !== '') {
                    Storage::disk('public')->put($relativePath, $binary);

                    return true;
                }
            }
        }

        $png = self::fallbackPng($seed);

        return Storage::disk('public')->put($relativePath, $png);
    }

    private static function fallbackPng(int $seed): string
    {
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mNk+M9Qz0AEYBxVSF+FABJADveWkH6oAAAAAElFTkSuQmCC',
            true
        );

        if ($png === false || $png === '') {
            $png = "\x89PNG\r\n\x1a\n";
        }

        return $png;
    }

    /**
     * @return array{0: int, 1: int, 2: int, 3: int, 4: int, 5: int}
     */
    private static function palette(int $seed): array
    {
        $hue = ($seed * 47) % 360;
        [$r1, $g1, $b1] = self::hslToRgb($hue / 360, 0.45, 0.42);
        [$r2, $g2, $b2] = self::hslToRgb((($hue + 40) % 360) / 360, 0.55, 0.28);

        return [$r1, $g1, $b1, $r2, $g2, $b2];
    }

    /**
     * @return array{0: int, 1: int, 2: int}
     */
    private static function hslToRgb(float $h, float $s, float $l): array
    {
        if ($s <= 0) {
            $v = (int) round($l * 255);

            return [$v, $v, $v];
        }

        $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
        $p = 2 * $l - $q;

        return [
            (int) round(self::hueToChannel($p, $q, $h + 1 / 3) * 255),
            (int) round(self::hueToChannel($p, $q, $h) * 255),
            (int) round(self::hueToChannel($p, $q, $h - 1 / 3) * 255),
        ];
    }

    private static function hueToChannel(float $p, float $q, float $t): float
    {
        if ($t < 0) {
            $t += 1;
        }
        if ($t > 1) {
            $t -= 1;
        }
        if ($t < 1 / 6) {
            return $p + ($q - $p) * 6 * $t;
        }
        if ($t < 1 / 2) {
            return $q;
        }
        if ($t < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }
}
