<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ darkMode: window.__adminDark || false, showPassword: false }" :class="{ 'dark': darkMode }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | {{ config('app.name') }}</title>
    <script>
        window.__adminDark = localStorage.getItem('admin-dark-mode') === 'true';
        if (window.__adminDark) document.documentElement.classList.add('dark');
    </script>
    @php($hasViteManifest = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @if ($hasViteManifest)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                        }
                    }
                }
            };
        </script>
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        @font-face {
            font-family: 'Inter';
            src: url('{{ asset('Inter-VariableFont_opsz,wght.ttf') }}') format('truetype');
            font-weight: 100 900;
            font-style: normal;
            font-display: swap;
        }
        [x-cloak] { display: none !important; }
        html, body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-[#eff3ee] font-sans text-slate-900 transition-colors duration-300 dark:bg-[#708372] dark:text-slate-900">
    @php($loginImagePath = route('media.public', ['path' => 'login/login_img.png']))
    @php($adminLogoPath = route('media.public', ['path' => 'logo/LOGO_TKC-01.png']))

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8 sm:px-6">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.82),_transparent_32%),linear-gradient(180deg,_#f3f6f1_0%,_#eef3ed_100%)] dark:bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.08),_transparent_22%),linear-gradient(180deg,_#738674_0%,_#687c6a_100%)]"></div>

        <div class="relative w-full max-w-[720px] overflow-hidden rounded-[18px] bg-[#fcf8f4] shadow-[0_26px_60px_rgba(114,130,115,0.18)] lg:grid lg:min-h-[610px] lg:grid-cols-[1.02fr_0.92fr]">
            <div class="relative hidden h-full lg:block">
                <img
                    src="{{ $loginImagePath }}"
                    alt="Admin login visual"
                    class="h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.36),rgba(255,255,255,0.22))]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(231,238,228,0.72),_transparent_50%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-28 bg-[linear-gradient(180deg,rgba(255,255,255,0),rgba(255,255,255,0.2)_55%,rgba(255,255,255,0.48))]"></div>
            </div>

            <div class="flex h-full flex-col justify-between bg-[#fcf8f4] px-5 py-5 sm:px-6 sm:py-6">
                <div>
                    <div class="flex items-start justify-between gap-4">
                        <div class="inline-flex min-h-[44px] items-center rounded-[6px] border border-[#d7d1c8] bg-white px-3 py-2 shadow-sm">
                            <img 
                                src="{{ $adminLogoPath }}" 
                                alt="The Kahwa Co." 
                                class="h-10 w-auto sm:h-12"
                            >
                        </div>

                        <button
                            type="button"
                            class="inline-flex items-center rounded-full bg-[#f2efeb] p-1 text-[#8e877e] shadow-sm transition hover:text-[#5f574f]"
                            @click="darkMode = !darkMode; localStorage.setItem('admin-dark-mode', darkMode ? 'true' : 'false')"
                            aria-label="Toggle theme"
                        >
                            <span class="flex h-7 w-7 items-center justify-center rounded-full" :class="darkMode ? 'bg-white text-[#625b54] shadow-sm' : ''">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3c-.12.58-.18 1.18-.18 1.79A7.5 7.5 0 0018.5 12.3c.86 0 1.68-.14 2.45-.4.03.3.05.59.05.89z"/></svg>
                            </span>
                            <span class="flex h-7 w-7 items-center justify-center rounded-full" :class="!darkMode ? 'bg-white text-[#625b54] shadow-sm' : ''">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m8.25-9H18.75M5.25 12H3.75m14.084 6.334-1.06-1.06M7.227 7.227l-1.06-1.06m11.667 0-1.06 1.06M7.227 16.773l-1.06 1.06M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                        </button>
                    </div>

                    <div class="mt-10 sm:mt-12">
                        <h1 class="text-[2rem] font-semibold leading-none tracking-[-0.035em] text-[#23201d] sm:text-[2.3rem]">Welcome Back!</h1>
                        <p class="mt-4 max-w-sm text-[11px] leading-4 text-[#6e675e]">
                            Log in to continue the kahwa company tasks, panel team learn more inside.
                        </p>
                    </div>

                    <div class="mt-6">@include('admin.components.alerts')</div>

                    <form method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-4" data-loading-form>
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-[11px] font-medium text-[#4f4942]">
                                Your email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="business@yourlye.com"
                                class="h-9 w-full rounded-full border border-[#d8d1c6] bg-[#f9f6f1] px-4 text-xs text-[#2d2925] outline-none transition placeholder:text-[#c0b9b0] focus:border-[#aebba9] focus:ring-2 focus:ring-[#d9e4d7]"
                                required
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-[11px] font-medium text-[#4f4942]">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Enter your password"
                                    class="h-9 w-full rounded-full border border-[#d8d1c6] bg-[#f9f6f1] px-4 pr-11 text-xs text-[#2d2925] outline-none transition placeholder:text-[#c0b9b0] focus:border-[#aebba9] focus:ring-2 focus:ring-[#d9e4d7]"
                                    required
                                >
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-3 inline-flex items-center text-[#9b9389] transition hover:text-[#5f574f]"
                                    @click="showPassword = !showPassword"
                                    aria-label="Toggle password visibility"
                                >
                                    <svg x-show="!showPassword" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <svg x-show="showPassword" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.584 10.587A2 2 0 0012 14a2 2 0 001.414-.586"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.294 5.197"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.228 6.228A9.956 9.956 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.358 0 2.652-.27 3.834-.759"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 pt-0.5 text-[11px] text-[#625b54]">
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" class="h-3.5 w-3.5 rounded border-[#cfc7bb] text-[#7a9680] focus:ring-[#c8d6c6]">
                                <span>Remember me</span>
                            </label>
                            <a href="{{ route('admin.password.request') }}" class="font-medium text-[#4e4a44] transition hover:text-[#1f1d1a]">Forgot password?</a>
                        </div>

                        <button
                            type="submit"
                            class="mt-2 inline-flex h-10 w-full items-center justify-center rounded-full bg-gradient-to-r from-[#6c836f] to-[#a9c5b0] px-5 text-sm font-medium text-white shadow-[0_12px_24px_rgba(115,140,118,0.22)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_28px_rgba(115,140,118,0.28)] focus:outline-none focus:ring-2 focus:ring-[#c3d4c2] focus:ring-offset-2"
                        >
                            log in
                        </button>
                    </form>
                </div>

                <div class="pt-6 text-center">
                    <p class="text-[11px] text-[#9b9388]">For any quries contact us at</p>
                    <a href="mailto:info@thekahwacompany.com" class="mt-2 inline-block text-sm font-medium text-[#4f4942] transition hover:text-[#22201d]">
                        info@thekahwacompany.com
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




