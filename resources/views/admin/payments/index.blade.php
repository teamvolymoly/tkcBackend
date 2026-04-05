@extends('admin.layouts.app')
@section('title', 'Payments')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Payments</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Payment operations</h1>
    </div>

    <form method="GET" class="grid gap-4 rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 md:grid-cols-[1fr_180px_180px_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search order, transaction, customer" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <select name="status" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <option value="">All statuses</option>
            @foreach (['initiated', 'success', 'failed', 'refunded'] as $status)
                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <input type="text" name="payment_method" value="{{ $filters['payment_method'] ?? '' }}" placeholder="Method" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>

    @if (empty($payments['data']))
        @include('admin.components.empty-state', ['title' => 'No payments'])
    @else
        <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Order</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Customer</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Method</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Amount</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th><th class="px-4 py-3"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($payments['data'] as $payment)
                        <tr>
                            <td class="px-4 py-4 font-medium">{{ $payment['order']['order_number'] ?? 'Order #'.$payment['order_id'] }}</td>
                            <td class="px-4 py-4">{{ $payment['order']['user']['name'] ?? 'Unknown customer' }}</td>
                            <td class="px-4 py-4">{{ $payment['payment_method'] }}</td>
                            <td class="px-4 py-4">Rs. {{ number_format((float) $payment['amount'], 2) }}</td>
                            <td class="px-4 py-4">@include('admin.components.status-badge', ['value' => $payment['status']])</td>
                            <td class="px-4 py-4 text-right"><a href="{{ route('admin.payments.show', $payment['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Inspect</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagination', ['paginator' => $payments])
    @endif
</div>
@endsection

