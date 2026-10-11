<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ProfilePictureProcessor
{
    public const SIZE = 256;

    /**
     * Validation rules for an uploaded profile picture (matches admin user forms).
     *
     * @return array<int, mixed>
     */
    public static function validationRules(): array
    {
        return [
            'nullable',
            \Illuminate\Validation\Rules\File::image()
                ->types(['jpeg', 'jpg', 'png'])
                ->max(1024),
        ];
    }

    /**
     * Center-crop to square, resize to 256×256, store on the public disk.
     *
     * @return string Path relative to the public disk root (e.g. users/abc.jpg)
     */
    public static function store(UploadedFile $file, string $directory): string
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('GD extension is required to process profile pictures.');
        }

        $directory = trim($directory, '/');
        $extension = self::extensionForUpload($file);
        $filename = Str::uuid()->toString().'.'.$extension;
        $relativePath = $directory.'/'.$filename;

        $source = self::loadImageResource($file);
        if ($source === false) {
            throw new RuntimeException('Unable to read uploaded image.');
        }

        $source = self::applyExifOrientation($source, $file);
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $cropSize = min($sourceWidth, $sourceHeight);
        $cropX = (int) floor(($sourceWidth - $cropSize) / 2);
        $cropY = (int) floor(($sourceHeight - $cropSize) / 2);

        $square = imagecreatetruecolor($cropSize, $cropSize);
        if ($square === false) {
            imagedestroy($source);

            throw new RuntimeException('Unable to allocate image memory.');
        }

        imagecopyresampled(
            $square,
            $source,
            0,
            0,
            $cropX,
            $cropY,
            $cropSize,
            $cropSize,
            $cropSize,
            $cropSize
        );
        imagedestroy($source);

        $target = imagecreatetruecolor(self::SIZE, self::SIZE);
        if ($target === false) {
            imagedestroy($square);

            throw new RuntimeException('Unable to allocate image memory.');
        }

        if ($extension === 'png') {
            imagealphablending($target, false);
            imagesavealpha($target, true);
        }

        imagecopyresampled(
            $target,
            $square,
            0,
            0,
            0,
            0,
            self::SIZE,
            self::SIZE,
            $cropSize,
            $cropSize
        );
        imagedestroy($square);

        $absolutePath = Storage::disk('public')->path($relativePath);
        $dir = dirname($absolutePath);
        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            imagedestroy($target);

            throw new RuntimeException('Unable to create storage directory.');
        }

        $saved = self::saveImageResource($target, $absolutePath, $extension);
        imagedestroy($target);

        if (! $saved) {
            throw new RuntimeException('Unable to save processed profile picture.');
        }

        return $relativePath;
    }

    private static function extensionForUpload(UploadedFile $file): string
    {
        $mime = strtolower((string) $file->getMimeType());
        if ($mime === 'image/png') {
            return 'png';
        }

        return 'jpg';
    }

    /**
     * @return \GdImage|false
     */
    private static function loadImageResource(UploadedFile $file)
    {
        $path = $file->getRealPath();
        if ($path === false) {
            return false;
        }

        $mime = strtolower((string) $file->getMimeType());
        if ($mime === 'image/png') {
            return imagecreatefrompng($path);
        }

        return imagecreatefromjpeg($path);
    }

    /**
     * @param  \GdImage  $image
     * @return \GdImage
     */
    private static function applyExifOrientation($image, UploadedFile $file)
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $mime = strtolower((string) $file->getMimeType());
        if (! in_array($mime, ['image/jpeg', 'image/jpg'], true)) {
            return $image;
        }

        $path = $file->getRealPath();
        if ($path === false) {
            return $image;
        }

        $exif = @exif_read_data($path);
        if (! is_array($exif) || ! isset($exif['Orientation'])) {
            return $image;
        }

        return match ((int) $exif['Orientation']) {
            3 => imagerotate($image, 180, 0) ?: $image,
            6 => imagerotate($image, -90, 0) ?: $image,
            8 => imagerotate($image, 90, 0) ?: $image,
            default => $image,
        };
    }

    /**
     * @param  \GdImage  $image
     */
    private static function saveImageResource($image, string $absolutePath, string $extension): bool
    {
        if ($extension === 'png') {
            return imagepng($image, $absolutePath, 6);
        }

        return imagejpeg($image, $absolutePath, 90);
    }
}
