@php
    $current = request()->route()?->getName();
    $sidebarLogoPath = route('media.public', ['path' => 'logo/LOGO_TKC-01.svg']);
    $permissionNames = collect($adminUser['permissions'] ?? [])->pluck('name')->all();
    $isAdmin = collect($adminUser['roles'] ?? [])->pluck('name')->contains('admin');
    $canAccess = fn (?string $permission = null) => $permission === null || $isAdmin || in_array($permission, $permissionNames, true);
    $cmsOpen = str_starts_with((string) $current, 'admin.blogs');
    $moreOpen = str_starts_with((string) $current, 'admin.users') || str_starts_with((string) $current, 'admin.reviews') || str_starts_with((string) $current, 'admin.contact-queries') || str_starts_with((string) $current, 'admin.carts') || str_starts_with((string) $current, 'admin.wishlists');
    $settingsOpen = str_starts_with((string) $current, 'admin.profile') || str_starts_with((string) $current, 'admin.roles') || str_starts_with((string) $current, 'admin.hero-sections');
@endphp
<aside x-data="{ cmsOpen: {{ $cmsOpen ? 'true' : 'false' }}, moreOpen: {{ $moreOpen ? 'true' : 'false' }}, settingsOpen: {{ $settingsOpen ? 'true' : 'false' }} }">
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-[#5A6F61] lg:hidden" @click="sidebarOpen = false"></div>
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-40 flex w-[15.8rem] flex-col rounded-[10px] bg-white px-3 py-3 shadow-2xl transition-all duration-300 lg:sticky lg:bottom-auto lg:top-2 lg:h-[calc(100vh-1rem)] lg:self-start lg:shadow-none">
        <div class="flex h-[70px] items-center justify-center rounded-[10px]">
            <img
                src="{{ $sidebarLogoPath }}"
                alt="The Kahwa Company logo"
                class="h-[58px] w-auto object-contain transition duration-300"
                :class="darkMode ? 'brightness-0 invert' : ''"
            >
        </div>

        @php($primaryLinks = collect([
            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'hint' => 'Dashboard overview', 'permission' => 'dashboard.view'],
            ['route' => 'admin.analytics', 'label' => 'Analytics', 'hint' => 'Analytics and order insights', 'permission' => 'dashboard.view'],
            ['route' => 'admin.orders.index', 'label' => 'Orders', 'hint' => 'Orders management', 'permission' => 'orders.view'],
            ['route' => 'admin.payments.index', 'label' => 'Payments', 'hint' => 'Payments management', 'permission' => 'payments.view'],
            ['route' => 'admin.products.index', 'label' => 'Products', 'hint' => 'Products management', 'permission' => 'products.view'],
            ['route' => 'admin.coupons.index', 'label' => 'Coupons', 'hint' => 'Coupons management', 'permission' => 'coupons.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($cmsLinks = collect([
            ['route' => 'admin.blogs.index', 'label' => 'Blog', 'hint' => 'Blog CMS', 'permission' => 'blogs.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($moreLinks = collect([
            ['route' => 'admin.users.index', 'label' => 'Users', 'hint' => 'Users management', 'permission' => 'users.view'],
            ['route' => 'admin.reviews.index', 'label' => 'Reviews', 'hint' => 'Customer reviews', 'permission' => 'reviews.view'],
            ['route' => 'admin.contact-queries.index', 'label' => 'Contact Queries', 'hint' => 'Frontend contact submissions', 'permission' => 'contact_queries.view'],
            ['route' => 'admin.carts.index', 'label' => 'Carts', 'hint' => 'Customer carts', 'permission' => 'carts.view'],
            ['route' => 'admin.wishlists.index', 'label' => 'Wishlists', 'hint' => 'Saved wishlist products', 'permission' => 'wishlists.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($settingsLinks = collect([
            ['route' => 'admin.profile.show', 'label' => 'Profile', 'hint' => 'Profile and settings', 'permission' => 'profile.view'],
            ['route' => 'admin.hero-sections.index', 'label' => 'Hero Section', 'hint' => 'Home hero section management', 'permission' => 'hero_sections.view'],
            ['route' => 'admin.roles.index', 'label' => 'Roles & Permissions', 'hint' => 'Role access management', 'permission' => 'roles.view'],
        ])->filter(fn ($link) => $canAccess($link['permission'])))
        @php($icons = [
            'Dashboard' => 'Widget_add_light.svg',
            'Analytics' => 'Chart_light.svg',
            'Orders' => 'Box_open_light.svg',
            'Payments' => 'Wallet_light.svg',
            'Products' => 'Boxes_light.svg',
            'Coupons' => 'Gift_light.svg',
            'CMS' => 'desktop_light.svg',
            'More' => 'Shop_light.svg',
            'Setting' => 'Stat.svg',
        ])
        @php($sidebarIcon = function (string $key) use ($icons) {
            $file = $icons[$key] ?? $icons['Dashboard'];
            return asset('assects/admin/' . $file);
        })

        <div class="mt-4 flex-1 overflow-y-auto pr-1 scrollbar-hide">
            <nav class="space-y-1.5">
                @foreach ($primaryLinks as $link)
                    @php($active = match ($link['label']) {
                        'Dashboard' => $current === 'admin.dashboard',
                        'Analytics' => $current === 'admin.analytics',
                        default => str_starts_with((string) $current, str_replace('.index', '', $link['route'])),
                    })
                    <a href="{{ route($link['route']) }}" title="{{ $link['hint'] }}" class="group flex items-center gap-2.5 rounded-full px-2.5 py-2 text-[14px] font-medium transition {{ $active ? 'bg-[#5A6F61] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                        @php($icon = $sidebarIcon($link['label']))
                        <span class="flex h-6 w-6 items-center justify-center">
                            <img src="{{ $icon }}" alt="" class="h-5 w-5 object-contain transition {{ $active ? 'brightness-0 invert' : '' }}" :class="darkMode ? 'brightness-0 invert' : ''">
                        </span>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach

                @if ($cmsLinks->isNotEmpty())
                    <div class="space-y-1.5 pt-1">
                        <button type="button" @click="cmsOpen = !cmsOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[14px] font-medium transition {{ $cmsOpen ? 'bg-[#5A6F61] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                @php($cmsIcon = $sidebarIcon('CMS'))
                                <span class="flex h-6 w-6 items-center justify-center">
                                    <img src="{{ $cmsIcon }}" alt="" class="h-5 w-5 object-contain transition {{ $cmsOpen ? 'brightness-0 invert' : '' }}" :class="darkMode ? 'brightness-0 invert' : ''">
                                </span>
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
                        <button type="button" @click="moreOpen = !moreOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[14px] font-medium transition {{ $moreOpen ? 'bg-[#5A6F61] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                @php($moreIcon = $sidebarIcon('More'))
                                <span class="flex h-6 w-6 items-center justify-center">
                                    <img src="{{ $moreIcon }}" alt="" class="h-5 w-5 object-contain transition {{ $moreOpen ? 'brightness-0 invert' : '' }}" :class="darkMode ? 'brightness-0 invert' : ''">
                                </span>
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
                        <button type="button" @click="settingsOpen = !settingsOpen" class="flex w-full items-center justify-between rounded-full px-2.5 py-2 text-[14px] font-medium transition {{ $settingsOpen ? 'bg-[#5A6F61] text-white' : 'text-[#2f3630] hover:bg-[#eef1ec]' }}">
                            <span class="flex items-center gap-2.5">
                                @php($settingIcon = $sidebarIcon('Setting'))
                                <span class="flex h-6 w-6 items-center justify-center">
                                    <img src="{{ $settingIcon }}" alt="" class="h-5 w-5 object-contain transition {{ $settingsOpen ? 'brightness-0 invert' : '' }}" :class="darkMode ? 'brightness-0 invert' : ''">
                                </span>
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

        <a
            href="https://volymoly.com"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Visit Volymoly website"
            class="mt-3 block overflow-hidden rounded-[10px] bg-[#5A6F61] text-white transition hover:bg-[#506457] focus:outline-none focus:ring-2 focus:ring-[#9fb3a4] focus:ring-offset-2"
        >
            <div class="space-y-2 px-3 py-3">
                <p class="text-[10px] tracking-[0.04em] text-white/75">Designed and developed by</p>
                <img src="{{ asset('assects/admin/volymoly_logo.svg') }}" alt="Volymoly" class="h-auto w-32">
            </div>
        </a>
    </div>
</aside>
