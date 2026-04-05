<section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-5">
    <div>
        <h2 class="text-lg font-semibold">Variant images</h2>
        
    </div>

    @forelse (($product['variants'] ?? []) as $variant)
        <div class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/60">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-base font-semibold">{{ $variant['variant_name'] ?? 'Variant' }}</h3>
                    <p class="text-xs text-slate-500">SKU: {{ $variant['sku'] ?? 'N/A' }}</p>
                </div>
                <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ count($variant['images'] ?? []) }} images</span>
            </div>

            @if (! empty($variant['images']))
                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach (($variant['images'] ?? []) as $image)
                        <div class="space-y-3 rounded-[1.25rem] border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                            <img src="{{ $image['image_url'] }}" alt="Variant image" class="h-40 w-full rounded-[1rem] object-cover">
                            <form method="POST" action="{{ route('admin.products.variants.images.update', [$product['id'], $variant['id'], $image['id']]) }}" enctype="multipart/form-data" class="space-y-3" data-loading-form>
                                @csrf
                                @method('PUT')
                                <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                                <input type="number" min="0" name="sort_order" value="{{ $image['sort_order'] ?? 0 }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                                <label class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium dark:border-slate-700">
                                    <span>Primary image</span>
                                    <input type="checkbox" name="is_primary" value="1" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked($image['is_primary'] ?? false)>
                                </label>
                                <div class="flex items-center gap-3">
                                    <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-xs font-semibold dark:border-slate-700">Save</button>
                            </form>
                                    <form method="POST" action="{{ route('admin.products.variants.images.destroy', [$product['id'], $variant['id'], $image['id']]) }}" data-confirm="Delete this variant image?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button>
                                    </form>
                                </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div>@include('admin.components.empty-state', ['title' => 'No variant images yet', 'message' => 'Upload images from the main product form or add one below.'])</div>
            @endif

            <form method="POST" action="{{ route('admin.products.variants.images.store', [$product['id'], $variant['id']]) }}" enctype="multipart/form-data" class="space-y-3 border-t border-slate-200 pt-4 dark:border-slate-800" data-loading-form>
                @csrf
                <input type="file" name="image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900" required>
                <input type="number" min="0" name="sort_order" placeholder="Sort order" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                <label class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium dark:border-slate-700">
                    <span>Primary image</span>
                    <input type="checkbox" name="is_primary" value="1" class="h-5 w-5 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                </label>
                <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Add Variant Image</button>
            </form>
        </div>
    @empty
        <div>@include('admin.components.empty-state', ['title' => 'No variants saved yet', 'message' => 'Save product variants first, then add multiple images to each variant here.'])</div>
    @endforelse
</section>

