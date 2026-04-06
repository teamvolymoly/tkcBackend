<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HomeCatalogService;
use Illuminate\Http\JsonResponse;

class HomeShopByCategoryController extends Controller
{
    public function __construct(private readonly HomeCatalogService $homeCatalogService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Home shop by category fetched successfully',
            'data' => $this->homeCatalogService->popularCategories(6),
        ]);
    }
}
