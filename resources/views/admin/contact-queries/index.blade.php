@extends('admin.layouts.app')

@section('title', 'Contact Queries')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold tracking-tight">Contact Queries</h1>
    </div>

    <form method="GET" class="rounded-lg border border-white/70 bg-white/85 p-4 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <div class="flex gap-3">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search company, name, email, phone or comment" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-950">
            <button class="rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Search</button>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-white/70 bg-white/85 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 text-left text-xs uppercase tracking-wider text-slate-500 dark:bg-slate-950/60">
                    <tr><th class="px-5 py-4">Company</th><th class="px-5 py-4">Name</th><th class="px-5 py-4">Email</th><th class="px-5 py-4">Phone</th><th class="px-5 py-4">Received</th><th class="px-5 py-4"></th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($queries as $query)
                        <tr>
                            <td class="px-5 py-4">{{ $query->company_name ?: '—' }}</td>
                            <td class="px-5 py-4 font-medium">{{ $query->name }}</td>
                            <td class="px-5 py-4">{{ $query->email }}</td>
                            <td class="px-5 py-4">{{ $query->phone_number }}</td>
                            <td class="px-5 py-4 text-slate-500">{{ $query->created_at?->format('d M Y, h:i A') }}</td>
                            <td class="px-5 py-4 text-right"><a href="{{ route('admin.contact-queries.show', $query) }}" class="font-semibold text-sky-600">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">No contact queries found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $queries->links() }}</div>
    </div>
</div>
@endsection
