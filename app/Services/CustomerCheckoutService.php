<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CustomerCheckoutService
{
    public const FREE_SHIPPING_THRESHOLD = 500;
    public const SHIPPING_AMOUNT = 50;
    public const CURRENCY = 'INR';

    public function currentCart(User $user): Cart
    {
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->load('items.variant.product');

        return $cart;
    }

    public function checkoutSummary(User $user): array
    {
        $cart = $this->currentCart($user);
        $items = $cart->items
            ->filter(fn (CartItem $item) => $item->variant && $item->variant->product)
            ->values()
            ->map(function (CartItem $item) {
                $variant = $item->variant;
                $product = $variant?->product;
                $price = $this->resolveVariantPrice($variant);

                return [
                    'id' => $item->id,
                    'name' => $product?->name,
                    'variant' => $variant?->name,
                    'qty' => (int) $item->quantity,
                    'price' => round($price, 2),
                    'image' => $variant?->primary_image['image_url']
                        ?? $product?->resolveMediaUrl($product?->image_1),
                ];
            })
            ->all();

        $subtotal = round(collect($items)->sum(fn (array $item) => $item['qty'] * $item['price']), 2);
        $shipping = $subtotal > self::FREE_SHIPPING_THRESHOLD ? 0.0 : ($subtotal > 0 ? self::SHIPPING_AMOUNT : 0.0);
        $taxes = 0.0;

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => round($shipping, 2),
            'taxes' => round($taxes, 2),
            'total' => round($subtotal + $shipping + $taxes, 2),
        ];
    }

    public function createPendingOrderFromCart(User $user, UserAddress $address, array $attributes = []): Order
    {
        $cart = $this->currentCart($user);

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => ['Cart is empty'],
            ]);
        }

        foreach ($cart->items as $item) {
            $validationError = $this->validatePurchasableVariant($item->variant);

            if ($validationError) {
                throw ValidationException::withMessages([
                    'cart' => [$validationError],
                ]);
            }
        }

        $summary = $this->checkoutSummary($user);

        return DB::transaction(function () use ($user, $address, $attributes, $cart, $summary) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'order_number' => $attributes['order_number'] ?? $this->generateOrderNumber(),
                'subtotal' => $summary['subtotal'],
                'discount_amount' => (float) ($attributes['discount_amount'] ?? 0),
                'shipping_amount' => $summary['shipping'],
                'total_amount' => (float) ($attributes['total_amount'] ?? $summary['total']),
                'coupon_code' => $attributes['coupon_code'] ?? null,
                'status' => $attributes['status'] ?? 'pending',
                'payment_status' => $attributes['payment_status'] ?? 'unpaid',
                'notes' => $attributes['notes'] ?? null,
                'tracking_id' => $attributes['tracking_id'] ?? null,
                'delivery_date' => $attributes['delivery_date'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->variant->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->variant->product->name,
                    'variant_name' => $item->variant->name,
                    'price' => $this->resolveVariantPrice($item->variant),
                    'quantity' => $item->quantity,
                ]);
            }

            return $order->load('items.variant.product', 'address', 'payments');
        });
    }

    public function clearCart(User $user): void
    {
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $cart->items()->delete();
        }
    }

    public function buildOrderListItem(Order $order): array
    {
        $firstItem = $order->items->first();

        return [
            'id' => $order->order_number,
            'date' => optional($order->created_at)->toDateString(),
            'status' => $this->humanStatus($order->status),
            'total' => round((float) $order->total_amount, 2),
            'product_name' => $firstItem?->product_name,
        ];
    }

    public function buildOrderDetail(Order $order): array
    {
        $payment = $order->payments->sortByDesc('id')->first();
        $address = $order->address;

        return [
            'id' => $order->order_number,
            'date' => optional($order->created_at)->toDateString(),
            'ordered_date' => optional($order->created_at)->toDateString(),
            'delivery_date' => optional($order->delivery_date ?? $order->created_at?->copy()->addDays(4))->toDateString(),
            'status' => $this->humanStatus($order->status),
            'payment_method' => $payment ? ucfirst((string) $payment->payment_method) : null,
            'payment_status' => $this->humanPaymentStatus($order->payment_status),
            'tracking_id' => $order->tracking_id,
            'subtotal' => round((float) $order->subtotal, 2),
            'shipping' => round((float) $order->shipping_amount, 2),
            'total' => round((float) $order->total_amount, 2),
            'items' => $order->items->map(function (OrderItem $item) {
                return [
                    'product_name' => $item->product_name,
                    'variant_name' => $item->variant_name,
                    'quantity' => (int) $item->quantity,
                    'price' => round((float) $item->price, 2),
                    'image' => $item->variant?->primary_image['image_url']
                        ?? $item->product?->resolveMediaUrl($item->product?->image_1),
                ];
            })->values()->all(),
            'shipping_address' => $address ? $this->transformAddress($address) : null,
        ];
    }

    public function buildPaymentSuccess(Order $order): array
    {
        $payment = $order->payments->sortByDesc('id')->first();

        return [
            'order_id' => $order->order_number,
            'payment_id' => $payment?->transaction_id,
            'status' => $this->humanPaymentStatus($order->payment_status),
            'amount' => round((float) ($payment?->amount ?? $order->total_amount), 2),
            'currency' => $payment?->currency ?? self::CURRENCY,
            'paid_at' => $payment?->paid_at?->toISOString(),
            'items' => $this->buildOrderDetail($order)['items'],
            'shipping_address' => $order->address ? $this->transformAddress($order->address) : null,
        ];
    }

    public function trackingEvents(Order $order): array
    {
        $events = [
            [
                'status' => 'Ordered',
                'date' => optional($order->created_at)->toDateString(),
            ],
        ];

        if (in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered'], true)) {
            $events[] = [
                'status' => 'Packed',
                'date' => optional($order->updated_at ?? $order->created_at)->toDateString(),
            ];
        }

        if (in_array($order->status, ['shipped', 'delivered'], true)) {
            $events[] = [
                'status' => 'Shipped',
                'date' => optional($order->updated_at ?? $order->created_at)->toDateString(),
            ];
        }

        if ($order->status === 'delivered') {
            $events[] = [
                'status' => 'Out for delivery',
                'date' => optional($order->delivery_date ?? $order->updated_at ?? $order->created_at)->toDateString(),
            ];
        }

        return collect($events)
            ->filter(fn (array $event) => filled($event['date']))
            ->values()
            ->all();
    }

    public function generateTrackingId(): string
    {
        return 'TRK-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function generateGatewayOrderId(): string
    {
        return 'order_'.bin2hex(random_bytes(6));
    }

    public function humanStatus(?string $status): ?string
    {
        return match ($status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Packed',
            'shipped' => 'In transit',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => $status ? ucfirst($status) : null,
        };
    }

    public function humanPaymentStatus(?string $status): ?string
    {
        return match ($status) {
            'paid' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            'unpaid' => 'Unpaid',
            default => $status ? ucfirst($status) : null,
        };
    }

    private function transformAddress(UserAddress $address): array
    {
        return [
            'label' => $address->label,
            'address_line1' => $address->address_line1,
            'address_line2' => $address->address_line2,
            'city' => $address->city,
            'state' => $address->state,
            'pincode' => $address->pincode,
            'country' => $address->country,
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

    private function validatePurchasableVariant(?ProductVariant $variant): ?string
    {
        if (! $variant) {
            return 'One or more cart items are no longer available';
        }

        if (! $variant->status || ! $variant->product || ! $variant->product->status) {
            return 'One or more cart items are inactive';
        }

        return null;
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'TKC-'.str_pad((string) random_int(1, 999999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
