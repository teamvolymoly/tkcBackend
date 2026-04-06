@php
    $selectedPermissions = collect(old('permissions', $selectedPermissions ?? []));
@endphp
<div class="grid gap-4 lg:grid-cols-2">
    @foreach ($permissionGroups as $group)
        <section class="rounded-[1.6rem] border border-slate-200 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-950/40">
            <div class="mb-4 flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ $group['label'] }}</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Select what this role can access in admin.</p>
                </div>
                <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800" @click="toggleGroup('{{ $group['key'] }}', @js(collect($group['permissions'])->pluck('name')->values()))">Toggle All</button>
            </div>
            <div class="space-y-3">
                @foreach ($group['permissions'] as $permission)
                    <label class="flex gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm transition hover:border-slate-300 dark:border-slate-800 dark:bg-slate-900/80 dark:hover:border-slate-700">
                        <input type="checkbox" name="permissions[]" value="{{ $permission['name'] }}" x-model="selectedPermissions" class="mt-0.5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" @checked($selectedPermissions->contains($permission['name']))>
                        <span>
                            <span class="block font-semibold text-slate-900 dark:text-white">{{ $permission['label'] }}</span>
                            <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">{{ $permission['description'] }}</span>
                            <span class="mt-1 block text-[11px] uppercase tracking-[0.18em] text-slate-400">{{ $permission['name'] }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
