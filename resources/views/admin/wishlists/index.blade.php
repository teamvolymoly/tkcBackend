@extends('admin.layouts.app')
@section('title', 'Wishlists')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Wishlists</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Customer intent board</h1>
    </div>
    <form method="GET" class="grid gap-4 rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 md:grid-cols-[1fr_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search customer or product" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>
    @if (empty($wishlists['data']))
        @include('admin.components.empty-state', ['title' => 'No wishlist activity'])
    @else
        <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Customer</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Product</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Created</th><th class="px-4 py-3"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($wishlists['data'] as $item)
                        <tr>
                            <td class="px-4 py-4 font-medium">{{ $item['user']['name'] ?? 'Unknown customer' }}</td>
                            <td class="px-4 py-4">{{ $item['product']['name'] ?? 'Product removed' }}</td>
                            <td class="px-4 py-4">{{ !empty($item['created_at']) ? \Illuminate\Support\Carbon::parse($item['created_at'])->diffForHumans() : 'N/A' }}</td>
                            <td class="px-4 py-4">
                                <form method="POST" action="{{ route('admin.wishlists.destroy', $item['id']) }}" class="flex justify-end" data-confirm="Remove this wishlist item?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-2xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 dark:border-rose-500/20 dark:text-rose-300">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagination', ['paginator' => $wishlists])
    @endif
</div>
@endsection

