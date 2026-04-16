<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerCheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
    }

    public function summary(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $this->checkoutService->checkoutSummary($request->user()),
        ]);
    }
}
