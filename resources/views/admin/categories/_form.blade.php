@php($selectedParent = old('parent_id', $category['parent_id'] ?? ''))
<div class="space-y-6">
    <section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <div class="border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
            <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Category</p>
                    <h2 class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-100">Basic Information</h2>
                </div>
                <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">
                    <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('status', $category['status'] ?? true))>
                    <span>Active category</span>
                </label>
            </div>
        </div>

        <div class="p-6">
            <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Category name</label>
                        <input type="text" name="name" value="{{ old('name', $category['name'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-950 dark:focus:ring-sky-500/10" placeholder="Green Tea" required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Category type</label>
                        <select name="parent_id" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-950 dark:focus:ring-sky-500/10">
                            <option value="">Main category</option>
                            @foreach ($categories as $parent)
                                @if (($category['id'] ?? null) !== $parent['id'])
                                    <option value="{{ $parent['id'] }}" @selected((string) $selectedParent === (string) $parent['id'])>{{ $parent['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Preview</label>
                        <div class="flex h-[116px] items-center justify-center overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-950/60">
                            @if (!empty($category['image_url']))
                                <img src="{{ $category['image_url'] }}" alt="{{ $category['name'] ?? 'Category image' }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-sm text-slate-400">No image selected</span>
                            @endif
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Description</label>
                        <textarea name="description" rows="6" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-950 dark:focus:ring-sky-500/10" placeholder="Write a short note about this category...">{{ old('description', $category['description'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">Category Image</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">This image works for both main categories and subcategories.</p>
                    </div>

                    <div class="mt-5 space-y-4">
                        <label class="block">
                            <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Upload image</span>
                            <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:ring-4 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-950 dark:focus:ring-sky-500/10">
                        </label>

                        @if (!empty($category['image_url']))
                            <p class="text-xs text-slate-500 dark:text-slate-400">Uploading a new file will replace the current image.</p>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400">Recommended: square or wide image with a clean background.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
