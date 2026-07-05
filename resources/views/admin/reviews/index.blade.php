@extends('admin.layouts.app')
@section('title', 'Reviews')
@section('content')
@php
    $permissionNames = collect($adminUser['permissions'] ?? [])->pluck('name')->all();
    $isAdmin = collect($adminUser['roles'] ?? [])->pluck('name')->contains('admin');
    $canModerateReviews = $isAdmin || in_array('reviews.update', $permissionNames, true);
    $canDeleteReviews = $isAdmin || in_array('reviews.delete', $permissionNames, true);
@endphp
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Reviews</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Customer review moderation</h1>
    </div>

    <form method="GET" class="grid gap-4 rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 lg:grid-cols-[1fr_170px_170px_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search product, customer, or review text" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <select name="rating" class="rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <option value="">All ratings</option>
            @foreach ([5,4,3,2,1] as $rating)
                <option value="{{ $rating }}" @selected(($filters['rating'] ?? '') == $rating)>{{ $rating }} stars</option>
            @endforeach
        </select>
        <select name="status" class="rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <option value="">All statuses</option>
            @foreach (['pending', 'approved', 'rejected'] as $status)
                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>

    @if (empty($reviews['data']))
        @include('admin.components.empty-state', ['title' => 'No reviews'])
    @else
        <div class="space-y-4">
            @foreach ($reviews['data'] as $review)
                <section class="rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600 dark:text-sky-300">{{ $review['product']['name'] ?? 'Product removed' }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold">{{ $review['user']['name'] ?? 'Unknown customer' }}</h2>
                                @include('admin.components.status-badge', ['value' => $review['status'] ?? 'pending'])
                            </div>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                                {{ $review['user']['email'] ?? '' }} | Rating: {{ $review['rating'] }}/5
                                @if (!empty($review['order']['order_number']))
                                    | Order: {{ $review['order']['order_number'] }}
                                @endif
                            </p>
                            @if (!empty($review['title']))
                                <p class="mt-4 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $review['title'] }}</p>
                            @endif
                            <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $review['review'] ?: 'No text review provided.' }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.reviews.show', $review['id']) }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Inspect</a>
                            @if ($canModerateReviews && ($review['status'] ?? 'pending') !== 'approved')
                                <form method="POST" action="{{ route('admin.reviews.status', $review['id']) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="rounded-lg border border-emerald-200 px-4 py-2.5 text-sm font-semibold text-emerald-700 dark:border-emerald-500/20 dark:text-emerald-300">Approve</button>
                                </form>
                            @endif
                            @if ($canModerateReviews && ($review['status'] ?? 'pending') !== 'rejected')
                                <form method="POST" action="{{ route('admin.reviews.status', $review['id']) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="rounded-lg border border-amber-200 px-4 py-2.5 text-sm font-semibold text-amber-700 dark:border-amber-500/20 dark:text-amber-300">Reject</button>
                                </form>
                            @endif
                            @if ($canDeleteReviews)
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review['id']) }}" data-confirm="Delete this review permanently?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
        @include('admin.components.pagination', ['paginator' => $reviews])
    @endif
</div>
@endsection
