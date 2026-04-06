@extends('admin.layouts.app')
@section('title', 'Blogs')
@section('content')
@php($totalPosts = count($posts['data'] ?? []))
@php($publishedPosts = collect($posts['data'] ?? [])->where('status', true)->count())
<div class="space-y-6">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">CMS</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Blog Manager</h1>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Create, schedule, and maintain blog content from the CMS dropdown.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950"><span class="text-slate-500 dark:text-slate-400">Loaded</span><span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalPosts }}</span></div>
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300"><span>Published</span><span class="ml-2 font-semibold">{{ $publishedPosts }}</span></div>
                <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add Blog</a>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.8fr_0.8fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Search title, excerpt, or content">
            <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All status</option>
                <option value="1" @selected(($filters['status'] ?? '') === '1')>Published</option>
                <option value="0" @selected(($filters['status'] ?? '') === '0')>Draft</option>
            </select>
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if (empty($posts['data']))
            @include('admin.components.empty-state', ['title' => 'No blog posts found', 'message' => 'Start with your first article from the CMS dropdown.'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Post</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Publish Time</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($posts['data'] as $post)
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $post['title'] }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($post['excerpt'] ?? 'No excerpt added yet.', 90) }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ !empty($post['published_at']) ? \Illuminate\Support\Carbon::parse($post['published_at'])->format('d M Y, h:i A') : 'Publish immediately' }}</td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($post['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($post['status']) ? 'Published' : 'Draft' }}</span></td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('admin.blogs.show', $post['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">View</a>
                                            <a href="{{ route('admin.blogs.edit', $post['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $post['id']) }}" data-confirm="Delete this blog post?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.components.pagination', ['paginator' => $posts])
        @endif
    </section>
</div>
@endsection
