@php
    $selectedCategory = old('category_id', $product['category_id'] ?? '');
    $selectedSubcategory = old('subcategory_id', $product['subcategory_id'] ?? '');
    $ingredients = old('ingredients', $product['ingredients'] ?? '');
    $faqs = old('faqs', $product['faqs'] ?? [['question' => '', 'answer' => '']]);
    $brewingRituals = old('brewing_rituals', $product['brewing_rituals'] ?? ($product['variants'][0]['brewing_rituals'] ?? []));
    $variants = old('variants', $product['variants'] ?? [[
        'name' => '',
        'sku' => '',
        'price' => '',
        'discount_price' => '',
        'weight' => '',
        'product_dimension' => '',
        'item_form' => '',
        'is_default' => 1,
        'status' => 1,
    ]]);
@endphp

<div x-data="productForm({{ \Illuminate\Support\Js::from($faqs) }}, {{ \Illuminate\Support\Js::from($brewingRituals) }}, {{ \Illuminate\Support\Js::from($variants) }})" class="space-y-6">
    <form method="POST" action="{{ $productFormAction }}" enctype="multipart/form-data" data-loading-form class="space-y-6">
        @csrf
        @if ($productFormMethod !== 'POST')
            @method($productFormMethod)
        @endif

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Product</p>
                    <h2 class="mt-1 text-xl font-semibold">Basic Information</h2>
                </div>
                <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium">
                    <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('status', $product['status'] ?? true))>
                    <span>Active product</span>
                </label>
            </div>

            <div class="mt-6 grid gap-5 lg:grid-cols-2">
                <div><label class="mb-2 block text-sm font-medium">Tag line 1</label><input type="text" name="tag_line_1" value="{{ old('tag_line_1', $product['tag_line_1'] ?? '') }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                <div><label class="mb-2 block text-sm font-medium">Product name</label><input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" required></div>
                <div><label class="mb-2 block text-sm font-medium">Tag line 2</label><input type="text" name="tag_line_2" value="{{ old('tag_line_2', $product['tag_line_2'] ?? '') }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                <div><label class="mb-2 block text-sm font-medium">Category</label><select name="category_id" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><option value="">Select category</option>@foreach ($categories as $categoryOption)<option value="{{ $categoryOption['id'] }}" @selected((string) $selectedCategory === (string) $categoryOption['id'])>{{ $categoryOption['name'] }}</option>@endforeach</select></div>
                <div><label class="mb-2 block text-sm font-medium">Subcategory</label><select name="subcategory_id" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><option value="">Optional subcategory</option>@foreach ($categories as $categoryOption)@foreach ($categoryOption['children'] ?? [] as $child)<option value="{{ $child['id'] }}" @selected((string) $selectedSubcategory === (string) $child['id'])>{{ $categoryOption['name'] }} / {{ $child['name'] }}</option>@endforeach @endforeach</select></div>
                <div class="lg:col-span-2"><label class="mb-2 block text-sm font-medium">Short Description</label><textarea name="short_description" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('short_description', $product['short_description'] ?? '') }}</textarea></div>
                <div class="lg:col-span-2"><label class="mb-2 block text-sm font-medium">Description</label><textarea name="description" rows="5" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('description', $product['description'] ?? '') }}</textarea></div>
                <div class="lg:col-span-2 rounded-lg border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Filter Section</h3>
                    <div class="mt-4 grid gap-5 lg:grid-cols-2">
                        <div>
                            <label class="mb-3 block text-sm font-medium">Caffeine</label>
                            @php($selectedCaffeine = old('caffeine', $product['caffeine'] ?? ''))
                            <div class="flex flex-wrap gap-3">
                                <label class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm dark:border-slate-700 dark:bg-slate-900">
                                    <input type="radio" name="caffeine" value="low" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500" @checked($selectedCaffeine === 'low')>
                                    <span>Low</span>
                                </label>
                                <label class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm dark:border-slate-700 dark:bg-slate-900">
                                    <input type="radio" name="caffeine" value="medium" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500" @checked($selectedCaffeine === 'medium')>
                                    <span>Medium</span>
                                </label>
                                <label class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm dark:border-slate-700 dark:bg-slate-900">
                                    <input type="radio" name="caffeine" value="caffeine_free" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500" @checked($selectedCaffeine === 'caffeine_free')>
                                    <span>Caffeine Free</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Collection</label>
                            <input type="text" name="collection" value="{{ old('collection', $product['collection'] ?? '') }}" placeholder="Summer Special, Limited Batch" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                            <p class="mt-2 text-xs text-slate-500">Comma separated values likhiye.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">Product Images</h2>
                    <p class="mt-1 text-sm text-slate-500">Exactly five slots linked directly to the product table.</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach (range(1, 5) as $index)
                    @php($imagePath = $product['image_'.$index] ?? null)
                    <div class="space-y-3 rounded-lg border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                        <label class="block text-sm font-medium">Image {{ $index }}</label>
                        @if ($imagePath)
                            <img src="{{ preg_match('/^https?:\/\//', $imagePath) ? $imagePath : route('media.public', ['path' => ltrim($imagePath, '/')]) }}" alt="Product image {{ $index }}" class="h-32 w-full rounded-lg object-cover">
                        @endif
                        <input type="file" name="image_{{ $index }}" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <h2 class="text-lg font-semibold">Ingredients</h2>
            <div class="mt-6">
                <label class="mb-2 block text-sm font-medium">Ingredients</label>
                <textarea name="ingredients" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter ingredients">{{ $ingredients }}</textarea>
            </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">FAQs</h2>
                    <p class="mt-1 text-sm text-slate-500">Question and answer pairs.</p>
                </div>
                <button type="button" @click="addFaq()" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add FAQ</button>
            </div>
            <div class="mt-6 space-y-4">
                <template x-for="(faq, index) in faqs" :key="faq.uid">
                    <div class="grid gap-4 rounded-lg border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                        <input type="text" :name="`faqs[${index}][question]`" x-model="faq.question" placeholder="Question" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                        <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="3" placeholder="Answer" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></textarea>
                        <button type="button" @click="removeFaq(index)" class="justify-self-start rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600">Remove</button>
                    </div>
                </template>
            </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
                        <div class="rounded-[1.25rem] border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                            <div>
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h4 class="font-semibold">Brewing Rituals</h4>
                                        <p class="mt-1 text-sm text-slate-500">Add multiple hot brew / iced brew label and value pairs.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                <div class="rounded-lg border border-slate-200 p-4 dark:border-slate-700">
                                    <div class="mb-4 flex items-center justify-between gap-3">
                                        <h5 class="text-sm font-semibold">Hot Brew</h5>
                                        <button type="button" @click="addBrewingRitual('hot_brew')" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">+ Add Hot Brew</button>
                                    </div>
                                    <div class="space-y-4">
                                        <template x-for="(ritual, ritualIndex) in brewing_rituals.hot_brew" :key="ritual.uid">
                                            <div class="rounded-lg border border-slate-100 bg-slate-50/60 p-3 dark:border-slate-800 dark:bg-slate-950/60">
                                                <div class="mb-2 flex items-center justify-between gap-3">
                                                    <label class="block text-sm font-medium" x-text="`Hot Brew ${ritualIndex + 1}`"></label>
                                                    <button type="button" @click="removeBrewingRitual('hot_brew', ritualIndex)" class="text-xs font-semibold text-rose-600" x-show="brewing_rituals.hot_brew.length > 1">Remove</button>
                                                </div>
                                                <div class="grid gap-3 sm:grid-cols-2">
                                                    <div><label class="mb-2 block text-sm font-medium">Label</label><input type="text" :name="`brewing_rituals[hot_brew][${ritualIndex}][label]`" x-model="ritual.label" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter label"></div>
                                                    <div><label class="mb-2 block text-sm font-medium">Value</label><input type="text" :name="`brewing_rituals[hot_brew][${ritualIndex}][value]`" x-model="ritual.value" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter value"></div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="rounded-lg border border-slate-200 p-4 dark:border-slate-700">
                                    <div class="mb-4 flex items-center justify-between gap-3">
                                        <h5 class="text-sm font-semibold">Iced Brew</h5>
                                        <button type="button" @click="addBrewingRitual('iced_brew')" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">+ Add Iced Brew</button>
                                    </div>
                                    <div class="space-y-4">
                                        <template x-for="(ritual, ritualIndex) in brewing_rituals.iced_brew" :key="ritual.uid">
                                            <div class="rounded-lg border border-slate-100 bg-slate-50/60 p-3 dark:border-slate-800 dark:bg-slate-950/60">
                                                <div class="mb-2 flex items-center justify-between gap-3">
                                                    <label class="block text-sm font-medium" x-text="`Iced Brew ${ritualIndex + 1}`"></label>
                                                    <button type="button" @click="removeBrewingRitual('iced_brew', ritualIndex)" class="text-xs font-semibold text-rose-600" x-show="brewing_rituals.iced_brew.length > 1">Remove</button>
                                                </div>
                                                <div class="grid gap-3 sm:grid-cols-2">
                                                    <div><label class="mb-2 block text-sm font-medium">Label</label><input type="text" :name="`brewing_rituals[iced_brew][${ritualIndex}][label]`" x-model="ritual.label" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter label"></div>
                                                    <div><label class="mb-2 block text-sm font-medium">Value</label><input type="text" :name="`brewing_rituals[iced_brew][${ritualIndex}][value]`" x-model="ritual.value" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter value"></div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 block text-sm font-medium">Note</label>
                                <textarea name="brewing_rituals[note]" x-model="brewing_rituals.note" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Enter brewing rituals note"></textarea>
                            </div>
                        </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">Product Variants</h2>
                    <p class="mt-1 text-sm text-slate-500">Only `product_variants` table fields are edited here.</p>
                </div>
                <button type="button" @click="addVariant()" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add Variant</button>
            </div>
            <div class="mt-6 space-y-5">
                <template x-for="(variant, index) in variants" :key="variant.uid">
                    <div class="space-y-5 rounded-lg border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                        <input type="hidden" :name="`variants[${index}][id]`" x-model="variant.id">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h3 class="text-base font-semibold" x-text="variant.name || `Variant ${index + 1}`"></h3>
                            <button type="button" @click="removeVariant(index)" class="rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600">Remove</button>
                        </div>
                        <div class="grid gap-4 lg:grid-cols-4">
                            <div><label class="mb-2 block text-sm font-medium">Name</label><input type="text" :name="`variants[${index}][name]`" x-model="variant.name" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">SKU</label><input type="text" :name="`variants[${index}][sku]`" x-model="variant.sku" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">Price</label><input type="number" step="0.01" :name="`variants[${index}][price]`" x-model="variant.price" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">Discount price</label><input type="number" step="0.01" :name="`variants[${index}][discount_price]`" x-model="variant.discount_price" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div><label class="mb-2 block text-sm font-medium">Weight</label><input type="text" :name="`variants[${index}][weight]`" x-model="variant.weight" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div><label class="mb-2 block text-sm font-medium">Product Dimension</label><input type="text" :name="`variants[${index}][product_dimension]`" x-model="variant.product_dimension" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div><label class="mb-2 block text-sm font-medium">Item Form</label><input type="text" :name="`variants[${index}][item_form]`" x-model="variant.item_form" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <label class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span class="text-sm font-medium">Default variant</span><input type="checkbox" value="1" :name="`variants[${index}][is_default]`" x-model="variant.is_default" @change="setDefaultVariant(index)" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                            <label class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span class="text-sm font-medium">Active variant</span><input type="checkbox" value="1" :name="`variants[${index}][status]`" x-model="variant.status" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                        </div>


                    </div>
                </template>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">{{ $productFormSubmit }}</button>
        </div>
    </form>
</div>
