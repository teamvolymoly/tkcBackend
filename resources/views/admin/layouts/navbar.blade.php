@php
    $quickActionIcons = [
        ['label' => 'Gmail', 'src' => asset('assects/svg/Gmail.svg'), 'class' => 'h-7 w-7'],
        ['label' => 'Amazon', 'src' => asset('assects/svg/Amazon.svg'), 'class' => 'h-8 w-8'],
        ['label' => 'WhatsApp', 'src' => asset('assects/svg/WhatsApp.svg'), 'class' => 'h-8 w-8'],
    ];
@endphp

<header class="admin-sticky-chrome sticky top-1.5 z-30 px-1 pb-3 pt-1 sm:top-2 sm:px-2">
    <div class="mx-auto flex w-full max-w-[1480px] items-center justify-between gap-3 rounded-[12px] bg-transparent px-2 py-1.5 sm:px-3">
        <div class="flex min-w-0 items-center gap-3">
            <button type="button" class="admin-header-control inline-flex h-10 w-10 items-center justify-center rounded-full text-[#586056] transition hover:-translate-y-0.5 lg:hidden" @click="sidebarOpen = true" aria-label="Open sidebar">
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5"/></svg>
            </button>
        </div>

        <div class="flex items-center gap-2 sm:gap-2.5">
            <button type="button" class="admin-header-control hidden h-12 w-12 items-center justify-center rounded-full transition hover:-translate-y-0.5 md:inline-flex" aria-label="App icon">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <rect x="4" y="2.5" width="13" height="19" rx="1.8" class="fill-[#263044] dark:fill-[#dce4dc]"/>
                    <rect x="9" y="6.5" width="5" height="11" rx="0.7" class="fill-white dark:fill-[#202a21]"/>
                    <path d="M4 16.5h5v5H5.8A1.8 1.8 0 0 1 4 19.7v-3.2Z" fill="#e84b4b"/>
                </svg>
            </button>

            @foreach ($quickActionIcons as $icon)
                <button type="button" class="admin-header-control hidden h-12 w-12 items-center justify-center rounded-full text-[#1f2a44] transition hover:-translate-y-0.5 md:inline-flex" aria-label="{{ $icon['label'] }}">
                    <img src="{{ $icon['src'] }}" alt="" class="{{ $icon['class'] }} object-contain">
                </button>
            @endforeach

            <button type="button" class="admin-header-control inline-flex h-12 items-center rounded-full p-0.5 text-[#8d857a] dark:text-[#d7e0d5]" @click="toggleDarkMode()" aria-label="Toggle theme">
                <span class="flex h-10 w-10 items-center justify-center rounded-full" :class="darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3c-.12.58-.18 1.18-.18 1.79A7.5 7.5 0 0018.5 12.3c.86 0 1.68-.14 2.45-.4.03.3.05.59.05.89z"/></svg>
                </span>
                <span class="flex h-10 w-10 items-center justify-center rounded-full" :class="!darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m8.25-9H18.75M5.25 12H3.75m14.084 6.334-1.06-1.06M7.227 7.227l-1.06-1.06m11.667 0-1.06 1.06M7.227 16.773l-1.06 1.06M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </button>

            <form method="POST" action="{{ route('admin.logout') }}" class="hidden md:inline-flex">
                @csrf
                <button type="submit" class="admin-header-control inline-flex h-12 w-12 items-center justify-center rounded-full p-3 text-[#586056] transition hover:-translate-y-0.5" aria-label="Logout">
                    <img src="{{ asset('assects/svg/Sign_out_squre_light.svg') }}" alt="" class="h-6 w-6 object-contain transition dark:brightness-0 dark:invert">
                </button>
            </form>

            <a href="{{ route('admin.profile.show') }}" class="admin-header-control inline-flex h-12 w-12 items-center justify-center overflow-hidden rounded-full" aria-label="Open profile">
                <svg class="h-7 w-7" viewBox="0 0 28 28" role="img" aria-label="{{ strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) }}">
                    <circle cx="14" cy="14" r="13" class="fill-[#edf3ec] dark:fill-[#27342a]"/>
                    <text x="14" y="14.5" text-anchor="middle" dominant-baseline="middle" class="fill-[#52685a] text-[10px] font-semibold dark:fill-[#dce7dc]">{{ strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) }}</text>
                </svg>
            </a>
        </div>
    </div>
</header>
