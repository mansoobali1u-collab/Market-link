
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        MarketLink Admin - Users Management
    </title>

    <link
        rel="icon"
        href="{{ asset('icon.svg') }}"
    >


    <style>

        :root {
            --background: #f4f7f5;
            --line: #e3ebe6;
            --primary: #2e7d32;
            --primary-dark: #1b5e20;
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

            color: #2e3e35;
        }

        .app-shell {
            display: flex;

            min-height: 100vh;
        }

        

        .sidebar {
            width: 260px;

            background: #fff;

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

            color: #819088;

            letter-spacing: .5px;

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

        .logout-button {
            width: 100%;

            padding: 10px;

            border: 1px solid var(--line);

            border-radius: 8px;

            background: #fff;

            color: #50665a;

            cursor: pointer;
        }

        .support-card {
            background: #f8fafc;

            border: 1px solid var(--line);

            border-radius: 10px;

            padding: 14px;

            font-size: 12px;
        }

        .support-card p {
            color: #819088;
        }

        

        .main-content {
            flex: 1;

            display: flex;

            flex-direction: column;

            min-width: 0;
        }

        .topbar {
            height: 64px;

            background: #fff;

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

            color: #819088;
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
        }

        .page-wrap {
            padding: 28px;

            flex: 1;
        }

        .page-heading {
            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            margin-bottom: 24px;
        }

        .eyebrow {
            font-size: 10px;

            font-weight: 700;

            color: #819088;

            letter-spacing: .5px;

            margin: 0 0 4px;
        }

        .page-heading h1 {
            margin: 0;

            font-size: 24px;

            color: #1b2e25;
        }

        .heading-sub {
            margin: 4px 0 0;

            font-size: 13px;

            color: #63736b;
        }

        

        .mini-stats {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 16px;

            margin-bottom: 20px;
        }

        .mini-stats > div {
            background: #fff;

            border: 1px solid var(--line);

            border-radius: 10px;

            padding: 14px 16px;
        }

        .mini-stats strong {
            display: block;

            font-size: 18px;

            color: #1b2e25;
        }

        .mini-stats span {
            font-size: 11px;

            color: #819088;
        }

        

        .primary-button {
            background: var(--primary);

            color: #fff;

            border: none;

            padding: 8px 16px;

            border-radius: 8px;

            font-weight: 600;

            font-size: 12px;

            cursor: pointer;

            display: inline-flex;

            align-items: center;

            gap: 6px;
        }

        

        .table-panel {
            background: #fff;

            border: 1px solid var(--line);

            border-radius: 12px;

            overflow: hidden;
        }

        .toolbar {
            display: flex;

            gap: 10px;

            padding: 14px 18px;

            border-bottom: 1px solid var(--line);

            align-items: center;
        }

        .table-search {
            display: flex;

            align-items: center;

            gap: 8px;

            border: 1px solid var(--line);

            border-radius: 6px;

            padding: 4px 10px;

            flex: 1;

            max-width: 320px;
        }

        .table-search input {
            border: 0;

            outline: 0;

            font-size: 12px;

            width: 100%;
        }

        .toolbar select {
            border: 1px solid var(--line);

            border-radius: 6px;

            padding: 5px 10px;

            font-size: 12px;

            background: #fff;
        }

        table {
            width: 100%;

            border-collapse: collapse;
        }

        th {
            text-align: left;

            padding: 12px 18px;

            font-size: 11px;

            color: #819088;

            background: #f8fafc;

            border-bottom: 1px solid var(--line);
        }

        td {
            padding: 14px 18px;

            border-bottom: 1px solid #eef2ef;

            font-size: 12px;
        }

        .role-badge {
            display: inline-block;

            padding: 4px 10px;

            border-radius: 20px;

            font-size: 11px;

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

        .make-admin-button {
            margin-left: 8px;

            padding: 6px 10px;

            border: none;

            border-radius: 6px;

            background: #166534;

            color: white;

            cursor: pointer;

            font-size: 11px;
        }

        .make-admin-button:hover {
            background: #14532d;
        }

        .pagination {
            padding: 14px 18px;
        }

        @media (max-width: 1000px) {

            .mini-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                display: none;
            }

            .page-wrap {
                padding: 18px;
            }

            .mini-stats {
                grid-template-columns: 1fr;
            }

            .table-panel {
                overflow-x: auto;
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
                class="nav-item"
            >

                <i data-lucide="layout-dashboard"></i>

                <span>
                    Dashboard
                </span>

            </a>


            <a
                href="{{ route('admin.users.index') }}"
                class="nav-item active"
            >

                <i data-lucide="users"></i>

                <span>
                    Users Management
                </span>

            </a>


            <a
                href="{{ route('admin.markets.index') }}"
                class="nav-item"
            >

                <i data-lucide="map-pin"></i>

                <span>
                    Markets
                </span>

            </a>


            <a
                href="{{ route('admin.categories.index') }}"
                class="nav-item"
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

                <strong>
                    Need help?
                </strong>

                <p>
                    Open a ticket for the support team
                </p>

            </div>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main-content">


        <!-- TOPBAR -->

        <header class="topbar">

            <div class="breadcrumbs">

                <span>
                    Admin
                </span>

                <i data-lucide="chevron-right"></i>

                <strong>
                    Users Management
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


                <button
                    type="button"
                    style="border:none;background:none;cursor:pointer;"
                >

                    <i data-lucide="bell"></i>

                </button>


                <button class="profile-button">

                    <strong>
                        Admin
                    </strong>

                </button>

            </div>

        </header>


        <!-- PAGE -->

        <div class="page-wrap">


            <div class="page-heading">

                <div>

                    <p class="eyebrow">
                        {{ strtoupper(now()->format('l, F j, Y')) }}
                    </p>

                    <h1>
                        Users Management
                    </h1>

                    <p class="heading-sub">
                        Overview, search, and manage user privileges across the platform.
                    </p>

                </div>


            </div>


            @if (session('success'))
                <div style="margin-bottom:16px;padding:10px 14px;background:#dcfce7;color:#166534;border-radius:8px;font-size:13px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;color:#991b1b;border-radius:8px;font-size:13px;">
                    {{ session('error') }}
                </div>
            @endif


            <!-- STATISTICS -->

            <div class="mini-stats">

                <div>

                    <strong>
                        {{ $users->total() }}
                    </strong>

                    <span>
                        Total Users
                    </span>

                </div>


                <div>

                    <strong>
                        {{ $users->where('role', 'farmer')->count() }}
                    </strong>

                    <span>
                        Farmers
                    </span>

                </div>


                <div>

                    <strong>
                        {{ $users->where('role', 'user')->count() }}
                    </strong>

                    <span>
                        Regular Users
                    </span>

                </div>


                <div>

                    <strong>
                        {{ $users->where('role', 'admin')->count() }}
                    </strong>

                    <span>
                        Admins
                    </span>

                </div>

            </div>


            <!-- TABLE -->

            <div class="table-panel">


                <form
                    method="GET"
                    action="{{ route('admin.users.index') }}"
                    class="toolbar"
                >

                    <div class="table-search">

                        <i data-lucide="search"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search users..."
                        >

                    </div>


                    <select
                        name="role"
                        onchange="this.form.submit()"
                    >

                        <option
                            value=""
                            {{ request('role') == '' ? 'selected' : '' }}
                        >
                            All Roles
                        </option>


                        <option
                            value="admin"
                            {{ request('role') == 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>


                        <option
                            value="farmer"
                            {{ request('role') == 'farmer' ? 'selected' : '' }}
                        >
                            Farmer
                        </option>


                        <option
                            value="user"
                            {{ request('role') == 'user' ? 'selected' : '' }}
                        >
                            User
                        </option>

                    </select>


                    <button
                        type="submit"
                        class="primary-button"
                    >
                        Search
                    </button>

                </form>


                <table>

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Name
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Created
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>
                                    #{{ $user->id }}
                                </td>


                                <td>
                                    <strong>
                                        {{ $user->name }}
                                    </strong>
                                </td>


                                <td>
                                    {{ $user->email }}
                                </td>


                                <td>

                                    <span
                                        class="role-badge role-{{ strtolower($user->role) }}"
                                    >
                                        {{ ucfirst($user->role) }}
                                    </span>


                                    @if($user->role !== 'admin')

                                        <button
                                            type="button"
                                            class="make-admin-button"
                                            data-user-id="{{ $user->id }}"
                                        >
                                            Make Admin
                                        </button>

                                    @endif

                                </td>


                                <td>

                                    @if ($user->role === 'farmer')

                                        @if ($user->is_approved)
                                            <span class="role-badge role-user" style="background:#dcfce7;color:#166534;">Approved</span>
                                        @else
                                            <span class="role-badge role-user" style="background:#fef3c7;color:#92400e;">Pending</span>
                                        @endif

                                        <form method="POST" action="{{ route($user->is_approved ? 'admin.users.suspend' : 'admin.users.approve', $user) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="make-admin-button" style="background:{{ $user->is_approved ? '#991b1b' : '#166534' }};">
                                                {{ $user->is_approved ? 'Suspend' : 'Approve' }}
                                            </button>
                                        </form>

                                    @endif

                                    @if ($user->role !== 'admin')

                                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="make-admin-button" style="background:{{ $user->is_active ? '#334155' : '#166534' }};">
                                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                    @endif

                                    @if ($user->role === 'admin')
                                        <span style="color:#819088;">&mdash;</span>
                                    @endif

                                </td>


                                <td>

                                    {{ $user->created_at->format('M d, Y') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    style="text-align:center;padding:30px;"
                                >

                                    No users found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>


                <div class="pagination">

                    {{ $users->withQueryString()->links() }}

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


    

    const csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).content;


    const buttons =
        document.querySelectorAll(
            '.make-admin-button'
        );


    buttons.forEach(function(button) {

        button.addEventListener(
            'click',
            function() {

                const userId =
                    button.dataset.userId;


                const confirmed =
                    confirm(
                        'Are you sure you want to make this user an admin?'
                    );


                if (!confirmed) {
                    return;
                }


                fetch(
                    '/admin/users/' + userId + '/role',
                    {
                        method: 'PATCH',

                        headers: {
                            'Content-Type': 'application/json',

                            'Accept': 'application/json',

                            'X-CSRF-TOKEN': csrfToken
                        },

                        body: JSON.stringify({
                            role: 'admin'
                        })
                    }
                )

                .then(function(response) {

                    if (!response.ok) {
                        throw new Error(
                            'Request failed'
                        );
                    }

                    return response.json();

                })

                .then(function(data) {

                    if (data.error) {

                        alert(data.error);

                        return;
                    }


                    alert(
                        'User is now an admin.'
                    );


                    location.reload();

                })

                .catch(function(error) {

                    console.error(error);

                    alert(
                        'Something went wrong while updating the user.'
                    );

                });

            }
        );

    });

</script>

</body>
</html>
