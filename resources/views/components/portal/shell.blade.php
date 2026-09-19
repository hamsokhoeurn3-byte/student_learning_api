<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SLAS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .portal-layout {
            min-height: 100vh;
            display: flex;
            background: #f7f8ff;
        }

        .portal-sidebar {
            width: 258px;
            min-width: 258px;
            background: #fff;
            border-right: 1px solid #ebedf5;
            padding: 22px 14px;
            display: flex;
            flex-direction: column;
        }

        .portal-brand {
            padding: 0 8px 22px;
            border-bottom: 1px solid #f0f1f7;
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
            color: #0f766e;
            background: #e6f4f1;
        }

        .portal-nav a.active {
            color: #fff;
            background: linear-gradient(100deg, #14b8a6, #0f766e);
            box-shadow: 0 6px 14px rgba(15, 118, 110, .2);
        }

        .portal-nav i {
            font-size: 1rem;
            width: 18px;
        }

        .portal-user {
            margin-top: auto;
            border-radius: 14px;
            padding: 12px;
            background: #faf9ff;
        }

        .portal-avatar {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: #0f766e;
            background: #e6f4f1;
            overflow: hidden;
        }

        .portal-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            background: #fff;
        }

        .portal-logout {
            width: 100%;
            margin-top: 10px;
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

        .portal-search {
            width: min(340px, 45vw);
            border: 0;
            background: #f5f6fb;
            border-radius: 9px;
            padding: 9px 13px;
            font-size: .82rem;
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
                    <small>{{ $role }}</small>
                </span>
            </a>
            <nav class="portal-nav">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="{{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i class="bi bi-{{ $item['icon'] }}"></i><span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="portal-user d-flex align-items-center gap-2">
                <div class="portal-avatar">
                    @if (Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                            alt="{{ Auth::user()->name }}" />
                    @else
                        <i class="bi bi-person-fill"></i>
                    @endif
                </div>
                <div class="user-copy small"><strong
                        class="d-block text-truncate">{{ Auth::user()->name ?? $role }}</strong><span
                        class="text-muted">{{ $role }}</span></div>
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit" class="portal-logout"><i
                            class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </div>
        </aside>
        <section class="portal-main">
            <header class="portal-header">
                <input aria-label="Search" class="portal-search" placeholder="Search students, courses, reports...">
                <div class="d-flex align-items-center gap-3"><button class="btn btn-light rounded-circle"><i
                            class="bi bi-bell"></i></button>
                    <a href="{{ route($profileRoute) }}" class="portal-avatar portal-profile-link"
                        aria-label="Update profile" title="Update profile">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                alt="{{ Auth::user()->name }}" />
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif
                    </a>
                </div>
            </header>
            <main class="portal-content">@yield('content')</main>
            <footer class="portal-global-footer">
                <span>© {{ now()->year }} SLAS. All rights reserved.</span>
                <span class="d-none d-sm-inline">Student Learning Analytics System</span>
            </footer>
        </section>
    </div>
    @stack('scripts')
</body>

</html>
