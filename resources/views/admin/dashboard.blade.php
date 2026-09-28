<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MarketLink Admin Dashboard</title>

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
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                sans-serif;

            background: var(--background);
            color: var(--text);
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        

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

        

        .main-content {
            flex: 1;

            display: flex;
            flex-direction: column;

            min-width: 0;
        }

        

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
        }

        .mobile-menu {
            display: none;
        }

        

        .page-wrap {
            padding: 28px;

            flex: 1;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .eyebrow {
            font-size: 10px;

            font-weight: 700;

            color: var(--muted);

            letter-spacing: 0.5px;

            margin: 0 0 4px;
        }

        .page-heading h1 {
            margin: 0;

            font-size: 28px;

            color: #1b2e25;
        }

        .heading-sub {
            margin: 6px 0 0;

            font-size: 13px;

            color: #63736b;
        }

        

        .stats-grid {
            display: grid;

            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));

            gap: 16px;

            margin-bottom: 24px;
        }

        .stat-card {
            background: #ffffff;

            border: 1px solid var(--line);

            border-radius: 12px;

            padding: 20px;

            display: flex;

            align-items: center;

            gap: 14px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #e9f6ef;

            color: var(--primary);
        }

        .stat-card strong {
            display: block;

            font-size: 24px;

            color: #1b2e25;
        }

        .stat-card span {
            display: block;

            margin-top: 3px;

            font-size: 12px;

            color: var(--muted);
        }

        

        .dashboard-grid {
            display: grid;

            grid-template-columns: 2fr 1fr;

            gap: 20px;
        }

        .panel {
            background: #ffffff;

            border: 1px solid var(--line);

            border-radius: 12px;

            overflow: hidden;
        }

        .panel-header {
            padding: 18px;

            border-bottom: 1px solid var(--line);

            display: flex;

            align-items: center;

            justify-content: space-between;
        }

        .panel-header h2 {
            margin: 0;

            font-size: 15px;

            color: #1b2e25;
        }

        .panel-header a {
            font-size: 12px;

            color: var(--primary);

            text-decoration: none;

            font-weight: 600;
        }

        .panel-body {
            padding: 18px;
        }

        

        .user-row {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 13px 0;

            border-bottom: 1px solid #eef2ef;
        }

        .user-row:last-child {
            border-bottom: none;
        }

        .user-info strong {
            display: block;

            font-size: 13px;

            color: #1b2e25;
        }

        .user-info span {
            display: block;

            margin-top: 3px;

            font-size: 11px;

            color: var(--muted);
        }

        .role-badge {
            display: inline-block;

            padding: 4px 10px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;
        }

        .role-admin {
            background: #fee2e2;
            color: #991b1b;
        }

        .role-farmer {
            background: #dcfce7;
            color: #166534;
        }

        .role-user {
            background: #dbeafe;
            color: #1e40af;
        }

        

        .quick-action {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px;

            margin-bottom: 10px;

            background: #f8fafc;

            border: 1px solid var(--line);

            border-radius: 8px;

            text-decoration: none;

            color: #2e3e35;
        }

        .quick-action:hover {
            background: #e9f6ef;
        }

        .quick-action-icon {
            color: var(--primary);
        }

        .quick-action strong {
            display: block;

            font-size: 12px;
        }

        .quick-action span {
            display: block;

            font-size: 10px;

            color: var(--muted);

            margin-top: 2px;
        }

        

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

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

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>

<body>

