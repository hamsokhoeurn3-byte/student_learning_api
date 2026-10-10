<div class="lang-switcher d-inline-flex align-items-center bg-white border rounded-pill p-1 shadow-sm" style="font-size: 0.78rem; font-weight: 600; gap: 2px;" role="group" aria-label="Language switcher">
    <a href="{{ route('lang.switch', 'en') }}"
       class="text-decoration-none px-2 py-1 rounded-pill {{ app()->getLocale() === 'en' ? 'bg-primary text-white shadow-xs' : 'text-secondary' }}"
       style="transition: all 0.15s ease;"
       title="English">
       EN
    </a>
    <a href="{{ route('lang.switch', 'km') }}"
       class="text-decoration-none px-2 py-1 rounded-pill {{ app()->getLocale() === 'km' ? 'bg-primary text-white shadow-xs' : 'text-secondary' }}"
       style="transition: all 0.15s ease;"
       title="ភាសាខ្មែរ">
       ខ្មែរ
    </a>
</div>

