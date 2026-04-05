@extends('admin.layouts.app')
@section('title', 'Coupon Details')
@section('content')
@php
    $usages = $coupon['usages'] ?? [];
@endphp
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Coupons</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $coupon['code'] ?? 'Coupon' }}</h1>
            
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.coupons.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
            <a href="{{ route('admin.coupons.edit', $coupon['id']) }}" class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Edit Coupon</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <div class="space-y-6">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Overview</h2>
                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Discount type</span><span class="font-medium">{{ strtoupper($coupon['discount_type'] ?? 'N/A') }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Discount value</span><span class="font-medium">{{ number_format((float) ($coupon['discount_value'] ?? 0), 2) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Usage count</span><span class="font-medium">{{ $coupon['usages_count'] ?? count($usages) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl px-4 py-3 {{ !empty($coupon['is_active']) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}"><span>Status</span><span class="font-semibold">{{ !empty($coupon['is_active']) ? 'Active' : 'Inactive' }}</span></div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Coupon Rules</h2>
                <div class="mt-5 grid gap-3 text-sm">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Required completed orders</span><span class="mt-1 block font-medium">{{ $coupon['required_completed_orders'] ?? 'No order requirement' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Minimum order</span><span class="mt-1 block font-medium">{{ $coupon['min_order_amount'] !== null ? number_format((float) $coupon['min_order_amount'], 2) : 'No minimum' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Maximum discount</span><span class="mt-1 block font-medium">{{ $coupon['max_discount'] !== null ? number_format((float) $coupon['max_discount'], 2) : 'No cap' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Usage limit</span><span class="mt-1 block font-medium">{{ $coupon['usage_limit'] ?? 'Unlimited' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Per user limit</span><span class="mt-1 block font-medium">{{ $coupon['per_user_limit'] ?? 'Unlimited' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Expiry date</span><span class="mt-1 block font-medium">{{ !empty($coupon['expiry_date']) ? \Illuminate\Support\Carbon::parse($coupon['expiry_date'])->format('d M Y') : 'No expiry' }}</span></div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Timeline</h2>
                <div class="mt-5 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Created</span><span class="mt-1 block">{{ !empty($coupon['created_at']) ? \Illuminate\Support\Carbon::parse($coupon['created_at'])->format('d M Y, h:i A') : 'N/A' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Last updated</span><span class="mt-1 block">{{ !empty($coupon['updated_at']) ? \Illuminate\Support\Carbon::parse($coupon['updated_at'])->format('d M Y, h:i A') : 'N/A' }}</span></div>
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold">Usage History</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Orders and customers who redeemed this coupon.</p>
                    </div>
                </div>
                @if (count($usages))
                    <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                            <thead class="bg-slate-50/80 dark:bg-slate-950/70">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Customer</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Email</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Order</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                @foreach ($usages as $usage)
                                    <tr>
                                        <td class="px-4 py-4 font-medium">{{ $usage['user']['name'] ?? 'Unknown User' }}</td>
                                        <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $usage['user']['email'] ?? 'N/A' }}</td>
                                        <td class="px-4 py-4">{{ $usage['order']['order_number'] ?? 'N/A' }}</td>
                                        <td class="px-4 py-4">{{ isset($usage['order']['total_amount']) ? number_format((float) $usage['order']['total_amount'], 2) : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No usages yet', 'message' => 'This coupon has not been redeemed in any order yet.'])</div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection

