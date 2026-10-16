<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - SLAS
    </title>

    {{-- Bootstrap --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* =====================================================
           GLOBAL
        ===================================================== */

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            background: #f7f8ff;
            font-family:
                'Kantumruy Pro',
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }


        /* =====================================================
           MAIN STUDENT LAYOUT
        ===================================================== */

        .student-layout {
            display: flex;

            width: 100%;
            height: 100vh;

            overflow: hidden;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .student-sidebar {

            width: 260px;
            min-width: 260px;

            height: 100vh;

            background: linear-gradient(180deg, #f5f3ff 0%, #ede9fe 100%);

            border-right: 1px solid #ddd6fe;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            position: relative;

            z-index: 1000;
        }


        /* =====================================================
            SIDEBAR TOGGLE
        ===================================================== */

        .portal-sidebar-toggle {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: inline-grid;
            place-items: center;
            border: 1px solid #e4e7ec;
            border-radius: 10px;
            color: #566075;
            background: #fff;
            font-size: 1.15rem;
            line-height: 1;
            cursor: pointer;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }

        .portal-sidebar-toggle:hover {
            color: #6d28d9;
            background: #f1ebff;
            border-color: #d8c9ff;
        }

        .portal-sidebar-toggle:focus-visible {
            outline: 2px solid #7c3aed;
            outline-offset: 2px;
        }

        /* Collapsed state: hide the sidebar entirely */
        .student-layout.nav-collapsed .student-sidebar {
            display: none;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .student-logo {

            padding: 28px 20px;

            border-bottom: 1px solid #ddd6fe;

            flex-shrink: 0;
        }

        .student-logo a {

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .student-logo-icon {

            width: 52px;
            height: 52px;

            border-radius: 10px;

            background: #f1ebff;

            object-fit: contain;

            flex-shrink: 0;
        }

        .student-logo-title {

            font-size: 24px;

            font-weight: 700;

            color: #111827;

            line-height: 1.1;
        }

        .student-logo-subtitle {

            font-size: 14px;

            color: #6b7280;

            margin-top: 4px;
        }


        /* =====================================================
           SIDEBAR NAVIGATION
        ===================================================== */

        .student-nav {

            flex: 1;

            padding: 16px 12px;

            overflow-y: auto;

            overflow-x: hidden;
        }


        /* Hide scrollbar but keep scrolling */
        .student-nav::-webkit-scrollbar {
            width: 5px;
        }

        .student-nav::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }


        /* =====================================================
           MENU LINK
        ===================================================== */

        .student-nav-link {

            display: flex;

            align-items: center;

            width: 100%;

            min-height: 46px;

            padding: 11px 14px;

            margin-bottom: 4px;

            border-radius: 8px;

            text-decoration: none;

            color: #475467;

            font-size: 16px;

            font-weight: 500;

            transition:
                background-color 0.2s ease,
                color 0.2s ease;
        }

        .student-nav-link i {

            width: 26px;

            font-size: 18px;

            margin-right: 10px;

            flex-shrink: 0;
        }


        /* Hover */

        .student-nav-link:hover {

            background: #f1ebff;

            color: #6d28d9;
        }


        /* Active */

        .student-nav-link.active {

            background: linear-gradient(135deg, #7c3aed, #5b21b6);

            color: #ffffff;

            font-weight: 600;
        }

        .student-nav-link.active:hover {

            background: linear-gradient(135deg, #6d28d9, #4c1d95);

            color: #ffffff;
        }


        /* =====================================================
           USER CARD
        ===================================================== */

        .student-user-section {

            padding: 14px;

            flex-shrink: 0;

            background: #ffffff;
        }

        .student-user-card {

            width: 100%;

            padding: 14px;

            border-radius: 16px;

            background: #f8f9fa;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .student-user-icon {

            width: 44px;
            height: 44px;

            border-radius: 50%;

            background: #dbeafe;

            color: #6d28d9;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;
        }

        .student-user-info {

            min-width: 0;
        }

        .student-user-name {

            color: #111827;

            font-size: 16px;

            font-weight: 600;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .student-user-role {

            color: #6b7280;

            font-size: 14px;

            margin-top: 2px;
        }

        .student-logout {
            width: 100%;
            margin-top: 12px;
            padding: 9px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #ffffff;
            color: #b42318;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .student-logout:hover {
            background: #b42318;
            border-color: #b42318;
            color: #ffffff;
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .student-content {

            flex: 1;

            min-width: 0;

            height: 100vh;

            overflow-y: auto;

            overflow-x: hidden;

            background: #f7f8ff;
        }


        /* =====================================================
           CONTENT SCROLLBAR
        ===================================================== */

        .student-content::-webkit-scrollbar {

            width: 8px;
        }

        .student-content::-webkit-scrollbar-thumb {

            background: #cbd5e1;

            border-radius: 10px;
        }

        .student-content::-webkit-scrollbar-track {

            background: transparent;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 768px) {
            .student-layout {
                position: relative;
            }

            .student-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 260px;
                min-width: 260px;
                height: 100vh;
                height: 100dvh;
                z-index: 1050;
                box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
                transform: translateX(0);
                transition: transform 0.25s ease;
            }

            .student-layout.nav-collapsed .student-sidebar {
                display: block !important;
                transform: translateX(-100%);
                box-shadow: none;
            }

            .student-content {
                width: 100%;
            }

            .student-logo {
                padding: 20px 14px;
            }

            .student-nav {
                padding: 12px 8px;
            }

            .student-nav-link {
                font-size: 15px;
                padding: 10px 12px;
            }
        }

        /* =====================================================
           PURPLE BRAND HEADER THEME
        ===================================================== */

        .student-global-header {
            position: sticky;
            top: 0;
            z-index: 30;
            height: 70px;
            padding: 0 30px;
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 4px 20px rgba(91, 33, 182, 0.18);
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #ffffff;
        }

        .student-global-header .portal-sidebar-toggle {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: inline-grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 10px;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(8px);
            font-size: 1.15rem;
            line-height: 1;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .student-global-header .portal-sidebar-toggle:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.28);
            border-color: rgba(255, 255, 255, 0.45);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .student-global-header .student-header-icon {
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 10px;
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(8px);
            font-size: 1.15rem;
            line-height: 1;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .student-global-header .student-header-icon:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.28);
            border-color: rgba(255, 255, 255, 0.45);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .student-global-header [data-live-clock] {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .student-global-header .student-header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff !important;
            text-decoration: none;
        }

        .student-global-header .student-header-user strong {
            color: #ffffff;
        }

        .student-global-header .student-header-user small {
            display: block;
            color: rgba(255, 255, 255, 0.72) !important;
        }

        .student-global-header .student-header-user b {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #5b21b6;
            background: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            font-weight: 700;
        }

    </style>

    @stack('styles')

</head>


<body>

    <div class="student-layout">


        {{-- =====================================================
         STUDENT SIDEBAR
    ====================================================== --}}

        <aside class="student-sidebar">


            {{-- =================================================
             LOGO
        ================================================== --}}

            <div class="student-logo">

                <a href="{{ route('student.dashboard') }}">

                    <img src="{{ asset('slas-logo.png') }}" alt="SLAS - Siem Reap University" class="student-logo-icon">

                    <div>

                        <div class="student-logo-title">
                            SLAS
                        </div>

                        <div class="student-logo-subtitle">
                            {{ __('Student Portal') }}
                        </div>

                    </div>

                </a>

            </div>



            {{-- =================================================
             NAVIGATION
        ================================================== --}}

            <nav class="student-nav">


                {{-- Attendance --}}

                <a href="{{ route('student.attendance') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.attendance') ? 'active' : '' }}">

                    <i class="bi bi-calendar-check"></i>

                    <span>{{ __('Attendance') }}</span>

                </a>


                {{-- Assignments --}}

                <a href="{{ route('student.assignments') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.assignments') ? 'active' : '' }}">

                    <i class="bi bi-journal-text"></i>

                    <span>{{ __('Assignments') }}</span>

                </a>


                {{-- Quizzes --}}

                <a href="{{ route('student.quizzes') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.quizzes') ? 'active' : '' }}">

                    <i class="bi bi-patch-question"></i>

                    <span>{{ __('Quizzes') }}</span>

                </a>


                {{-- Grades --}}

                <a href="{{ route('student.grades') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.grades') ? 'active' : '' }}">

                    <i class="bi bi-bar-chart-line"></i>

                    <span>{{ __('Grades') }}</span>

                </a>


                {{-- Analytics --}}

                <a href="{{ route('student.analytics') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.analytics') ? 'active' : '' }}">

                    <i class="bi bi-graph-up-arrow"></i>

                    <span>{{ __('Analytics') }}</span>

                </a>


                {{-- Courses --}}

                <a href="{{ route('student.courses') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.courses') ? 'active' : '' }}">

                    <i class="bi bi-book"></i>

                    <span>{{ __('Courses') }}</span>

                </a>


                {{-- Calendar --}}

                <a href="{{ route('student.calendar') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.calendar') ? 'active' : '' }}">

                    <i class="bi bi-calendar3"></i>

                    <span>{{ __('Calendar') }}</span>

                </a>


                {{-- Notifications --}}

                <a href="{{ route('student.notifications') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.notifications') ? 'active' : '' }}">

                    <i class="bi bi-bell"></i>

                    <span>{{ __('Notifications') }}</span>

                </a>


                {{-- Reports --}}

                <a href="{{ route('student.reports') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.reports') ? 'active' : '' }}">

                    <i class="bi bi-file-earmark-bar-graph"></i>

                    <span>{{ __('Reports') }}</span>

                </a>

                <a href="{{ route('student.settings') }}"
                    class="student-nav-link
                {{ request()->routeIs('student.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>{{ __('Settings') }}</span>
                </a>


            </nav>



        </aside>



        {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

        <main class="student-content">
            @include('components.student.header')
            @yield('content')
            @include('components.student.footer')

        </main>


    </div>


    <script>
        (function () {
            var toggle = document.getElementById('sidebarToggle');
            var layout = document.querySelector('.student-layout');
            if (!toggle || !layout) {
                return;
            }

            var isMobile = window.innerWidth <= 768;
            var saved = localStorage.getItem('slas-nav-collapsed');

            // On mobile screen, collapse by default unless user previously explicitly opened it
            if (saved === '1' || (isMobile && saved === null)) {
                layout.classList.add('nav-collapsed');
            }

            toggle.addEventListener('click', function () {
                var collapsed = layout.classList.toggle('nav-collapsed');
                try {
                    localStorage.setItem('slas-nav-collapsed', collapsed ? '1' : '0');
                } catch (e) {}
            });

            // Tap on content area on mobile closes open drawer
            var mainContent = document.querySelector('.student-content');
            if (mainContent) {
                mainContent.addEventListener('click', function (e) {
                    if (window.innerWidth <= 768 && !layout.classList.contains('nav-collapsed') && !e.target.closest('#sidebarToggle')) {
                        layout.classList.add('nav-collapsed');
                    }
                });
            }
        })();
    </script>
    @stack('scripts')

</body>

</html>
