@php
    $totalRoles = count($roles['data'] ?? []);
    $totalAssignments = collect($roles['data'] ?? [])->sum('users_count');
@endphp
@extends('admin.layouts.app')
@section('title', 'Roles & Permissions')
@section('content')
<div class="space-y-6" x-data="roleManager()">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">System Control</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Roles & Permissions</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Roles create kijiye aur checkbox se decide kijiye ki admin panel ka kaunsa section visible aur manageable hoga.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm dark:border-slate-800 dark:bg-slate-950"><span class="text-slate-500 dark:text-slate-400">Roles</span><span class="ml-2 font-semibold text-slate-900 dark:text-white">{{ $totalRoles }}</span></div>
                <div class="rounded-xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-700 dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-300"><span>Assignments</span><span class="ml-2 font-semibold">{{ $totalAssignments }}</span></div>
                <button type="button" @click="createOpen = true" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Create Role</button>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" class="grid gap-3 xl:grid-cols-[1.6fr_auto]">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-950" placeholder="Search role name">
            <button type="submit" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:bg-slate-800">Apply Filters</button>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        @if (empty($roles['data']))
            @include('admin.components.empty-state', ['title' => 'No roles found', 'message' => 'Create a role to start controlling admin permissions.'])
        @else
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/80">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Role</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Permissions</th>
                                <th class="px-4 py-4 text-left font-semibold text-slate-500">Users</th>
                                <th class="px-4 py-4 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($roles['data'] as $role)
                                @php($roleName = strtolower($role['name']))
                                <tr class="align-top transition hover:bg-slate-50/70 dark:hover:bg-slate-950/70">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-slate-900 dark:text-white">{{ ucfirst($role['name']) }}</div>
                                        <div class="mt-1 text-xs text-slate-500">{{ in_array($roleName, $protectedRoles, true) ? 'Protected system role' : 'Custom/manageable role' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (collect($role['permissions'] ?? [])->take(4) as $permission)
                                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ $permission['name'] }}</span>
                                            @endforeach
                                            @if (($role['permissions_count'] ?? 0) > 4)
                                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500 dark:bg-slate-800 dark:text-slate-400">+{{ ($role['permissions_count'] ?? 0) - 4 }} more</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">{{ $role['users_count'] ?? 0 }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('admin.roles.edit', $role['id']) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            @if (! in_array($roleName, $protectedRoles, true))
                                                <form method="POST" action="{{ route('admin.roles.destroy', $role['id']) }}" data-confirm="Delete this role? Users must be reassigned first.">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="rounded-xl border border-rose-200 px-3 py-2 text-xs font-medium text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.components.pagination', ['paginator' => $roles])
        @endif
    </section>

    <div x-show="createOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50" @click="createOpen = false"></div>
    <div x-show="createOpen" x-transition class="fixed inset-0 z-50 overflow-y-auto p-4">
        <div class="mx-auto w-full max-w-6xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900" @click.stop>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">System</p>
                    <h2 class="mt-2 text-2xl font-semibold">Create role</h2>
                </div>
                <button type="button" @click="createOpen = false" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600">Close</button>
            </div>
            <form method="POST" action="{{ route('admin.roles.store') }}" class="mt-6 space-y-6" data-loading-form>
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-medium">Role name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm" placeholder="manager, support, content-editor" required>
                </div>
                @include('admin.roles._permission-groups', ['permissionGroups' => $permissionGroups, 'selectedPermissions' => old('permissions', [])])
                <div class="flex justify-end">
                    <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function roleManager(){return{createOpen:{{ $errors->any() ? 'true' : 'false' }},selectedPermissions:@js(old('permissions', [])),toggleGroup(groupKey,permissions){const set=new Set(this.selectedPermissions);const allSelected=permissions.every(permission=>set.has(permission));permissions.forEach(permission=>{if(allSelected){set.delete(permission);}else{set.add(permission);}});this.selectedPermissions=Array.from(set);}}}
</script>
@endpush
