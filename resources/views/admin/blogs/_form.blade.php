@php($publishedAt = old('published_at', isset($post['published_at']) && $post['published_at'] ? \Illuminate\Support\Carbon::parse($post['published_at'])->format('Y-m-d\\TH:i') : ''))
<section class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
    <div class="border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">CMS</p>
                <h2 class="mt-1 text-xl font-semibold text-slate-900 dark:text-slate-100">Blog Content</h2>
            </div>
            <label class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-950/60 dark:text-slate-200">
                <input type="checkbox" name="status" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked(old('status', $post['status'] ?? true))>
                <span>Published</span>
            </label>
        </div>
    </div>

    <div class="grid gap-6 p-6 xl:grid-cols-[1.6fr_0.9fr]">
        <div class="space-y-5">
            <div>
                <label class="mb-2 block text-sm font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title', $post['title'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium">Excerpt</label>
                <textarea name="excerpt" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" placeholder="Short intro for cards and previews">{{ old('excerpt', $post['excerpt'] ?? '') }}</textarea>
            </div>
            <div>
                <label class="mb-2 block text-sm font-medium">Content</label>
                <textarea name="content" rows="16" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" placeholder="Write the full blog content here..." required>{{ old('content', $post['content'] ?? '') }}</textarea>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <h3 class="text-base font-semibold">Publishing</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Publish at</label>
                        <input type="datetime-local" name="published_at" value="{{ $publishedAt }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Featured image</label>
                        <input type="file" name="featured_image" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    @if (!empty($post['featured_image_url']))
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                            <img src="{{ $post['featured_image_url'] }}" alt="{{ $post['title'] ?? 'Blog image' }}" class="h-48 w-full object-cover">
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/60">
                <h3 class="text-base font-semibold">SEO</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Meta title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post['meta_title'] ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Meta description</label>
                        <textarea name="meta_description" rows="5" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">{{ old('meta_description', $post['meta_description'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
