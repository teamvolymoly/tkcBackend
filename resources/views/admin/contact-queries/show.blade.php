@extends('admin.layouts.app')

@section('title', 'Contact Query')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-4">
        <div><p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Contact query</p><h1 class="mt-1 text-2xl font-semibold">{{ $contactQuery->name }}</h1></div>
        <a href="{{ route('admin.contact-queries.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>

    <section class="rounded-lg border border-white/70 bg-white/85 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80">
        <dl class="grid gap-5 md:grid-cols-2">
            <div><dt class="text-xs uppercase tracking-wider text-slate-400">Company name</dt><dd class="mt-2 font-medium">{{ $contactQuery->company_name ?: '—' }}</dd></div>
            <div><dt class="text-xs uppercase tracking-wider text-slate-400">Name</dt><dd class="mt-2 font-medium">{{ $contactQuery->name }}</dd></div>
            <div><dt class="text-xs uppercase tracking-wider text-slate-400">Email</dt><dd class="mt-2"><a class="text-sky-600" href="mailto:{{ $contactQuery->email }}">{{ $contactQuery->email }}</a></dd></div>
            <div><dt class="text-xs uppercase tracking-wider text-slate-400">Phone number</dt><dd class="mt-2"><a class="text-sky-600" href="tel:{{ $contactQuery->phone_number }}">{{ $contactQuery->phone_number }}</a></dd></div>
            <div class="md:col-span-2"><dt class="text-xs uppercase tracking-wider text-slate-400">Comment</dt><dd class="mt-2 whitespace-pre-wrap text-slate-700 dark:text-slate-300">{{ $contactQuery->comment }}</dd></div>
        </dl>
    </section>
</div>
@endsection
