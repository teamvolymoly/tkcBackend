<?php

namespace App\Services;

use App\Models\ContactQuery;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function adminAnalytics(array $filters): array
    {
        $year = $this->resolveYear($filters['year'] ?? null);
        $range = $this->resolveRange($filters['range'] ?? null);
        [$start, $end] = $this->resolveWindow($year, $range);

        $ordersInRange = Order::query()->whereBetween('created_at', [$start, $end]);
        $customersInRange = User::role('customer')->whereBetween('created_at', [$start, $end]);
        $queriesInRange = ContactQuery::query()->whereBetween('created_at', [$start, $end]);

        $overview = $this->overviewSeries($start, $end);

        return [
            'filters' => [
                'year' => $year,
                'range' => $range,
                'available_years' => $this->availableYears($year),
            ],
            'summary' => [
                'total_revenue' => (float) (clone $ordersInRange)
                    ->where('payment_status', 'paid')
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount'),
                'orders_completed' => (clone $ordersInRange)
                    ->whereIn('status', ['delivered', 'completed'])
                    ->count(),
                'total_customers' => (clone $customersInRange)->count(),
                'total_active_products' => Product::query()->where('status', true)->count(),
            ],
            'overview' => $overview,
            'cancellations' => [
                'total' => (clone $ordersInRange)->where('status', 'cancelled')->count(),
                'items' => Order::query()
                    ->with('user:id,name,email')
                    ->where('status', 'cancelled')
                    ->whereBetween('created_at', [$start, $end])
                    ->latest()
                    ->limit(6)
                    ->get()
                    ->map(fn (Order $order) => [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_name' => $order->user?->name,
                        'customer_email' => $order->user?->email,
                        'total_amount' => (float) $order->total_amount,
                        'created_at' => optional($order->created_at)?->toIso8601String(),
                    ])
                    ->all(),
            ],
            'top_selling_products' => [
                'items' => DB::table('order_items')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->whereIn('orders.status', ['processing', 'shipped', 'delivered', 'completed'])
                    ->groupBy('order_items.product_id', 'order_items.product_name', 'products.slug')
                    ->selectRaw('order_items.product_id as id, order_items.product_name as name, products.slug as slug, SUM(order_items.quantity) as total_quantity, SUM(order_items.price * order_items.quantity) as total_sales')
                    ->orderByDesc('total_quantity')
                    ->limit(6)
                    ->get()
                    ->map(fn ($item) => [
                        'id' => $item->id,
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'total_quantity' => (int) $item->total_quantity,
                        'total_sales' => (float) $item->total_sales,
                    ])
                    ->all(),
            ],
            'customers' => [
                'total' => (clone $customersInRange)->count(),
                'items' => User::role('customer')
                    ->whereBetween('created_at', [$start, $end])
                    ->latest()
                    ->limit(6)
                    ->get(['id', 'name', 'email', 'phone', 'created_at'])
                    ->map(fn (User $user) => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'created_at' => optional($user->created_at)?->toIso8601String(),
                    ])
                    ->all(),
            ],
            'contact_queries' => [
                'total' => (clone $queriesInRange)->count(),
                'items' => ContactQuery::query()
                    ->whereBetween('created_at', [$start, $end])
                    ->latest()
                    ->limit(6)
                    ->get(['id', 'name', 'email', 'phone', 'subject', 'message', 'created_at'])
                    ->map(fn (ContactQuery $query) => [
                        'id' => $query->id,
                        'name' => $query->name,
                        'email' => $query->email,
                        'phone' => $query->phone,
                        'subject' => $query->subject,
                        'message' => $query->message,
                        'created_at' => optional($query->created_at)?->toIso8601String(),
                    ])
                    ->all(),
            ],
        ];
    }

    private function overviewSeries(Carbon $start, Carbon $end): array
    {
        $labels = collect(range(1, 12))->map(
            fn (int $month) => Carbon::create($start->year, $month, 1, 0, 0, 0, $start->timezone)->format('M Y')
        );

        $sales = $this->orderAggregateByMonth($start, $end, ['payment_status' => 'paid'], ['status', '!=', 'cancelled'], 'SUM(total_amount)');
        $cancelled = $this->orderAggregateByMonth($start, $end, ['status' => 'cancelled'], null, 'SUM(total_amount)');
        $completed = $this->orderAggregateByMonth($start, $end, null, ['status', 'IN', ['delivered', 'completed']], 'COUNT(*)');
        $newOrders = $this->orderAggregateByMonth($start, $end, null, null, 'COUNT(*)');

        $salesSeries = $this->normalizeMonthlySeries($sales);
        $cancelledSeries = $this->normalizeMonthlySeries($cancelled);
        $completedSeries = $this->normalizeMonthlySeries($completed);
        $newOrdersSeries = $this->normalizeMonthlySeries($newOrders);

        return [
            'labels' => $labels->all(),
            'series' => [
                'sales' => $salesSeries,
                'cancelled' => $cancelledSeries,
                'completed' => $completedSeries,
                'new_orders' => $newOrdersSeries,
            ],
            'totals' => [
                'sales' => array_sum($salesSeries),
                'cancelled' => array_sum($cancelledSeries),
                'completed' => array_sum($completedSeries),
                'new_orders' => array_sum($newOrdersSeries),
            ],
        ];
    }

    private function orderAggregateByMonth(Carbon $start, Carbon $end, ?array $where, ?array $specialWhere, string $select): Collection
    {
        $query = Order::query()
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('MONTH(created_at) as month_key, '.$select.' as aggregate');

        if ($where) {
            foreach ($where as $column => $value) {
                $query->where($column, $value);
            }
        }

        if ($specialWhere) {
            [$column, $operator, $value] = $specialWhere;
            if ($operator === 'IN') {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $operator, $value);
            }
        }

        return $query
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->pluck('aggregate', 'month_key');
    }

    private function normalizeMonthlySeries(Collection $series): array
    {
        return collect(range(1, 12))
            ->map(fn (int $month) => round((float) ($series->get($month) ?? 0), 2))
            ->all();
    }

    private function availableYears(int $fallbackYear): array
    {
        $years = collect([
            Order::query()->selectRaw('YEAR(created_at) as year')->pluck('year'),
            User::role('customer')->selectRaw('YEAR(created_at) as year')->pluck('year'),
            ContactQuery::query()->selectRaw('YEAR(created_at) as year')->pluck('year'),
            collect([$fallbackYear]),
        ])->flatten()->filter()->map(fn ($year) => (int) $year)->unique()->sortDesc()->values();

        return $years->all();
    }

    private function resolveYear(mixed $year): int
    {
        $currentYear = now()->year;
        $resolved = (int) $year;

        if ($resolved < 2020 || $resolved > $currentYear + 1) {
            return $currentYear;
        }

        return $resolved;
    }

    private function resolveRange(mixed $range): string
    {
        return in_array($range, ['yearly'], true) ? $range : 'yearly';
    }

    private function resolveWindow(int $year, string $range): array
    {
        return match ($range) {
            'yearly' => [
                Carbon::create($year, 1, 1)->startOfDay(),
                Carbon::create($year, 12, 31)->endOfDay(),
            ],
            default => [
                Carbon::create($year, 1, 1)->startOfDay(),
                Carbon::create($year, 12, 31)->endOfDay(),
            ],
        };
    }
}
