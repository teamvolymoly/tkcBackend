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
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Home hero sections fetched successfully',
            'data' => $heroSections,
        ]);
    }
}
