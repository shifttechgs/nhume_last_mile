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
            background: #fff;
            border-right: 1px solid #E9EAEC;
            transition: width 0.24s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            flex-shrink: 0;
            display: none;            /* hidden on mobile; shown at lg via the query below */
            flex-direction: column;
            height: 100%;
            position: relative;
            z-index: 40;
        }
        /* Authoritative responsive toggle — the inline block loads after Tailwind,
           so `.dash-sidebar` would otherwise override the `hidden` utility. */
        @media (min-width: 1024px) { .dash-sidebar { display: flex; } }
        /* ── Nav items ─────────────────────────────────────────── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #475467;
            text-decoration: none;
            transition: background 0.14s, color 0.14s;
            white-space: nowrap;
            position: relative;
        }
        .nav-item:hover {
            background: #F6F7F9;
            color: #101828;
        }
        .nav-item.active {
            background: #EAF6DE;
            color: #357a12;
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
            color: #98A2B3;
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
        /* ── Top header bar ────────────────────────────────────── */
        .dash-header {
            height: 72px;
            padding: 0 24px;
            background: #fff;
            border-bottom: 1px solid #E9EAEC;
        }
        @media (max-width: 640px) {
            .dash-header { height: 64px; padding: 0 16px; }
        }
        /* ═══════════════════════════════════════════════════════
           Admin overview — "Stripe" design system
           Neutral ink scale + single green accent. No rainbow.
        ═══════════════════════════════════════════════════════ */
        .ov { --ink:#101828; --body:#475467; --muted:#8A9099; --line:#E9EAEC;
              --acc:#5aad28; --acc-2:#6bc630; --canvas:#F6F7F9; }
        .ov-title { font-size:20px; font-weight:600; letter-spacing:-0.02em; color:var(--ink); }
        .ov-sub   { font-size:13px; color:var(--muted); margin-top:2px; }
        .ov-chip  { display:inline-flex; align-items:center; gap:7px; font-size:12px; font-weight:500;
                    color:var(--body); background:#fff; border:1px solid var(--line);
                    border-radius:8px; padding:7px 12px; }
        .ov-chip .dot { width:6px; height:6px; border-radius:50%; background:var(--acc-2); }

        /* card shell */
        .d-card { background:#fff; border:1px solid var(--line); border-radius:8px; }
        .d-card-head { display:flex; align-items:center; justify-content:space-between;
                       padding:16px 18px; border-bottom:1px solid #F2F4F7; }
        .d-h { font-size:13.5px; font-weight:600; color:var(--ink); letter-spacing:-0.01em; }
        .d-link { font-size:12.5px; font-weight:500; color:var(--acc); text-decoration:none; }
        .d-link:hover { color:var(--acc-2); }

        /* KPI card */
        .kpi { background:#fff; border:1px solid var(--line); border-radius:8px; padding:16px 18px;
               display:flex; flex-direction:column; gap:10px; }
        .kpi-label { font-size:11px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:var(--muted); }
        .kpi-num { font-size:30px; font-weight:600; letter-spacing:-0.02em; color:var(--ink);
                   line-height:1; font-variant-numeric:tabular-nums; }
        .kpi-foot { display:flex; align-items:center; justify-content:space-between; gap:8px; min-height:16px; }
        .kpi-sub { font-size:12px; color:var(--muted); }
        .kpi-delta { display:inline-flex; align-items:center; gap:3px; font-size:12px; font-weight:600; font-variant-numeric:tabular-nums; }
        .kpi-delta.up   { color:var(--acc); }
        .kpi-delta.down { color:#98A2B3; }
        .kpi-delta.flat { color:#98A2B3; }

        /* honest proportion mini-bar */
        .mini-bar { height:5px; border-radius:3px; background:#EEF0F3; overflow:hidden; }
        .mini-bar > span { display:block; height:100%; border-radius:3px; background:var(--acc); }

        /* structured table */
        .d-table { width:100%; border-collapse:collapse; }
        .d-table th { text-align:left; font-size:10.5px; font-weight:600; letter-spacing:0.05em;
                      text-transform:uppercase; color:var(--muted); padding:10px 18px; border-bottom:1px solid #F2F4F7; }
        .d-table td { padding:13px 18px; border-bottom:1px solid #F5F6F8; font-size:13px; color:var(--body); vertical-align:middle; }
        .d-table tr:last-child td { border-bottom:none; }
        .d-table tbody tr { transition:background 0.12s; }
        .d-table tbody tr:hover { background:#FAFBFC; }
        .d-mono { font-family:ui-monospace,'SF Mono',Menlo,monospace; font-size:12px; font-weight:600; color:var(--ink); white-space:nowrap; }
        .d-route { display:inline-flex; align-items:center; gap:7px; color:var(--body); white-space:nowrap; }
        .d-route .arr { color:#C6CBD3; }
        .d-cust { color:var(--body); }
        .d-time { color:var(--muted); font-size:12px; font-variant-numeric:tabular-nums; }
        .d-chev { color:#C6CBD3; opacity:0; transition:opacity 0.12s, color 0.12s; }
        .d-table tbody tr:hover .d-chev { opacity:1; }
        .d-chev:hover { color:var(--body); }

        /* card footer + pagination */
        .d-card-foot { display:flex; align-items:center; justify-content:space-between; gap:12px;
                       padding:12px 18px; border-top:1px solid #F2F4F7; }
        .d-pageinfo { font-size:12.5px; color:var(--muted); font-variant-numeric:tabular-nums; }
        .d-pageinfo b { color:var(--body); font-weight:600; }
        .d-pg { display:flex; align-items:center; gap:6px; }
        .d-pgbtn { display:inline-flex; align-items:center; gap:5px; font-size:12.5px; font-weight:500;
                   color:#344054; background:#fff; border:1px solid var(--line); border-radius:8px;
                   padding:6px 11px; text-decoration:none; transition:background 0.12s, border-color 0.12s, color 0.12s; }
        .d-pgbtn:hover { background:#F6F7F9; border-color:#D0D5DD; }
        .d-pgbtn.is-disabled { color:#CBD0D8; background:#fff; border-color:#EEF0F3; pointer-events:none; }

        /* single muted status pill (neutral bg + small tinted dot) */
        .st-pill { display:inline-flex; align-items:center; gap:6px; font-size:11.5px; font-weight:500;
                   color:#344054; background:#F2F4F7; border-radius:6px; padding:3px 9px; white-space:nowrap; }
        .st-pill .st-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }

        /* quick action rows — monochrome */
        .qa-row { display:flex; align-items:center; gap:11px; padding:9px 10px; border-radius:9px;
                  font-size:13.5px; font-weight:500; color:#344054; text-decoration:none; transition:background 0.12s; }
        .qa-row:hover { background:#F6F7F9; }
        .qa-ic { width:30px; height:30px; border-radius:8px; background:#F2F4F7; color:#475467;
                 display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .qa-row:hover .qa-ic { background:#EAF6DE; color:var(--acc); }
        .qa-count { margin-left:auto; font-size:11.5px; font-weight:600; color:var(--body);
                    background:#F2F4F7; border-radius:20px; padding:1px 8px; font-variant-numeric:tabular-nums; }

        /* trust breakdown — one green→gray hue family */
        .trust-stack { display:flex; height:8px; border-radius:5px; overflow:hidden; background:#EEF0F3; }
        .trust-stack > span { height:100%; }
        .trust-row { display:flex; align-items:center; gap:9px; font-size:12.5px; }
        .trust-key { width:9px; height:9px; border-radius:3px; flex-shrink:0; }
        .trust-name { color:var(--body); }
        .trust-val { margin-left:auto; font-weight:600; color:var(--ink); font-variant-numeric:tabular-nums; }

        /* ── Stat cards ────────────────────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid #E9EAEC;
            border-radius: 8px;
            padding: 22px 24px 20px;
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
        .sidebar-user:hover { background: #F6F7F9; }
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
        @keyframes spin { to { transform: rotate(360deg); } }
        .form-spinner { animation: spin 0.7s linear infinite; flex-shrink: 0; }
    </style>
</head>
<body class="h-full font-sans antialiased" style="background:#F6F7F9;">

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
            ['href' => route('send'),     'label' => 'Book an errand', 'icon' => 'plus', 'route' => 'send'],
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
         style="background:#fff;border-right:1px solid #E9EAEC;"
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
        <header class="dash-header flex items-center gap-4 flex-shrink-0">

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
                    <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full" style="background:#6bc630;"></span>
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
