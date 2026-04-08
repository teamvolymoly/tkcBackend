<?php

namespace App\Support;

use Illuminate\Support\Str;

class PublicMediaUrl
{
    public static function make(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return route('media.public', ['path' => ltrim($path, '/')]);
    }
}
