@extends('admin.layouts.app')
@section('title', 'Review Detail')
@section('content')
@php
    $permissionNames = collect($adminUser['permissions'] ?? [])->pluck('name')->all();
    $isAdmin = collect($adminUser['roles'] ?? [])->pluck('name')->contains('admin');
    $canModerateReviews = $isAdmin || in_array('reviews.update', $permissionNames, true);
    $canDeleteReviews = $isAdmin || in_array('reviews.delete', $permissionNames, true);
@endphp
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Review Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $review['product']['name'] ?? 'Product review' }}</h1>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <section class="rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Review snapshot</h2>
            <dl class="mt-5 space-y-3 text-sm">
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Customer</dt><dd class="font-medium">{{ $review['user']['name'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $review['user']['email'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Rating</dt><dd class="font-medium">{{ $review['rating'] }}/5</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Status</dt><dd>@include('admin.components.status-badge', ['value' => $review['status'] ?? 'pending'])</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Order</dt><dd class="font-medium">{{ $review['order']['order_number'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Item</dt><dd class="font-medium">{{ $review['order_item']['product_name'] ?? ($review['product']['name'] ?? 'N/A') }}</dd></div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Created</dt><dd class="font-medium">{{ !empty($review['created_at']) ? \Illuminate\Support\Carbon::parse($review['created_at'])->format('d M Y h:i A') : 'N/A' }}</dd></div>
            </dl>
            <div class="mt-6 flex flex-wrap gap-2">
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
                        <button type="submit" class="rounded-lg border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete Review</button>
                    </form>
                @endif
            </div>
        </section>
        <section class="rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Customer voice</h2>
            @if (!empty($review['title']))
                <p class="mt-5 text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $review['title'] }}</p>
            @endif
            <div class="mt-5 rounded-lg bg-slate-50 p-5 text-sm leading-7 text-slate-700 dark:bg-slate-950/60 dark:text-slate-200">{{ $review['review'] ?: 'No review text was submitted for this rating.' }}</div>
            @if (!empty($review['images']))
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach ($review['images'] as $image)
                        <img src="{{ $image['image_url'] ?? '' }}" alt="Review image" class="aspect-video rounded-lg border border-slate-200 object-cover dark:border-slate-700">
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
