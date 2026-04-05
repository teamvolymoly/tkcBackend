@extends('admin.layouts.app')
@section('title', 'Product Details')
@section('content')
@php
    $variants = $product['variants'] ?? [];
    $defaultVariant = collect($variants)->firstWhere('is_default', true)
        ?? ($product['default_variant'] ?? null)
        ?? ($variants[0] ?? null);
    $images = $defaultVariant['images'] ?? [];
    $features = $product['features'] ?? [];
    $ingredientsList = $product['ingredients_list'] ?? ($product['ingredientsList'] ?? []);
    $nutritionRows = $product['nutrition'] ?? [];
    $heroImage = $defaultVariant['primary_image']['image_url'] ?? ($images[0]['image_url'] ?? null);
@endphp
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Catalog Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $product['name'] ?? 'Product' }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Slug: {{ $product['slug'] ?? 'N/A' }}</p>
            @if (!empty($product['short_description']))
                <p class="mt-3 max-w-3xl text-sm text-slate-600 dark:text-slate-300">{{ $product['short_description'] }}</p>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
            <a href="{{ route('admin.products.edit', $product['id']) }}" class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Edit Product</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                    <div class="min-h-[280px] bg-slate-100 dark:bg-slate-950/70">
                        @if ($heroImage)
                            <img src="{{ $heroImage }}" alt="{{ $product['name'] ?? 'Product image' }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full min-h-[280px] items-center justify-center text-sm text-slate-500 dark:text-slate-400">No product image available</div>
                        @endif
                    </div>
                    <div class="space-y-5 p-6">
                        <div>
                            <h2 class="text-lg font-semibold">Overview</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Dynamic admin view for the selected catalog item.</p>
                        </div>
                        <div class="grid gap-3 text-sm">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Category</span><span class="font-medium">{{ $product['category']['name'] ?? 'Uncategorized' }}</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Subcategory</span><span class="font-medium">{{ $product['subcategory']['name'] ?? 'None' }}</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Tea type</span><span class="font-medium">{{ $product['tea_type'] ?? 'N/A' }}</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="text-slate-500">Variants</span><span class="font-medium">{{ count($variants) }}</span></div>
                            <div class="flex items-center justify-between rounded-2xl px-4 py-3 {{ !empty($product['status']) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}"><span>Status</span><span class="font-semibold">{{ !empty($product['status']) ? 'Active' : 'Inactive' }}</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Description</h2>
                @if (!empty($product['description']))
                    <div class="mt-4 prose prose-slate max-w-none text-sm dark:prose-invert">{{ $product['description'] }}</div>
                @else
                    <div class="mt-4">@include('admin.components.empty-state', ['title' => 'No description', 'message' => 'Add a detailed description from the edit screen to improve this product profile.'])</div>
                @endif
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold">Variants</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Live packaging, price, stock, and brewing detail.</p>
                    </div>
                </div>
                @if (count($variants))
                    <div class="mt-5 grid gap-4 lg:grid-cols-2">
                        @foreach ($variants as $variant)
                            <article class="rounded-[1.5rem] border border-slate-200 bg-slate-50/80 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-base font-semibold">{{ $variant['variant_name'] ?? 'Default Variant' }}</h3>
                                        <p class="mt-1 text-xs text-slate-500">SKU: {{ $variant['sku'] ?? 'N/A' }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ !empty($variant['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">{{ !empty($variant['status']) ? 'Active' : 'Inactive' }}</span>
                                </div>
                                <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                                    <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Price</span><span class="mt-1 block font-medium">Rs. {{ number_format((float) ($variant['price'] ?? 0), 2) }}</span></div>
                                    <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Stock</span><span class="mt-1 block font-medium">{{ $variant['inventory']['stock'] ?? ($variant['stock'] ?? 0) }}</span></div>
                                    <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Size</span><span class="mt-1 block font-medium">{{ $variant['size'] ?? 'N/A' }}</span></div>
                                    <div class="rounded-2xl bg-white px-4 py-3 dark:bg-slate-900"><span class="block text-xs uppercase tracking-[0.2em] text-slate-400">Weight</span><span class="mt-1 block font-medium">{{ $variant['weight'] ?? ($variant['net_weight'] ?? 'N/A') }}</span></div>
                                </div>
                                @if (!empty($variant['tags']))
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($variant['tags'] as $tag)
                                            <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if (!empty($variant['brewing_rituals']))
                                    <div class="mt-4 space-y-2">
                                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Brewing Rituals</p>
                                        @foreach ($variant['brewing_rituals'] as $ritual)
                                            <div class="rounded-2xl bg-white px-4 py-3 text-sm dark:bg-slate-900">{{ $ritual['icon'] ?? '*' }} {{ $ritual['text'] ?? '' }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No variants available'])</div>
                @endif
            </section>
        </div>

        <div class="space-y-6">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Gallery</h2>
                @if (count($images))
                    <div class="mt-5 grid grid-cols-2 gap-3">
                        @foreach ($images as $image)
                            <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950/60">
                                <img src="{{ $image['image_url'] }}" alt="Product image" class="h-32 w-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No gallery images', 'message' => 'Upload storefront images from the edit page to populate the gallery.'])</div>
                @endif
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Product Notes</h2>
                <div class="mt-5 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Allergy info</span><span class="mt-1 block">{{ $product['allergic_information'] ?? 'No allergy note added.' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Ingredients summary</span><span class="mt-1 block">{{ $product['ingredients'] ?? 'No freeform ingredients summary available.' }}</span></div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><span class="block text-xs uppercase tracking-[0.22em] text-slate-400">Disclaimer</span><span class="mt-1 block">{{ $product['disclaimer'] ?? 'No disclaimer added.' }}</span></div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Feature Highlights</h2>
                @if (count($features))
                    <div class="mt-5 space-y-3">
                        @foreach ($features as $feature)
                            <div class="rounded-[1.5rem] bg-slate-50 px-4 py-3 text-sm dark:bg-slate-950/60">
                                <span class="font-semibold text-sky-600 dark:text-sky-300">{{ $feature['icon'] ?? '*' }}</span>
                                <span class="ml-2">{{ $feature['text'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No highlights added'])</div>
                @endif
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Structured Ingredients</h2>
                @if (count($ingredientsList))
                    <div class="mt-5 space-y-3">
                        @foreach ($ingredientsList as $ingredient)
                            <div class="flex items-center justify-between rounded-[1.5rem] bg-slate-50 px-4 py-3 text-sm dark:bg-slate-950/60">
                                <span class="font-medium">{{ $ingredient['name'] ?? 'Ingredient' }}</span>
                                <span class="text-slate-500 dark:text-slate-400">{{ $ingredient['value'] ?? 'N/A' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No ingredient rows', 'message' => 'Structured ingredient data will show here once added from the edit page.'])</div>
                @endif
            </section>

            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                <h2 class="text-lg font-semibold">Nutrition Facts</h2>
                @if (count($nutritionRows))
                    <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                            <thead class="bg-slate-50/80 dark:bg-slate-950/70">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Nutrient</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-500">Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                                @foreach ($nutritionRows as $row)
                                    <tr>
                                        <td class="px-4 py-4 font-medium">{{ $row['nutrient'] ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ trim(($row['value'] ?? '').' '.($row['unit'] ?? '')) ?: 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No nutrition rows'])</div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection



