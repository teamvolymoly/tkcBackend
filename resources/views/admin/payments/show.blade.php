@extends('admin.layouts.app')
@section('title', 'Payment Detail')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Payment Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $payment['transaction_id'] ?: 'Manual payment record' }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Order: {{ $payment['order']['order_number'] ?? 'N/A' }}</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Update payment</h2>
            <form method="POST" action="{{ route('admin.payments.update', $payment['id']) }}" class="mt-5 space-y-4" data-loading-form>
                @csrf @method('PUT')
                <label class="block text-sm font-medium">Payment method
                    <input type="text" name="payment_method" value="{{ old('payment_method', $payment['payment_method']) }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                </label>
                <label class="block text-sm font-medium">Transaction ID
                    <input type="text" name="transaction_id" value="{{ old('transaction_id', $payment['transaction_id']) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                </label>
                <label class="block text-sm font-medium">Status
                    <select name="status" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                        @foreach (['initiated', 'success', 'failed', 'refunded'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $payment['status']) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit" class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Save Payment</button>
            </form>
        </section>
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-6">
            <div>
                <h2 class="text-lg font-semibold">Snapshot</h2>
                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Customer</span><span class="font-medium">{{ $payment['order']['user']['name'] ?? 'N/A' }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Amount</span><span class="font-medium">Rs. {{ number_format((float) $payment['amount'], 2) }}</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Status</span><span>@include('admin.components.status-badge', ['value' => $payment['status']])</span></div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Paid at</span><span class="font-medium">{{ !empty($payment['paid_at']) ? \Illuminate\Support\Carbon::parse($payment['paid_at'])->format('d M Y h:i A') : 'Not paid yet' }}</span></div>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Order items</h2>
                <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Product</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Variant</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Qty</th></tr></thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach (($payment['order']['items'] ?? []) as $item)
                                <tr><td class="px-4 py-4 font-medium">{{ $item['product_name'] ?? ($item['variant']['product']['name'] ?? 'Product') }}</td><td class="px-4 py-4">{{ $item['variant_name'] ?? ($item['variant']['variant_name'] ?? 'Variant') }}</td><td class="px-4 py-4">{{ $item['quantity'] }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
