@if (!empty($paginator['links']) && ($paginator['last_page'] ?? 1) > 1)
    <div class="mt-6 flex flex-col gap-4 rounded-lg border border-[#ddd6ca] bg-white px-4 py-4 shadow-sm dark:border-[#354335] dark:bg-[#171f18] sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-[#6d665e] dark:text-[#b8c3b4]">Showing page {{ $paginator['current_page'] ?? 1 }} of {{ $paginator['last_page'] ?? 1 }}</p>
        <nav class="flex flex-wrap items-center gap-2">
            @foreach ($paginator['links'] as $link)
                @continue($loop->first || $loop->last)
                <a href="{{ $link['url'] ?? '#' }}" class="inline-flex min-w-10 items-center justify-center rounded-xl border px-3 py-2 text-sm font-medium transition {{ $link['active'] ? 'border-transparent bg-gradient-to-r from-[#5f715f] to-[#a9c5b0] text-white shadow-[0_12px_24px_rgba(115,140,118,0.22)]' : 'border-[#ddd6ca] bg-white text-[#6d665e] hover:border-[#cfc5b8] hover:text-[#27231f] dark:border-[#354335] dark:bg-[#202a21] dark:text-[#b8c3b4] dark:hover:border-[#4d5f4d] dark:hover:text-white' }} {{ $link['url'] ? '' : 'pointer-events-none opacity-50' }}">{!! $link['label'] !!}</a>
            @endforeach
        </nav>
    </div>
@endif
