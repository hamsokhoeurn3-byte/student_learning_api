<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SLAS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: 'Kantumruy Pro', Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .portal-layout {
            min-height: 100vh;
            display: flex;
            background: #f7f8ff;
        }

        .portal-sidebar {
            width: 260px;
            min-width: 260px;
            background: linear-gradient(180deg, #f5f3ff 0%, #ede9fe 100%);
            border-right: 1px solid #ddd6fe;
            padding: 28px 14px 14px;
            display: flex;
            flex-direction: column;
        }

        .portal-brand {
            padding: 0 8px 22px;
            border-bottom: 1px solid #ddd6fe;
            color: #17203a;
            text-decoration: none;
        }

        .portal-brand-logo {
            width: 52px;
            height: 52px;
            object-fit: contain;
            object-position: center;
            border-radius: 12px;
            background: #f1ebff;
        }

        .portal-brand small {
            color: #7d8597;
            font-size: .64rem;
            letter-spacing: .06em;
            white-space: nowrap;
        }

        .portal-nav {
            padding-top: 18px;
        }

        .portal-nav a {
            color: #566075;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 4px;
            display: flex;
            gap: 12px;
            align-items: center;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 600;
        }

        .portal-nav a:hover {
            color: #6d28d9;
            background: #f1ebff;
        }

        .portal-nav a.active {
            color: #fff;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            box-shadow: 0 6px 14px rgba(91, 33, 182, .2);
        }

        .portal-nav i {
            font-size: 1rem;
            width: 18px;
        }

        .portal-user {
            margin-top: auto;
            border-radius: 16px;
            padding: 14px;
            background: #f8f9fa;
        }

        .portal-avatar {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #6d28d9;
            background: #dbeafe;
            overflow: hidden;
        }

        .portal-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            background: #fff;
        }

        .portal-profile-menu {
            position: relative;
        }

        .portal-profile-menu > summary {
            cursor: pointer;
            list-style: none;
        }

        .portal-profile-menu > summary::-webkit-details-marker {
            display: none;
        }

        .portal-account-menu {
            position: absolute;
            z-index: 50;
            top: calc(100% + 12px);
            right: 0;
            width: min(320px, calc(100vw - 32px));
            padding: 18px;
            border: 1px solid #e4e7ec;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 16px 40px rgba(16, 24, 40, .16);
        }

        .portal-account-avatar {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 50%;
            color: #6d28d9;
            background: #ede7ff;
        }

        .portal-account-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .portal-logout {
            width: 100%;
            margin-top: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 10px;
            color: #b42318;
            background: #fff;
            font-size: .82rem;
            font-weight: 600;
        }

        .portal-logout:hover {
            color: #fff;
            background: #b42318;
            border-color: #b42318;
        }

        .portal-main {
            flex: 1;
            min-width: 0;
        }

        .portal-header {
            height: 70px;
            background: rgba(255, 255, 255, .9);
            border-bottom: 1px solid #ebedf5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .portal-sidebar-toggle {
            width: 42px;
            height: 42px;
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
        .portal-layout.nav-collapsed .portal-sidebar {
            display: none;
        }

        .portal-content {
            padding: 28px 30px 36px;
        }

        @media (max-width: 768px) {
            .portal-sidebar {
                width: 68px;
                min-width: 68px;
                padding: 16px 8px;
            }

            .portal-brand span,
            .portal-brand small,
            .portal-nav span,
            .portal-user .user-copy {
                display: none;
            }

            .portal-brand {
                padding-left: 7px;
            }

            .portal-brand-logo {
                width: 38px;
                height: 38px;
                border-radius: 10px;
            }

            .portal-nav a {
                justify-content: center;
                padding: 11px;
            }

            .portal-nav i {
                width: auto;
            }

            .portal-header {
                padding: 0 16px;
            }

            .portal-content {
                padding: 20px 16px;
            }
        }

        /* =====================================================
           PURPLE BRAND HEADER THEME
        ===================================================== */

        .portal-header {
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 4px 20px rgba(91, 33, 182, 0.18);
            color: #ffffff;
        }

        .portal-header .portal-sidebar-toggle {
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #ffffff;
            background: rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(8px);
        }

        .portal-header .portal-sidebar-toggle:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.28);
            border-color: rgba(255, 255, 255, 0.45);
        }

        .portal-header [data-live-clock] {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .portal-header .portal-profile-link {
            border: 2px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

    </style>
    @stack('styles')
</head>

<body>
    <div class="portal-layout">
        <aside class="portal-sidebar">
            <a href="{{ route($homeRoute) }}" class="portal-brand d-flex align-items-center gap-2">
                <img src="{{ asset('slas-logo.png') }}" alt="SLAS - Siem Reap University" class="portal-brand-logo">
                <span>
                    <strong class="d-block lh-1">SLAS</strong>
                    <small>{{ __($role) }}</small>
                </span>
            </a>
            <nav class="portal-nav">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i class="bi bi-{{ $item['icon'] }}"></i><span>{{ __($item['label']) }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>
        <section class="portal-main">
            <header class="portal-header justify-content-between">
                <button type="button" class="portal-sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation menu" title="Show/hide navigation">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <x-language-switcher />
                    <time class="d-none d-md-inline small text-muted text-nowrap" data-live-clock datetime="{{ now()->toIso8601String() }}" aria-label="Local date and time"><i class="bi bi-calendar3 me-1"></i>{{ now()->format('M d, Y h:i:s A') }}</time>
                    @php
                        $currentUser = Auth::user();
                        $notificationsRoute = match ($currentUser->role ?? '') {
                            'admin' => 'admin.notifications',
                            'teacher' => 'teacher.notifications',
                            default => 'student.notifications',
                        };
                        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                        $accountIdentifier = match ($currentUser->role) {
                            'student' => $currentUser->student?->student_id,
                            'teacher' => $currentUser->teacher?->teacher_id,
                            'admin' => $currentUser->admin?->admin_id,
                            default => null,
                        };
                    @endphp
                    <a href="{{ route($notificationsRoute) }}" class="portal-sidebar-toggle position-relative text-decoration-none" title="Notifications" aria-label="Notifications">
                        <i class="bi bi-bell"></i>
                        @if($unreadCount > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>@endif
                    </a>
                    <details class="portal-profile-menu">
                        <summary class="portal-avatar portal-profile-link" aria-label="Open account details" title="Account details">
                            @if ($currentUser->profile_picture_url)
                                <img src="{{ $currentUser->profile_picture_url }}" alt="{{ $currentUser->name }}" />
                            @else
                                <i class="bi bi-person-fill"></i>
                            @endif
                        </summary>
                        <div class="portal-account-menu">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="portal-account-avatar">
                                    @if($currentUser->profile_picture_url)
                                        <img src="{{ $currentUser->profile_picture_url }}" alt="{{ $currentUser->name }}">
                                    @else
                                        <i class="bi bi-person-fill fs-4"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <strong class="d-block text-truncate">{{ $currentUser->name }}</strong>
                                    <span class="small text-muted text-truncate d-block">{{ $currentUser->email }}</span>
                                </div>
                            </div>
                            <div class="small text-muted border-top pt-3 mb-3">{{ __(ucfirst($currentUser->role)) }}{{ $accountIdentifier ? ' ID: ' . $accountIdentifier : '' }}</div>
                            <a class="btn btn-outline-primary w-100 mb-2" href="{{ route($profileRoute) }}"><i class="bi bi-person-gear me-2"></i>{{ __('My Account') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-danger w-100" type="submit"><i class="bi bi-box-arrow-right me-2"></i>{{ __('Sign out') }}</button>
                            </form>
                        </div>
                    </details>
                </div>
            </header>
            <main class="portal-content">@yield('content')</main>
            <footer class="portal-global-footer">
                <span>© {{ now()->year }} SLAS. All rights reserved.</span>
                <span class="d-none d-sm-inline">Student Learning Analytics System</span>
            </footer>
        </section>
    </div>
    <script>
        (function () {
            var toggle = document.getElementById('sidebarToggle');
            var layout = document.querySelector('.portal-layout');
            if (!toggle || !layout) {
                return;
            }

            var isMobile = window.innerWidth <= 768;
            var saved = localStorage.getItem('slas-nav-collapsed');

            if (saved === '1' || (isMobile && saved === null)) {
                layout.classList.add('nav-collapsed');
            }

            toggle.addEventListener('click', function () {
                var collapsed = layout.classList.toggle('nav-collapsed');
                try {
                    localStorage.setItem('slas-nav-collapsed', collapsed ? '1' : '0');
                } catch (e) {}
            });

            var mainContent = document.querySelector('.portal-main');
            if (mainContent) {
                mainContent.addEventListener('click', function (e) {
                    if (window.innerWidth <= 576 && !layout.classList.contains('nav-collapsed') && !e.target.closest('#sidebarToggle')) {
                        layout.classList.add('nav-collapsed');
                    }
                });
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>
