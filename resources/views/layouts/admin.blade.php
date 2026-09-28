<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MarketLink Admin')</title>

    <link rel="icon" href="{{ asset('icon.svg') }}">

    <style>

        :root {
            --background: #f4f7f5;
            --line: #e3ebe6;
            --primary: #2e7d32;
            --primary-dark: #1b5e20;
            --orange: #e65100;
            --text: #2e3e35;
            --muted: #819088;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid var(--line);
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 24px;
        }

        .brand-mark {
            color: var(--primary);
        }

        .brand-name span {
            color: var(--primary);
        }

        .sidebar-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: 0.5px;
            margin: 16px 0 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #50665a;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .nav-item:hover,
        .nav-item.active {
            background: #e9f6ef;
            color: var(--primary);
        }

        .sidebar-bottom {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .support-card {
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 14px;
            font-size: 12px;
        }

        .support-card p {
            color: var(--muted);
            margin-bottom: 0;
        }

        .logout-button {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            color: #50665a;
            cursor: pointer;
            font-size: 13px;
        }

        .logout-button:hover {
            background: #f4f7f5;
        }

        /* Main */

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Topbar */

        .topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
        }

        .breadcrumbs {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .global-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f4f7f5;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 6px 12px;
        }

        .global-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 12px;
        }

        .profile-button {
            background: none;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 6px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .icon-button {
            background: transparent;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-decoration: none;
            color: inherit;
        }

        .icon-button .notif-dot {
            position: absolute;
            top: -3px;
            right: -3px;
            min-width: 15px;
            height: 15px;
            padding: 0 3px;
            border-radius: 50%;
            background: #e65100;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-menu {
            display: none;
        }

        /* Page */

        .page-wrap {
            padding: 28px;
            flex: 1;
        }

        /* Responsive */

        @media (max-width: 900px) {

            .sidebar {
                width: 220px;
            }

            .global-search {
                display: none;
            }

            .mobile-menu {
                display: inline-flex;
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                display: none;
            }

            .page-wrap {
                padding: 18px;
            }
        }

    </style>

    @stack('styles')

</head>

<body>

<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="brand">

            <span class="brand-mark">
                <i data-lucide="leaf"></i>
            </span>

            <span class="brand-name">
                Market<span>Link</span>
            </span>

        </div>

        <div class="sidebar-label">
            MAIN MENU
        </div>

        <nav>

            <a
                href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('admin.users.index') }}"
                class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
            >
                <i data-lucide="users"></i>
                <span>Users Management</span>
            </a>

            <a
                href="{{ route('admin.markets.index') }}"
                class="nav-item {{ request()->routeIs('admin.markets.*') ? 'active' : '' }}"
            >
                <i data-lucide="store"></i>
                <span>Markets Management</span>
            </a>

            <a
                href="{{ route('admin.categories.index') }}"
                class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
            >
                <i data-lucide="tag"></i>
                <span>Categories</span>
            </a>

            <a
                href="{{ route('admin.products.index') }}"
                class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
            >
                <i data-lucide="package"></i>
                <span>Products</span>
            </a>

            <a
                href="{{ route('notifications.index') }}"
                class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
            >
                <i data-lucide="bell"></i>
                <span>Notifications</span>
            </a>

        </nav>

        <div class="sidebar-bottom">

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>

            <div class="support-card">

                <div>
                    <i data-lucide="activity"></i>
                </div>

                <strong>
                    Need help?
                </strong>

                <p>
                    Open a ticket for the support team
                </p>

            </div>

        </div>

    </aside>


    {{-- MAIN CONTENT --}}
    <main class="main-content">

        {{-- TOPBAR --}}
        <header class="topbar">

            <button class="icon-button mobile-menu">
                <i data-lucide="menu"></i>
            </button>

            <div class="breadcrumbs">

                <span>
                    Admin
                </span>

                <i data-lucide="chevron-right"></i>

                <strong>
                    @yield('breadcrumb', 'Dashboard')
                </strong>

            </div>

            <div class="top-actions">

                <div class="global-search">

                    <i data-lucide="search"></i>

                    <input
                        type="text"
                        placeholder="Search anything..."
                    >

                </div>

                <a href="{{ route('notifications.index') }}" class="icon-button" title="Notifications">
                    <i data-lucide="bell"></i>
                    @php $adminUnreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                    @if($adminUnreadCount > 0)
                        <span class="notif-dot">{{ $adminUnreadCount }}</span>
                    @endif
                </a>

                <button class="profile-button">

                    <strong>
                        {{ auth()->user()->name ?? 'Admin' }}
                    </strong>

                    <i data-lucide="chevron-down"></i>

                </button>

            </div>

        </header>


        {{-- PAGE CONTENT --}}
        <div class="page-wrap">

            @yield('content')

        </div>

    </main>

</div>


<script src="https://unpkg.com/lucide@latest"></script>

<script>

    if (window.lucide) {
        lucide.createIcons();
    }

</script>

@stack('scripts')

</body>

</html>