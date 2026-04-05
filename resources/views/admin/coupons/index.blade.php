@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Coupons</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Discount control room</h1>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add Coupon</a>
    </div>

    <form method="GET" class="grid gap-4 rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 md:grid-cols-[1fr_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search code" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>

    @if (empty($coupons['data']))
        @include('admin.components.empty-state', ['title' => 'No coupons yet'])
    @else
        <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Code</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Discount</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Order Rule</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Usage</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Expiry</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th><th class="px-4 py-3"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($coupons['data'] as $coupon)
                        <tr>
                            <td class="px-4 py-4 font-medium">{{ $coupon['code'] }}</td>
                            <td class="px-4 py-4">{{ strtoupper($coupon['discount_type']) }} {{ number_format((float) $coupon['discount_value'], 2) }}</td>
                            <td class="px-4 py-4">{{ $coupon['required_completed_orders'] ?? 'No rule' }}</td>
                            <td class="px-4 py-4">{{ $coupon['usages_count'] ?? 0 }}</td>
                            <td class="px-4 py-4">{{ !empty($coupon['expiry_date']) ? \Illuminate\Support\Carbon::parse($coupon['expiry_date'])->format('d M Y') : 'No expiry' }}</td>
                            <td class="px-4 py-4">@include('admin.components.status-badge', ['value' => !empty($coupon['is_active']) ? 'active' : 'inactive'])</td>
                            <td class="px-4 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.coupons.show', $coupon['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">View</a>
                                    <a href="{{ route('admin.coupons.edit', $coupon['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon['id']) }}" data-confirm="Delete this coupon?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-2xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagination', ['paginator' => $coupons])
    @endif
</div>
@endsection

