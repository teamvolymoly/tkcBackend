@extends('admin.layouts.app')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold tracking-tight">Newsletter Subscribers</h1>
        <p class="mt-1 text-sm text-slate-500">Manage email addresses collected from the website subscription form.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-lg border border-white/70 bg-white/85 p-5 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <p class="text-sm text-slate-500">Total subscribers</p>
            <p class="mt-2 text-3xl font-semibold">{{ number_format($totalSubscribers) }}</p>
        </div>
        <div class="rounded-lg border border-white/70 bg-white/85 p-5 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
            <p class="text-sm text-slate-500">Active subscribers</p>
            <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ number_format($activeSubscribers) }}</p>
        </div>
    </div>

    <form method="GET" class="rounded-lg border border-white/70 bg-white/85 p-4 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_220px_auto]">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search email address" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <select name="status" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All statuses</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="unsubscribed" @selected(request('status') === 'unsubscribed')>Unsubscribed</option>
            </select>
            <div class="flex gap-2">
                <button class="rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Filter</button>
                @if (request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.newsletter-subscribers.index') }}" class="rounded-lg border border-slate-200 px-5 py-3 text-sm font-semibold dark:border-slate-700">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 text-left text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-950/60">
                    <tr>
                        <th class="px-5 py-4">ID</th>
                        <th class="px-5 py-4">Email</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Subscribed at</th>
                        <th class="px-5 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($subscribers as $subscriber)
                        <tr>
                            <td class="px-5 py-4 text-slate-500">#{{ $subscriber->id }}</td>
                            <td class="px-5 py-4 font-medium">{{ $subscriber->email }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $subscriber->status === 'active' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                                    {{ ucfirst($subscriber->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-500">{{ $subscriber->subscribed_at?->format('d M Y, h:i A') ?? '—' }}</td>
                            <td class="px-5 py-4 text-right">
                                <form method="POST" action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" class="inline" data-confirm="Delete this subscriber permanently?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-rose-600 hover:text-rose-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No newsletter subscribers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $subscribers->links() }}</div>
    </div>
</div>
@endsection
