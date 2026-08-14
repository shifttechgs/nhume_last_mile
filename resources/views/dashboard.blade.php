<x-dashboard-layout title="Dashboard">
@php
    $user    = Auth::user();
    $role    = $user->role->value ?? 'sender';
    $isAdmin = $role === 'admin';
    $isSender = $role === 'sender';
    $isDriver = $role === 'transport_partner';
    $hour    = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
@endphp

<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-8">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">
                {{ $greeting }}, {{ Str::of($user->name)->explode(' ')->first() }}
            </h1>
            <p class="text-sm text-gray-400 mt-0.5">
                {{ now()->format('l, j F Y') }}
            </p>
        </div>

        @if($isSender)
        <a href="{{ route('send') }}"
           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-all"
           style="background:#6bc630;box-shadow:0 4px 16px rgba(107,198,48,0.3);"
           onmouseover="this.style.background='#5aad28'"
           onmouseout="this.style.background='#6bc630'">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Send Parcel
        </a>
        @endif
    </div>

    {{-- ── Stat cards ──────────────────────────────────────── --}}
    @if($isAdmin)
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Orders</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#F0FDE4;">
                    <svg width="15" height="15" fill="none" stroke="#6bc630" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/>
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $totalOrders }}</div>
            <div class="text-xs text-gray-400 mt-1">All time</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Active Drivers</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#EFF6FF;">
                    <svg width="15" height="15" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $activeDrivers }}</div>
            <div class="text-xs text-gray-400 mt-1">of {{ $totalDrivers }} total</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Verified</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#F0FDE4;">
                    <svg width="15" height="15" fill="none" stroke="#6bc630" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $verifiedDrivers }}</div>
            <div class="flex items-center gap-1.5 mt-1">
                <span class="text-xs text-gray-400">Fully verified drivers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Need Review</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#FEF3C7;">
                    <svg width="15" height="15" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $pendingReview }}</div>
            <div class="text-xs text-gray-400 mt-1">Unverified drivers</div>
        </div>

    </div>

    {{-- ── Admin: Two columns ────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Recent Drivers --}}
        <div class="lg:col-span-2"
             style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
            <div class="flex items-center justify-between px-6 py-4"
                 style="border-bottom:1px solid #F0F1F0;">
                <h2 class="text-sm font-semibold text-gray-800">Drivers</h2>
                <a href="#" class="text-xs font-medium" style="color:#6bc630;">View all</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentDrivers as $driver)
                @php
                    $tier = $driver->trust_tier->value;
                    $badge = match($tier) {
                        'verified'        => ['label' => 'Verified',  'class' => 'trust-verified'],
                        'manually_reviewed'=> ['label' => 'Reviewed', 'class' => 'trust-manually'],
                        'id_submitted'    => ['label' => 'ID Sent',   'class' => 'trust-id-submitted'],
                        default           => ['label' => 'New',       'class' => 'trust-unverified'],
                    };
                @endphp
                <div class="flex items-center gap-3 px-6 py-3.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                         style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                        {{ strtoupper(substr($driver->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $driver->user->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ $driver->phone ?? 'No phone' }}</div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                        <span class="text-[11px] text-gray-400">
                            {{ $driver->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <div class="text-3xl mb-2">🚗</div>
                    <div class="text-sm font-medium text-gray-500">No drivers yet</div>
                    <div class="text-xs text-gray-400 mt-1">Seed transporters to get started</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick actions + trust breakdown --}}
        <div class="space-y-4">

            {{-- Quick actions --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Quick actions</h2>
                <div class="space-y-2">
                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#F0FDE4;">
                            <svg width="14" height="14" fill="none" stroke="#6bc630" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                        Add Driver
                    </a>
                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#EFF6FF;">
                            <svg width="14" height="14" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/>
                            </svg>
                        </div>
                        View Analytics
                    </a>
                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#FEF3C7;">
                            <svg width="14" height="14" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                        </div>
                        Review Queue
                        @if($pendingReview > 0)
                        <span class="ml-auto text-xs font-bold text-white px-1.5 py-0.5 rounded-full" style="background:#d97706;">
                            {{ $pendingReview }}
                        </span>
                        @endif
                    </a>
                </div>
            </div>

            {{-- Trust tier breakdown --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">Trust breakdown</h2>
                @php
                    $tiers = [
                        ['label' => 'Verified',  'color' => '#6bc630', 'count' => $verifiedDrivers],
                        ['label' => 'Reviewed',  'color' => '#3b82f6', 'count' => \App\Models\TransporterProfile::where('trust_tier','manually_reviewed')->count()],
                        ['label' => 'ID Sent',   'color' => '#f59e0b', 'count' => \App\Models\TransporterProfile::where('trust_tier','id_submitted')->count()],
                        ['label' => 'New',        'color' => '#e5e7eb', 'count' => $pendingReview],
                    ];
                    $total = max($totalDrivers, 1);
                @endphp
                <div class="space-y-3">
                    @foreach($tiers as $tier)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-500">{{ $tier['label'] }}</span>
                            <span class="text-xs font-semibold text-gray-700">{{ $tier['count'] }}</span>
                        </div>
                        <div class="h-1.5 rounded-full" style="background:#F3F4F6;">
                            <div class="h-1.5 rounded-full transition-all duration-500"
                                 style="background:{{ $tier['color'] }};width:{{ $total > 0 ? round($tier['count']/$total*100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ── Recent Orders (admin) ───────────────────────────── --}}
    @if($recentOrders->count() > 0)
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="flex items-center justify-between px-6 py-4"
             style="border-bottom:1px solid #F0F1F0;">
            <h2 class="text-sm font-semibold text-gray-800">Recent orders</h2>
            <a href="#" class="text-xs font-medium" style="color:#6bc630;">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Order</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Route</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                    @php
                        $statusColors = [
                            'draft'       => ['bg' => '#F3F4F6', 'text' => '#6B7280'],
                            'posted'      => ['bg' => '#FEF3C7', 'text' => '#B45309'],
                            'assigned'    => ['bg' => '#DBEAFE', 'text' => '#1D4ED8'],
                            'in_progress' => ['bg' => '#EDE9FE', 'text' => '#6D28D9'],
                            'delivered'   => ['bg' => '#DCFCE7', 'text' => '#15803D'],
                            'cancelled'   => ['bg' => '#FEE2E2', 'text' => '#DC2626'],
                        ];
                        $statusVal = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
                        $sc = $statusColors[$statusVal] ?? $statusColors['draft'];
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="font-mono text-xs font-semibold text-gray-700">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[160px]">{{ $order->item_description ?? 'No description' }}</div>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="text-xs text-gray-600 truncate max-w-[180px]">
                                <span class="text-gray-400">From</span> {{ Str::limit($order->pickup_address, 20) }}
                            </div>
                            <div class="text-xs text-gray-600 mt-0.5 truncate max-w-[180px]">
                                <span class="text-gray-400">To</span> {{ Str::limit($order->dropoff_address, 20) }}
                            </div>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold"
                                  style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                {{ $order->status instanceof \App\Enums\TaskStatus ? $order->status->label() : ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-xs text-gray-400 whitespace-nowrap">
                            {{ $order->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @elseif($isSender)
    @php
        $sc = [
            'draft'       => ['bg'=>'#f3f4f6','text'=>'#6b7280','dot'=>'#9ca3af','label'=>'Draft'],
            'posted'      => ['bg'=>'#fef3c7','text'=>'#b45309','dot'=>'#f59e0b','label'=>'Order received'],
            'assigned'    => ['bg'=>'#dbeafe','text'=>'#1d4ed8','dot'=>'#3b82f6','label'=>'Driver assigned'],
            'in_progress' => ['bg'=>'#ede9fe','text'=>'#6d28d9','dot'=>'#8b5cf6','label'=>'On the way'],
            'delivered'   => ['bg'=>'#dcfce7','text'=>'#15803d','dot'=>'#22c55e','label'=>'Delivered'],
            'cancelled'   => ['bg'=>'#fee2e2','text'=>'#dc2626','dot'=>'#ef4444','label'=>'Cancelled'],
        ];
        $timeline = \App\Enums\TaskStatus::timeline();
    @endphp

    {{-- ── Stats ───────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['label'=>'Total',      'value'=>$totalOrders,    'color'=>'#6b7280', 'bg'=>'#f9fafb'],
            ['label'=>'In transit', 'value'=>$pendingOrders,  'color'=>'#d97706', 'bg'=>'#FFFBEB'],
            ['label'=>'Delivered',  'value'=>$deliveredOrders,'color'=>'#15803d', 'bg'=>'#F0FDE4'],
            ['label'=>'Cancelled',  'value'=>$cancelledOrders,'color'=>'#dc2626', 'bg'=>'#FFF1F1'],
        ] as $s)
        <div class="stat-card" style="border-left:3px solid {{ $s['color'] }};">
            <div class="text-2xl font-bold tabular-nums" style="color:{{ $s['color'] }}">{{ $s['value'] }}</div>
            <div class="text-xs font-medium text-gray-400 mt-0.5">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── Active Orders ────────────────────────────────────── --}}
    @if($activeOrders->count() > 0)
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-800">Active shipments</h2>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background:#fef3c7;color:#b45309;">
                {{ $activeOrders->count() }} in progress
            </span>
        </div>

        @foreach($activeOrders as $order)
        @php
            $sv   = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
            $badge = $sc[$sv] ?? $sc['draft'];
            $timelineIdx = collect($timeline)->search(fn($s) => $s->value === $sv) ?? -1;
            $orderNum = $order->order_number ?? '#'.str_pad($order->id, 5, '0', STR_PAD_LEFT);
        @endphp
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">

            {{-- Card header --}}
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid #F5F6F5;">
                <div class="flex items-center gap-3">
                    <div class="font-mono text-xs font-bold text-gray-600">{{ $orderNum }}</div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                          style="background:{{ $badge['bg'] }};color:{{ $badge['text'] }};">
                        <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:{{ $badge['dot'] }};"></span>
                        {{ $badge['label'] }}
                    </span>
                </div>
                <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
            </div>

            <div class="px-5 py-4 space-y-4">

                {{-- Route --}}
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:#6bc630;"></div>
                        <span class="text-sm text-gray-700 truncate">{{ $order->pickup_address }}</span>
                    </div>
                    <svg width="20" height="20" fill="none" stroke="#d1d5db" stroke-width="2" viewBox="0 0 24 24" class="flex-shrink-0">
                        <path d="M5 12h14m-7-7 7 7-7 7"/>
                    </svg>
                    <div class="flex items-center gap-2 flex-1 min-w-0 justify-end">
                        <span class="text-sm text-gray-700 truncate text-right">{{ $order->dropoff_address }}</span>
                        <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:#3b82f6;"></div>
                    </div>
                </div>

                {{-- Timeline progress --}}
                <div class="flex items-center gap-0">
                    @foreach($timeline as $i => $step)
                    @php $done = $timelineIdx >= $i; @endphp
                    <div class="flex items-center {{ $i < count($timeline)-1 ? 'flex-1' : '' }}">
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background:{{ $done ? '#6bc630' : '#F3F4F6' }};">
                                @if($done)
                                <svg width="11" height="11" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
                                @else
                                <div class="w-1.5 h-1.5 rounded-full" style="background:#D1D5DB;"></div>
                                @endif
                            </div>
                            <div class="text-[9px] font-semibold whitespace-nowrap"
                                 style="color:{{ $done ? '#6bc630' : '#9ca3af' }};">
                                {{ $step->label() }}
                            </div>
                        </div>
                        @if($i < count($timeline)-1)
                        <div class="h-px flex-1 mx-1 mb-3.5" style="background:{{ $timelineIdx > $i ? '#6bc630' : '#E5E7EB' }};"></div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Driver + package row --}}
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    @if($order->assignedDriver)
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                             style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                            {{ strtoupper(substr($order->assignedDriver->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-700">{{ $order->assignedDriver->user->name ?? 'Driver' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->assignedDriver->trust_badge }}</div>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/>
                        </svg>
                        Awaiting driver assignment
                    </div>
                    @endif

                    <div class="flex items-center gap-4">
                        @if($order->item_description)
                        <div class="text-xs text-gray-500">{{ Str::limit($order->item_description, 30) }}</div>
                        @endif
                        @if($order->offered_price)
                        <div class="text-sm font-semibold text-gray-800">${{ number_format($order->offered_price, 2) }}</div>
                        @endif
                        <a href="{{ route('track', ['orderNumber' => $order->order_number]) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors"
                           style="background:#f0fde4;color:#15803d;">
                            Track
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Empty state (no orders at all) ─────────────────── --}}
    @if($totalOrders === 0)
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:20px;padding:56px 32px;text-align:center;">
        <div style="width:64px;height:64px;border-radius:20px;background:linear-gradient(135deg,#f0fde4,#dcfce7);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="30" height="30" fill="none" stroke="#6bc630" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/>
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Send your first parcel</h3>
        <p class="text-sm text-gray-400 max-w-xs mx-auto mb-6">
            Moving a parcel between cities? We match it to a driver already travelling that route.
        </p>
        <a href="{{ route('send') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 20px rgba(107,198,48,0.35);"
           onmouseover="this.style.background='#5aad28'"
           onmouseout="this.style.background='#6bc630'">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Send a parcel
        </a>
    </div>
    @endif

    {{-- ── Order history ────────────────────────────────────── --}}
    @if($pastOrders->count() > 0)
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F0F1F0;">
            <h2 class="text-sm font-semibold text-gray-800">Order history</h2>
            <a href="{{ route('send') }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg"
               style="background:#6bc630;color:#fff;">
                + New order
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($pastOrders as $order)
            @php
                $sv    = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
                $badge = $sc[$sv] ?? $sc['draft'];
                $orderNum = $order->order_number ?? '#'.str_pad($order->id, 5, '0', STR_PAD_LEFT);
            @endphp
            <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <span class="font-mono text-xs font-bold text-gray-600">{{ $orderNum }}</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold"
                              style="background:{{ $badge['bg'] }};color:{{ $badge['text'] }};">
                            <span class="w-1 h-1 rounded-full" style="background:{{ $badge['dot'] }};"></span>
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 truncate">
                        {{ Str::limit($order->pickup_address, 25) }}
                        <span class="text-gray-300 mx-1">→</span>
                        {{ Str::limit($order->dropoff_address, 25) }}
                    </div>
                </div>
                <div class="hidden sm:block text-right flex-shrink-0">
                    @if($order->offered_price)
                    <div class="text-sm font-semibold text-gray-700">${{ number_format($order->offered_price, 2) }}</div>
                    @endif
                    <div class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</div>
                </div>
                @if($sv === 'delivered')
                <a href="{{ route('track', ['orderNumber' => $order->order_number]) }}"
                   class="text-gray-300 hover:text-gray-600 transition-colors flex-shrink-0">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @elseif($isDriver)

    {{-- ── DRIVER STATS ──────────────────────────────────── --}}
    @php
        $profile   = Auth::user()->transporterProfile;
        $tier      = $profile?->trust_tier->value ?? 'unverified';
        $badgeMap  = [
            'verified'         => ['label' => 'Nhume Verified', 'class' => 'trust-verified'],
            'manually_reviewed'=> ['label' => 'Nhume Reviewed', 'class' => 'trust-manually'],
            'id_submitted'     => ['label' => 'ID Submitted',   'class' => 'trust-id-submitted'],
            'unverified'       => ['label' => 'Unverified',     'class' => 'trust-unverified'],
        ];
        $badge = $badgeMap[$tier] ?? $badgeMap['unverified'];
    @endphp

    {{-- Trust tier banner --}}
    @if($tier !== 'verified')
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-sm"
         style="background:#FFFBEB;border:1px solid #FDE68A;">
        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <span class="text-amber-800 font-medium">
            Your account is <strong>{{ strtolower(str_replace('_', ' ', $tier)) }}</strong>. Complete verification to unlock all features.
        </span>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Assigned Tasks</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $badge['class'] }}">
                    {{ $badge['label'] }}
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $assignedTasks }}</div>
            <div class="text-xs text-gray-400 mt-1">All time</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Completed</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#DCFCE7;">
                    <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $completedTasks }}</div>
            <div class="text-xs text-gray-400 mt-1">Deliveries done</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Earnings</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#F0FDE4;">
                    <svg width="15" height="15" fill="none" stroke="#6bc630" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">$0</div>
            <div class="text-xs text-gray-400 mt-1">Coming soon</div>
        </div>
    </div>

    @if($recentOrders->count() === 0)
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:48px 24px;text-align:center;">
        <div style="width:56px;height:56px;border-radius:16px;background:#F0FDE4;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg width="26" height="26" fill="none" stroke="#6bc630" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                <line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-800 mb-1">No journeys yet</h3>
        <p class="text-sm text-gray-400">Your assigned tasks will appear here once orders come in.</p>
    </div>
    @endif

    @endif

</div>
</x-dashboard-layout>
