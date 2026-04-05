<header class="px-1 pb-3 pt-1 sm:px-2">
    <div class="mx-auto flex w-full max-w-[1480px] items-center justify-between gap-3 rounded-[12px] bg-transparent px-2 py-1.5 sm:px-3">
        <div class="flex min-w-0 items-center gap-3">
            <button type="button" class="rounded-full bg-white p-2 text-slate-600 shadow-sm lg:hidden" @click="sidebarOpen = true">
                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5"/></svg>
            </button>

            <div class="relative hidden sm:block">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#7c837b]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/></svg>
                <input type="text" placeholder="Search" class="h-9 w-[150px] rounded-full border-0 bg-white px-9 pr-8 text-[11px] text-slate-700 outline-none ring-1 ring-[#d8ddd4] placeholder:text-[#9ba19a] focus:ring-[#c1cabd] sm:w-[185px]">
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[#7c837b]">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-2.5">
            <button type="button" class="hidden h-9 w-9 items-center justify-center rounded-full bg-white text-[#1f2a44] shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="App icon">
                <span class="relative block h-4.5 w-4.5 rounded-[4px] bg-[#1f2a44]">
                    <span class="absolute inset-y-[2px] right-[2px] w-[5px] rounded-[2px] bg-[#ff7e29]"></span>
                </span>
            </button>
            <button type="button" class="hidden h-9 w-9 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="Gmail">
                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M3.75 7.5 12 13.5l8.25-6" stroke="#EA4335" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 18.25V8.25" stroke="#34A853" stroke-width="2" stroke-linecap="round"/>
                    <path d="M19 18.25V8.25" stroke="#4285F4" stroke-width="2" stroke-linecap="round"/>
                    <path d="M5.25 18.25H18.75" stroke="#FBBC05" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <button type="button" class="hidden h-9 w-9 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="Amazon">
                <span class="relative text-[22px] font-semibold leading-none text-[#222]">a
                    <span class="absolute -bottom-0.5 left-1/2 h-[2px] w-4.5 -translate-x-1/2 rounded-full bg-[#f6a623]"></span>
                </span>
            </button>
            <button type="button" class="hidden h-9 w-9 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="WhatsApp">
                <span class="flex h-5.5 w-5.5 items-center justify-center rounded-full bg-[#25D366] text-white">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.198.297-.768.966-.94 1.164-.173.198-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.76-1.653-2.058-.173-.297-.018-.458.13-.606.135-.135.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.273.297-1.04 1.015-1.04 2.475 0 1.461 1.065 2.872 1.213 3.07.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.29.173-1.413-.074-.124-.272-.198-.57-.347Z"/></svg>
                </span>
            </button>
            <button type="button" class="inline-flex h-9 items-center rounded-full bg-[#f3efe9] p-0.5 text-[#8d857a] shadow-sm ring-1 ring-[#edf0ea]" @click="toggleDarkMode()" aria-label="Toggle theme">
                <span class="flex h-8 w-8 items-center justify-center rounded-full" :class="darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3c-.12.58-.18 1.18-.18 1.79A7.5 7.5 0 0018.5 12.3c.86 0 1.68-.14 2.45-.4.03.3.05.59.05.89z"/></svg>
                </span>
                <span class="flex h-8 w-8 items-center justify-center rounded-full" :class="!darkMode ? 'bg-white text-[#625b53]' : ''">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m8.25-9H18.75M5.25 12H3.75m14.084 6.334-1.06-1.06M7.227 7.227l-1.06-1.06m11.667 0-1.06 1.06M7.227 16.773l-1.06 1.06M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
            </button>
            <form method="POST" action="{{ route('admin.logout') }}" class="inline-flex">
                @csrf
                <button type="submit" class="hidden h-9 w-9 items-center justify-center rounded-full bg-white text-[#586056] shadow-sm ring-1 ring-[#edf0ea] transition hover:-translate-y-0.5 md:inline-flex" aria-label="Logout">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 12H9m0 0 3-3m-3 3 3 3"/></svg>
                </button>
            </form>
            <a href="{{ route('admin.profile.show') }}" class="inline-flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-[#e5d6c7] shadow-sm ring-1 ring-[#edf0ea]">
                <span class="text-[10px] font-semibold text-[#5f665e]">{{ strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) }}</span>
            </a>
        </div>
    </div>
</header>
