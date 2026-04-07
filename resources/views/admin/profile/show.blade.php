@extends('admin.layouts.app')

@section('title', 'Profile')

@php($roles = collect($profile['roles'] ?? [])->pluck('name')->filter()->values())

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Account</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Admin profile settings</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Apna basic account information update kijiye. Changes directly API ke through save honge.</p>
        </div>
        <div class="rounded-[1.75rem] border border-white/70 bg-white/80 px-5 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/70">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400 dark:text-slate-500">Signed in as</p>
            <p class="mt-2 text-base font-semibold text-slate-900 dark:text-white">{{ $profile['email'] ?? 'admin@example.com' }}</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-start gap-4">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-sky-500 via-cyan-400 to-emerald-400 text-xl font-black text-slate-950 shadow-lg shadow-cyan-500/25">
                    {{ strtoupper(substr($profile['name'] ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $profile['name'] ?? 'Admin User' }}</h2>
                    <p class="mt-1 break-all text-sm text-slate-500 dark:text-slate-400">{{ $profile['email'] ?? 'admin@example.com' }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-4 text-sm">
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Phone</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ $profile['phone'] ?: 'Not added yet' }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Member since</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">
                        {{ !empty($profile['created_at']) ? \Illuminate\Support\Carbon::parse($profile['created_at'])->format('d M Y') : 'N/A' }}
                    </p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Roles</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @forelse ($roles as $role)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ $role }}</span>
                        @empty
                            <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300">No roles found</span>
                        @endforelse
                    </div>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Security note</p>
                    <p class="mt-2 text-slate-600 dark:text-slate-300">Ye panel API token ke through authenticated hai, isliye profile edits live backend par save honge.</p>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Edit profile</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Name, email aur phone ko yahin se update kijiye.</p>
                </div>
                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">API Driven</span>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-8 space-y-6" data-loading-form>
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Full name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $profile['name'] ?? '') }}"
                            class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
                            placeholder="Enter full name"
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $profile['email'] ?? '') }}"
                            class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
                            placeholder="Enter email"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Phone number</label>
                    <input
                        id="phone"
                        name="phone"
                        type="text"
                        value="{{ old('phone', $profile['phone'] ?? '') }}"
                        class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
                        placeholder="Enter phone number"
                    >
                    @error('phone')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Save karne ke baad topbar aur session profile bhi refresh ho jayega.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
                        Update profile
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

