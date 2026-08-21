@extends('admin.layouts.app')

@section('title', 'Profile')

@php($roles = collect($profile['roles'] ?? [])->pluck('name')->filter()->values())

@section('content')
<div class="space-y-8">
    <div>
        <div>
            <h1 class="text-3xl font-semibold tracking-tight">Profile</h1>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.8fr_1.2fr]">
        <section class="rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border border-[#d8e2d8] bg-[#edf3ec] text-lg font-semibold text-[#52685a] dark:border-[#344538] dark:bg-[#243128] dark:text-[#dce7dc]">
                    {{ strtoupper(substr($profile['name'] ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ $profile['name'] ?? 'Admin User' }}</h2>
                    <p class="mt-1 break-all text-sm text-slate-500 dark:text-slate-400">{{ $profile['email'] ?? 'admin@example.com' }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-4 text-sm">
                <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Phone</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ $profile['phone'] ?: 'Not added yet' }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Member since</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">
                        {{ !empty($profile['created_at']) ? \Illuminate\Support\Carbon::parse($profile['created_at'])->format('d M Y') : 'N/A' }}
                    </p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Roles</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @forelse ($roles as $role)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">{{ $role }}</span>
                        @empty
                            <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300">No roles found</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-lg border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Edit profile</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update your name, email address, and phone number here.</p>
                </div>
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
                            class="block w-full rounded-lg border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
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
                            class="block w-full rounded-lg border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
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
                        class="block w-full rounded-lg border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white"
                        placeholder="Enter phone number"
                    >
                    @error('phone')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex border-t border-slate-200 pt-6 dark:border-slate-800 sm:justify-end">
                    <button type="submit" class="inline-flex h-12 shrink-0 items-center justify-center whitespace-nowrap rounded-full bg-[#607969] px-7 text-sm font-semibold text-white shadow-sm transition hover:bg-[#52695a] focus:outline-none focus:ring-2 focus:ring-[#9fb3a4] focus:ring-offset-2 dark:bg-[#a8bca9] dark:text-[#182019] dark:hover:bg-[#bacabb] dark:focus:ring-offset-[#171f18]">
                        Update profile
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
