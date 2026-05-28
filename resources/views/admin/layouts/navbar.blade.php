@php
    $quickActionIcons = [
        ['label' => 'App icon', 'src' => asset('assects/icons/image 1.png'), 'class' => 'h-5 w-5'],
        ['label' => 'Gmail', 'src' => asset('assects/svg/Gmail.svg'), 'class' => 'h-7 w-7'],
        ['label' => 'Amazon', 'src' => asset('assects/svg/Amazon.svg'), 'class' => 'h-8 w-8'],
        ['label' => 'WhatsApp', 'src' => asset('assects/svg/WhatsApp.svg'), 'class' => 'h-8 w-8'],
    ];
@endphp

<header class="admin-sticky-chrome sticky top-1.5 z-30 px-1 pb-3 pt-1 sm:top-2 sm:px-2">
    <div class="mx-auto flex w-full max-w-[1480px] items-center justify-between gap-3 rounded-[12px] bg-transparent px-2 py-1.5 sm:px-3">
        <div class="flex min-w-0 items-center gap-3">
            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-[#586056] shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 lg:hidden" @click="sidebarOpen = true" aria-label="Open sidebar">
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5"/></svg>
            </button>

            <div class="relative hidden sm:block">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#7c837b]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/></svg>
                <input type="text" placeholder="Search" class="h-9 w-[150px] rounded-full border-0 bg-white px-9 pr-8 text-[14px] text-slate-700 outline-none ring-1 ring-[#d8ddd4] placeholder:text-[#9ba19a] focus:ring-[#c1cabd] sm:w-[185px]">
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#7c837b]">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-2.5">
            @foreach ($quickActionIcons as $icon)
                <button type="button" class="hidden h-12 w-12 items-center justify-center rounded-full bg-white text-[#1f2a44] shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="{{ $icon['label'] }}">
                    <img src="{{ $icon['src'] }}" alt="" class="{{ $icon['class'] }} object-contain">
                </button>
            @endforeach

            <button type="button" class="inline-flex h-12 items-center rounded-full bg-[#f3efe9] p-0.5 text-[#8d857a] shadow-sm ring-1 ring-[#edf0ea]" @click="toggleDarkMode()" aria-label="Toggle theme">
                <span class="flex h-10 w-10 items-center justify-center rounded-full" :class="darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3c-.12.58-.18 1.18-.18 1.79A7.5 7.5 0 0018.5 12.3c.86 0 1.68-.14 2.45-.4.03.3.05.59.05.89z"/></svg>
                </span>
                <span class="flex h-10 w-10 items-center justify-center rounded-full" :class="!darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m8.25-9H18.75M5.25 12H3.75m14.084 6.334-1.06-1.06M7.227 7.227l-1.06-1.06m11.667 0-1.06 1.06M7.227 16.773l-1.06 1.06M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </button>

            <form method="POST" action="{{ route('admin.logout') }}" class="hidden md:inline-flex">
                @csrf
                <button type="submit" class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white p-3 text-[#586056] shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5" aria-label="Logout">
                    <img src="{{ asset('assects/svg/Sign_out_squre_light.svg') }}" alt="" class="h-6 w-6 object-contain">
                </button>
            </form>

            <a href="{{ route('admin.profile.show') }}" class="inline-flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-[#e5d6c7] shadow-sm ring-1 ring-[#edf0ea]" aria-label="Open profile">
                <span class="text-[10px] font-semibold text-[#5f665e]">{{ strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) }}</span>
            </a>
        </div>
    </div>
</header>
