@php
    $sortOrder = old('sort_order', $heroSection['sort_order'] ?? 0);
@endphp
<section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
    <div class="border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Settings</p>
                <h2 class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-100">Hero Section Content</h2>
            </div>
            <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">
                <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('status', $heroSection['status'] ?? true))>
                <span>Active</span>
            </label>
        </div>
    </div>

    <div class="grid gap-6 p-6 xl:grid-cols-[1.5fr_0.95fr]">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium">Product name</label>
                <input type="text" name="product_name" value="{{ old('product_name', $heroSection['product_name'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium">Product slug</label>
                <input type="text" name="product_slug" value="{{ old('product_slug', $heroSection['product_slug'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" placeholder="leave blank for auto slug">
                <p class="mt-2 text-xs text-slate-500">Frontend is slug ko home hero CTA/product linking ke liye use karega.</p>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <h3 class="text-base font-semibold">Hero Media</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Product image</label>
                        <input type="file" name="product_image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    @if (!empty($heroSection['product_image_url']))
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <img src="{{ $heroSection['product_image_url'] }}" alt="{{ $heroSection['product_name'] ?? 'Hero image' }}" class="h-56 w-full object-cover">
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <h3 class="text-base font-semibold">Display Control</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Sort order</label>
                        <input type="number" min="0" name="sort_order" value="{{ $sortOrder }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
