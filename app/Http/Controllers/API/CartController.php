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
    private const FREE_SHIPPING_THRESHOLD = 500;
    private const SHIPPING_AMOUNT = 50;

    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->load('items.variant.product');

        return response()->json([
            'status' => true,
            'message' => 'Cart fetched successfully',
            'data' => $this->transformCart($cart),
        ]);
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

        $item->load('variant.product');

        return response()->json([
            'status' => true,
            'message' => 'Cart updated',
            'data' => $this->transformCartItem($item),
        ], 201);
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

    private function transformCart(Cart $cart): array
    {
        $items = $cart->items
            ->filter(fn (CartItem $item) => $item->variant && $item->variant->product)
            ->values()
            ->map(fn (CartItem $item) => $this->transformCartItem($item))
            ->all();

        $subtotal = collect($items)->sum('subtotal');
        $shipping = $subtotal > self::FREE_SHIPPING_THRESHOLD ? 0.0 : ($subtotal > 0 ? self::SHIPPING_AMOUNT : 0.0);

        return [
            'items' => $items,
            'summary' => [
                'subtotal' => (float) $subtotal,
                'shipping' => (float) $shipping,
                'total' => (float) ($subtotal + $shipping),
                'free_shipping_threshold' => self::FREE_SHIPPING_THRESHOLD,
            ],
        ];
    }

    private function transformCartItem(CartItem $item): array
    {
        $variant = $item->variant;
        $product = $variant?->product;
        $unitPrice = $this->resolveVariantPrice($variant);
        $subtotal = $unitPrice * (int) $item->quantity;
        $shipping = $subtotal > self::FREE_SHIPPING_THRESHOLD ? 0.0 : self::SHIPPING_AMOUNT;

        return [
            'id' => $item->id,
            'quantity' => (int) $item->quantity,
            'product_name' => $product?->name,
            'variant_name' => $variant?->name,
            'product_image' => $product?->resolveMediaUrl($product?->image_1),
            'price' => (float) $unitPrice,
            'subtotal' => (float) $subtotal,
            'shipping' => (float) $shipping,
            'total' => (float) ($subtotal + $shipping),
        ];
    }

    private function resolveVariantPrice(?ProductVariant $variant): float
    {
        if (! $variant) {
            return 0.0;
        }

        $discountPrice = $variant->discount_price !== null ? (float) $variant->discount_price : null;
        $price = $variant->price !== null ? (float) $variant->price : 0.0;

        if ($discountPrice !== null && $discountPrice > 0 && $discountPrice < $price) {
            return $discountPrice;
        }

        return $price;
    }
}
