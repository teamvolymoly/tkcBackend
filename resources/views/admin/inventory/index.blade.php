@extends('admin.layouts.app')
@section('title', 'Inventory')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Inventory</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Variant stock control</h1>
        
    </div>

    @if (empty($inventory['data']))
        @include('admin.components.empty-state', ['title' => 'No inventory rows'])
    @else
        <div class="space-y-4">
            @foreach ($inventory['data'] as $row)
                <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-300">{{ $row['variant']['product']['name'] ?? 'Unknown product' }}</p>
                            <h2 class="mt-2 text-xl font-semibold">{{ $row['variant']['variant_name'] ?? 'Default variant' }}</h2>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">SKU: {{ $row['variant']['sku'] ?? 'N/A' }} | Price: Rs. {{ number_format((float) ($row['variant']['price'] ?? 0), 2) }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.inventory.update', $row['variant_id']) }}" class="grid gap-3 sm:grid-cols-3 lg:min-w-[32rem]" data-loading-form>
                            @csrf @method('PUT')
                            <label class="text-sm font-medium">Stock
                                <input type="number" name="stock" value="{{ $row['stock'] ?? 0 }}" min="0" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                            </label>
                            <label class="text-sm font-medium">Reserved
                                <input type="number" name="reserved_stock" value="{{ $row['reserved_stock'] ?? 0 }}" min="0" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                            </label>
                            <label class="text-sm font-medium">Warehouse
                                <input type="text" name="warehouse" value="{{ $row['warehouse'] ?? 'default' }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                            </label>
                            <div class="sm:col-span-3 flex justify-end">
                                <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Save Inventory</button>
                            </div>
                        </form>
                    </div>
                </section>
            @endforeach
        </div>
        @include('admin.components.pagination', ['paginator' => $inventory])
    @endif
</div>
@endsection


