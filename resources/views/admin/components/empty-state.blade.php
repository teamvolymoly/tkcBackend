<div class="rounded-[1.75rem] border border-dashed border-[#d8d1c6] bg-[#fcf8f4] p-10 text-center shadow-[0_24px_50px_rgba(114,130,115,0.10)]">
    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-[1.35rem] bg-[#f3eee7] text-[#7a746d]">
        <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 0l6.75 6.75M3.75 12l6.75-6.75"/></svg>
    </div>
    <h3 class="mt-6 text-lg font-semibold text-[#27231f]">{{ $title ?? 'Nothing to show yet' }}</h3>
    <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-[#6d665e]">{{ $message ?? 'Try adjusting filters or adding new records to populate this area.' }}</p>
</div>
