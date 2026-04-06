<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user()->load([
            'addresses',
            'cart.items',
            'orders' => fn ($query) => $query->with('payments')->latest()->limit(5),
        ]);

        $wishlistCount = $user->wishlistItems()->count();
        $totalOrdersCount = $user->orders()->count();
        $activeSubscriptionsCount = 0;
        $loyaltyPoints = 0;

        $recentOrders = $user->orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'total_amount' => $order->total_amount,
                'ordered_at' => $order->created_at,
                'ordered_at_label' => $order->created_at?->format('M d, Y'),
            ];
        })->values();

        return response()->json([
            'status' => true,
            'message' => 'Customer dashboard fetched successfully',
            'data' => [
                'profile' => $user->customerProfileData(),
                'stats' => [
                    'total_orders' => $totalOrdersCount,
                    'active_subscriptions' => $activeSubscriptionsCount,
                    'loyalty_points' => $loyaltyPoints,
                    'saved_blends' => $wishlistCount,
                ],
                'recent_orders' => $recentOrders,
                'subscriptions' => [],
                'default_address' => $user->addresses->firstWhere('is_default', true),
            ],
        ]);
    }
}
