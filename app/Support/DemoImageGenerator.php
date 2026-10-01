<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class DemoImageGenerator
{
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
