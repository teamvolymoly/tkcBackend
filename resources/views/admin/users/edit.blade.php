@extends('admin.layouts.app')
@section('title', 'Edit User')
@php($currentRole = collect($user['roles'] ?? [])->pluck('name')->first() ?: 'customer')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Customers & Staff</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Edit user</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Account details aur role ko admin panel se update kijiye.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.show', $user['id']) }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-start gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-sky-500 via-cyan-400 to-emerald-400 text-xl font-black text-slate-950 shadow-lg shadow-cyan-500/25">
                    {{ strtoupper(substr($user['name'] ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $user['name'] ?? 'User' }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $user['email'] ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-4 text-sm">
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Current role</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ strtoupper($currentRole) }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Phone</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ $user['phone'] ?: 'Not added yet' }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 text-slate-600 dark:bg-slate-950/60 dark:text-slate-300">
                    Agar aap apne khud ke admin account ko edit kar rahe ho, system role ko non-admin par downgrade nahi karega taaki panel access safe rahe.
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Update account</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Changes save hote hi user record refresh ho jayega.</p>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user['id']) }}" class="mt-8 space-y-6" data-loading-form>
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Full name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user['name'] ?? '') }}" class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white" required>
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user['email'] ?? '') }}" class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white" required>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Phone number</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $user['phone'] ?? '') }}" class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white">
                    </div>
                    <div>
                        <label for="role" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Role</label>
                        <select id="role" name="role" class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white">
                            <option value="customer" @selected(old('role', $currentRole) === 'customer')>Customer</option>
                            <option value="admin" @selected(old('role', $currentRole) === 'admin')>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Email duplicate ya invalid role hua to API validation error show karegi.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Save changes</button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
