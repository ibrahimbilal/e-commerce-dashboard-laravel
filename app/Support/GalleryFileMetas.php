<?php

namespace App\Support;

class GalleryFileMetas
{
    /**
     * @return array{name: string, title: string, alt: string, size: string, width: int, height: int}
     */
    public static function fromPublicDiskRelativePath(string $relativePath, string $title, string $alt): array
    {
        $path = storage_path('app/public/'.ltrim($relativePath, '/'));
        $name = basename($relativePath);

        $size = '0';
        $width = 0;
        $height = 0;

        if (is_readable($path)) {
            $size = number_format(filesize($path) / 1024, 1);
            $dimensions = @getimagesize($path);
            if (is_array($dimensions)) {
                $width = (int) $dimensions[0];
                $height = (int) $dimensions[1];
            }
        }

        return [
            'name' => $name,
            'title' => $title,
            'alt' => $alt,
            'size' => $size,
            'width' => $width,
            'height' => $height,
        ];
    }
}
