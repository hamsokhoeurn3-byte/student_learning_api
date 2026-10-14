<div class="lang-switcher d-inline-flex align-items-center text-nowrap rounded-pill p-1 shadow-sm" style="font-size: 0.78rem; font-weight: 600; gap: 2px;" role="group" aria-label="Language switcher">
    <a href="{{ route('lang.switch', 'en') }}"
       class="text-decoration-none px-2 py-1 rounded-pill {{ app()->getLocale() === 'en' ? 'lang-btn-active' : 'lang-btn-inactive' }}"
       style="transition: all 0.15s ease;"
       title="English">
       EN
    </a>
    <a href="{{ route('lang.switch', 'km') }}"
       class="text-decoration-none px-2 py-1 rounded-pill {{ app()->getLocale() === 'km' ? 'lang-btn-active' : 'lang-btn-inactive' }}"
       style="transition: all 0.15s ease;"
       title="ភាសាខ្មែរ">
       ខ្មែរ
    </a>
</div>

<style>
    /* Language Switcher Default Styling (Login page, light surfaces) */
    .lang-switcher {
        background: #ffffff;
        border: 1px solid #e4e7ec;
    }
    .lang-switcher .lang-btn-active {
        background: linear-gradient(135deg, #7c3aed, #5b21b6);
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(91, 33, 182, 0.3);
    }
    .lang-switcher .lang-btn-inactive {
        color: #64748b;
    }
    .lang-switcher .lang-btn-inactive:hover {
        color: #7c3aed;
        background: #f5f3ff;
    }

    /* Inverted Theme when inside Purple Header */
    .student-global-header .lang-switcher,
    .portal-header .lang-switcher {
        background: rgba(255, 255, 255, 0.16) !important;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12) !important;
    }
    .student-global-header .lang-switcher .lang-btn-active,
    .portal-header .lang-switcher .lang-btn-active {
        background: #ffffff !important;
        color: #6d28d9 !important;
        font-weight: 750;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18) !important;
    }
    .student-global-header .lang-switcher .lang-btn-inactive,
    .portal-header .lang-switcher .lang-btn-inactive {
        color: rgba(255, 255, 255, 0.88) !important;
    }
    .student-global-header .lang-switcher .lang-btn-inactive:hover,
    .portal-header .lang-switcher .lang-btn-inactive:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.18) !important;
    }
</style>
