@php
    $current = request()->route()?->getName();
    $sidebarLogoPath = route('media.public', ['path' => 'logo/LOGO_TKC-01.png']);
    $permissionNames = collect($adminUser['permissions'] ?? [])->pluck('name')->all();
    $isAdmin = collect($adminUser['roles'] ?? [])->pluck('name')->contains('admin');
    $canAccess = fn (?string $permission = null) => $permission === null || $isAdmin || in_array($permission, $permissionNames, true);
    $cmsOpen = str_starts_with((string) $current, 'admin.blogs');
    $moreOpen = str_starts_with((string) $current, 'admin.users') || str_starts_with((string) $current, 'admin.reviews') || str_starts_with((string) $current, 'admin.carts') || str_starts_with((string) $current, 'admin.wishlists');
    $settingsOpen = str_starts_with((string) $current, 'admin.profile') || str_starts_with((string) $current, 'admin.roles') || str_starts_with((string) $current, 'admin.hero-sections');
@endphp
<aside x-data="{ cmsOpen: {{ $cmsOpen ? 'true' : 'false' }}, moreOpen: {{ $moreOpen ? 'true' : 'false' }}, settingsOpen: {{ $settingsOpen ? 'true' : 'false' }} }">
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-950/45 lg:hidden" @click="sidebarOpen = false"></div>
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-40 flex w-[15.8rem] flex-col rounded-[10px] bg-white px-3 py-3 shadow-2xl transition-all duration-300 lg:static lg:shadow-none">
        <div class="flex h-[70px] items-center justify-center rounded-[10px] bg-white">
            <img src="{{ $sidebarLogoPath }}" alt="The Kahwa Company logo" class="h-full w-auto object-contain">
        </div>

        @php($primaryLinks = collect([
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'hint' => 'Dashboard overview', 'permission' => 'dashboard.view'],
            ['route' => 'admin.orders.index', 'label' => 'Analytics', 'hint' => 'Analytics and order insights', 'permission' => 'dashboard.view'],
            ['route' => 'admin.orders.index', 'label' => 'Orders', 'hint' => 'Orders management', 'permission' => 'orders.view'],
            ['route' => 'admin.payments.index', 'label' => 'Payments', 'hint' => 'Payments management', 'permission' => 'payments.view'],
            ['route' => 'admin.products.index', 'label' => 'Products', 'hint' => 'Products management', 'permission' => 'products.view'],
            ['route' => 'admin.inventory.index', 'label' => 'Inventory', 'hint' => 'Inventory management', 'permission' => 'inventory.view'],
            ['route' => 'admin.coupons.index', 'label' => 'Coupons', 'hint' => 'Coupons management', 'permission' => 'coupons.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($cmsLinks = collect([
            ['route' => 'admin.blogs.index', 'label' => 'Blog', 'hint' => 'Blog CMS', 'permission' => 'blogs.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($moreLinks = collect([
            ['route' => 'admin.users.index', 'label' => 'Users', 'hint' => 'Users management', 'permission' => 'users.view'],
            ['route' => 'admin.reviews.index', 'label' => 'Reviews', 'hint' => 'Customer reviews', 'permission' => 'reviews.view'],
            ['route' => 'admin.carts.index', 'label' => 'Carts', 'hint' => 'Customer carts', 'permission' => 'carts.view'],
            ['route' => 'admin.wishlists.index', 'label' => 'Wishlists', 'hint' => 'Saved wishlist products', 'permission' => 'wishlists.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($settingsLinks = collect([
            ['route' => 'admin.profile.show', 'label' => 'Profile', 'hint' => 'Profile and settings', 'permission' => 'profile.view'],
            ['route' => 'admin.hero-sections.index', 'label' => 'Hero Section', 'hint' => 'Home hero section management', 'permission' => 'hero_sections.view'],
            ['route' => 'admin.roles.index', 'label' => 'Roles & Permissions', 'hint' => 'Role access management', 'permission' => 'roles.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($icons = [
            'Dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 7.5h6v4.75h-6zm9 0h6v4.75h-6zM4.5 14.25h6V19h-6zm9 0h6V19h-6z"/>',
            'Analytics' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.5 18V9.5h3V18m5-6.5V18h3V6h-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 18h15"/>',
            'Orders' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7.5h3V18H7zm7-3h3V18h-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 18h15"/>',
            'Payments' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5h13a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-13a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5h15"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14h3"/>',
            'Products' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 9.5h12l1.25 8.5H4.75L6 9.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5a3 3 0 0 1 6 0"/>',
            'Inventory' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.75 18 8v8l-6 3.25L6 16V8z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.75V12m0 0 6-4M12 12 6 8"/>',
            'Coupons' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 6.75h8l1.75 3.5L12 13 6.25 10.25z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.25 10.25V17.5H17.75v-7.25"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75v10.75"/>',
            'CMS' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5h13v9h-13z"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 18.5h8"/>',
            'More' => '<circle cx="12" cy="12" r="1.25"/><circle cx="6.75" cy="12" r="1.25"/><circle cx="17.25" cy="12" r="1.25"/>',
            'Setting' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.5a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 12l-1.2-.7.1-1.35-1.25-2.15-1.35.3-.95-.95.3-1.35-2.15-1.25L12 5 10.65 4.7 8.5 5.95l.3 1.35-.95.95-1.35-.3-1.25 2.15.1 1.35L5 12l1.2.7-.1 1.35 1.25 2.15 1.35-.3.95.95-.3 1.35 2.15 1.25L12 19l1.35.3 2.15-1.25-.3-1.35.95-.95 1.35.3 1.25-2.15-.1-1.35z"/>',
        ])

        <div class="mt-4 flex-1 overflow-y-auto pr-1 scrollbar-hide">
            <nav class="space-y-1.5">
                @foreach ($primaryLinks as $link)
                    @php($active = $link['label'] === 'Dashboard' ? $current === 'admin.dashboard' : str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                    <a href="{{ route($link['route']) }}" title="{{ $link['hint'] }}" class="group flex items-center gap-2.5 rounded-full px-2.5 py-2 text-[15px] font-medium transition {{ $active ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                        <span class="flex h-5 w-5 items-center justify-center {{ $active ? 'text-white' : 'text-[#2f3630]' }}">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons[$link['label']] !!}</svg>
                        </span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach

                @if ($cmsLinks->isNotEmpty())
                    <div class="space-y-1.5 pt-1">
                        <button type="button" @click="cmsOpen = !cmsOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[15px] font-medium transition {{ $cmsOpen ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                <span class="flex h-5 w-5 items-center justify-center"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons['CMS'] !!}</svg></span>
                                <span>CMS</span>
                            </span>
                            <svg class="h-4 w-4 transition" :class="cmsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="cmsOpen" class="space-y-1 pl-6">
                            @foreach ($cmsLinks as $link)
                                @php($active = str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                                <a href="{{ route($link['route']) }}" class="flex items-center gap-2 rounded-full px-3 py-2 text-sm transition {{ $active ? 'bg-[#dfe7db] text-[#2f3630]' : 'text-[#536054] hover:bg-[#eef1ec]' }}">{{ $link['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($moreLinks->isNotEmpty())
                    <div class="space-y-1.5 pt-1">
                        <button type="button" @click="moreOpen = !moreOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[15px] font-medium transition {{ $moreOpen ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                <span class="flex h-5 w-5 items-center justify-center"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons['More'] !!}</svg></span>
                                <span>More</span>
                            </span>
                            <svg class="h-4 w-4 transition" :class="moreOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="moreOpen" class="space-y-1 pl-6">
                            @foreach ($moreLinks as $link)
                                @php($active = str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                                <a href="{{ route($link['route']) }}" class="flex items-center gap-2 rounded-full px-3 py-2 text-sm transition {{ $active ? 'bg-[#dfe7db] text-[#2f3630]' : 'text-[#536054] hover:bg-[#eef1ec]' }}">{{ $link['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </nav>

            @if ($settingsLinks->isNotEmpty())
                <div class="my-4 border-t border-[#e7ebe4]"></div>
                <nav class="space-y-1.5">
                    <div class="space-y-1.5">
                        <button type="button" @click="settingsOpen = !settingsOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[11px] font-medium transition {{ $settingsOpen ? 'bg-[#708271] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                <span class="flex h-5 w-5 items-center justify-center"><svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.55" viewBox="0 0 24 24">{!! $icons['Setting'] !!}</svg></span>
                                <span>Setting</span>
                            </span>
                            <svg class="h-4 w-4 transition" :class="settingsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="settingsOpen" class="space-y-1 pl-6">
                            @foreach ($settingsLinks as $link)
                                @php($active = str_starts_with((string) $current, str_replace('.index', '', $link['route'])))
                                <a href="{{ route($link['route']) }}" class="flex items-center gap-2 rounded-full px-3 py-2 text-sm transition {{ $active ? 'bg-[#dfe7db] text-[#2f3630]' : 'text-[#536054] hover:bg-[#eef1ec]' }}">{{ $link['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </nav>
            @endif
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

