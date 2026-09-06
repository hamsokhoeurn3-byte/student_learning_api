<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - SLAS
    </title>

    {{-- Bootstrap --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

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
            background: #f8f9fc;
            font-family:
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

            background: #ffffff;

            border-right: 1px solid #e5e7eb;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            position: relative;

            z-index: 1000;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .student-logo {

            padding: 28px 20px;

            border-bottom: 1px solid #e5e7eb;

            flex-shrink: 0;
        }

        .student-logo a {

            text-decoration: none;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .student-logo-icon {

            width: 46px;
            height: 46px;

            border-radius: 10px;

            background: #0d6efd;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 22px;

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

            color: #0d6efd;

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

            background: #f0f6ff;

            color: #0d6efd;
        }


        /* Active */

        .student-nav-link.active {

            background: #0d6efd;

            color: #ffffff;

            font-weight: 600;
        }

        .student-nav-link.active:hover {

            background: #0b5ed7;

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

            color: #0d6efd;

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


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .student-content {

            flex: 1;

            min-width: 0;

            height: 100vh;

            overflow-y: auto;

            overflow-x: hidden;

            background: #f8f9fc;
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

            .student-sidebar {

                width: 220px;

                min-width: 220px;
            }

            .student-logo {

                padding: 20px 14px;
            }

            .student-nav {

                padding: 12px 8px;
            }

            .student-nav-link {

                font-size: 14px;

                padding: 10px 10px;
            }
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

                <div class="student-logo-icon">

                    <i class="bi bi-mortarboard-fill"></i>

                </div>

                <div>

                    <div class="student-logo-title">
                        SLAS
                    </div>

                    <div class="student-logo-subtitle">
                        Student Portal
                    </div>

                </div>

            </a>

        </div>



        {{-- =================================================
             NAVIGATION
        ================================================== --}}

        <nav class="student-nav">


            {{-- Dashboard --}}

            <a
                href="{{ route('student.dashboard') }}"
                class="student-nav-link
                {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
            >

                <i class="bi bi-grid-1x2-fill"></i>

                <span>Dashboard</span>

            </a>


            {{-- Profile --}}

            <a
                href="{{ route('student.profile') }}"
                class="student-nav-link
                {{ request()->routeIs('student.profile') ? 'active' : '' }}"
            >

                <i class="bi bi-person-circle"></i>

                <span>Profile</span>

            </a>


            {{-- Attendance --}}

            <a
                href="{{ route('student.attendance') }}"
                class="student-nav-link
                {{ request()->routeIs('student.attendance') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar-check"></i>

                <span>Attendance</span>

            </a>


            {{-- Assignments --}}

            <a
                href="{{ route('student.assignments') }}"
                class="student-nav-link
                {{ request()->routeIs('student.assignments') ? 'active' : '' }}"
            >

                <i class="bi bi-journal-text"></i>

                <span>Assignments</span>

            </a>


            {{-- Quizzes --}}

            <a
                href="{{ route('student.quizzes') }}"
                class="student-nav-link
                {{ request()->routeIs('student.quizzes') ? 'active' : '' }}"
            >

                <i class="bi bi-patch-question"></i>

                <span>Quizzes</span>

            </a>


            {{-- Grades --}}

            <a
                href="{{ route('student.grades') }}"
                class="student-nav-link
                {{ request()->routeIs('student.grades') ? 'active' : '' }}"
            >

                <i class="bi bi-bar-chart-line"></i>

                <span>Grades</span>

            </a>


            {{-- Analytics --}}

            <a
                href="{{ route('student.analytics') }}"
                class="student-nav-link
                {{ request()->routeIs('student.analytics') ? 'active' : '' }}"
            >

                <i class="bi bi-graph-up-arrow"></i>

                <span>Analytics</span>

            </a>


            {{-- Courses --}}

            <a
                href="{{ route('student.courses') }}"
                class="student-nav-link
                {{ request()->routeIs('student.courses') ? 'active' : '' }}"
            >

                <i class="bi bi-book"></i>

                <span>Courses</span>

            </a>


            {{-- Calendar --}}

            <a
                href="{{ route('student.calendar') }}"
                class="student-nav-link
                {{ request()->routeIs('student.calendar') ? 'active' : '' }}"
            >

                <i class="bi bi-calendar3"></i>

                <span>Calendar</span>

            </a>


            {{-- Notifications --}}

            <a
                href="{{ route('student.notifications') }}"
                class="student-nav-link
                {{ request()->routeIs('student.notifications') ? 'active' : '' }}"
            >

                <i class="bi bi-bell"></i>

                <span>Notifications</span>

            </a>


            {{-- Reports --}}

            <a
                href="{{ route('student.reports') }}"
                class="student-nav-link
                {{ request()->routeIs('student.reports') ? 'active' : '' }}"
            >

                <i class="bi bi-file-earmark-bar-graph"></i>

                <span>Reports</span>

            </a>


        </nav>



        {{-- =================================================
             USER CARD
        ================================================== --}}

        <div class="student-user-section">

            <div class="student-user-card">


                <div class="student-user-icon">

                    <i class="bi bi-person-fill"></i>

                </div>


                <div class="student-user-info">

                    <div class="student-user-name">

                        {{ Auth::user()->name ?? 'Student' }}

                    </div>

                    <div class="student-user-role">

                        Student Portal

                    </div>

                </div>


            </div>

        </div>


    </aside>



    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="student-content">

        @yield('content')

    </main>


</div>


@stack('scripts')

</body>

</html>