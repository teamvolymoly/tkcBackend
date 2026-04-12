@extends('admin.layouts.app')
@section('title', 'Product Details')
@section('content')
@php
    $variants = $product['variants'] ?? [];
    $gallery = $product['gallery'] ?? [];
    $ingredients = $product['ingredients'] ?? [];
    $faqs = $product['faqs'] ?? [];
@endphp
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Catalog Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $product['name'] ?? 'Product' }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $product['tag_line_1'] ?? '' }} @if(!empty($product['tag_line_2'])) | {{ $product['tag_line_2'] }} @endif</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold">Back</a>
            <a href="{{ route('admin.products.edit', $product['id']) }}" class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Edit Product</a>
        </div>
    </div>

    <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <h2 class="text-lg font-semibold">Description</h2>
                <p class="mt-4 text-sm text-slate-600 dark:text-slate-300">{{ $product['description'] ?? 'No description added.' }}</p>
            </div>
            <div class="grid gap-3 text-sm">
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span>Category</span><span class="font-medium">{{ $product['category']['name'] ?? 'Uncategorized' }}</span></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span>Subcategory</span><span class="font-medium">{{ $product['subcategory']['name'] ?? 'None' }}</span></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span>Variants</span><span class="font-medium">{{ count($variants) }}</span></div>
                <div class="flex items-center justify-between rounded-2xl px-4 py-3 {{ !empty($product['status']) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}"><span>Status</span><span class="font-semibold">{{ !empty($product['status']) ? 'Active' : 'Inactive' }}</span></div>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <h2 class="text-lg font-semibold">Gallery</h2>
        <div class="mt-5 grid gap-3 md:grid-cols-3 xl:grid-cols-5">
            @forelse ($gallery as $image)
                <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/60">
                    <img src="{{ $image['image_url'] }}" alt="Product image" class="h-40 w-full object-cover">
                </div>
            @empty
                <div>@include('admin.components.empty-state', ['title' => 'No product images'])</div>
            @endforelse
        </div>
    </section>

    <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <h2 class="text-lg font-semibold">Ingredients</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @forelse ($ingredients as $ingredient)
                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                    @if (!empty($ingredient['image_url']))
                        <img src="{{ $ingredient['image_url'] }}" alt="{{ $ingredient['name'] }}" class="mb-3 h-28 w-full rounded-2xl object-cover">
                    @endif
                    <p class="text-sm font-semibold">{{ $ingredient['name'] ?? 'Ingredient' }}</p>
                </div>
            @empty
                <div>@include('admin.components.empty-state', ['title' => 'No ingredients'])</div>
            @endforelse
        </div>
    </section>

    <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <h2 class="text-lg font-semibold">FAQs</h2>
        <div class="mt-5 space-y-3">
            @forelse ($faqs as $faq)
                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                    <p class="font-semibold">{{ $faq['question'] ?? 'Question' }}</p>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $faq['answer'] ?? 'No answer' }}</p>
                </div>
            @empty
                <div>@include('admin.components.empty-state', ['title' => 'No FAQs'])</div>
            @endforelse
        </div>
    </section>

    <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <h2 class="text-lg font-semibold">Variants</h2>
        <div class="mt-5 grid gap-4 lg:grid-cols-2">
            @forelse ($variants as $variant)
                <article class="rounded-[1.5rem] border border-slate-200 bg-slate-50/80 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold">{{ $variant['name'] ?? ($variant['variant_name'] ?? 'Variant') }}</h3>
                            <p class="mt-1 text-xs text-slate-500">SKU: {{ $variant['sku'] ?? 'N/A' }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ !empty($variant['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">{{ !empty($variant['status']) ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Price</span><span class="mt-1 block font-medium">Rs. {{ number_format((float) ($variant['price'] ?? 0), 2) }}</span></div>
                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Discount price</span><span class="mt-1 block font-medium">{{ isset($variant['discount_price']) ? 'Rs. '.number_format((float) $variant['discount_price'], 2) : 'N/A' }}</span></div>
                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Weight</span><span class="mt-1 block font-medium">{{ $variant['weight'] ?? 'N/A' }}</span></div>
                        <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Default</span><span class="mt-1 block font-medium">{{ !empty($variant['is_default']) ? 'Yes' : 'No' }}</span></div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach (($variant['brewing_rituals'] ?? []) as $ritual)
                            <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 dark:bg-slate-900">
                                @if (!empty($ritual['image_url']))
                                    <img src="{{ $ritual['image_url'] }}" alt="{{ $ritual['ritual'] ?? 'Ritual' }}" class="h-12 w-12 rounded-xl object-cover">
                                @endif
                                <span class="text-sm font-medium">{{ $ritual['ritual'] ?? $ritual['text'] ?? 'Ritual' }}</span>
                            </div>
                        @endforeach
                    </div>
                </article>
            @empty
                <div>@include('admin.components.empty-state', ['title' => 'No variants available'])</div>
            @endforelse
        </div>
    </section>
</div>
@endsection
