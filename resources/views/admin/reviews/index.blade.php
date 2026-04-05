@extends('admin.layouts.app')
@section('title', 'Reviews')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Reviews</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Customer review moderation</h1>
    </div>

    <form method="GET" class="grid gap-4 rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 md:grid-cols-[1fr_180px_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search product, customer, or review text" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <select name="rating" class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <option value="">All ratings</option>
            @foreach ([5,4,3,2,1] as $rating)
                <option value="{{ $rating }}" @selected(($filters['rating'] ?? '') == $rating)>{{ $rating }} stars</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>

    @if (empty($reviews['data']))
        @include('admin.components.empty-state', ['title' => 'No reviews'])
    @else
        <div class="space-y-4">
            @foreach ($reviews['data'] as $review)
                <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-300">{{ $review['product']['name'] ?? 'Product removed' }}</p>
                            <h2 class="mt-2 text-xl font-semibold">{{ $review['user']['name'] ?? 'Unknown customer' }}</h2>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $review['user']['email'] ?? '' }} | Rating: {{ $review['rating'] }}/5</p>
                            <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $review['review'] ?: 'No text review provided.' }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.reviews.show', $review['id']) }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Inspect</a>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review['id']) }}" data-confirm="Delete this review permanently?">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button>
                            </form>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
        @include('admin.components.pagination', ['paginator' => $reviews])
    @endif
</div>
@endsection

