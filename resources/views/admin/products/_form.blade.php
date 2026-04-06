@php
    $selectedCategory = old('category_id', $product['category_id'] ?? '');
    $selectedSubcategory = old('subcategory_id', $product['subcategory_id'] ?? '');
    $variants = old('variants', collect($product['variants'] ?? [[
        'variant_name' => '',
        'size' => '',
        'color' => '',
        'sku' => '',
        'price' => '',
        'stock' => 0,
        'weight' => '',
        'dimensions' => '',
        'net_weight' => '',
        'tags_raw' => '',
        'brewing_rituals' => [['icon' => '', 'text' => '']],
        'images' => [['sort_order' => 0, 'is_primary' => 1]],
        'is_default' => 1,
        'status' => 1,
    ]])->map(function ($variant) {
        $variant['tags_raw'] = isset($variant['tags']) && is_array($variant['tags']) ? implode(', ', $variant['tags']) : ($variant['tags_raw'] ?? '');
        $variant['brewing_rituals'] = ! empty($variant['brewing_rituals']) ? $variant['brewing_rituals'] : [['icon' => '', 'text' => '']];
        $variant['images'] = collect($variant['images'] ?? [])->map(function ($image, $imageIndex) {
            return [
                'sort_order' => $image['sort_order'] ?? $imageIndex,
                'is_primary' => (int) ($image['is_primary'] ?? ($imageIndex === 0)),
            ];
        })->whenEmpty(fn ($collection) => $collection->push(['sort_order' => 0, 'is_primary' => 1]))->values()->all();

        return $variant;
    })->all());
    $features = old('features', ! empty($product['features']) ? $product['features'] : [['icon' => '', 'text' => '']]);
