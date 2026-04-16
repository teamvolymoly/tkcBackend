<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;

class AdvertisementController extends Controller
{
    public function header()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'image_url' => $this->resolveImageUrl(0),
            ],
        ]);
    }

    public function shop()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'image_url' => $this->resolveImageUrl(1),
            ],
        ]);
    }

    private function resolveImageUrl(int $offset): ?string
    {
        $heroSection = HeroSection::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->skip($offset)
            ->first();

        return $heroSection?->product_image_url
            ?? HeroSection::query()->where('status', true)->orderBy('sort_order')->orderByDesc('id')->first()?->product_image_url;
    }
}
