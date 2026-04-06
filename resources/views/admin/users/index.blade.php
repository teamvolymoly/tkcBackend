@php
    $totalUsers = count($users['data'] ?? []);
    $adminUsers = collect($users['data'] ?? [])->filter(fn ($user) => collect($user['roles'] ?? [])->pluck('name')->contains('admin'))->count();
@endphp
@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="space-y-6" x-data="userTable()">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Customers & Staff</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Users</h1>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950"><span class="text-slate-500 dark:text-slate-400">Loaded</span><span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalUsers }}</span></div>
                <div class="rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300"><span>Admins</span><span class="ml-2 font-semibold">{{ $adminUsers }}</span></div>
                <button type="button" @click="createOpen = true" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add User</button>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.6fr_0.8fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Name, email, or phone">
            <select name="role" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950">
                <option value="">All roles</option>
                @foreach ($roleOptions as $roleOption)
                    <option value="{{ $roleOption['name'] }}" @selected(($filters['role'] ?? '') === $roleOption['name'])>{{ ucfirst($roleOption['name']) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">User listing</h2>
            </div>
            <form method="POST" action="{{ route('admin.users.bulk-delete') }}" data-confirm="Delete selected users? Admin accounts will be skipped by the API." class="flex items-center gap-3">
                @csrf
                <template x-for="id in selected" :key="id"><input type="hidden" name="ids[]" :value="id"></template>
                <button type="submit" class="rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-medium text-rose-600 transition hover:bg-rose-50 disabled:opacity-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10" :disabled="selected.length === 0">Delete Selected</button>
            </form>
        </div>
        @if (empty($users['data']))
            @include('admin.components.empty-state', ['title' => 'No users found', 'message' => 'Try different filters or add a new account from the modal.'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4"><input type="checkbox" @change="toggleAll($event)" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">User</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Phone</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Roles</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($users['data'] as $user)
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4"><input type="checkbox" value="{{ $user['id'] }}" x-model="selected" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $user['name'] }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ $user['email'] }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $user['phone'] ?? 'N/A' }}</td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ collect($user['roles'] ?? [])->pluck('name')->implode(', ') ?: 'No role' }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.show', $user['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">View</a>
                                            <a href="{{ route('admin.users.edit', $user['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user['id']) }}" data-confirm="Delete this user account?">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.components.pagination', ['paginator' => $users])
        @endif
    </section>

    <div x-show="createOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50" @click="createOpen = false"></div>
    <div x-show="createOpen" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="w-full max-w-2xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900" @click.stop>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Users</p>
                    <h2 class="mt-2 text-2xl font-semibold">Add user</h2>
                </div>
                <button type="button" @click="createOpen = false" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600">Close</button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-5" data-loading-form>
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Role</label>
                        <select name="role" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm">
                            @foreach ($roleOptions as $roleOption)
                                <option value="{{ $roleOption['name'] }}" @selected(old('role', 'customer') === $roleOption['name'])>{{ ucfirst($roleOption['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Password</label>
                    <input type="password" name="password" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function userTable(){return{selected:[],createOpen:{{ $errors->any() ? 'true' : 'false' }},toggleAll(event){const boxes=Array.from(document.querySelectorAll('tbody input[type=checkbox]'));this.selected=event.target.checked?boxes.map(box=>box.value):[]}}}
</script>
@endpush
