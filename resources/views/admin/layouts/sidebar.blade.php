@php($current = request()->route()?->getName())
@php($sidebarLogoPath = asset('storage/logo/LOGO_TKC-01.png'))
<aside>
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-950/45 lg:hidden" @click="sidebarOpen = false"></div>
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-40 flex w-[15.8rem] flex-col rounded-[10px] bg-white px-3 py-3 shadow-2xl transition-all duration-300 lg:static lg:shadow-none">
        <div class="flex h-[70px] items-center justify-center rounded-[10px] bg-white">
            <img 
                src="{{ $sidebarLogoPath }}" 
                alt="The Kahwa Company logo" 
                class="h-full w-auto object-contain"
            >
        </div>

        @php($mainLinks = [
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'hint' => 'Dashboard overview'],
            ['route' => 'admin.orders.index', 'label' => 'Analytics', 'hint' => 'Analytics and order insights'],
            ['route' => 'admin.orders.index', 'label' => 'Orders', 'hint' => 'Orders management'],
            ['route' => 'admin.payments.index', 'label' => 'Payments', 'hint' => 'Payments management'],
            ['route' => 'admin.products.index', 'label' => 'Products', 'hint' => 'Products management'],
            ['route' => 'admin.inventory.index', 'label' => 'Inventory', 'hint' => 'Inventory management'],
            ['route' => 'admin.coupons.index', 'label' => 'Coupons', 'hint' => 'Coupons management'],
            ['route' => 'admin.categories.index', 'label' => 'Categories', 'hint' => 'Categories management'],
            ['route' => 'admin.categories.index', 'label' => 'CMS', 'hint' => 'Categories'],
            ['route' => 'admin.users.index', 'label' => 'More', 'hint' => 'Users, Reviews, Carts, Wishlists'],
        ])
        @php($lowerLinks = [
            ['route' => 'admin.reviews.index', 'label' => 'Support', 'hint' => 'Support and reviews'],
            ['route' => 'admin.profile.show', 'label' => 'Setting', 'hint' => 'Roles & permissions, links, profile'],
        ])
        @php($icons = [
            'Dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7.5h6v4.75h-6zm9 0h6v4.75h-6zM4.5 14.25h6V19h-6zm9 0h6V19h-6z"/>',
            'Analytics' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.5 18V9.5h3V18m5-6.5V18h3V6h-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 18h15"/>',
            'Orders' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7.5h3V18H7zm7-3h3V18h-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 18h15"/>',
            'Payments' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5h13a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-13a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5h15"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14h3"/>',
            'Products' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 9.5h12l1.25 8.5H4.75L6 9.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5a3 3 0 0 1 6 0"/>',
            'Inventory' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.75 18 8v8l-6 3.25L6 16V8z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.75V12m0 0 6-4M12 12 6 8"/>',
            'Coupons' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 6.75h8l1.75 3.5L12 13 6.25 10.25z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.25 10.25V17.5H17.75v-7.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v10.75"/>',
            'Categories' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5h13"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.5 12h13"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.5 16.5h13"/>',
            'CMS' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5h13v9h-13z"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 18.5h8"/>',
            'More' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 6.75h8"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 6.75v4.5h11v-4.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25v7.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 14h5"/>',
            'Support' => '<circle cx="12" cy="12" r="7.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h.01"/>',
            'Setting' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 12l-1.2-.7.1-1.35-1.25-2.15-1.35.3-.95-.95.3-1.35-2.15-1.25L12 5 10.65 4.7 8.5 5.95l.3 1.35-.95.95-1.35-.3-1.25 2.15.1 1.35L5 12l1.2.7-.1 1.35 1.25 2.15 1.35-.3.95.95-.3 1.35 2.15 1.25L12 19l1.35.3 2.15-1.25-.3-1.35.95-.95 1.35.3 1.25-2.15-.1-1.35z"/>',
        ])

        <div class="mt-4 flex-1 overflow-y-auto pr-1 scrollbar-hide">
            <nav class="space-y-1.5">
                @foreach ($mainLinks as $link)
                    @php($active = $link['label'] === 'Dashboard' ? $current === 'admin.dashboard' : str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                    <a href="{{ route($link['route']) }}" title="{{ $link['hint'] }}" class="group flex items-center gap-2.5 rounded-full px-2.5 py-2 text-[15px] font-medium transition {{ $active ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                        <span class="flex h-5 w-5 items-center justify-center {{ $active ? 'text-white' : 'text-[#2f3630]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons[$link['label']] ?? '<path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"/>' !!}</svg>
                        </span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="my-4 border-t border-[#e7ebe4]"></div>

            <nav class="space-y-1.5">
                @foreach ($lowerLinks as $link)
                    @php($active = str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                    <a href="{{ route($link['route']) }}" title="{{ $link['hint'] }}" class="group flex items-center gap-2.5 rounded-full px-2.5 py-2 text-[11px] font-medium transition {{ $active ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                        <span class="flex h-5 w-5 items-center justify-center {{ $active ? 'text-white' : 'text-[#2f3630]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons[$link['label']] ?? '<path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"/>' !!}</svg>
                        </span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="mt-3 overflow-hidden rounded-[10px] bg-[#a5b4a1] text-white">
            <div class="space-y-1 px-3 py-3">
                <p class="text-[8px] uppercase tracking-[0.18em] text-white/75">Designed and developed by volymoly</p>
                <p class="text-lg font-light leading-none">VOLYMOLY</p>
                <p class="text-[18px] italic leading-none text-white/90">wm</p>
            </div>
        </div>
    </div>
</aside>

