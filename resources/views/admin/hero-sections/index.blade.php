@extends('admin.layouts.app')
@section('title', 'Hero Sections')
@section('content')
@php($totalHeroSections = count($heroSections['data'] ?? []))
@php($activeHeroSections = collect($heroSections['data'] ?? [])->where('status', true)->count())
<div class="space-y-6">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Settings</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Hero Section Manager</h1>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Homepage hero slides ko manage kijiye. Yahin se product image, name aur slug frontend home API me jayega.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950"><span class="text-slate-500 dark:text-slate-400">Loaded</span><span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalHeroSections }}</span></div>
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300"><span>Active</span><span class="ml-2 font-semibold">{{ $activeHeroSections }}</span></div>
                <a href="{{ route('admin.hero-sections.create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add Hero Section</a>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.8fr_0.8fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Search product name or slug">
            <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All status</option>
                <option value="1" @selected(($filters['status'] ?? '') === '1')>Active</option>
                <option value="0" @selected(($filters['status'] ?? '') === '0')>Inactive</option>
            </select>
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if (empty($heroSections['data']))
            @include('admin.components.empty-state', ['title' => 'No hero sections found', 'message' => 'Start with your first hero banner item from settings.'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Hero Item</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Slug</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Order</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($heroSections['data'] as $heroSection)
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-16 w-16 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                                                @if (!empty($heroSection['product_image_url']))
                                                    <img src="{{ $heroSection['product_image_url'] }}" alt="{{ $heroSection['product_name'] }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">No image</div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900 dark:text-white">{{ $heroSection['product_name'] }}</div>
                                                <div class="mt-1 text-xs text-slate-500">Hero section entry</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $heroSection['product_slug'] }}</td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $heroSection['sort_order'] ?? 0 }}</td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($heroSection['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($heroSection['status']) ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('admin.hero-sections.show', $heroSection['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">View</a>
                                            <a href="{{ route('admin.hero-sections.edit', $heroSection['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            <form method="POST" action="{{ route('admin.hero-sections.destroy', $heroSection['id']) }}" data-confirm="Delete this hero section item?">
                                                @csrf
                                                @method('DELETE')
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
            @include('admin.components.pagination', ['paginator' => $heroSections])
        @endif
    </section>
</div>
@endsection
