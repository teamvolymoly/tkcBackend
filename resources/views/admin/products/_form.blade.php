@php
    $selectedCategory = old('category_id', $product['category_id'] ?? '');
    $selectedSubcategory = old('subcategory_id', $product['subcategory_id'] ?? '');
    $ingredients = old('ingredients', $product['ingredients'] ?? [['name' => '', 'image' => null]]);
    $faqs = old('faqs', $product['faqs'] ?? [['question' => '', 'answer' => '']]);
    $variants = old('variants', $product['variants'] ?? [[
        'name' => '',
        'sku' => '',
        'price' => '',
        'discount_price' => '',
        'weight' => '',
        'brewing_rituals' => [['ritual' => '', 'image' => null]],
        'is_default' => 1,
        'status' => 1,
    ]]);
@endphp

<div x-data="productForm({{ \Illuminate\Support\Js::from($ingredients) }}, {{ \Illuminate\Support\Js::from($faqs) }}, {{ \Illuminate\Support\Js::from($variants) }})" class="space-y-6">
    <form method="POST" action="{{ $productFormAction }}" enctype="multipart/form-data" data-loading-form class="space-y-6">
        @csrf
        @if ($productFormMethod !== 'POST')
            @method($productFormMethod)
        @endif

        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
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
                <div><label class="mb-2 block text-sm font-medium">Tag line 1</label><input type="text" name="tag_line_1" value="{{ old('tag_line_1', $product['tag_line_1'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                <div><label class="mb-2 block text-sm font-medium">Product name</label><input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950" required></div>
                <div><label class="mb-2 block text-sm font-medium">Tag line 2</label><input type="text" name="tag_line_2" value="{{ old('tag_line_2', $product['tag_line_2'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"></div>
                <div><label class="mb-2 block text-sm font-medium">Category</label><select name="category_id" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><option value="">Select category</option>@foreach ($categories as $categoryOption)<option value="{{ $categoryOption['id'] }}" @selected((string) $selectedCategory === (string) $categoryOption['id'])>{{ $categoryOption['name'] }}</option>@endforeach</select></div>
                <div><label class="mb-2 block text-sm font-medium">Subcategory</label><select name="subcategory_id" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950"><option value="">Optional subcategory</option>@foreach ($categories as $categoryOption)@foreach ($categoryOption['children'] ?? [] as $child)<option value="{{ $child['id'] }}" @selected((string) $selectedSubcategory === (string) $child['id'])>{{ $categoryOption['name'] }} / {{ $child['name'] }}</option>@endforeach @endforeach</select></div>
                <div class="lg:col-span-2"><label class="mb-2 block text-sm font-medium">Description</label><textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">{{ old('description', $product['description'] ?? '') }}</textarea></div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">Product Images</h2>
                    <p class="mt-1 text-sm text-slate-500">Exactly five slots linked directly to the product table.</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach (range(1, 5) as $index)
                    @php($imagePath = $product['image_'.$index] ?? null)
                    <div class="space-y-3 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                        <label class="block text-sm font-medium">Image {{ $index }}</label>
                        @if ($imagePath)
                            <img src="{{ preg_match('/^https?:\/\//', $imagePath) ? $imagePath : route('media.public', ['path' => ltrim($imagePath, '/')]) }}" alt="Product image {{ $index }}" class="h-32 w-full rounded-2xl object-cover">
                        @endif
                        <input type="file" name="image_{{ $index }}" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">Ingredients</h2>
                    <p class="mt-1 text-sm text-slate-500">Only image + name is stored.</p>
                </div>
                <button type="button" @click="addIngredient()" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add Ingredient</button>
            </div>
            <div class="mt-6 space-y-4">
                <template x-for="(ingredient, index) in ingredients" :key="ingredient.uid">
                    <div class="grid gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 md:grid-cols-[1fr_1fr_auto] dark:border-slate-800 dark:bg-slate-950/60">
                        <div>
                            <label class="mb-2 block text-sm font-medium">Name</label>
                            <input type="text" :name="`ingredients[${index}][name]`" x-model="ingredient.name" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                            <input type="hidden" :name="`ingredients[${index}][existing_image]`" x-model="ingredient.existing_image">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium">Image</label>
                            <template x-if="ingredient.preview"><img :src="ingredient.preview" class="mb-3 h-24 w-24 rounded-2xl object-cover"></template>
                            <input type="file" :name="`ingredients[${index}][image]`" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div class="flex items-end">
                            <button type="button" @click="removeIngredient(index)" class="rounded-2xl border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600">Remove</button>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">FAQs</h2>
                    <p class="mt-1 text-sm text-slate-500">Question and answer pairs.</p>
                </div>
                <button type="button" @click="addFaq()" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add FAQ</button>
            </div>
            <div class="mt-6 space-y-4">
                <template x-for="(faq, index) in faqs" :key="faq.uid">
                    <div class="grid gap-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
                        <input type="text" :name="`faqs[${index}][question]`" x-model="faq.question" placeholder="Question" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                        <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="3" placeholder="Answer" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></textarea>
                        <button type="button" @click="removeFaq(index)" class="justify-self-start rounded-2xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600">Remove</button>
                    </div>
                </template>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold">Product Variants</h2>
                    <p class="mt-1 text-sm text-slate-500">Only `product_variants` table fields are edited here.</p>
                </div>
                <button type="button" @click="addVariant()" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Add Variant</button>
            </div>
            <div class="mt-6 space-y-5">
                <template x-for="(variant, index) in variants" :key="variant.uid">
                    <div class="space-y-5 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                        <input type="hidden" :name="`variants[${index}][id]`" x-model="variant.id">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <h3 class="text-base font-semibold" x-text="variant.name || `Variant ${index + 1}`"></h3>
                            <button type="button" @click="removeVariant(index)" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600">Remove</button>
                        </div>
                        <div class="grid gap-4 lg:grid-cols-4">
                            <div><label class="mb-2 block text-sm font-medium">Name</label><input type="text" :name="`variants[${index}][name]`" x-model="variant.name" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">SKU</label><input type="text" :name="`variants[${index}][sku]`" x-model="variant.sku" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">Price</label><input type="number" step="0.01" :name="`variants[${index}][price]`" x-model="variant.price" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required></div>
                            <div><label class="mb-2 block text-sm font-medium">Discount price</label><input type="number" step="0.01" :name="`variants[${index}][discount_price]`" x-model="variant.discount_price" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <div><label class="mb-2 block text-sm font-medium">Weight</label><input type="text" :name="`variants[${index}][weight]`" x-model="variant.weight" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
                            <label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span class="text-sm font-medium">Default variant</span><input type="checkbox" value="1" :name="`variants[${index}][is_default]`" x-model="variant.is_default" @change="setDefaultVariant(index)" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                            <label class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 dark:border-slate-800 dark:bg-slate-900"><span class="text-sm font-medium">Active variant</span><input type="checkbox" value="1" :name="`variants[${index}][status]`" x-model="variant.status" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500"></label>
                        </div>

                        <div class="rounded-[1.25rem] border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <h4 class="font-semibold">Brewing Rituals</h4>
                                    <p class="mt-1 text-sm text-slate-500">Ritual text with optional image.</p>
                                </div>
                                <button type="button" @click="addRitual(index)" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Add Ritual</button>
                            </div>
                            <div class="mt-4 space-y-4">
                                <template x-for="(ritual, ritualIndex) in variant.brewing_rituals" :key="ritual.uid">
                                    <div class="grid gap-4 rounded-2xl border border-slate-200 p-4 md:grid-cols-[1fr_1fr_auto] dark:border-slate-700">
                                        <div>
                                            <label class="mb-2 block text-sm font-medium">Ritual</label>
                                            <input type="text" :name="`variants[${index}][brewing_rituals][${ritualIndex}][ritual]`" x-model="ritual.ritual" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                                            <input type="hidden" :name="`variants[${index}][brewing_rituals][${ritualIndex}][existing_image]`" x-model="ritual.existing_image">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-sm font-medium">Image</label>
                                            <template x-if="ritual.preview"><img :src="ritual.preview" class="mb-3 h-24 w-24 rounded-2xl object-cover"></template>
                                            <input type="file" :name="`variants[${index}][brewing_rituals][${ritualIndex}][image]`" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" @click="removeRitual(index, ritualIndex)" class="rounded-2xl border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600">Remove</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <div class="flex justify-end">
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">{{ $productFormSubmit }}</button>
        </div>
    </form>
</div>
