<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
    }

    public function summary(Request $request): JsonResponse
    {
        $summary = $this->checkoutService->checkoutSummary($request->user());

        return response()->json([
            'status' => true,
            'message' => 'Checkout fetched successfully',
            'data' => [
                'products' => $summary['items'] ?? [],
                'totals' => $summary['summary'] ?? [],
                'coupon_messages' => [
                    'coupon' => $summary['coupon'] ?? null,
                    'messages' => $summary['messages'] ?? [],
                ],
            ],
        ]);
    }
}
