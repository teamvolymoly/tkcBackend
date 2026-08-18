<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
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
        $cart->load(['items.variant.product', 'appliedCoupon']);

        return $cart;
    }

    public function applyCoupon(User $user, string $couponCode): array
    {
        $cart = $this->currentCart($user);
        $coupon = $this->resolveApplicableCoupon($couponCode, $this->cartSubtotal($cart), $user->id);

        $cart->forceFill(['applied_coupon_id' => $coupon->id])->save();
        $cart->setRelation('appliedCoupon', $coupon);

        return $this->checkoutSummary($user, true);
    }

    public function removeCoupon(User $user): array
    {
        $cart = $this->currentCart($user);

        if ($cart->applied_coupon_id !== null) {
            $cart->forceFill(['applied_coupon_id' => null])->save();
            $cart->unsetRelation('appliedCoupon');
        }

        return $this->checkoutSummary($user);
    }

    public function checkoutSummary(User $user, bool $strictCouponValidation = false): array
    {
        $cart = $this->currentCart($user);
        $items = $this->transformCartItems($cart);
        $subtotal = round(collect($items)->sum(fn (array $item) => $item['line_total']), 2);
        $shipping = $subtotal > self::FREE_SHIPPING_THRESHOLD ? 0.0 : ($subtotal > 0 ? self::SHIPPING_AMOUNT : 0.0);
        $tax = 0.0;
        $discount = 0.0;
        $coupon = null;
        $couponNotice = null;

        if ($cart->appliedCoupon) {
            try {
                $coupon = $this->resolveApplicableCoupon($cart->appliedCoupon->code, $subtotal, $user->id);
                $discount = round($this->calculateDiscount($coupon, $subtotal), 2);
            } catch (ValidationException $exception) {
                if ($strictCouponValidation) {
                    throw $exception;
                }

                $cart->forceFill(['applied_coupon_id' => null])->save();
                $cart->unsetRelation('appliedCoupon');
                $couponNotice = data_get($exception->errors(), 'code.0') ?? 'Applied coupon has been removed.';
            }
        }

        $finalTotal = round(max(0, $subtotal - $discount) + $shipping + $tax, 2);

        return [
            'items' => $items,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => round($shipping, 2),
                'tax' => round($tax, 2),
                'discount_amount' => round($discount, 2),
                'total' => $finalTotal,
                'final_total' => $finalTotal,
                'currency' => self::CURRENCY,
                'free_shipping_threshold' => self::FREE_SHIPPING_THRESHOLD,
            ],
            'coupon' => $coupon ? $this->transformCoupon($coupon, $discount) : null,
            'messages' => array_values(array_filter([$couponNotice])),
        ];
    }

    public function prepareCheckoutForPayment(User $user): array
    {
        $cart = $this->currentCart($user);

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => ['Cart is empty.'],
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

        $checkout = $this->checkoutSummary($user, true);

        return [
            'cart' => $cart,
            'items' => $checkout['items'],
            'summary' => $checkout['summary'],
            'coupon' => $checkout['coupon'],
        ];
    }

    public function createPendingOrderFromCart(User $user, UserAddress $address, array $attributes = []): Order
    {
        $checkout = $this->prepareCheckoutForPayment($user);
        $cart = $checkout['cart'];
        $summary = $checkout['summary'];
        $coupon = $checkout['coupon'];

        return DB::transaction(function () use ($user, $address, $attributes, $cart, $summary, $coupon) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'order_number' => $attributes['order_number'] ?? $this->generateOrderNumber(),
                'subtotal' => $summary['subtotal'],
                'discount_amount' => $attributes['discount_amount'] ?? $summary['discount_amount'],
                'shipping_amount' => $summary['shipping'],
                'total_amount' => $attributes['total_amount'] ?? $summary['final_total'],
                'coupon_code' => $attributes['coupon_code'] ?? ($coupon['code'] ?? null),
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

    public function createOrderFromCheckoutSnapshot(User $user, ?UserAddress $address, array $snapshot, array $attributes = []): Order
    {
        $items = collect($snapshot['items'] ?? [])->filter(fn (array $item) => ! empty($item['variant_id']))->values();
        $summary = $snapshot['summary'] ?? [];
        $coupon = $snapshot['coupon'] ?? null;

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'payment' => ['Unable to create order because the payment snapshot is incomplete.'],
            ]);
        }

        return DB::transaction(function () use ($user, $address, $attributes, $items, $summary, $coupon) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address?->id,
                'order_number' => $attributes['order_number'] ?? $this->generateOrderNumber(),
                'subtotal' => (float) ($summary['subtotal'] ?? 0),
                'discount_amount' => $attributes['discount_amount'] ?? (float) ($summary['discount_amount'] ?? 0),
                'shipping_amount' => (float) ($summary['shipping'] ?? 0),
                'total_amount' => $attributes['total_amount'] ?? (float) ($summary['final_total'] ?? $summary['total'] ?? 0),
                'coupon_code' => $attributes['coupon_code'] ?? ($coupon['code'] ?? null),
                'status' => $attributes['status'] ?? 'pending',
                'payment_status' => $attributes['payment_status'] ?? 'unpaid',
                'notes' => $attributes['notes'] ?? null,
                'tracking_id' => $attributes['tracking_id'] ?? null,
                'delivery_date' => $attributes['delivery_date'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'] ?? null,
                    'variant_id' => $item['variant_id'],
                    'product_name' => $item['product_name'] ?? $item['name'] ?? 'Product',
                    'variant_name' => $item['variant_name'] ?? $item['variant'] ?? 'Variant',
                    'price' => (float) ($item['price'] ?? 0),
                    'quantity' => (int) ($item['quantity'] ?? $item['qty'] ?? 0),
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

    public function clearAppliedCoupon(User $user): void
    {
        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart && $cart->applied_coupon_id !== null) {
            $cart->forceFill(['applied_coupon_id' => null])->save();
        }
    }

    public function resolveApplicableCoupon(string $couponCode, float $amount, int $userId): Coupon
    {
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->first();

        if (! $coupon) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or inactive coupon code.'],
            ]);
        }

        $validationError = $this->validateCouponForAmount($coupon, $amount, $userId);

        if ($validationError !== null) {
            throw ValidationException::withMessages([
                'code' => [$validationError],
            ]);
        }

        return $coupon;
    }

    public function recordCouponUsage(Order $order): void
    {
        if (! $order->coupon_code || (float) $order->discount_amount <= 0) {
            return;
        }

        $coupon = Coupon::where('code', $order->coupon_code)->first();

        if (! $coupon) {
            return;
        }

        CouponUsage::firstOrCreate(
            ['coupon_id' => $coupon->id, 'order_id' => $order->id],
            [
                'user_id' => $order->user_id,
                'used_at' => now(),
            ]
        );
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
            'discount' => round((float) $order->discount_amount, 2),
            'shipping' => round((float) $order->shipping_amount, 2),
            'tax' => 0.0,
            'total' => round((float) $order->total_amount, 2),
            'coupon_code' => $order->coupon_code,
            'items' => $order->items->map(function (OrderItem $item) {
                return [
                    'product_name' => $item->product_name,
                    'variant_name' => $item->variant_name,
                    'quantity' => (int) $item->quantity,
                    'price' => round((float) $item->price, 2),
                    'image' => $item->variant?->primary_image['image_url']
                        ?? $item->product?->resolveMediaUrl($item->product?->cart_image_1),
                ];
            })->values()->all(),
            'shipping_address' => $address ? $this->transformAddress($address) : null,
        ];
    }

    public function buildPaymentSuccess(Order $order): array
    {
        $payment = $order->payments->sortByDesc('id')->first();
        $detail = $this->buildOrderDetail($order);

        return [
            'order' => [
                'id' => $order->order_number,
                'placed_on' => optional($order->created_at)->toDateString(),
                'expected_delivery' => [
                    'date' => optional($order->delivery_date ?? $order->created_at?->copy()->addDays(4))->toDateString(),
                    'time_window' => '10 AM - 7 PM',
                ],
                'status' => $this->humanStatus($order->status),
            ],
            'payment' => [
                'payment_id' => $payment?->transaction_id,
                'gateway_order_id' => $payment?->gateway_order_id,
                'method' => $payment ? strtoupper((string) $payment->payment_method) : null,
                'status' => $this->humanPaymentStatus($order->payment_status),
                'amount_paid' => round((float) ($payment?->amount ?? $order->total_amount), 2),
                'currency' => $payment?->currency ?? self::CURRENCY,
                'paid_at' => $payment?->paid_at?->toISOString(),
            ],
            'customer' => [
                'name' => $order->user?->name,
                'email' => $order->user?->email,
                'phone' => $payment?->gateway_payload['contact']
                    ?? $order->user?->delivery_phone
                    ?? $order->user?->phone,
            ],
            'items' => $detail['items'],
            'shipping_address' => $detail['shipping_address'],
            'summary' => [
                'subtotal' => $detail['subtotal'],
                'shipping' => $detail['shipping'],
                'tax' => $detail['tax'],
                'discount' => $detail['discount'],
                'total' => $detail['total'],
                'currency' => $payment?->currency ?? self::CURRENCY,
                'coupon_code' => $detail['coupon_code'],
            ],
            'invoice' => [
                'number' => 'INV-'.preg_replace('/[^A-Za-z0-9]/', '', (string) $order->order_number),
                'issued_on' => optional($payment?->paid_at ?? $order->created_at)->toDateString(),
            ],
        ];
    }

    public function buildPaymentFailure(Order $order): array
    {
        $payment = $order->payments->sortByDesc('id')->first();
        $detail = $this->buildOrderDetail($order);

        return [
            'order' => [
                'id' => $order->order_number,
                'attempted_on' => optional($payment?->updated_at ?? $payment?->created_at ?? $order->updated_at ?? $order->created_at)->toDateString(),
                'status' => $this->humanStatus($order->status),
            ],
            'payment' => [
                'payment_id' => $payment?->transaction_id,
                'gateway_order_id' => $payment?->gateway_order_id,
                'method' => $payment ? strtoupper((string) $payment->payment_method) : null,
                'status' => $this->humanPaymentStatus($order->payment_status),
                'amount' => round((float) ($payment?->amount ?? $order->total_amount), 2),
                'currency' => $payment?->currency ?? self::CURRENCY,
                'failure_code' => $payment?->failure_code,
                'failure_reason' => $payment?->failure_reason ?: 'Payment could not be processed. Please try again.',
            ],
            'customer' => [
                'name' => $order->user?->name,
                'email' => $order->user?->email,
                'phone' => $payment?->gateway_payload['contact']
                    ?? $order->user?->delivery_phone
                    ?? $order->user?->phone,
            ],
            'items' => $detail['items'],
            'summary' => [
                'subtotal' => $detail['subtotal'],
                'shipping' => $detail['shipping'],
                'tax' => $detail['tax'],
                'discount' => $detail['discount'],
                'total' => $detail['total'],
                'currency' => $payment?->currency ?? self::CURRENCY,
                'coupon_code' => $detail['coupon_code'],
            ],
            'can_retry' => $this->canRetryPayment($order),
        ];
    }

    public function buildPaymentFailureFromAttempt(Payment $payment): array
    {
        if ($payment->order) {
            return $this->buildPaymentFailure($payment->order);
        }

        $payload = $payment->gateway_payload ?? [];
        $checkout = $payload['checkout'] ?? [];
        $summary = $checkout['summary'] ?? [];

        return [
            'order' => [
                'id' => $payment->gateway_order_id ?? (string) $payment->id,
                'attempted_on' => optional($payment->updated_at ?? $payment->created_at)->toDateString(),
                'status' => $payment->status === 'failed' ? 'Payment Failed' : 'Payment Pending',
            ],
            'payment' => [
                'payment_id' => $payment->transaction_id,
                'gateway_order_id' => $payment->gateway_order_id,
                'method' => strtoupper((string) $payment->payment_method),
                'status' => $this->humanPaymentStatus($payment->status),
                'amount' => round((float) ($payment->amount ?? ($summary['final_total'] ?? 0)), 2),
                'currency' => $payment->currency ?? self::CURRENCY,
                'failure_code' => $payment->failure_code,
                'failure_reason' => $payment->failure_reason ?: 'Payment could not be processed. Please try again.',
            ],
            'customer' => [
                'name' => $payload['name'] ?? null,
                'email' => $payload['email'] ?? null,
                'phone' => $payload['contact'] ?? null,
            ],
            'items' => collect($checkout['items'] ?? [])
                ->map(fn (array $item) => [
                    'product_name' => $item['product_name'] ?? $item['name'] ?? null,
                    'variant_name' => $item['variant_name'] ?? $item['variant'] ?? null,
                    'quantity' => (int) ($item['quantity'] ?? $item['qty'] ?? 0),
                    'price' => round((float) ($item['price'] ?? 0), 2),
                    'image' => $item['image'] ?? null,
                ])
                ->values()
                ->all(),
            'shipping_address' => $payload['address_snapshot'] ?? null,
            'summary' => [
                'subtotal' => round((float) ($summary['subtotal'] ?? 0), 2),
                'shipping' => round((float) ($summary['shipping'] ?? 0), 2),
                'tax' => round((float) ($summary['tax'] ?? 0), 2),
                'discount' => round((float) ($summary['discount_amount'] ?? 0), 2),
                'total' => round((float) ($summary['final_total'] ?? $summary['total'] ?? 0), 2),
                'currency' => $payment->currency ?? self::CURRENCY,
                'coupon_code' => data_get($checkout, 'coupon.code'),
            ],
            'can_retry' => in_array($payment->status, ['initiated', 'failed'], true),
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
            'initiated' => 'Initiated',
            'paid' => 'Paid',
            'success' => 'Paid',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            'unpaid' => 'Unpaid',
            default => $status ? ucfirst($status) : null,
        };
    }

    public function canRetryPayment(Order $order): bool
    {
        return in_array($order->payment_status, ['unpaid', 'failed'], true)
            && in_array($order->status, ['pending', 'confirmed'], true);
    }

    private function transformCartItems(Cart $cart): array
    {
        return $cart->items
            ->filter(fn (CartItem $item) => $item->variant && $item->variant->product)
            ->values()
            ->map(function (CartItem $item) {
                $variant = $item->variant;
                $product = $variant?->product;
                $unitPrice = $this->resolveVariantPrice($variant);
                $lineTotal = round($unitPrice * (int) $item->quantity, 2);

                return [
                    'id' => $item->id,
                    'product_id' => $product?->id,
                    'variant_id' => $item->variant_id,
                    'name' => $product?->name,
                    'product_name' => $product?->name,
                    'variant' => $variant?->name,
                    'variant_name' => $variant?->name,
                    'qty' => (int) $item->quantity,
                    'quantity' => (int) $item->quantity,
                    'price' => round($unitPrice, 2),
                    'line_total' => $lineTotal,
                    'image' => $variant?->primary_image['image_url']
                        ?? $product?->resolveMediaUrl($product?->cart_image_1),
                ];
            })
            ->all();
    }

    private function transformCoupon(Coupon $coupon, float $discount): array
    {
        return [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount_type' => $coupon->discount_type,
            'discount_value' => round((float) $coupon->discount_value, 2),
            'discount_amount' => round($discount, 2),
        ];
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

    private function cartSubtotal(Cart $cart): float
    {
        return round($cart->items
            ->filter(fn (CartItem $item) => $item->variant && $item->variant->product)
            ->sum(fn (CartItem $item) => $item->quantity * $this->resolveVariantPrice($item->variant)), 2);
    }

    private function validatePurchasableVariant(?ProductVariant $variant): ?string
    {
        if (! $variant) {
            return 'One or more cart items are no longer available.';
        }

        if (! $variant->status || ! $variant->product || ! $variant->product->status) {
            return 'One or more cart items are inactive.';
        }

        return null;
    }

    private function validateCouponForAmount(Coupon $coupon, float $amount, int $userId): ?string
    {
        if ($coupon->expiry_date && Carbon::today()->gt($coupon->expiry_date)) {
            return 'Coupon expired.';
        }

        if ($coupon->min_order_amount && $amount < $coupon->min_order_amount) {
            return 'Minimum cart value not met for this coupon.';
        }

        if ($coupon->required_completed_orders !== null) {
            $completedOrdersCount = Order::where('user_id', $userId)
                ->whereIn('status', ['delivered', 'completed'])
                ->count();

            if ($completedOrdersCount < $coupon->required_completed_orders) {
                return 'Required completed orders not reached for this coupon.';
            }
        }

        if ($coupon->usage_limit !== null && $coupon->usages()->count() >= $coupon->usage_limit) {
            return 'Coupon usage limit reached.';
        }

        if ($coupon->per_user_limit !== null) {
            $userUsageCount = $coupon->usages()->where('user_id', $userId)->count();

            if ($userUsageCount >= $coupon->per_user_limit) {
                return 'Per-user coupon limit reached.';
            }
        }

        return null;
    }

    private function calculateDiscount(Coupon $coupon, float $amount): float
    {
        $discount = $coupon->discount_type === 'percent'
            ? ($amount * (float) $coupon->discount_value) / 100
            : min($amount, (float) $coupon->discount_value);

        if ($coupon->max_discount) {
            $discount = min($discount, (float) $coupon->max_discount);
        }

        return $discount;
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'TKC-'.str_pad((string) random_int(1, 999999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
