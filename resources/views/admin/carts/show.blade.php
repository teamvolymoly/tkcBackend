@extends('admin.layouts.app')
@section('title', 'Cart Detail')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Cart Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $cart['user']['name'] ?? 'Customer cart' }}</h1>
        </div>
        <a href="{{ route('admin.carts.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Customer snapshot</h2>
            <dl class="mt-5 space-y-3 text-sm">
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $cart['user']['email'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Phone</dt><dd class="font-medium">{{ $cart['user']['phone'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Items</dt><dd class="font-medium">{{ count($cart['items'] ?? []) }}</dd></div>
            </dl>
        </section>
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Cart items</h2>
            <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                    <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Product</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Variant</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Qty</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Available</th></tr></thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                        @foreach (($cart['items'] ?? []) as $item)
                            <tr>
                                <td class="px-4 py-4 font-medium">{{ $item['variant']['product']['name'] ?? 'Product' }}</td>
                                <td class="px-4 py-4">{{ $item['variant']['name'] ?? ($item['variant']['variant_name'] ?? 'Variant') }}</td>
                                <td class="px-4 py-4">{{ $item['quantity'] }}</td>
                                <td class="px-4 py-4">Available</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
