@props(['title' => 'Dashboard', 'header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — Nhume</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Sidebar shell ─────────────────────────────────────── */
        .dash-sidebar {
            background: #062e14;
            border-right: 1px solid rgba(255,255,255,0.055);
            transition: width 0.24s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
            z-index: 40;
        }
        /* ── Nav items ─────────────────────────────────────────── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(255,255,255,0.48);
            text-decoration: none;
            transition: background 0.14s, color 0.14s;
            white-space: nowrap;
            position: relative;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.055);
            color: rgba(255,255,255,0.82);
        }
        .nav-item.active {
            background: rgba(107,198,48,0.1);
            color: #d4f09e;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: #6bc630;
        }
        .nav-icon {
            flex-shrink: 0;
            width: 18px;
            height: 18px;
            opacity: 0.7;
        }
        .nav-item.active .nav-icon { opacity: 1; }
        .nav-item:hover .nav-icon  { opacity: 0.9; }
        /* ── Section labels ────────────────────────────────────── */
        .nav-section {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.22);
            padding: 0 12px;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
        }
        /* ── Collapse tooltip ──────────────────────────────────── */
        .nav-tooltip {
            position: absolute;
            left: calc(100% + 12px);
            top: 50%; transform: translateY(-50%);
            background: #1a2a1f;
            color: rgba(255,255,255,0.88);
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 7px;
            border: 1px solid rgba(255,255,255,0.1);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.12s;
            z-index: 99;
        }
        .nav-item:hover .nav-tooltip { opacity: 1; }
        /* ── Stat cards ────────────────────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid #E9EAEC;
            border-radius: 14px;
            padding: 22px 24px 20px;
            transition: box-shadow 0.18s, transform 0.18s;
        }
        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            transform: translateY(-1px);
        }
        /* ── Activity item ─────────────────────────────────────── */
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #F0F1F0;
        }
        .activity-item:last-child { border-bottom: none; }
        /* ── User area ─────────────────────────────────────────── */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            cursor: default;
            transition: background 0.14s;
            white-space: nowrap;
            overflow: hidden;
        }
        .sidebar-user:hover { background: rgba(255,255,255,0.055); }
        /* ── Mobile overlay ────────────────────────────────────── */
        .mobile-overlay {
            position: fixed; inset: 0; z-index: 30;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(2px);
        }
        .mobile-sidebar {
            position: fixed; left: 0; top: 0; bottom: 0;
            width: 260px; z-index: 35;
        }
        /* ── Trust badge ───────────────────────────────────────── */
        .trust-verified      { background:#dcfce7; color:#15803d; }
        .trust-manually      { background:#dbeafe; color:#1d4ed8; }
        .trust-id-submitted  { background:#fef3c7; color:#b45309; }
        .trust-unverified    { background:#f3f4f6; color:#6b7280; }
    </style>
</head>
<body class="h-full font-sans antialiased" style="background:#F5F7F5;">

@php
    $user     = Auth::user();
    $role     = $user->role->value ?? 'sender';
    $isAdmin  = $role === 'admin';
    $isSender = $role === 'sender';
    $isDriver = $role === 'transport_partner';

    $navMain = match(true) {
        $isAdmin  => [
            ['href' => route('dashboard'), 'label' => 'Overview',   'icon' => 'home',    'route' => 'dashboard'],
            ['href' => '#',               'label' => 'Orders',      'icon' => 'package', 'route' => null],
            ['href' => '#',               'label' => 'Drivers',     'icon' => 'users',   'route' => null],
            ['href' => '#',               'label' => 'Journeys',    'icon' => 'map',     'route' => null],
        ],
        $isDriver => [
            ['href' => route('dashboard'), 'label' => 'Overview',   'icon' => 'home',    'route' => 'dashboard'],
            ['href' => '#',               'label' => 'My Journeys', 'icon' => 'map',     'route' => null],
            ['href' => '#',               'label' => 'Assigned',    'icon' => 'package', 'route' => null],
            ['href' => '#',               'label' => 'Earnings',    'icon' => 'dollar',  'route' => null],
        ],
        default   => [
            ['href' => route('dashboard'), 'label' => 'Overview',   'icon' => 'home',    'route' => 'dashboard'],
            ['href' => '#',               'label' => 'My Parcels',  'icon' => 'package', 'route' => null],
            ['href' => route('send'),     'label' => 'Send Parcel', 'icon' => 'plus',    'route' => 'send'],
            ['href' => '#',               'label' => 'Track',       'icon' => 'location','route' => null],
        ],
    };

    $navManage = $isAdmin ? [
        ['href' => '#', 'label' => 'Analytics', 'icon' => 'chart',   'route' => null],
        ['href' => '#', 'label' => 'Settings',  'icon' => 'settings','route' => null],
    ] : [
        ['href' => route('profile.edit'), 'label' => 'Settings', 'icon' => 'settings', 'route' => 'profile.edit'],
    ];
@endphp

<div x-data="{
    collapsed: localStorage.getItem('nhume-nav-collapsed') === 'true',
    mobileOpen: false,
    toggle() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('nhume-nav-collapsed', this.collapsed);
    }
}" class="flex h-full overflow-hidden">

    {{-- ───────────────── MOBILE OVERLAY ───────────────── --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="mobile-overlay lg:hidden"
         x-cloak></div>

    {{-- ───────────────── MOBILE SIDEBAR ───────────────── --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition-transform duration-200"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform duration-150"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="mobile-sidebar lg:hidden"
         style="background:#062e14;border-right:1px solid rgba(255,255,255,0.055);"
         x-cloak>
        @include('components.dashboard-sidenav', ['collapsed' => false, 'mobile' => true])
    </div>

    {{-- ───────────────── DESKTOP SIDEBAR ───────────────── --}}
    <aside class="dash-sidebar hidden lg:flex"
           :style="collapsed ? 'width:68px' : 'width:260px'">
        @include('components.dashboard-sidenav', ['collapsed' => false, 'mobile' => false])
    </aside>

    {{-- ───────────────── MAIN CONTENT ───────────────── --}}
    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="flex items-center gap-4 px-5 h-[88px] flex-shrink-0"
                style="background:#fff;border-bottom:1px solid #E9EAEC;">

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = true"
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Search --}}
            <div class="hidden sm:flex items-center gap-2.5 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 flex-1 max-w-xs">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-gray-400 flex-shrink-0">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" placeholder="Search…" class="bg-transparent border-0 p-0 text-sm text-gray-600 placeholder-gray-400 focus:ring-0 w-full outline-none">
            </div>

            <div class="ml-auto flex items-center gap-2">
                {{-- Notifications --}}
                <button class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-brand-green"></span>
                </button>

                {{-- User menu --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold text-white flex-shrink-0"
                             style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-semibold text-gray-800 leading-tight">{{ Str::limit($user->name, 18) }}</div>
                            <div class="text-[11px] text-gray-400 leading-tight">{{ ucfirst(str_replace('_', ' ', $role)) }}</div>
                        </div>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-gray-400">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         class="absolute right-0 mt-2 w-52 origin-top-right"
                         style="background:#fff;border:1px solid #E9EAEC;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.1);padding:6px;z-index:50;"
                         x-cloak>
                        <div class="px-3 py-2 mb-1" style="border-bottom:1px solid #F0F1F0;">
                            <div class="text-xs font-semibold text-gray-800">{{ $user->name }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">{{ $user->email }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</div>
</body>
</html>
