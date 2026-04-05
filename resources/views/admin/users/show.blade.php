@extends('admin.layouts.app')
@section('title', 'User Details')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">User Profile</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">{{ $user['name'] }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $user['email'] }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
            <a href="{{ route('admin.users.edit', $user['id']) }}" class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Edit User</a>
        </div>
    </div>
    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Account snapshot</h2>
            <dl class="mt-5 space-y-4 text-sm">
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Phone</dt><dd class="font-medium">{{ $user['phone'] ?? 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Roles</dt><dd class="font-medium">{{ collect($user['roles'] ?? [])->pluck('name')->implode(', ') ?: 'N/A' }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Addresses</dt><dd class="font-medium">{{ count($user['addresses'] ?? []) }}</dd></div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60"><dt class="text-slate-500">Recent orders</dt><dd class="font-medium">{{ count($user['orders'] ?? []) }}</dd></div>
            </dl>
        </section>
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <h2 class="text-lg font-semibold">Recent orders</h2>
            @if (empty($user['orders']))
                <div class="mt-5">@include('admin.components.empty-state', ['title' => 'No orders yet', 'message' => 'This user has not placed any recent orders.'])</div>
            @else
                <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-950/70"><tr><th class="px-4 py-3 text-left font-semibold text-slate-500">Order</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Total</th><th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th></tr></thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($user['orders'] as $order)
                                <tr>
                                    <td class="px-4 py-4 font-medium">{{ $order['order_number'] }}</td>
                                    <td class="px-4 py-4">Rs. {{ number_format((float) $order['total_amount'], 2) }}</td>
                                    <td class="px-4 py-4">@include('admin.components.status-badge', ['value' => $order['status']])</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
