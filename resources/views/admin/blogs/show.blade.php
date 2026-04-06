@extends('admin.layouts.app')
@section('title', 'View Blog')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">CMS</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $post['title'] }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blogs.edit', $post['id']) }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
            <a href="{{ route('admin.blogs.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
        </div>
    </div>

    <section class="rounded-[2rem] border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none space-y-5">
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($post['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($post['status']) ? 'Published' : 'Draft' }}</span>
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ !empty($post['published_at']) ? \Illuminate\Support\Carbon::parse($post['published_at'])->format('d M Y, h:i A') : 'Publish immediately' }}</span>
        </div>

        @if (!empty($post['featured_image_url']))
            <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white dark:border-slate-800">
                <img src="{{ $post['featured_image_url'] }}" alt="{{ $post['title'] }}" class="max-h-[360px] w-full object-cover">
            </div>
        @endif

        @if (!empty($post['excerpt']))
            <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50/70 p-5 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-950/60 dark:text-slate-300">{{ $post['excerpt'] }}</div>
        @endif

        <article class="prose max-w-none prose-slate dark:prose-invert">
            {!! nl2br(e($post['content'] ?? '')) !!}
        </article>
    </section>
</div>
@endsection
