<?php

namespace App\Helpers;

class Image
{
    /**
     * Get media URL with optimized performance.
     * Removed File::exists() call which was causing expensive I/O operations.
     * Spatie Media Library handles missing files gracefully.
     */
    public static function getMediaUrl($item, $collection = '', $defaultImage = 'not-found.png')
    {
        if (!isset($item)) {
            return asset($defaultImage);
        }

        $media = $item->getFirstMedia($collection);

        if ($media !== null) {
            return $media->getUrl();
        }

        return asset($defaultImage);
    }
}
