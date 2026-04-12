<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->load('items.variant.product');

        return response()->json(['status' => true, 'data' => $cart]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $variant = ProductVariant::with('product')->findOrFail($request->variant_id);
        $validationError = $this->validateVariant($variant, (int) $request->quantity);

        if ($validationError) {
            return response()->json(['status' => false, 'message' => $validationError], 422);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        $item = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'variant_id' => $variant->id],
            ['quantity' => $request->quantity]
        );

        return response()->json(['status' => true, 'message' => 'Cart updated', 'data' => $item->load('variant.product')], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $item = $cart->items()->with(['variant.product'])->where('id', $id)->firstOrFail();
        $validationError = $this->validateVariant($item->variant, (int) $request->quantity);

        if ($validationError) {
            return response()->json(['status' => false, 'message' => $validationError], 422);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['status' => true, 'message' => 'Cart item updated', 'data' => $item->fresh()->load('variant.product')]);
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $item = $cart->items()->where('id', $id)->firstOrFail();
        $item->delete();

        return response()->json(['status' => true, 'message' => 'Cart item removed']);
    }

    public function clear(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->items()->delete();

        return response()->json(['status' => true, 'message' => 'Cart cleared']);
    }

    public function adminIndex(Request $request)
    {
        $carts = Cart::with(['user', 'items.variant.product'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->whereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('name', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.$term.'%')
                        ->orWhere('phone', 'like', '%'.$term.'%');
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json(['status' => true, 'data' => $carts]);
    }

    public function adminShow($id)
    {
        $cart = Cart::with(['user.addresses', 'items.variant.product'])->findOrFail($id);

        return response()->json(['status' => true, 'data' => $cart]);
    }

    private function validateVariant(?ProductVariant $variant, int $quantity): ?string
    {
        if (! $variant) {
            return 'Selected variant is not available';
        }

        if (! $variant->status || ! $variant->product || ! $variant->product->status) {
            return 'Selected variant is inactive';
        }

        return null;
    }
}
