@php
    $toastType = session('success') ? 'success' : (session('error') ? 'error' : null);
    $toastMessage = session('success') ?: session('error');
@endphp
@if ($toastMessage)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3200)" x-show="show" x-transition class="fixed right-4 top-24 z-50 w-full max-w-sm overflow-hidden rounded-[1.4rem] border border-[#ddd6ca] bg-[#fcf8f4] p-4 shadow-[0_24px_50px_rgba(114,130,115,0.16)]">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-[1rem] {{ $toastType === 'success' ? 'bg-[#e1f2df] text-[#4e9b55]' : 'bg-[#fbe3e2] text-[#c76b68]' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15 9.75"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-[#27231f]">{{ $toastType === 'success' ? 'Success' : 'Something went wrong' }}</p>
                <p class="mt-1 text-sm leading-6 text-[#6d665e]">{{ $toastMessage }}</p>
            </div>
            <button type="button" class="rounded-lg p-1 text-[#91877b] transition hover:bg-[#f2ede6] hover:text-[#5f574f]" @click="show = false">&times;</button>
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="mb-6 overflow-hidden rounded-[1.5rem] border border-[#edd0cf] bg-[#fff5f4] shadow-sm">
        <div class="flex items-start gap-4 p-5">
            <div class="flex h-10 w-10 items-center justify-center rounded-[1rem] bg-[#fbe3e2] text-[#c76b68]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 4.5h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#9a4f4b]">Please review the highlighted errors</h3>
                <ul class="mt-2 space-y-1 text-sm text-[#a25f5b]">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
