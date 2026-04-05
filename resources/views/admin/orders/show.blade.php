@extends('admin.layouts.app')
@section('title', 'Order Details')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Order Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $order['order_number'] }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Customer: {{ $order['user']['name'] ?? 'Unknown User' }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <div class="space-y-6">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Workflow</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order['id']) }}" data-loading-form class="mt-5 space-y-4">
                    @csrf @method('PUT')
                    <select name="status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                        @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order['status'] === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Update Status</button>
                </form>
            </section>
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Summary</h2>
                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Payment</span><span>@include('admin.components.status-badge', ['value' => $order['payment_status']])</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Subtotal</span><span class="font-medium">Rs. {{ number_format((float) $order['subtotal'], 2) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Shipping</span><span class="font-medium">Rs. {{ number_format((float) $order['shipping_amount'], 2) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Discount</span><span class="font-medium">Rs. {{ number_format((float) $order['discount_amount'], 2) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-900 px-4 py-3 text-white dark:bg-white dark:text-slate-900"><span>Total</span><span class="font-semibold">Rs. {{ number_format((float) $order['total_amount'], 2) }}</span></div>
                </div>
            </section>
        </div>
        <div class="space-y-6">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Items</h2>
                <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Product</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Variant</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Qty</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Price</th></tr></thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($order['items'] as $item)
                                <tr>
                                    <td class="px-4 py-4 font-medium">{{ $item['product_name'] }}</td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $item['variant_name'] }}</td>
                                    <td class="px-4 py-4">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-4">Rs. {{ number_format((float) $item['price'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Shipping address</h2>
                @if (!empty($order['address']))
                    <div class="mt-5 rounded-[1.5rem] bg-slate-50 p-5 text-sm text-slate-600 dark:bg-slate-950/60 dark:text-slate-300">
                        {{ $order['address']['address_line1'] ?? '' }}, {{ $order['address']['address_line2'] ?? '' }}<br>
                        {{ $order['address']['city'] ?? '' }}, {{ $order['address']['state'] ?? '' }} {{ $order['address']['pincode'] ?? '' }}<br>
                        {{ $order['address']['country'] ?? '' }}
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No address available', 'message' => 'This order does not have shipping address data.'])</div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
