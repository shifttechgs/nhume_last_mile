{{--
  Renders inside both the desktop sidebar (AlpineJS collapsed binding)
  and the mobile drawer (always expanded).
  Variables available: $collapsed (bool, desktop only), $mobile (bool)
--}}

@php
    $user    = Auth::user();
    $role    = $user->role->value ?? 'sender';
    $isAdmin = $role === 'admin';
    $isSender = $role === 'sender';
    $isDriver = $role === 'transport_partner';

    $navMain = match(true) {
        $isAdmin  => [
            ['href' => route('dashboard'),             'label' => 'Overview',  'icon' => 'home',     'route' => 'dashboard'],
            ['href' => route('admin.orders.index'),    'label' => 'Orders',    'icon' => 'package',  'route' => 'admin.orders.*'],
            ['href' => route('admin.customers.index'), 'label' => 'Customers', 'icon' => 'users',    'route' => 'admin.customers.*'],
            ['href' => route('admin.drivers.index'),   'label' => 'Drivers',   'icon' => 'truck',    'route' => 'admin.drivers.*'],
            ['href' => route('admin.routes.index'),    'label' => 'Routes',    'icon' => 'map',      'route' => 'admin.routes.*'],
        ],
        $isDriver => [
            ['href' => route('dashboard'), 'label' => 'Overview',   'icon' => 'home',     'route' => 'dashboard'],
            ['href' => '#',               'label' => 'My Journeys', 'icon' => 'map',      'route' => null],
            ['href' => '#',               'label' => 'Assigned',    'icon' => 'package',  'route' => null],
            ['href' => '#',               'label' => 'Earnings',    'icon' => 'dollar',   'route' => null],
        ],
        default   => [
            ['href' => route('dashboard'), 'label' => 'Overview',   'icon' => 'home',     'route' => 'dashboard'],
            ['href' => '#',               'label' => 'My Parcels',  'icon' => 'package',  'route' => null],
            ['href' => route('send'),     'label' => 'Book an errand', 'icon' => 'plus', 'route' => 'send'],
            ['href' => '#',               'label' => 'Track',       'icon' => 'location', 'route' => null],
        ],
    };

    $navManage = $isAdmin ? [
        ['href' => '#',                   'label' => 'Analytics',  'icon' => 'chart',    'route' => null],
        ['href' => '#',                   'label' => 'Settings',   'icon' => 'settings', 'route' => null],
    ] : [
        ['href' => route('profile.edit'), 'label' => 'Settings',   'icon' => 'settings', 'route' => 'profile.edit'],
    ];
@endphp

{{-- ── Logo ──────────────────────────────────────────────── --}}
<div class="flex items-center justify-center flex-shrink-0"
     style="height:88px;padding:0 16px;border-bottom:1px solid #F2F4F7;">
    <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-full overflow-hidden">
        @if($mobile)
            <img src="/images/nhume_logo_v4.png" alt="Nhume" style="height:104px;width:auto;flex-shrink:0;margin:-18px 0;">
        @else
            {{-- Full wordmark when expanded (scaled up; negative margins trim baked-in padding) --}}
            <img x-show="!collapsed" x-cloak src="/images/nhume_logo_v4.png" alt="Nhume"
                 style="height:104px;width:auto;flex-shrink:0;margin:-18px 0;">
            {{-- Icon-only mark when collapsed --}}
            <img x-show="collapsed" x-cloak src="/images/nhume_icon.png" alt="Nhume"
                 style="height:34px;width:34px;flex-shrink:0;">
        @endif
    </a>
</div>

{{-- ── Nav scroll area ────────────────────────────────────── --}}
<div class="flex-1 overflow-y-auto overflow-x-hidden py-4" style="padding-left:10px;padding-right:10px;">

    {{-- MAIN section --}}
    <div class="mb-5">
        @if($mobile)
            <div class="nav-section mb-2">Main</div>
        @else
            <div x-show="!collapsed" x-cloak class="nav-section mb-2">Main</div>
        @endif

        @foreach($navMain as $item)
            @php
                $isActive = $item['route'] && request()->routeIs($item['route']);
            @endphp
            <a href="{{ $item['href'] }}"
               class="nav-item {{ $isActive ? 'active' : '' }} group mb-0.5 block">
                @include('components.dashboard-icon', ['icon' => $item['icon']])
                @if($mobile)
                    <span>{{ $item['label'] }}</span>
                @else
                    <span x-show="!collapsed" x-cloak class="truncate">{{ $item['label'] }}</span>
                    <span x-show="collapsed" x-cloak class="nav-tooltip">{{ $item['label'] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- MANAGE section --}}
    <div>
        @if($mobile)
            <div class="nav-section mb-2">Manage</div>
        @else
            <div x-show="!collapsed" x-cloak class="nav-section mb-2">Manage</div>
        @endif

        @foreach($navManage as $item)
            @php
                $isActive = $item['route'] && request()->routeIs($item['route']);
            @endphp
            <a href="{{ $item['href'] }}"
               class="nav-item {{ $isActive ? 'active' : '' }} group mb-0.5 block">
                @include('components.dashboard-icon', ['icon' => $item['icon']])
                @if($mobile)
                    <span>{{ $item['label'] }}</span>
                @else
                    <span x-show="!collapsed" x-cloak class="truncate">{{ $item['label'] }}</span>
                    <span x-show="collapsed" x-cloak class="nav-tooltip">{{ $item['label'] }}</span>
                @endif
            </a>
        @endforeach
    </div>

</div>

{{-- ── User + collapse at bottom ──────────────────────────── --}}
<div style="padding:10px;border-top:1px solid #F2F4F7;flex-shrink:0;">

    {{-- User row --}}
    <div class="sidebar-user overflow-hidden">
        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
             style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        @if($mobile)
            <div class="min-w-0">
                <div style="font-size:12.5px;font-weight:600;color:#344054;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $user->name }}
                </div>
                <div style="font-size:11px;color:#98A2B3;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $user->email }}
                </div>
            </div>
        @else
            <div x-show="!collapsed" x-cloak class="min-w-0">
                <div style="font-size:12.5px;font-weight:600;color:#344054;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $user->name }}
                </div>
                <div style="font-size:11px;color:#98A2B3;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $user->email }}
                </div>
            </div>
        @endif
    </div>

    {{-- Desktop collapse toggle --}}
    @if(!$mobile)
    <button @click="toggle()"
            class="nav-item w-full mt-1 justify-center"
            style="font-size:12px;color:#98A2B3;">
        <svg x-show="!collapsed" x-cloak width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M15 18l-6-6 6-6"/>
            <path d="M9 18l-6-6 6-6" opacity=".4"/>
        </svg>
        <svg x-show="collapsed" x-cloak width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 18l6-6-6-6"/>
            <path d="M15 18l6-6-6-6" opacity=".4"/>
        </svg>
        <span x-show="!collapsed" x-cloak style="font-size:12px;color:#98A2B3;">Collapse</span>
    </button>
    @endif

</div>
