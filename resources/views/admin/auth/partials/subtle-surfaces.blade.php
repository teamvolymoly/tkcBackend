<style>
    .admin-auth-shell {
        --auth-stroke: #dfe8dc;
        --auth-stroke-focus: #c6d5c2;
        --auth-shadow: 0 3px 12px rgba(92, 110, 94, 0.075);
        --auth-focus: 0 0 0 3px rgba(169, 197, 176, 0.14);
        --auth-shell: #f2f6f1;
        --auth-surface: #ffffff;
        --auth-surface-soft: #edf3ec;
        background: var(--auth-shell) !important;
    }
    .dark .admin-auth-shell {
        --auth-stroke: #263229;
        --auth-stroke-focus: #3b4b3e;
        --auth-shadow: 0 2px 12px rgba(0, 0, 0, 0.14);
        --auth-focus: 0 0 0 3px rgba(143, 163, 140, 0.14);
        --auth-shell: #0d130e;
        --auth-surface: #171f18;
        --auth-surface-soft: #202b22;
    }
    .admin-auth-shell .border,
    .admin-auth-shell [class*="border-"] {
        border-color: var(--auth-stroke) !important;
    }
    .admin-auth-shell [class*="ring-"] {
        --tw-ring-color: var(--auth-stroke) !important;
    }
    .admin-auth-shell [class*="shadow-"] {
        box-shadow: var(--auth-shadow) !important;
    }
    .admin-auth-shell .bg-white {
        background: var(--auth-surface) !important;
    }
    .admin-auth-shell .bg-slate-50,
    .admin-auth-shell .bg-slate-100,
    .admin-auth-shell .bg-gray-50,
    .admin-auth-shell .bg-gray-100 {
        background: var(--auth-surface-soft) !important;
    }
    .admin-auth-shell input:focus,
    .admin-auth-shell select:focus,
    .admin-auth-shell textarea:focus {
        border-color: var(--auth-stroke-focus) !important;
        box-shadow: var(--auth-focus) !important;
    }
</style>
