<?php

namespace App\Support;

use App\Models\Gallery;
use Illuminate\Support\Arr;

class GalleryMetadataBackfill
{
    /**
     * @return array{name: string, title: string, alt: string, size: string, width: int, height: int}
     */
    public static function completeMetas(Gallery $gallery): array
    {
        $existing = is_array($gallery->metas) ? $gallery->metas : [];

        $title = (string) ($gallery->title ?? Arr::get($existing, 'title', ''));
        $alt = (string) ($gallery->alt ?? Arr::get($existing, 'alt', ''));

        if ($title === '') {
            $title = (string) (Arr::get($existing, 'name') ?: basename((string) $gallery->url));
        }

        if ($alt === '') {
            $alt = $title;
        }

        $fromFile = GalleryFileMetas::fromPublicDiskRelativePath((string) $gallery->url, $title, $alt);

        return [
            'name' => (string) (Arr::get($existing, 'name') ?: $fromFile['name']),
            'title' => $title !== '' ? $title : $fromFile['title'],
            'alt' => $alt !== '' ? $alt : $fromFile['alt'],
            'size' => (string) (Arr::get($existing, 'size') ?: $fromFile['size']),
            'width' => (int) (Arr::get($existing, 'width') ?: $fromFile['width']),
            'height' => (int) (Arr::get($existing, 'height') ?: $fromFile['height']),
        ];
    }

    public static function rowNeedsBackfill(Gallery $gallery): bool
    {
        if (! is_array($gallery->metas) || $gallery->metas === []) {
            return true;
        }

        foreach (['name', 'title', 'alt', 'size', 'width', 'height'] as $key) {
            if (! array_key_exists($key, $gallery->metas)) {
                return true;
            }
        }

        return false;
    }

    public static function run(): int
    {
        $updated = 0;

        Gallery::query()->orderBy('id')->each(function (Gallery $gallery) use (&$updated) {
            if ((string) $gallery->url === '') {
                return;
            }

            if (! self::rowNeedsBackfill($gallery)) {
                return;
            }

            $gallery->forceFill([
                'metas' => self::completeMetas($gallery),
            ])->save();

            $updated++;
        });

        return $updated;
    }
}
