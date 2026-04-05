@php
    $totalProducts = count($products['data'] ?? []);
    $activeProducts = collect($products['data'] ?? [])->where('status', true)->count();
@endphp
@extends('admin.layouts.app')
@section('title', 'Products')
@section('content')
<div class="space-y-6" x-data="selectionTable()">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Catalog</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Products</h1>
                
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950">
                    <span class="text-slate-500 dark:text-slate-400">Loaded</span>
                    <span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalProducts }}</span>
                </div>
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <span>Active</span>
                    <span class="ml-2 font-semibold">{{ $activeProducts }}</span>
                </div>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add Product</a>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.7fr_0.9fr_0.8fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Search by product name or description">
            <select name="category_id" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" @selected(($filters['category_id'] ?? '') == $category['id'])>{{ $category['name'] }}</option>
                @endforeach
            </select>
            <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All status</option>
                <option value="1" @selected(($filters['status'] ?? '') === '1')>Active</option>
                <option value="0" @selected(($filters['status'] ?? '') === '0')>Inactive</option>
            </select>
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Product listing</h2>
                
            </div>
            <form method="POST" action="{{ route('admin.products.bulk-delete') }}" data-confirm="Delete selected products and their variants?" class="flex items-center gap-3">
                @csrf
                <template x-for="id in selected" :key="id"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50 disabled:opacity-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10" :disabled="selected.length === 0">Delete Selected</button>
            </form>
        </div>
        @if (empty($products['data']))
            @include('admin.components.empty-state', ['title' => 'No products found'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4"><input type="checkbox" @change="toggleAll($event)" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Product</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Category</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Variants</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($products['data'] as $product)
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4"><input type="checkbox" value="{{ $product['id'] }}" x-model="selected" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $product['name'] }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $product['slug'] }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $product['category']['name'] ?? 'Uncategorized' }}</td>
                                    <td class="px-4 py-4"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ count($product['variants'] ?? []) }} variants</span></td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($product['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($product['status']) ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.show', $product['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">View</a>
                                            <a href="{{ route('admin.products.edit', $product['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product['id']) }}" data-confirm="Delete this product and all variants?">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.components.pagination', ['paginator' => $products])
        @endif
    </section>
</div>
@endsection
@push('scripts')
<script>function selectionTable(){return{selected:[],toggleAll(event){const boxes=Array.from(document.querySelectorAll('tbody input[type=checkbox]'));this.selected=event.target.checked?boxes.map(box=>box.value):[]}}}</script>
@endpush



