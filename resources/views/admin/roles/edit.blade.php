@php
    $selectedPermissions = collect(old('permissions', collect($role['permissions'] ?? [])->pluck('name')->all()));
    $roleName = strtolower($role['name'] ?? '');
@endphp
@extends('admin.layouts.app')
@section('title', 'Edit Role')
@section('content')
<div class="space-y-6" x-data="roleEditor(@js($selectedPermissions->values()->all()))">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">System Control</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Edit role</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Role name aur permissions ko checkbox ke through manage kijiye.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.roles.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Back</a>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[0.85fr_1.15fr]">
        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div class="flex items-start gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-sky-500 via-cyan-400 to-emerald-400 text-xl font-black text-slate-950 shadow-lg shadow-cyan-500/25">
                    {{ strtoupper(substr($role['name'] ?? 'R', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white">{{ ucfirst($role['name'] ?? 'Role') }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $role['permissions_count'] ?? count($role['permissions'] ?? []) }} permissions assigned</p>
                </div>
            </div>

            <div class="mt-6 space-y-4 text-sm">
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Assigned users</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ $role['users_count'] ?? 0 }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-400 dark:text-slate-500">Role type</p>
                    <p class="mt-2 font-medium text-slate-900 dark:text-white">{{ in_array($roleName, $protectedRoles, true) ? 'Protected system role' : 'Custom role' }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-slate-50 p-4 text-slate-600 dark:bg-slate-950/60 dark:text-slate-300">
                    Protected roles rename ya delete nahi honge, lekin inki permissions aap manage kar sakte ho.
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Update role</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Permissions save hote hi access matrix refresh ho jayega.</p>
            </div>

            <form method="POST" action="{{ route('admin.roles.update', $role['id']) }}" class="mt-8 space-y-6" data-loading-form>
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Role name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $role['name'] ?? '') }}" class="block w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-950/60 dark:text-white" @disabled(in_array($roleName, $protectedRoles, true)) required>
                </div>

                @include('admin.roles._permission-groups', ['permissionGroups' => $permissionGroups, 'selectedPermissions' => $selectedPermissions])

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 dark:border-slate-800 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Protected roles ka name locked rahega, baki permissions fully manageable hain.</p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Save changes</button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
@push('scripts')
<script>
function roleEditor(initialPermissions){return{selectedPermissions:initialPermissions,toggleGroup(groupKey,permissions){const set=new Set(this.selectedPermissions);const allSelected=permissions.every(permission=>set.has(permission));permissions.forEach(permission=>{if(allSelected){set.delete(permission);}else{set.add(permission);}});this.selectedPermissions=Array.from(set);}}}
</script>
@endpush
