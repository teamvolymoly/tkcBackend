<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ darkMode: window.__adminDark || false }" :class="{ 'dark': darkMode }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | {{ config('app.name') }}</title>
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
        html, body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-white">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.18),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,0.16),_transparent_25%)]"></div>
        <div class="absolute inset-0 opacity-60 dark:opacity-30" style="background-image:radial-gradient(circle at 1px 1px, rgba(148,163,184,.18) 1px, transparent 0);background-size:24px 24px"></div>
        <div class="relative w-full max-w-xl overflow-hidden rounded-[2rem] border border-white/70 bg-white/85 shadow-2xl shadow-slate-300/40 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/80">
            <div class="p-6 sm:p-10">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-600 dark:text-sky-300">Admin Recovery</p>
                        <h1 class="mt-3 text-3xl font-semibold">Forgot password</h1>
                    </div>
                    <button type="button" class="rounded-2xl border border-slate-200 bg-white p-2.5 text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300" @click="darkMode = !darkMode; localStorage.setItem('admin-dark-mode', darkMode ? 'true' : 'false')">
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M4.97 4.97l1.591 1.591M17.439 17.439l1.591 1.591M3 12h2.25M18.75 12H21"/></svg>
                        <svg x-show="darkMode" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0112 21c-5.385 0-9.75-4.365-9.75-9.75 0-4.264 2.737-7.89 6.548-9.213a.75.75 0 01.95.95A7.5 7.5 0 0019.013 14.25a.75.75 0 01.95.752z"/></svg>
                    </button>
                </div>
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Admin email dijiye. Us address par 6-digit OTP bheja jayega.</p>
                <div class="mt-8">@include('admin.components.alerts')</div>
                <form method="POST" action="{{ route('admin.password.email') }}" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Admin email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-sky-400 focus:ring-4 focus:ring-sky-100 dark:border-slate-700 dark:bg-slate-950 dark:focus:ring-sky-500/10" placeholder="admin@example.com" required>
                    </div>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">Send OTP</button>
                </form>
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.login') }}" class="text-sm font-medium text-sky-600 transition hover:text-sky-500 dark:text-sky-300 dark:hover:text-sky-200">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


