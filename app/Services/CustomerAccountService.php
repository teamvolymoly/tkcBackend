<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

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
        $order = $this->resolveUserOrder($user, $identifier);

        $payment = $order->payments->sortByDesc('id')->first();
        $address = $order->address;

        return [
            'order' => [
                'id' => $order->order_number,
                'placed_on' => optional($order->created_at)->toDateString(),
                'status' => $this->checkoutService->humanStatus($order->status),
                'payment_status' => $this->checkoutService->humanPaymentStatus($order->payment_status),
                'payment_method' => $payment ? strtoupper((string) $payment->payment_method) : null,
                'delivered_date' => optional($order->delivery_date ?? $order->updated_at ?? $order->created_at)->toDateString(),
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
            ->where('status', 'approved')
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
                    'title' => $review->title,
                    'comment' => $review->review,
                    'status' => ucfirst((string) $review->status),
                    'created_at' => optional($review->created_at)->toDateString(),
                ])
                ->values()
                ->all(),
            'pagination' => $this->paginationMeta($paginator),
        ];
    }

    public function eligibleReviewItems(User $user): array
    {
        $items = OrderItem::query()
            ->with([
                'order:id,order_number,status,payment_status,delivery_date,user_id,created_at,updated_at',
                'product:id,name,slug,image_1',
                'variant',
                'review' => fn ($query) => $query->where('user_id', $user->id),
            ])
            ->whereHas('order', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('payment_status', 'paid')
                    ->where('status', 'delivered');
            })
            ->latest('id')
            ->get();

        return [
            'items' => $items->map(fn (OrderItem $item) => $this->transformEligibleReviewItem($item))->values()->all(),
        ];
    }

    public function orderReviewEligibility(User $user, string $identifier): array
    {
        $order = $this->resolveUserOrder($user, $identifier);

        $canReviewOrder = $order->payment_status === 'paid' && $order->status === 'delivered';

        $order->load([
            'items.variant.product',
            'items.review' => fn ($query) => $query->where('user_id', $user->id),
        ]);

        return [
            'order_id' => $order->order_number,
            'order_status' => $this->checkoutService->humanStatus($order->status),
            'payment_status' => $this->checkoutService->humanPaymentStatus($order->payment_status),
            'items' => $order->items->map(function (OrderItem $item) use ($canReviewOrder) {
                $payload = $this->transformEligibleReviewItem($item);
                unset($payload['order_id'], $payload['delivered_date']);
                $payload['can_review'] = $canReviewOrder && $payload['review'] === null;
                $payload['reason'] = $payload['can_review']
                    ? null
                    : ($payload['review'] ? 'You have already reviewed this item.' : 'Only delivered paid order items can be reviewed.');

                return $payload;
            })->values()->all(),
        ];
    }

    public function storeCustomerReview(User $user, array $attributes): array
    {
        $orderItem = $this->resolveReviewableOrderItem($user, $attributes['order_item_id']);

        $existingReview = Review::query()
            ->where('order_item_id', $orderItem->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            throw ValidationException::withMessages([
                'order_item_id' => ['You have already reviewed this item.'],
            ]);
        }

        $review = Review::create([
            'product_id' => $orderItem->product_id,
            'variant_id' => $orderItem->variant_id,
            'user_id' => $user->id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $attributes['rating'],
            'title' => $attributes['title'] ?? null,
            'review' => $attributes['comment'] ?? null,
            'status' => 'pending',
        ]);

        return $this->transformCustomerReview($review->fresh());
    }

    public function updateCustomerReview(User $user, int $reviewId, array $attributes): array
    {
        $review = Review::query()
            ->where('id', $reviewId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $orderItem = $this->resolveReviewableOrderItem($user, $review->order_item_id);

        $review->update([
            'product_id' => $orderItem->product_id,
            'variant_id' => $orderItem->variant_id,
            'order_id' => $orderItem->order_id,
            'rating' => $attributes['rating'],
            'title' => $attributes['title'] ?? null,
            'review' => $attributes['comment'] ?? null,
        ]);

        return $this->transformCustomerReview($review->fresh());
    }

    private function transformOrderListItem(Order $order): array
    {
        $firstItem = $order->items->first();

        return [
            'id' => $order->order_number,
            'placed_on' => optional($order->created_at)->toDateString(),
            'status' => $this->checkoutService->humanStatus($order->status),
            'payment_status' => $this->checkoutService->humanPaymentStatus($order->payment_status),
            'can_review' => $order->payment_status === 'paid' && $order->status === 'delivered',
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

    private function resolveUserOrder(User $user, string $identifier): Order
    {
        return Order::query()
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
    }

    private function resolveReviewableOrderItem(User $user, int $orderItemId): OrderItem
    {
        $orderItem = OrderItem::query()
            ->with(['order', 'product', 'variant'])
            ->where('id', $orderItemId)
            ->whereHas('order', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('payment_status', 'paid')
                    ->where('status', 'delivered');
            })
            ->first();

        if (! $orderItem) {
            throw ValidationException::withMessages([
                'order_item_id' => ['Only delivered paid order items can be reviewed.'],
            ]);
        }

        return $orderItem;
    }

    private function transformEligibleReviewItem(OrderItem $item): array
    {
        $review = $item->review;

        return [
            'order_id' => $item->order?->order_number,
            'order_item_id' => $item->id,
            'product_id' => $item->product_id,
            'variant_id' => $item->variant_id,
            'product_name' => $item->product_name,
            'variant_name' => $item->variant_name,
            'image' => $item->variant?->primary_image['image_url']
                ?? $item->product?->resolveMediaUrl($item->product?->image_1),
            'delivered_date' => optional($item->order?->delivery_date ?? $item->order?->updated_at ?? $item->order?->created_at)->toDateString(),
            'can_review' => $review === null,
            'reason' => $review ? 'You have already reviewed this item.' : null,
            'review' => $review ? $this->transformCustomerReview($review) : null,
        ];
    }

    private function transformCustomerReview(Review $review): array
    {
        return [
            'id' => $review->id,
            'order_id' => $review->order?->order_number,
            'order_item_id' => $review->order_item_id,
            'product_id' => $review->product_id,
            'variant_id' => $review->variant_id,
            'rating' => (int) $review->rating,
            'title' => $review->title,
            'comment' => $review->review,
            'updated_at' => optional($review->updated_at)->toISOString(),
            'created_at' => optional($review->created_at)->toISOString(),
            'status' => ucfirst((string) $review->status),
        ];
    }
}
