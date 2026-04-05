@extends('admin.layouts.app')
@section('title', 'Edit Coupon')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Coupons</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Edit coupon</h1>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold dark:border-slate-700">Back</a>
    </div>
    <form method="POST" action="{{ route('admin.coupons.update', $coupon['id']) }}" class="space-y-6" data-loading-form>
        @csrf
        @method('PUT')
        @include('admin.coupons._form')
        <div class="flex justify-end">
            <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Save Changes</button>
        </div>
    </form>
</div>
@endsection
