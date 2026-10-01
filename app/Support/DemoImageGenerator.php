<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class DemoImageGenerator
{
    /**
     * @return string|null Public URL path prefix (e.g. storage/demo/products/x.png) or null if GD unavailable.
     */
    public static function writeProductImage(int $productId, string $label, int $seed = 0): ?string
    {
        return self::writeImage(
            'demo/products/product-'.$productId.'.png',
            600,
            600,
            $label,
            $seed !== 0 ? $seed : $productId
        );
    }

    /**
     * @return string|null storage/avatars/admin.png style path
     */
    public static function writeAdminAvatar(): ?string
    {
        return self::writeImage('avatars/admin.png', 256, 256, 'Admin', 42);
    }

    private static function writeImage(string $relativePath, int $width, int $height, string $label, int $seed): ?string
    {
        if (! extension_loaded('gd')) {
            return null;
        }

        Storage::disk('public')->makeDirectory(dirname($relativePath));

        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            return null;
        }

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

        if ($binary === false) {
            return null;
        }

        Storage::disk('public')->put($relativePath, $binary);

        return 'storage/'.$relativePath;
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
