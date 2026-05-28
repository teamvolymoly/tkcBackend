<!DOCTYPE html>
<html lang="en" class="h-full" x-data="adminShell()" :class="{ 'dark': darkMode }" x-cloak>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | {{ config('app.name') }}</title>
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
        [x-cloak]{display:none!important}
        .scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none}
        .scrollbar-hide::-webkit-scrollbar{display:none}
        html,body{font-family:'Inter',ui-sans-serif,system-ui,sans-serif}
        :root{
            --admin-shell:#ffffff;
            --admin-surface:#ffffff;
            --admin-surface-soft:#ffffff;
            --admin-surface-muted:#ffffff;
            --admin-stroke:#ddd6ca;
            --admin-stroke-strong:#cfc5b8;
            --admin-text:#27231f;
            --admin-text-soft:#6d665e;
            --admin-olive:#708271;
            --admin-olive-deep:#5f715f;
            --admin-olive-soft:#a9c5b0;
            --admin-success-bg:#e1f2df;
            --admin-success-text:#4e9b55;
            --admin-danger-bg:#fbe3e2;
            --admin-danger-text:#c76b68;
            --admin-warning-bg:#f8ecd6;
            --admin-warning-text:#a4732d;
            --admin-shadow:0 24px 50px rgba(114,130,115,.12);
        }
        .dark{
            --admin-shell:#0f1510;
            --admin-surface:#171f18;
            --admin-surface-soft:#202a21;
            --admin-surface-muted:#1c261d;
            --admin-stroke:#354335;
            --admin-stroke-strong:#4d5f4d;
            --admin-text:#f5f7f2;
            --admin-text-soft:#b8c3b4;
            --admin-olive:#8fa38c;
            --admin-olive-deep:#a9bea4;
            --admin-olive-soft:#647964;
            --admin-success-bg:#173321;
            --admin-success-text:#86efac;
            --admin-danger-bg:#3b1e20;
            --admin-danger-text:#fca5a5;
            --admin-warning-bg:#3a2c16;
            --admin-warning-text:#facc15;
            --admin-shadow:0 22px 45px rgba(0,0,0,.26);
        }
        body.admin-panel-shell{background:var(--admin-shell);color:var(--admin-text)}
        .admin-panel-shell .admin-shell-bg{background:var(--admin-shell)!important}
        .admin-panel-shell .admin-sticky-chrome{background:var(--admin-shell)!important}
     
        .admin-panel-shell .admin-muted-surface{
            background:var(--admin-surface-soft)!important;
            border-color:var(--admin-stroke)!important;
        }
        .admin-panel-shell h1,
        .admin-panel-shell h2,
        .admin-panel-shell h3,
        .admin-panel-shell h4,
        .admin-panel-shell h5,
        .admin-panel-shell h6{color:var(--admin-text)!important}
        .admin-panel-shell .text-slate-900,
        .admin-panel-shell .dark\:text-white,
        .admin-panel-shell .dark\:text-slate-100,
        .admin-panel-shell .dark\:text-slate-200,
        .admin-panel-shell .text-black,
        .admin-panel-shell .text-\[\#1e2620\],
        .admin-panel-shell .text-\[\#1d241d\],
        .admin-panel-shell .text-\[\#2b322c\],
        .admin-panel-shell .text-\[\#2d342e\],
        .admin-panel-shell .text-\[\#4e5650\]{color:var(--admin-text)!important}
        .admin-panel-shell .text-slate-700,
        .admin-panel-shell .text-slate-600,
        .admin-panel-shell .text-slate-500,
        .admin-panel-shell .text-slate-400,
        .admin-panel-shell .dark\:text-slate-300,
        .admin-panel-shell .dark\:text-slate-400,
        .admin-panel-shell .dark\:text-slate-500,
        .admin-panel-shell .text-black\/70,
        .admin-panel-shell .text-\[\#52604f\],
        .admin-panel-shell .text-\[\#556053\],
        .admin-panel-shell .text-\[\#6f766f\],
        .admin-panel-shell .text-\[\#6b7368\],
        .admin-panel-shell .text-\[\#7d8579\],
        .admin-panel-shell .text-\[\#889084\],
        .admin-panel-shell .text-\[\#8b9388\],
        .admin-panel-shell .text-\[\#8f988d\],
        .admin-panel-shell .text-\[\#9aa298\]{color:var(--admin-text-soft)!important}
        .admin-panel-shell input:not([type="checkbox"]):not([type="radio"]):not([type="file"]),
        .admin-panel-shell select,
        .admin-panel-shell textarea{
            border-color:var(--admin-stroke)!important;
            background:var(--admin-surface-muted)!important;
            color:var(--admin-text)!important;
            border-radius:1.15rem!important;
            box-shadow:none!important;
        }
        .admin-panel-shell input::placeholder,
        .admin-panel-shell textarea::placeholder{color:#b4aa9f!important}
        .admin-panel-shell input:focus,
        .admin-panel-shell select:focus,
        .admin-panel-shell textarea:focus{
            border-color:var(--admin-olive-soft)!important;
            box-shadow:0 0 0 4px rgba(169,197,176,.28)!important;
            outline:none!important;
        }
        .admin-panel-shell input[type="checkbox"],
        .admin-panel-shell input[type="radio"]{
            border-color:var(--admin-stroke-strong)!important;
            color:var(--admin-olive)!important;
        }
        .admin-panel-shell table thead,
        .admin-panel-shell .bg-slate-50,
        .admin-panel-shell .bg-slate-50\/60,
        .admin-panel-shell .bg-slate-50\/70,
        .admin-panel-shell .bg-slate-50\/80,
        .admin-panel-shell .dark\:bg-slate-950,
        .admin-panel-shell .dark\:bg-slate-950\/40,
        .admin-panel-shell .dark\:bg-slate-950\/60,
        .admin-panel-shell .dark\:bg-slate-950\/70,
        .admin-panel-shell .dark\:bg-slate-950\/80,
        .admin-panel-shell .bg-\[\#f1f2ef\],
        .admin-panel-shell .bg-\[\#f1f3ef\],
        .admin-panel-shell .bg-\[\#eef3ec\],
        .admin-panel-shell .bg-gray-200{background:var(--admin-surface-soft)!important}
        .admin-panel-shell table,
        .admin-panel-shell tbody,
        .admin-panel-shell .border-slate-200,
        .admin-panel-shell .dark\:border-slate-800,
        .admin-panel-shell .dark\:border-slate-700,
        .admin-panel-shell .border-\[\#edf0ea\],
        .admin-panel-shell .border-\[\#e3e8e0\]{border-color:var(--admin-stroke)!important}
        .admin-panel-shell tbody tr:hover{background:rgba(169,197,176,.12)!important}
        .admin-panel-shell a.inline-flex,
        .admin-panel-shell button,
        .admin-panel-shell .btn-theme{transition:all .2s ease}
        .admin-panel-shell .btn-primary,
        .admin-panel-shell a[href*="create"],
        .admin-panel-shell button[type="submit"].bg-slate-900{
            background:linear-gradient(90deg, var(--admin-olive-deep), var(--admin-olive-soft))!important;
            color:#fff!important;
            border-color:transparent!important;
            box-shadow:0 12px 24px rgba(115,140,118,.22)!important;
        }
        .admin-panel-shell .btn-primary:hover,
        .admin-panel-shell a[href*="create"]:hover,
        .admin-panel-shell button[type="submit"].bg-slate-900:hover{
            transform:translateY(-1px);
            box-shadow:0 16px 28px rgba(115,140,118,.28)!important;
        }
        .admin-panel-shell .rounded-xl.border,
        .admin-panel-shell .rounded-lg.border,
        .admin-panel-shell .rounded-\[1\.75rem\].border{
            border-color:color-mix(in srgb, var(--admin-stroke) 82%, white)!important;
        }
        .admin-panel-shell .bg-emerald-50,
        .admin-panel-shell .bg-emerald-100,
        .admin-panel-shell .dark\:bg-emerald-500\/10{background:var(--admin-success-bg)!important}
        .admin-panel-shell .text-emerald-700,
        .admin-panel-shell .dark\:text-emerald-300{color:var(--admin-success-text)!important}
        .admin-panel-shell .bg-rose-50,
        .admin-panel-shell .bg-rose-100,
        .admin-panel-shell .dark\:bg-rose-500\/10{background:var(--admin-danger-bg)!important}
        .admin-panel-shell .text-rose-700,
        .admin-panel-shell .text-rose-600,
        .admin-panel-shell .dark\:text-rose-300{color:var(--admin-danger-text)!important}
        .admin-panel-shell .bg-amber-50,
        .admin-panel-shell .bg-amber-100,
        .admin-panel-shell .dark\:bg-amber-500\/10{background:var(--admin-warning-bg)!important}
        .admin-panel-shell .text-amber-700,
        .admin-panel-shell .dark\:text-amber-300{color:var(--admin-warning-text)!important}
        .admin-panel-shell .bg-sky-50,
        .admin-panel-shell .bg-sky-100,
        .admin-panel-shell .bg-blue-50,
        .admin-panel-shell .bg-blue-100,
        .admin-panel-shell .bg-cyan-50,
        .admin-panel-shell .bg-cyan-100,
        .admin-panel-shell .bg-indigo-50,
        .admin-panel-shell .bg-indigo-100{background:#e6eee4!important}
        .dark .admin-panel-shell .bg-sky-50,
        .dark .admin-panel-shell .bg-sky-100,
        .dark .admin-panel-shell .bg-blue-50,
        .dark .admin-panel-shell .bg-blue-100,
        .dark .admin-panel-shell .bg-cyan-50,
        .dark .admin-panel-shell .bg-cyan-100,
        .dark .admin-panel-shell .bg-indigo-50,
        .dark .admin-panel-shell .bg-indigo-100,
        .dark .admin-panel-shell .dark\:bg-sky-500\/10,
        .dark .admin-panel-shell .dark\:bg-blue-500\/10,
        .dark .admin-panel-shell .dark\:bg-cyan-500\/10,
        .dark .admin-panel-shell .dark\:bg-indigo-500\/10{background:var(--admin-surface-soft)!important}
        .admin-panel-shell .border-sky-200,
        .admin-panel-shell .border-blue-200,
        .admin-panel-shell .border-cyan-200,
        .admin-panel-shell .border-indigo-200,
        .admin-panel-shell .dark\:border-sky-500\/20,
        .admin-panel-shell .dark\:border-blue-500\/20,
        .admin-panel-shell .dark\:border-cyan-500\/20,
        .admin-panel-shell .dark\:border-indigo-500\/20{border-color:var(--admin-stroke)!important}
        .admin-panel-shell .text-sky-700,
        .admin-panel-shell .text-sky-600,
        .admin-panel-shell .dark\:text-sky-300,
        .admin-panel-shell .text-blue-700,
        .admin-panel-shell .text-blue-600,
        .admin-panel-shell .dark\:text-blue-300,
        .admin-panel-shell .text-cyan-700,
        .admin-panel-shell .text-cyan-600,
        .admin-panel-shell .dark\:text-cyan-300,
        .admin-panel-shell .text-indigo-700,
        .admin-panel-shell .text-indigo-600,
        .admin-panel-shell .dark\:text-indigo-300{color:var(--admin-olive-deep)!important}
        .admin-panel-shell .bg-white,
        .admin-panel-shell .bg-white\/80,
        .admin-panel-shell .bg-white\/85,
        .admin-panel-shell .dark\:bg-slate-900,
        .admin-panel-shell .dark\:bg-slate-900\/70,
        .admin-panel-shell .dark\:bg-slate-900\/80{background:var(--admin-surface)!important}
        .dark .admin-panel-shell .dark\:bg-slate-700\/40{background:var(--admin-surface-soft)!important}
        .admin-panel-shell .bg-\[\#fbfbfa\],
        .admin-panel-shell .bg-\[\#fbfcfa\],
        .admin-panel-shell .bg-\[\#f8faf7\]{background:var(--admin-surface-muted)!important}
        .admin-panel-shell .shadow-sm,
        .admin-panel-shell .shadow-lg{box-shadow:var(--admin-shadow)!important}
        .admin-panel-shell .ring-slate-200,
        .admin-panel-shell .ring-\[\#edf0ea\]{--tw-ring-color:var(--admin-stroke)!important}
        .admin-panel-shell .border-white\/70{border-color:rgba(255,255,255,.65)!important}
        .dark .admin-panel-shell .text-\[\#2f3630\],
        .dark .admin-panel-shell .text-\[\#536054\]{color:var(--admin-text-soft)!important}
        .dark .admin-panel-shell .bg-\[\#dfe7db\].text-\[\#2f3630\]{color:var(--admin-text)!important}
        .dark .admin-panel-shell .bg-\[\#dfe7db\],
        .dark .admin-panel-shell .hover\:bg-\[\#eef1ec\]:hover{background:var(--admin-surface-soft)!important}
        .dark .admin-panel-shell .border-\[\#e7ebe4\]{border-color:var(--admin-stroke)!important}
    </style>
    @stack('styles')
</head>
<body class="admin-panel-shell h-full bg-white text-slate-900 antialiased transition-colors duration-300">
<div class="admin-shell-bg min-h-screen transition-colors duration-300">
    <div class="flex min-h-screen gap-0 p-1.5 sm:p-2">
        @include('admin.layouts.sidebar')
        <div class="flex min-w-0 flex-1 flex-col rounded-[14px] bg-transparent">
            @include('admin.layouts.navbar')
            <main class="flex-1 px-3 pb-3 pt-1 sm:px-4 sm:pb-4" x-data="{ visible: false }" x-init="requestAnimationFrame(() => visible = true)">
                @include('admin.components.alerts')
                <div x-show="visible" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1.5" x-transition:enter-end="opacity-100 translate-y-0" class="mx-auto h-full w-full max-w-[1480px]">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div x-show="confirmOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50"></div>
    <div x-show="confirmOpen" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-6 shadow-xl">
            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 4.5h.008v.008H12v-.008z"/></svg>
            </div>
            <h3 class="text-lg font-semibold">Confirm Action</h3>
            <p class="mt-2 text-sm text-slate-600" x-text="confirmMessage"></p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50" @click="closeConfirm()">Cancel</button>
                <button type="button" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-500" @click="submitConfirmed()">Yes, Continue</button>
            </div>
        </div>
    </div>
</div>

<script>
function adminShell() {
    return {
        sidebarOpen: false,
        sidebarCollapsed: false,
        darkMode: window.__adminDark,
        confirmOpen: false,
        confirmForm: null,
        confirmMessage: 'Are you sure you want to continue?',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
        },
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('admin-dark-mode', this.darkMode ? 'true' : 'false');
        },
        openConfirm(form, message) {
            this.confirmForm = form;
            this.confirmMessage = message || this.confirmMessage;
            this.confirmOpen = true;
        },
        closeConfirm() {
            this.confirmOpen = false;
            this.confirmForm = null;
        },
        submitConfirmed() {
            if (this.confirmForm) this.confirmForm.submit();
            this.closeConfirm();
        },
        init() {
            window.addEventListener('confirm-action', (event) => {
                this.openConfirm(event.detail.form, event.detail.message);
            });
        }
    }
}

document.addEventListener('submit', function (event) {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.dataset.confirm && !form.dataset.confirmed) {
        event.preventDefault();
        window.dispatchEvent(new CustomEvent('confirm-action', { detail: { form, message: form.dataset.confirm } }));
        return;
    }
    if (form.dataset.loadingForm !== undefined) {
        const submitter = form.querySelector('[type="submit"]');
        if (submitter) {
            submitter.disabled = true;
            submitter.dataset.originalText = submitter.innerHTML;
            submitter.innerHTML = '<span class="inline-flex items-center gap-2"><span class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>Processing...</span>';
        }
    }
});
</script>
@stack('scripts')
</body>
</html>
