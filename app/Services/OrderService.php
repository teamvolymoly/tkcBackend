<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function adminDashboardStats(): array
    {
        return [
            'total_customers' => User::role('customer')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
        ];
    }

    public function adminOrders(array $filters): LengthAwarePaginator
    {
        return Order::with(['user', 'items'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['q'] ?? null, function ($query, $term) {
                $query->where(function ($inner) use ($term) {
                    $inner->where('order_number', 'like', "%{$term}%")
                        ->orWhereHas('user', function ($userQuery) use ($term) {
                            $userQuery->where('name', 'like', "%{$term}%")
                                ->orWhere('email', 'like', "%{$term}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();
    }

    public function adminOrderDetail(int|string $id): Order
    {
        return Order::with(['user', 'address', 'items.variant.product', 'payments'])
            ->findOrFail($id);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        if (! $this->canTransition($order->status, $status)) {
            throw ValidationException::withMessages([
                'status' => ['Invalid order status transition.'],
            ]);
        }

        $order->update(['status' => $status]);

        return $order->fresh(['user', 'items']);
    }

    private function canTransition(string $currentStatus, string $nextStatus): bool
    {
        if ($currentStatus === $nextStatus) {
            return true;
        }

        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
        ];

        return in_array($nextStatus, $allowedTransitions[$currentStatus] ?? [], true);
    }
}
