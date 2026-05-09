<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerAccountService;
use Illuminate\Http\Request;

class CustomerAccountController extends Controller
{
    public function __construct(
        private readonly CustomerAccountService $customerAccountService,
    ) {}

    public function orders(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully',
            'data' => $this->customerAccountService->userOrders(
                $request->user(),
                $request->only(['page', 'limit', 'status'])
            ),
        ]);
    }

    public function showOrder(Request $request, string $orderId)
    {
        return response()->json([
            'status' => true,
            'message' => 'Order fetched successfully',
            'data' => $this->customerAccountService->userOrderDetail($request->user(), $orderId),
        ]);
    }

    public function dashboard(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Dashboard fetched successfully',
            'data' => $this->customerAccountService->userDashboard($request->user()),
        ]);
    }

    public function productReviews(Request $request, string $identifier)
    {
        return response()->json([
            'status' => true,
            'message' => 'Reviews fetched successfully',
            'data' => $this->customerAccountService->productReviews(
                $identifier,
                $request->only(['page', 'limit'])
            ),
        ]);
    }
}
