@php
    $totalOrders = count($orders['data'] ?? []);
    $pendingOrders = collect($orders['data'] ?? [])->where('status', 'pending')->count();
@endphp
@extends('admin.layouts.app')
@section('title', 'Orders')
@section('content')
<div class="space-y-6" x-data="selectionTable()">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Fulfillment</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Orders</h1>
                
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950"><span class="text-slate-500 dark:text-slate-400">Loaded</span><span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalOrders }}</span></div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300"><span>Pending</span><span class="ml-2 font-semibold">{{ $pendingOrders }}</span></div>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.7fr_0.9fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Order number, customer name, or email">
            <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All statuses</option>
                @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Order queue</h2>
                
            </div>
            <form method="POST" action="{{ route('admin.orders.bulk-status') }}" class="flex flex-wrap items-center gap-3">
                @csrf
                <template x-for="id in selected" :key="id"><input type="hidden" name="ids[]" :value="id"></template>
                <select name="status" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-950">
                    @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:opacity-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800" :disabled="selected.length === 0">Bulk Update</button>
            </form>
        </div>
        @if (empty($orders['data']))
            @include('admin.components.empty-state', ['title' => 'No orders found'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4"><input type="checkbox" @change="toggleAll($event)" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Order</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Customer</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Total</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($orders['data'] as $order)
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4"><input type="checkbox" value="{{ $order['id'] }}" x-model="selected" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $order['order_number'] }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($order['created_at'])->format('d M Y, h:i A') }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $order['user']['name'] ?? 'Unknown User' }}</td>
                                    <td class="px-4 py-4 font-medium text-slate-900 dark:text-white">Rs. {{ number_format((float) $order['total_amount'], 2) }}</td>
                                    <td class="px-4 py-4">@include('admin.components.status-badge', ['value' => $order['status']])</td>
                                    <td class="px-4 py-4 text-right"><a href="{{ route('admin.orders.show', $order['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.components.pagination', ['paginator' => $orders])
        @endif
    </section>
</div>
@endsection
@push('scripts')
<script>function selectionTable(){return{selected:[],toggleAll(event){const boxes=Array.from(document.querySelectorAll('tbody input[type=checkbox]'));this.selected=event.target.checked?boxes.map(box=>box.value):[]}}}</script>
@endpush



