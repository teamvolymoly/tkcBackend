@extends('admin.layouts.app')
@section('title', 'Edit Product')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Catalog</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Edit product</h1>
        </div>
        <a href="{{ route('admin.products.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
    </div>
    @php($productFormAction = route('admin.products.update', $product['id']))
    @php($productFormMethod = 'PUT')
    @php($productFormSubmit = 'Save Product')
    @include('admin.products._form')
</div>
@endsection
@include('admin.products.variant-script')
