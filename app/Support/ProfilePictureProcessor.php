<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProfilePictureProcessor
{
    public const SIZE = 256;

    /**
     * When true, {@see store()} skips GD processing and stores the upload as-is (tests).
     */
    public static bool $forceGdUnavailable = false;

    /**
     * Validation rules for an uploaded profile picture (matches admin user forms).
     *
     * @return array<int, mixed>
     */
    public static function validationRules(): array
    {
        return [
            'nullable',
            new \App\Rules\AcceptableProfilePicture(),
        ];
    }

    public static function resetTestingState(): void
    {
        self::$forceGdUnavailable = false;
    }

    /**
     * Center-crop to square, resize to 256×256 when GD is available; otherwise store original.
     *
     * @return string Path relative to the public disk root (e.g. users/abc.jpg)
     */
    public static function store(UploadedFile $file, string $directory): string
    {
        if (! self::canProcessWithGd()) {
            return self::storeOriginal($file, $directory, 'GD extension or required image functions are unavailable');
        }

        try {
            return self::processTo256($file, $directory);
        } catch (Throwable $exception) {
            return self::storeOriginal($file, $directory, 'processing failed: '.$exception->getMessage());
        }
    }

    private static function canProcessWithGd(): bool
    {
        if (self::$forceGdUnavailable) {
            return false;
        }

        if (! extension_loaded('gd')) {
            return false;
        }

        return function_exists('imagecreatetruecolor')
            && function_exists('imagecopyresampled')
            && function_exists('imagejpeg')
            && function_exists('imagepng');
    }

    /**
     * @return string Path relative to the public disk root
     */
    private static function storeOriginal(UploadedFile $file, string $directory, string $reason): string
    {
        Log::warning('Profile picture stored without GD processing', ['reason' => $reason]);

        $directory = trim($directory, '/');
        $extension = self::extensionForUpload($file);
        $filename = Str::uuid()->toString().'.'.$extension;
        $relativePath = $directory.'/'.$filename;

        $file->storeAs($directory, $filename, 'public');

        return $relativePath;
    }

    /**
     * @return string Path relative to the public disk root
     */
    private static function processTo256(UploadedFile $file, string $directory): string
    {
        $directory = trim($directory, '/');
        $extension = self::extensionForUpload($file);
        $filename = Str::uuid()->toString().'.'.$extension;
        $relativePath = $directory.'/'.$filename;

        $source = self::loadImageResource($file);
        if ($source === false) {
            throw new \RuntimeException('Unable to read uploaded image.');
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

            throw new \RuntimeException('Unable to allocate image memory.');
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

            throw new \RuntimeException('Unable to allocate image memory.');
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

            throw new \RuntimeException('Unable to create storage directory.');
        }

        $saved = self::saveImageResource($target, $absolutePath, $extension);
        imagedestroy($target);

        if (! $saved) {
            throw new \RuntimeException('Unable to save processed profile picture.');
        }

        return $relativePath;
    }

    private static function extensionForUpload(UploadedFile $file): string
    {
        $mime = strtolower((string) $file->getMimeType());
        if ($mime === 'image/png' || str_ends_with($mime, 'png')) {
            return 'png';
        }

        if ($mime === 'image/jpeg' || $mime === 'image/jpg' || str_contains($mime, 'jpeg')) {
            return 'jpg';
        }

        $clientName = strtolower((string) $file->getClientOriginalExtension());
        if ($clientName === 'png') {
            return 'png';
        }
        if (in_array($clientName, ['jpg', 'jpeg'], true)) {
            return 'jpg';
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
        if ($mime === 'image/png' || str_ends_with($mime, 'png')) {
            return function_exists('imagecreatefrompng') ? imagecreatefrompng($path) : false;
        }

        return function_exists('imagecreatefromjpeg') ? imagecreatefromjpeg($path) : false;
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
        if (! in_array($mime, ['image/jpeg', 'image/jpg'], true) && ! str_contains($mime, 'jpeg')) {
            return $image;
        }

        $path = $file->getRealPath();
        if ($path === false) {
            return $image;
        }

        try {
            $exif = @exif_read_data($path);
        } catch (Throwable) {
            return $image;
        }

        if (! is_array($exif) || ! isset($exif['Orientation'])) {
            return $image;
        }

        if (! function_exists('imagerotate')) {
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
