<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->load([
            'orders' => fn ($query) => $query->with(['items', 'payments'])->latest()->limit(5),
        ]);

        $totalOrdersCount = $user->orders()->count();
        $inTransitOrders = $user->orders()->whereIn('status', ['confirmed', 'processing', 'shipped'])->count();
        $deliveredOrders = $user->orders()->where('status', 'delivered')->count();
        $amountSpent = (float) $user->orders()->where('payment_status', 'paid')->sum('total_amount');

        $recentOrders = $user->orders
            ->map(fn ($order) => $this->checkoutService->buildOrderListItem($order))
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data fetched successfully',
            'data' => [
                'stats' => [
                    'total_orders' => $totalOrdersCount,
                    'orders_in_transit' => $inTransitOrders,
                    'delivered_orders' => $deliveredOrders,
                    'amount_spent' => round($amountSpent, 2),
                    'currency' => CustomerCheckoutService::CURRENCY,
                ],
                'recent_orders' => $recentOrders,
            ],
        ]);
    }
}
