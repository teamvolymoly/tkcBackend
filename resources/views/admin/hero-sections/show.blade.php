@extends('admin.layouts.app')
@section('title', 'View Hero Section')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Settings</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $heroSection['product_name'] }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.hero-sections.edit', $heroSection['id']) }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
            <a href="{{ route('admin.hero-sections.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
        </div>
    </div>

    <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-5">
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($heroSection['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($heroSection['status']) ? 'Active' : 'Inactive' }}</span>
            <span class="text-sm text-slate-500 dark:text-slate-400">Sort order: {{ $heroSection['sort_order'] ?? 0 }}</span>
        </div>

        @if (!empty($heroSection['product_image_url']))
            <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white dark:border-slate-800">
                <img src="{{ $heroSection['product_image_url'] }}" alt="{{ $heroSection['product_name'] }}" class="max-h-[360px] w-full object-cover">
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Product name</p>
                <p class="mt-2 text-base font-medium text-slate-900 dark:text-white">{{ $heroSection['product_name'] }}</p>
            </div>
            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Product slug</p>
                <p class="mt-2 text-base font-medium text-slate-900 dark:text-white">{{ $heroSection['product_slug'] }}</p>
            </div>
        </div>
    </section>
</div>
@endsection
