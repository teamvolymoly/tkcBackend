<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;

class HomeHeroSectionController extends Controller
{
    public function index()
    {
        $heroSections = HeroSection::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->latest('id')
            ->get([
                'id',
                'product_name',
                'product_slug',
                'product_image_path',
                'status',
                'sort_order',
                'created_at',
                'updated_at',
            ])
            ->map(fn (HeroSection $heroSection) => [
                'id' => $heroSection->id,
                'product_name' => $heroSection->product_name,
                'product_slug' => $heroSection->product_slug,
                'product_image_path' => $heroSection->product_image_path,
                'product_image_url' => $heroSection->product_image_url,
                'status' => (bool) $heroSection->status,
                'sort_order' => (int) $heroSection->sort_order,
                'created_at' => $heroSection->created_at,
                'updated_at' => $heroSection->updated_at,
            ])
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Home hero sections fetched successfully',
            'data' => $heroSections,
        ]);
    }
}
