<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketLink - @yield('title', 'Farmer')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ink: #23302a;
            --ink-soft: #647266;
            --paper: #ffffff;
            --paper-tint: #f4faf5;
            --card: #ffffff;
            --line: #dfeee1;
            --sidebar: #eaf6ec;
            --leaf-dark: #245a2a;
            --leaf: #2f8f46;
            --leaf-hover: #256e37;
            --leaf-pale: #e2f4e5;
            --leaf-light: #8fc97c;
            --gold: #d99a2b;
            --gold-dark: #b47e1f;
            --gold-pale: #faecd2;
            --teal: #2e7d8c;
            --teal-pale: #dceef0;
            --brick: #b4472b;
            --brick-pale: #f7e1d9;
        }
        body { background: var(--paper-tint); color: var(--ink); font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Fraunces', serif; font-optical-sizing: auto; }
        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible {
            outline: 2px solid var(--gold-dark);
            outline-offset: 2px;
        }
        .field {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 0.5rem;
            padding: 0.55rem 0.9rem;
            background: #fff;
            color: var(--ink);
        }
        .field:focus { border-color: var(--leaf); box-shadow: 0 0 0 3px var(--leaf-pale); outline: none; }
        .btn-primary { background: var(--leaf); color: #fff; }
        .btn-primary:hover { background: var(--leaf-hover); }
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body class="antialiased">

    <div class="md:flex md:min-h-screen">

        {{-- Sidebar (desktop) --}}
        <aside class="hidden md:flex md:w-60 md:flex-col md:fixed md:inset-y-0 border-r" style="background: var(--sidebar); border-color: var(--line);">
            <div class="flex items-center px-6 h-20 border-b" style="border-color: var(--line);">
                <img src="{{ asset('images/marketlink-logo.png') }}" alt="MarketLink" class="h-10 w-auto">
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('farmer.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('farmer.dashboard') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9-7v14m-7-7h18" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('farmer.products.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('farmer.products.*') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Products
                </a>
                <a href="{{ route('farmer.orders.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('farmer.orders.*') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Orders
                </a>
                <a href="{{ route('farmer.reviews.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('farmer.reviews.*') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Reviews
                </a>
                <a href="{{ route('farmer.profile.edit') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('farmer.profile.*') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
                @php $farmerUnreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                <a href="{{ route('notifications.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition"
                   style="{{ request()->routeIs('notifications.*') ? 'background:#fff; color:var(--leaf-dark); box-shadow: 0 1px 2px rgba(36,90,42,0.12);' : 'color:var(--ink-soft);' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifications
                    @if($farmerUnreadCount > 0)
                        <span class="ml-auto text-xs font-bold rounded-full px-2 py-0.5" style="background:#b4472b; color:#fff;">{{ $farmerUnreadCount }}</span>
                    @endif
                </a>
            </nav>

            <div class="px-4 py-5 border-t" style="border-color: var(--line);">
                <div class="flex items-center gap-3 px-3 mb-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-display text-sm shrink-0"
                         style="background: var(--leaf-pale); color: var(--leaf-dark);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color: var(--ink);">{{ auth()->user()->name }}</p>
                        <p class="text-xs" style="color: var(--ink-soft);">Farmer</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium hover:bg-white/60 transition"
                            style="color: var(--brick);">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Topbar (mobile) --}}
        <div class="flex md:hidden items-center justify-between px-4 h-16 border-b" style="background: var(--sidebar); border-color: var(--line);">
            <img src="{{ asset('images/marketlink-logo.png') }}" alt="MarketLink" class="h-8 w-auto">
            <div class="flex items-center gap-3 overflow-x-auto">
                <a href="{{ route('farmer.dashboard') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('farmer.dashboard') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">Dashboard</a>
                <a href="{{ route('farmer.products.index') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('farmer.products.*') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">Products</a>
                <a href="{{ route('farmer.orders.index') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('farmer.orders.*') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">Orders</a>
                <a href="{{ route('farmer.reviews.index') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('farmer.reviews.*') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">Reviews</a>
                <a href="{{ route('farmer.profile.edit') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('farmer.profile.*') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">Profile</a>
                @php $farmerUnreadCountMobile = auth()->user()->unreadNotifications()->count(); @endphp
                <a href="{{ route('notifications.index') }}" class="text-xs font-medium px-2 py-1 rounded whitespace-nowrap" style="{{ request()->routeIs('notifications.*') ? 'background:#fff; color:var(--leaf-dark);' : 'color:var(--ink-soft);' }}">
                    Alerts
                    @if($farmerUnreadCountMobile > 0)
                        <span class="text-xs font-bold rounded-full px-1" style="background:#b4472b; color:#fff;">{{ $farmerUnreadCountMobile }}</span>
                    @endif
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0 ml-2">
                @csrf
                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full" style="color: var(--brick);" aria-label="Log out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Main --}}
        <main class="flex-1 md:ml-60">
            <div class="max-w-6xl mx-auto px-5 sm:px-8 py-8">

                @if(session('success'))
                    <div class="mb-6 px-5 py-4 rounded-lg text-sm font-medium" style="background: var(--leaf-pale); color: var(--leaf-dark); border: 1px solid var(--line);">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </main>
    </div>
</body>
</html>