<div class="app-shell">

    <!-- SIDEBAR -->

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

                <span>
                    Dashboard
                </span>

            </a>


            <a
                href="{{ route('admin.users.index') }}"
                class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
            >

                <i data-lucide="users"></i>

                <span>
                    Users Management
                </span>

            </a>


            <a
                href="{{ route('admin.markets.index') }}"
                class="nav-item {{ request()->routeIs('admin.markets.*') ? 'active' : '' }}"
            >

                <i data-lucide="store"></i>

                <span>
                    Markets Management
                </span>

            </a>


            <a
                href="{{ route('admin.categories.index') }}"
                class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
            >

                <i data-lucide="tag"></i>

                <span>
                    Categories
                </span>

            </a>

        </nav>


        <div class="sidebar-bottom">

            <form
                action="{{ route('admin.logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >
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


    <!-- MAIN CONTENT -->

    <main class="main-content">


        <!-- TOPBAR -->

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
                    Dashboard
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


                <button class="icon-button">

                    <i data-lucide="bell"></i>

                </button>


                <button class="profile-button">

                    <strong>
                        Admin
                    </strong>

                    <i data-lucide="chevron-down"></i>

                </button>

            </div>

        </header>


        <!-- PAGE -->

        <div class="page-wrap">


            <div class="page-heading">

                <p class="eyebrow">
                    {{ strtoupper(now()->format('l, F j, Y')) }}
                </p>

                <h1>
                    Admin Dashboard
                </h1>

                <p class="heading-sub">
                    Overview of your MarketLink platform.
                </p>

            </div>


            <!-- STATISTICS -->

            <div class="stats-grid">


                <!-- FARMERS -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i data-lucide="tractor"></i>

                    </div>

                    <div>

                        <strong>
                            {{ $totalFarmers }}
                        </strong>

                        <span>
                            Farmers
                        </span>

                    </div>

                </div>


                <!-- REGULAR USERS -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i data-lucide="user"></i>

                    </div>

                    <div>

                        <strong>
                            {{ $totalRegularUsers }}
                        </strong>

                        <span>
                            Regular Users
                        </span>

                    </div>

                </div>


                <!-- ADMINS -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i data-lucide="shield-check"></i>

                    </div>

                    <div>

                        <strong>
                            {{ $totalAdmins }}
                        </strong>

                        <span>
                            Administrators
                        </span>

                    </div>

                </div>


                <!-- MARKETS -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i data-lucide="store"></i>

                    </div>

                    <div>

                        <strong>
                            {{ $totalMarkets }}
                        </strong>

                        <span>
                            Markets
                        </span>

                    </div>

                </div>


                <!-- ORDERS -->

                <div class="stat-card">

                    <div class="stat-icon">

                        <i data-lucide="shopping-cart"></i>

                    </div>

                    <div>

                        <strong>
                            {{ $totalOrders }}
                        </strong>

                        <span>
                            Orders
                        </span>

                    </div>

                </div>


            </div>


            <!-- DASHBOARD CONTENT -->

            <div class="dashboard-grid">


                <!-- RECENT USERS -->

                <div class="panel">

                    <div class="panel-header">

                        <h2>
                            Recent Users
                        </h2>

                        <a href="{{ route('admin.users.index') }}">
                            View All
                        </a>

                    </div>


                    <div class="panel-body">

                        @forelse($recentUsers as $user)

                            <div class="user-row">

                                <div class="user-info">

                                    <strong>
                                        {{ $user->name }}
                                    </strong>

                                    <span>
                                        {{ $user->email }}
                                    </span>

                                </div>


                                <span
                                    class="role-badge role-{{ strtolower($user->role) }}"
                                >
                                    {{ ucfirst($user->role) }}
                                </span>

                            </div>

                        @empty

                            <p style="color:#819088; font-size:13px;">
                                No users found.
                            </p>

                        @endforelse

                    </div>

                </div>


                <!-- QUICK ACTIONS -->

                <div class="panel">

                    <div class="panel-header">

                        <h2>
                            Quick Actions
                        </h2>

                    </div>


                    <div class="panel-body">


                        <a
                            href="{{ route('admin.users.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i data-lucide="users"></i>

                            </div>

                            <div>

                                <strong>
                                    Manage Users
                                </strong>

                                <span>
                                    View and manage all users
                                </span>

                            </div>

                        </a>


                        <a
                            href="{{ route('admin.markets.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i data-lucide="store"></i>

                            </div>

                            <div>

                                <strong>
                                    Manage Markets
                                </strong>

                                <span>
                                    Add or edit farmers markets
                                </span>

                            </div>

                        </a>


                        <a
                            href="{{ route('admin.users.index') }}"
                            class="quick-action"
                        >

                            <div class="quick-action-icon">

                                <i data-lucide="search"></i>

                            </div>

                            <div>

                                <strong>
                                    Search Users
                                </strong>

                                <span>
                                    Find users quickly
                                </span>

                            </div>

                        </a>


                    </div>

                </div>


            </div>


        </div>

    </main>

</div>


<script src="https://unpkg.com/lucide@latest"></script>

<script>

    if (window.lucide) {
        lucide.createIcons();
    }

</script>

</body>

</html>
