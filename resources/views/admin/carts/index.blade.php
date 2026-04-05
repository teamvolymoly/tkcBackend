@extends('admin.layouts.app')
@section('title', 'Carts')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Carts</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Live cart visibility</h1>
    </div>
    <form method="GET" class="grid gap-4 rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 md:grid-cols-[1fr_auto] dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search customer" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
        <button type="submit" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold dark:border-slate-700">Filter</button>
    </form>
    @if (empty($carts['data']))
        @include('admin.components.empty-state', ['title' => 'No carts'])
    @else
        <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white/80 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Customer</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Items</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Updated</th><th class="px-4 py-3"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @foreach ($carts['data'] as $cart)
                        <tr>
                            <td class="px-4 py-4 font-medium">{{ $cart['user']['name'] ?? 'Unknown customer' }}</td>
                            <td class="px-4 py-4">{{ count($cart['items'] ?? []) }}</td>
                            <td class="px-4 py-4">{{ !empty($cart['updated_at']) ? \Illuminate\Support\Carbon::parse($cart['updated_at'])->diffForHumans() : 'N/A' }}</td>
                            <td class="px-4 py-4 text-right"><a href="{{ route('admin.carts.show', $cart['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold dark:border-slate-700">Inspect</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('admin.components.pagination', ['paginator' => $carts])
    @endif
</div>
@endsection

