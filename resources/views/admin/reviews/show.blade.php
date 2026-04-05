@extends('admin.layouts.app')
@section('title', 'Review Detail')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Review Detail</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $review['product']['name'] ?? 'Product review' }}</h1>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Review snapshot</h2>
            <dl class="mt-5 space-y-3 text-sm">
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Customer</dt><dd class="font-medium">{{ $review['user']['name'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Email</dt><dd class="font-medium">{{ $review['user']['email'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Rating</dt><dd class="font-medium">{{ $review['rating'] }}/5</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Created</dt><dd class="font-medium">{{ !empty($review['created_at']) ? \Illuminate\Support\Carbon::parse($review['created_at'])->format('d M Y h:i A') : 'N/A' }}</dd></div>
            </dl>
            <form method="POST" action="{{ route('admin.reviews.destroy', $review['id']) }}" class="mt-6" data-confirm="Delete this review permanently?">
                @csrf @method('DELETE')
                <button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Delete Review</button>
            </form>
        </section>
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Customer voice</h2>
            <div class="mt-5 rounded-[1.5rem] bg-slate-50 p-5 text-sm leading-7 text-slate-700 dark:bg-slate-950/60 dark:text-slate-200">{{ $review['review'] ?: 'No review text was submitted for this rating.' }}</div>
        </section>
    </div>
</div>
@endsection
