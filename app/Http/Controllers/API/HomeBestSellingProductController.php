<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class HomeBestSellingProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Home bestselling products fetched successfully',
            'data' => $this->productService->homeBestSellingProducts(8),
        ]);
    }
}
