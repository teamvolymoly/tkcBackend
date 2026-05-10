<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerAccountService
{
    public function __construct(
        private readonly CustomerCheckoutService $checkoutService,
    ) {}

    public function userOrders(User $user, array $filters = []): array
    {
        $limit = $this->resolveLimit($filters['limit'] ?? null, 10);
        $page = max(1, (int) ($filters['page'] ?? 1));
        $status = trim((string) ($filters['status'] ?? ''));

        $paginator = Order::query()
            ->with(['items'])
            ->where('user_id', $user->id)
            ->whereIn('payment_status', ['paid', 'refunded'])
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', strtolower($status));
            })
            ->latest()
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'items' => collect($paginator->items())
                ->map(fn (Order $order) => $this->transformOrderListItem($order))
                ->values()
                ->all(),
            'pagination' => $this->paginationMeta($paginator),
        ];
    }

    public function userOrderDetail(User $user, string $identifier): array
    {
        $order = Order::query()
            ->with(['items.variant.product', 'address', 'payments', 'user'])
            ->where('user_id', $user->id)
            ->whereIn('payment_status', ['paid', 'refunded'])
            ->where(function ($query) use ($identifier) {
                $query->where('order_number', $identifier);

                if (ctype_digit($identifier)) {
                    $query->orWhere('id', (int) $identifier);
                }
            })
            ->firstOrFail();

        $payment = $order->payments->sortByDesc('id')->first();
        $address = $order->address;

        return [
            'order' => [
                'id' => $order->order_number,
                'placed_on' => optional($order->created_at)->toDateString(),
                'status' => $this->checkoutService->humanStatus($order->status),
                'payment_status' => $this->checkoutService->humanPaymentStatus($order->payment_status),
                'payment_method' => $payment ? strtoupper((string) $payment->payment_method) : null,
                'delivered_date' => optional($order->delivery_date)->toDateString(),
                'subtotal' => round((float) $order->subtotal, 2),
                'shipping' => round((float) $order->shipping_amount, 2),
                'tax' => 0.0,
                'discount' => round((float) $order->discount_amount, 2),
                'total' => round((float) $order->total_amount, 2),
                'currency' => $payment?->currency ?? CustomerCheckoutService::CURRENCY,
            ],
            'customer' => [
                'name' => $order->user?->name,
                'email' => $order->user?->email,
                'phone' => $order->user?->delivery_phone ?: $order->user?->phone,
            ],
            'items' => $order->items
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product_name,
                        'variant_name' => $item->variant_name,
                        'quantity' => (int) $item->quantity,
                        'price' => round((float) $item->price, 2),
                        'line_total' => round((float) $item->price * (int) $item->quantity, 2),
                        'image' => $item->variant?->primary_image['image_url']
                            ?? $item->product?->resolveMediaUrl($item->product?->image_1),
                    ];
                })
                ->values()
                ->all(),
            'shipping_address' => $address ? [
                'label' => $address->label,
                'address_line1' => $address->address_line1,
                'address_line2' => $address->address_line2,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
                'country' => $address->country,
            ] : null,
            'invoice' => [
                'number' => 'INV-'.preg_replace('/[^A-Za-z0-9]/', '', (string) $order->order_number),
                'issued_on' => optional($payment?->paid_at ?? $order->created_at)->toDateString(),
            ],
        ];
    }

    public function userDashboard(User $user): array
    {
        $orders = Order::query()
            ->where('user_id', $user->id)
            ->whereIn('payment_status', ['paid', 'refunded'])
            ->get(['id', 'order_number', 'status', 'payment_status', 'total_amount', 'created_at']);

        $recentOrders = Order::query()
            ->where('user_id', $user->id)
            ->whereIn('payment_status', ['paid', 'refunded'])
            ->latest()
            ->limit(5)
            ->get(['id', 'order_number', 'status', 'total_amount', 'created_at']);

        return [
            'stats' => [
                'total_orders' => $orders->count(),
                'active_orders' => $orders->whereIn('status', ['pending', 'confirmed', 'processing', 'shipped'])->count(),
                'delivered_orders' => $orders->whereIn('status', ['delivered', 'completed'])->count(),
                'cancelled_orders' => $orders->where('status', 'cancelled')->count(),
                'total_spent' => round((float) $orders
                    ->whereIn('payment_status', ['paid', 'refunded'])
                    ->sum(fn (Order $order) => (float) $order->total_amount), 2),
                'currency' => CustomerCheckoutService::CURRENCY,
            ],
            'recent_orders' => $recentOrders
                ->map(fn (Order $order) => [
                    'id' => $order->order_number,
                    'placed_on' => optional($order->created_at)->toDateString(),
                    'status' => $this->checkoutService->humanStatus($order->status),
                    'total' => round((float) $order->total_amount, 2),
                    'currency' => CustomerCheckoutService::CURRENCY,
                ])
                ->values()
                ->all(),
        ];
    }

    public function productReviews(string $identifier, array $filters = []): array
    {
        $limit = $this->resolveLimit($filters['limit'] ?? null, 10);
        $page = max(1, (int) ($filters['page'] ?? 1));

        $product = Product::query()
            ->where('status', true)
            ->where(function ($query) use ($identifier) {
                $query->where('slug', $identifier);

                if (ctype_digit($identifier)) {
                    $query->orWhere('id', (int) $identifier);
                }
            })
            ->firstOrFail();

        $paginator = Review::query()
            ->with('user:id,name')
            ->where('product_id', $product->id)
            ->latest()
            ->paginate($limit, ['*'], 'page', $page);

        $summary = Review::query()
            ->where('product_id', $product->id)
            ->selectRaw('COALESCE(AVG(rating), 0) as average_rating, COUNT(*) as total_reviews')
            ->first();

        return [
            'summary' => [
                'average_rating' => round((float) ($summary?->average_rating ?? 0), 1),
                'total_reviews' => (int) ($summary?->total_reviews ?? 0),
            ],
            'items' => collect($paginator->items())
                ->map(fn (Review $review) => [
                    'id' => $review->id,
                    'name' => $review->user?->name,
                    'rating' => (int) $review->rating,
                    'comment' => $review->review,
                    'created_at' => optional($review->created_at)->toDateString(),
                ])
                ->values()
                ->all(),
            'pagination' => $this->paginationMeta($paginator),
        ];
    }

    private function transformOrderListItem(Order $order): array
    {
        $firstItem = $order->items->first();

        return [
            'id' => $order->order_number,
            'placed_on' => optional($order->created_at)->toDateString(),
            'status' => $this->checkoutService->humanStatus($order->status),
            'payment_status' => $this->checkoutService->humanPaymentStatus($order->payment_status),
            'total' => round((float) $order->total_amount, 2),
            'currency' => CustomerCheckoutService::CURRENCY,
            'items_count' => (int) $order->items->sum('quantity'),
            'product_name' => $firstItem?->product_name,
            'product_variant' => $firstItem?->variant_name,
        ];
    }

    private function paginationMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'page' => $paginator->currentPage(),
            'limit' => $paginator->perPage(),
            'total_items' => $paginator->total(),
            'total_pages' => $paginator->lastPage(),
        ];
    }

    private function resolveLimit(mixed $limit, int $default): int
    {
        $resolved = (int) $limit;

        if ($resolved <= 0) {
            return $default;
        }

        return min($resolved, 50);
    }
}
