<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\AnalyticsService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly AnalyticsService $analyticsService,
    ) {}

    public function dashboard()
    {
        return response()->json([
            'status' => true,
            'message' => 'Dashboard stats fetched successfully',
            'data' => $this->orderService->adminDashboardStats(),
        ]);
    }

    public function analytics(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Analytics fetched successfully',
            'data' => $this->analyticsService->adminAnalytics($request->only(['year', 'range'])),
        ]);
    }

    public function orders(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully',
            'data' => $this->orderService->adminOrders($request->only(['q', 'status'])),
        ]);
    }

    public function showOrder($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Order fetched successfully',
            'data' => $this->orderService->adminOrderDetail($id),
        ]);
    }

    public function updateOrderStatus(UpdateOrderStatusRequest $request, $id)
    {
        $order = Order::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully',
            'data' => $this->orderService->updateStatus($order, $request->validated('status')),
        ]);
    }
}
