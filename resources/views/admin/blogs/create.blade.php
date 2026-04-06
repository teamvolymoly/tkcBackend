@extends('admin.layouts.app')
@section('title', 'Create Blog')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">CMS</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Create blog post</h1>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
    </div>
    <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" data-loading-form class="space-y-6">
        @csrf
        @include('admin.blogs._form')
        <div class="flex justify-end">
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Save Blog</button>
        </div>
    </form>
</div>
@endsection