@endphp
<div x-data="productForm({{ \Illuminate\Support\Js::from($variants) }}, {{ \Illuminate\Support\Js::from($features) }}, {{ \Illuminate\Support\Js::from($categories) }})" class="space-y-6">
    <form method="POST" action="{{ $productFormAction }}" enctype="multipart/form-data" data-loading-form class="space-y-6">
        @csrf
        @if ($productFormMethod !== 'POST')
            @method($productFormMethod)
        @endif

        <section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
                <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Product</p>
                        <h2 class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-100">Basic Information</h2>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="categoryModalOpen = true" class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">Add Category</button>
                        <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">
                            <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('status', $product['status'] ?? true))>
                            <span>Active product</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4">
                    <div class="xl:col-span-2"><label class="mb-2 block text-sm font-medium">Product name</label><input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" required></div>
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <label class="block text-sm font-medium">Category</label>
                            <button type="button" @click="categoryModalOpen = true" class="text-xs font-semibold text-sky-700">Quick Add</button>
                        </div>
                        <select name="category_id" x-ref="categorySelect" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                            <option value="">Select category</option>
                            @foreach ($categories as $categoryOption)
                                <option value="{{ $categoryOption['id'] }}" @selected((string) $selectedCategory === (string) $categoryOption['id'])>{{ $categoryOption['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label class="mb-2 block text-sm font-medium">Subcategory</label><select name="subcategory_id" x-ref="subcategorySelect" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><option value="">Optional subcategory</option>@foreach ($categories as $categoryOption)@foreach ($categoryOption['children'] ?? [] as $child)<option value="{{ $child['id'] }}" @selected((string) $selectedSubcategory === (string) $child['id'])>{{ $categoryOption['name'] }} / {{ $child['name'] }}</option>@endforeach @endforeach</select></div>
                    <div><label class="mb-2 block text-sm font-medium">Tea type</label><input type="text" name="tea_type" value="{{ old('tea_type', $product['tea_type'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                    <div><label class="mb-2 block text-sm font-medium">Allergy note</label><input type="text" name="allergic_information" value="{{ old('allergic_information', $product['allergic_information'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                    <div class="lg:col-span-2 xl:grid xl:col-span-4"><label class="mb-2 block text-sm font-medium">Short description</label><textarea name="short_description" rows="3" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('short_description', $product['short_description'] ?? '') }}</textarea></div>
                    <div class="lg:col-span-2 xl:col-span-4"><label class="mb-2 block text-sm font-medium">Description</label><textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('description', $product['description'] ?? '') }}</textarea></div>
                    <div class="lg:col-span-2 xl:col-span-2"><label class="mb-2 block text-sm font-medium">Ingredients summary</label><textarea name="ingredients" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('ingredients', $product['ingredients'] ?? '') }}</textarea></div>
                    <div class="lg:col-span-2 xl:col-span-2"><label class="mb-2 block text-sm font-medium">Disclaimer</label><textarea name="disclaimer" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('disclaimer', $product['disclaimer'] ?? '') }}</textarea></div>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-center justify-between gap-4"><div><h2 class="text-lg font-semibold">Feature highlights</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Optional storefront callouts.</p></div><button type="button" @click="addFeature()" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add Feature</button></div>
            <div class="mt-6 space-y-4"><template x-for="(feature, featureIndex) in features" :key="feature.uid"><div class="grid gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 md:grid-cols-[180px_1fr_auto] dark:border-slate-800 dark:bg-slate-950/60"><input :name="`features[${featureIndex}][icon]`" x-model="feature.icon" placeholder="leaf, heart" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input :name="`features[${featureIndex}][text]`" x-model="feature.text" placeholder="Calming evening ritual" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><button type="button" @click="removeFeature(featureIndex)" class="rounded-2xl border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Remove</button></div></template></div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex flex-col gap-3 border-b border-slate-200 pb-5 sm:flex-row sm:items-center sm:justify-between dark:border-slate-800"><div><h2 class="text-lg font-semibold">Variants</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pricing, stock, images, and option details per variant.</p></div><button type="button" @click="addVariant()" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-200">Add Variant</button></div>
            <div class="mt-6 space-y-4">
                <template x-for="(variant, index) in variants" :key="variant.uid">
                    <div x-transition class="space-y-5 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                        <input type="hidden" :name="`variants[${index}][id]`" x-model="variant.id">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400" x-text="`Variant ${index + 1}`"></p>
                                <h3 class="mt-1 text-base font-semibold text-slate-900 dark:text-slate-100" x-text="variant.variant_name || 'Untitled Variant'"></h3>
                            </div>
                            <button type="button" @click="removeVariant(index)" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Remove</button>
                        </div>

                        <div class="grid gap-4 xl:grid-cols-12">
                            <div class="xl:col-span-3"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Variant name</label><input type="text" :name="`variants[${index}][variant_name]`" x-model="variant.variant_name" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" placeholder="Premium Pack"></div>
                            <div class="xl:col-span-2"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Size</label><input type="text" :name="`variants[${index}][size]`" x-model="variant.size" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div class="xl:col-span-2"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Color</label><input type="text" :name="`variants[${index}][color]`" x-model="variant.color" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div class="xl:col-span-2"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">SKU</label><input type="text" :name="`variants[${index}][sku]`" x-model="variant.sku" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div class="xl:col-span-1"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Price</label><input type="number" step="0.01" :name="`variants[${index}][price]`" x-model="variant.price" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div class="xl:col-span-1"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Stock</label><input type="number" :name="`variants[${index}][stock]`" x-model="variant.stock" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div class="xl:col-span-1"><label class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Weight</label><input type="number" step="0.01" min="0" :name="`variants[${index}][weight]`" x-model="variant.weight" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                            <label class="text-sm font-medium">Dimensions<input type="text" :name="`variants[${index}][dimensions]`" x-model="variant.dimensions" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></label>
                            <label class="text-sm font-medium">Net weight<input type="text" :name="`variants[${index}][net_weight]`" x-model="variant.net_weight" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></label>
                            <label class="text-sm font-medium">Tags<input type="text" :name="`variants[${index}][tags_raw]`" x-model="variant.tags_raw" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" placeholder="calming, premium"></label>
                        </div>

                        <div class="grid gap-4 xl:grid-cols-[1fr_320px]">
                            <div class="space-y-4 rounded-[1.25rem] border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div class="flex items-center justify-between"><div><h3 class="font-semibold">Brewing rituals</h3><p class="text-sm text-slate-500 dark:text-slate-400">Multiple icon/text rows per variant.</p></div><button type="button" @click="addRitual(index)" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Add Ritual</button></div>
                                <template x-for="(ritual, ritualIndex) in variant.brewing_rituals" :key="ritual.uid"><div class="grid gap-3 md:grid-cols-[180px_1fr_auto]"><input :name="`variants[${index}][brewing_rituals][${ritualIndex}][icon]`" x-model="ritual.icon" placeholder="cup" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><input :name="`variants[${index}][brewing_rituals][${ritualIndex}][text]`" x-model="ritual.text" placeholder="Steep for 4 minutes" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><button type="button" @click="removeRitual(index, ritualIndex)" class="rounded-2xl border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Remove</button></div></template>
                            </div>

                            <div class="space-y-4 rounded-[1.25rem] border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                                <div class="flex items-center justify-between"><div><h3 class="font-semibold">Images</h3><p class="text-sm text-slate-500 dark:text-slate-400">Upload multiple files for this variant.</p></div><button type="button" @click="addImage(index)" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Add Image</button></div>
                                <template x-for="(image, imageIndex) in variant.images" :key="image.uid"><div class="space-y-3 rounded-2xl border border-slate-200 p-3 dark:border-slate-700"><input type="file" accept="image/*" :name="`variants[${index}][images][${imageIndex}][file]`" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><div class="grid gap-3 sm:grid-cols-2"><label class="text-sm font-medium">Sort order<input type="number" min="0" :name="`variants[${index}][images][${imageIndex}][sort_order]`" x-model="image.sort_order" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></label><label class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium dark:border-slate-700"><span>Primary image</span><input type="checkbox" value="1" :name="`variants[${index}][images][${imageIndex}][is_primary]`" x-model="image.is_primary" @change="setPrimaryImage(index, imageIndex)" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label></div><button type="button" @click="removeImage(index, imageIndex)" class="rounded-2xl border border-rose-200 px-4 py-2 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Remove image row</button></div></template>
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span><span class="block text-sm font-medium">Default variant</span><span class="text-xs text-slate-500 dark:text-slate-400">Used as fallback on listings.</span></span><input type="checkbox" value="1" :name="`variants[${index}][is_default]`" x-model="variant.is_default" @change="setDefaultVariant(index)" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                            <label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span><span class="block text-sm font-medium">Active variant</span><span class="text-xs text-slate-500 dark:text-slate-400">Inactive variants stay hidden from purchase flow.</span></span><input type="checkbox" value="1" :name="`variants[${index}][status]`" x-model="variant.status" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <div class="flex justify-end"><button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">{{ $productFormSubmit }}</button></div>
    </form>

    @if ($product)
        <div class="grid gap-6 xl:grid-cols-2">
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-5"><div><h2 class="text-lg font-semibold">Ingredients</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Structured ingredient rows for the product detail page.</p></div>@forelse (($product['ingredients_list'] ?? $product['ingredientsList'] ?? []) as $ingredient)<div class="space-y-3 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60"><form method="POST" action="{{ route('admin.products.ingredients.update', [$product['id'], $ingredient['id']]) }}" class="space-y-3" data-loading-form>@csrf @method('PUT')<input type="text" name="name" value="{{ $ingredient['name'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="value" value="{{ $ingredient['value'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="number" min="0" name="sort_order" value="{{ $ingredient['sort_order'] ?? 0 }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><button type="submit" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-xs font-semibold dark:border-slate-700">Save</button></form><form method="POST" action="{{ route('admin.products.ingredients.destroy', [$product['id'], $ingredient['id']]) }}" data-confirm="Delete this ingredient row?">@csrf @method('DELETE')<button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button></form></div>@empty<div>@include('admin.components.empty-state', ['title' => 'No ingredient rows', 'message' => 'Add structured ingredients below.'])</div>@endforelse<form method="POST" action="{{ route('admin.products.ingredients.store', $product['id']) }}" class="space-y-3 border-t border-slate-200 pt-5 dark:border-slate-800" data-loading-form>@csrf<input type="text" name="name" placeholder="Ingredient name" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="value" placeholder="Value or note" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="number" min="0" name="sort_order" placeholder="Sort order" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Add Ingredient</button></form></section>
            <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-5"><div><h2 class="text-lg font-semibold">Nutrition</h2><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Nutrition rows stay separate and API-managed.</p></div>@forelse (($product['nutrition'] ?? []) as $nutrition)<div class="space-y-3 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60"><form method="POST" action="{{ route('admin.products.nutrition.update', [$product['id'], $nutrition['id']]) }}" class="space-y-3" data-loading-form>@csrf @method('PUT')<input type="text" name="nutrient" value="{{ $nutrition['nutrient'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="value" value="{{ $nutrition['value'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="unit" value="{{ $nutrition['unit'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><button type="submit" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-xs font-semibold dark:border-slate-700">Save</button></form><form method="POST" action="{{ route('admin.products.nutrition.destroy', [$product['id'], $nutrition['id']]) }}" data-confirm="Delete this nutrition row?">@csrf @method('DELETE')<button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button></form></div>@empty<div>@include('admin.components.empty-state', ['title' => 'No nutrition rows', 'message' => 'Add nutritional information below.'])</div>@endforelse<form method="POST" action="{{ route('admin.products.nutrition.store', $product['id']) }}" class="space-y-3 border-t border-slate-200 pt-5 dark:border-slate-800" data-loading-form>@csrf<input type="text" name="nutrient" placeholder="Nutrient" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="value" placeholder="Value" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><input type="text" name="unit" placeholder="Unit" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"><button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Add Nutrition</button></form></section>
        </div>
        @include('admin.products.variant-images')
    @else
        <section class="rounded-[2rem] border border-dashed border-slate-300 bg-slate-50/80 p-6 text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-300">Save the product once, then you can replace existing variant files from the dedicated variant media section.</section>
    @endif

    <div x-show="categoryModalOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50" @click="categoryModalOpen = false"></div>
    <div x-show="categoryModalOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900" @click.stop>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Products</p>
                    <h2 class="mt-2 text-2xl font-semibold">Add category</h2>
                </div>
                <button type="button" @click="categoryModalOpen = false" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600">Close</button>
            </div>
            <template x-if="categoryErrors.length">
                <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <template x-for="error in categoryErrors" :key="error"><p x-text="error"></p></template>
                </div>
            </template>
            <form method="POST" action="{{ route('admin.categories.quick-store') }}" enctype="multipart/form-data" class="mt-6 space-y-5" @submit.prevent="submitCategoryModal($event)">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium">Category name</label>
                        <input type="text" name="name" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Parent category</label>
                        <select name="parent_id" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                            <option value="">Main category</option>
                            @foreach ($categories as $categoryOption)
                                <option value="{{ $categoryOption['id'] }}">{{ $categoryOption['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium">Description</label>
                        <textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm"></textarea>
                    </div>
                </div>
                <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" checked>
                    <span>Active category</span>
                </label>
                <div class="flex justify-end">
                    <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white" :disabled="categorySaving" x-text="categorySaving ? 'Saving...' : 'Save Category'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
