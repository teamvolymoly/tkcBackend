@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="space-y-6" x-data="selectionTable()">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 dark:text-sky-300">Taxonomy</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Categories and subcategories</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Organize your catalog hierarchy with one clean management screen.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Add Category</a>
    </div>

    <div class="rounded-[2rem] border border-white/70 bg-white/80 p-5 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-none">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold">Hierarchy Listing</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Nested records stay visible so category structure is easy to audit.</p>
            </div>
            <form method="POST" action="{{ route('admin.categories.bulk-delete') }}" data-confirm="Delete selected categories? This can fail if child categories still exist." x-ref="bulkForm" class="flex items-center gap-3">
                @csrf
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit" class="rounded-2xl border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10" :disabled="selected.length === 0">Delete Selected</button>
            </form>
        </div>

        @if (empty($categories))
            <div class="mt-6">@include('admin.components.empty-state', ['title' => 'No categories yet'])</div>
        @else
            <div class="mt-6 overflow-hidden rounded-[1.5rem] border border-slate-200 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-950/70">
                            <tr>
                                <th class="px-4 py-3"><input type="checkbox" @change="toggleAll($event)" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Category</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Type</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-3 text-right font-semibold text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="px-4 py-4"><input type="checkbox" value="{{ $category['id'] }}" x-model="selected" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-950/60">
                                                @if (!empty($category['image_url']))
                                                    <img src="{{ $category['image_url'] }}" alt="{{ $category['name'] }}" class="h-full w-full object-cover">
                                                @else
                                                    <span class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400">No image</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900 dark:text-white">{{ $category['name'] }}</div>
                                                <div class="mt-1 text-xs text-slate-500">ID #{{ $category['id'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600 dark:text-slate-300">Main Category</td>
                                    <td class="px-4 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($category['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($category['status']) ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('admin.categories.edit', $category['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category['id']) }}" data-confirm="Delete this category?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($category['children'] ?? [] as $child)
                                    <tr class="bg-slate-50/60 dark:bg-slate-950/40">
                                        <td class="px-4 py-4"><input type="checkbox" value="{{ $child['id'] }}" x-model="selected" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500"></td>
                                        <td class="px-4 py-4 pl-8">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
                                                    @if (!empty($child['image_url']))
                                                        <img src="{{ $child['image_url'] }}" alt="{{ $child['name'] }}" class="h-full w-full object-cover">
                                                    @else
                                                        <span class="text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400">No image</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-slate-900 dark:text-white">{{ $child['name'] }}</div>
                                                    <div class="mt-1 text-xs text-slate-500">Parent: {{ $category['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-slate-600 dark:text-slate-300">Subcategory</td>
                                        <td class="px-4 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ !empty($child['status']) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-700/40 dark:text-slate-200' }}">{{ !empty($child['status']) ? 'Active' : 'Inactive' }}</span></td>
                                        <td class="px-4 py-4 text-right">
                                            <div class="inline-flex items-center gap-2">
                                                <a href="{{ route('admin.categories.edit', $child['id']) }}" class="rounded-2xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Edit</a>
                                                <form method="POST" action="{{ route('admin.categories.destroy', $child['id']) }}" data-confirm="Delete this subcategory?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-2xl border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/20 dark:text-rose-300 dark:hover:bg-rose-500/10">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectionTable() { return { selected: [], toggleAll(event) { const boxes = Array.from(document.querySelectorAll('tbody input[type=checkbox]')); this.selected = event.target.checked ? boxes.map(box => box.value) : []; } } }
</script>
@endpush

