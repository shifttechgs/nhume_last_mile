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
           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-md text-sm font-semibold text-white transition-colors"
           style="background:#6bc630;"
           onmouseover="this.style.background='#5aad28'"
           onmouseout="this.style.background='#6bc630'">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Book an errand
        </a>
        @endif
    </div>

    {{-- ── Stat cards ──────────────────────────────────────── --}}
    @if($isAdmin)
    <div class="ov space-y-5">
    @php
        // ── Sparkline (Total orders, 14d) ──
        $spark = $ordersTrend ?? array_fill(0, 14, 0);
        $sMax  = max(1, max($spark));
        $sN    = count($spark);
        $sStep = $sN > 1 ? 100 / ($sN - 1) : 0;
        $sPts  = [];
        foreach ($spark as $i => $v) { $sPts[] = round($i * $sStep, 2) . ',' . round(28 - ($v / $sMax) * 24, 2); }
        $sparkLine = implode(' ', $sPts);
        $sparkArea = '0,30 ' . $sparkLine . ' 100,30';
        $delta = $ordersDelta ?? 0;
        $tot   = max($totalDrivers, 1);
    @endphp

    {{-- ── KPI row ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total orders + sparkline --}}
        <div class="kpi">
            <div class="kpi-label">Total orders</div>
            <div class="kpi-num">{{ number_format($totalOrders) }}</div>
            <svg viewBox="0 0 100 30" preserveAspectRatio="none" style="width:100%;height:30px;display:block;">
                <defs><linearGradient id="sparkGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#6bc630" stop-opacity="0.16"/>
                    <stop offset="1" stop-color="#6bc630" stop-opacity="0"/>
                </linearGradient></defs>
                <polyline points="{{ $sparkArea }}" fill="url(#sparkGrad)" stroke="none"/>
                <polyline points="{{ $sparkLine }}" fill="none" stroke="#6bc630" stroke-width="1.5"
                          vector-effect="non-scaling-stroke" stroke-linejoin="round" stroke-linecap="round"/>
            </svg>
            <div class="kpi-foot">
                <span class="kpi-sub">Last 14 days</span>
                @if($delta > 0)
                    <span class="kpi-delta up"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M7 17 17 7M9 7h8v8"/></svg>{{ $delta }}%</span>
                @elseif($delta < 0)
                    <span class="kpi-delta down"><svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M7 7l10 10M17 9v8H9"/></svg>{{ abs($delta) }}%</span>
                @else
                    <span class="kpi-delta flat">No change</span>
                @endif
            </div>
        </div>

        {{-- Active drivers --}}
        <div class="kpi">
            <div class="kpi-label">Active drivers</div>
            <div class="kpi-num">{{ $activeDrivers }}</div>
            <div class="mini-bar"><span style="width:{{ round($activeDrivers / $tot * 100) }}%"></span></div>
            <div class="kpi-foot"><span class="kpi-sub">of {{ $totalDrivers }} total</span></div>
        </div>

        {{-- Verified --}}
        <div class="kpi">
            <div class="kpi-label">Verified</div>
            <div class="kpi-num">{{ $verifiedDrivers }}</div>
            <div class="mini-bar"><span style="width:{{ round($verifiedDrivers / $tot * 100) }}%"></span></div>
            <div class="kpi-foot"><span class="kpi-sub">{{ round($verifiedDrivers / $tot * 100) }}% of drivers</span></div>
        </div>

        {{-- Need review --}}
        <div class="kpi">
            <div class="kpi-label">Need review</div>
            <div class="kpi-num">{{ $pendingReview }}</div>
            <div class="mini-bar"><span style="width:{{ round($pendingReview / $tot * 100) }}%;background:#D0D5DD"></span></div>
            <div class="kpi-foot"><span class="kpi-sub">Unverified drivers</span></div>
        </div>

    </div>

    {{-- ── Main grid ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Left column --}}
        <div class="lg:col-span-2 flex flex-col">

            {{-- Recent orders table --}}
            <div class="d-card" style="flex:1;display:flex;flex-direction:column;">
                <div class="d-card-head">
                    <div class="d-h">Recent orders</div>
                    <a href="{{ route('admin.orders.index') }}" class="d-link">View all</a>
                </div>
                @if($recentOrders->total())
                @php
                    $dot = [
                        'draft'=>'#98A2B3','posted'=>'#E0A64B','assigned'=>'#6E9BF0',
                        'in_progress'=>'#9B8AF0','delivered'=>'#5aad28','cancelled'=>'#E56A6A',
                    ];
                @endphp
                <div style="flex:1;overflow-x:auto;">
                <table class="d-table">
                    <thead><tr>
                        <th>Order</th>
                        <th>Route</th>
                        <th class="hidden sm:table-cell">Customer</th>
                        <th>Status</th>
                        <th class="hidden sm:table-cell">Time</th>
                        <th></th>
                    </tr></thead>
                    <tbody>
                    @foreach($recentOrders as $order)
                    @php
                        $sv  = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
                        $lbl = $order->status instanceof \App\Enums\TaskStatus ? $order->status->label() : ucfirst(str_replace('_',' ',$sv));
                        $orderNum = $order->order_number ?? '#'.str_pad($order->id, 5, '0', STR_PAD_LEFT);
                    @endphp
                    <tr>
                        <td><span class="d-mono">{{ $orderNum }}</span></td>
                        <td><span class="d-route">{{ Str::limit($order->pickup_address, 16) }} <span class="arr">→</span> {{ Str::limit($order->dropoff_address, 16) }}</span></td>
                        <td class="hidden sm:table-cell"><span class="d-cust">{{ $order->user?->name ? Str::limit($order->user->name, 18) : '—' }}</span></td>
                        <td><span class="st-pill"><span class="st-dot" style="background:{{ $dot[$sv] ?? '#98A2B3' }}"></span>{{ $lbl }}</span></td>
                        <td class="hidden sm:table-cell"><span class="d-time">{{ $order->created_at->diffForHumans() }}</span></td>
                        <td style="width:28px;text-align:right;"><a href="{{ route('admin.orders.show', $order) }}" class="d-chev"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg></a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>

                {{-- Footer: pagination --}}
                <div class="d-card-foot">
                    <span class="d-pageinfo">Showing <b>{{ $recentOrders->firstItem() ?? 0 }}–{{ $recentOrders->lastItem() ?? 0 }}</b> of {{ number_format($recentOrders->total()) }}</span>
                    <div class="d-pg">
                        <a href="{{ $recentOrders->previousPageUrl() ?? '#' }}"
                           class="d-pgbtn {{ $recentOrders->onFirstPage() ? 'is-disabled' : '' }}"
                           @if($recentOrders->onFirstPage()) tabindex="-1" aria-disabled="true" @endif>
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                            Prev
                        </a>
                        <a href="{{ $recentOrders->nextPageUrl() ?? '#' }}"
                           class="d-pgbtn {{ $recentOrders->hasMorePages() ? '' : 'is-disabled' }}"
                           @if(!$recentOrders->hasMorePages()) tabindex="-1" aria-disabled="true" @endif>
                            Next
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                </div>
                @else
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:44px 18px;text-align:center;">
                    <div class="d-h" style="font-weight:500;color:var(--body);">No orders yet</div>
                    <div class="ov-sub" style="margin-top:4px;">Orders will appear here as they come in.</div>
                </div>
                @endif
            </div>

        </div>

        {{-- Right column --}}
        <div class="space-y-5">

            {{-- Trust breakdown --}}
            <div class="d-card">
                <div class="d-card-head">
                    <div class="d-h">Trust breakdown</div>
                    <span class="ov-sub">{{ $totalDrivers }} drivers</span>
                </div>
                <div style="padding:16px 18px;">
                    @php
                        $tiers = [
                            ['label'=>'Verified', 'color'=>'#5aad28', 'count'=>$verifiedDrivers],
                            ['label'=>'Reviewed', 'color'=>'#8bd45f', 'count'=>$reviewedDrivers],
                            ['label'=>'ID sent',  'color'=>'#cfe8b4', 'count'=>$idSubmittedDrivers],
                            ['label'=>'New',      'color'=>'#E5E7EB', 'count'=>$pendingReview],
                        ];
                    @endphp
                    <div class="trust-stack" style="margin-bottom:16px;">
                        @foreach($tiers as $t)
                            @if($t['count'] > 0)
                            <span style="width:{{ round($t['count'] / $tot * 100, 1) }}%;background:{{ $t['color'] }}"></span>
                            @endif
                        @endforeach
                    </div>
                    <div class="space-y-2.5">
                        @foreach($tiers as $t)
                        <div class="trust-row">
                            <span class="trust-key" style="background:{{ $t['color'] }}"></span>
                            <span class="trust-name">{{ $t['label'] }}</span>
                            <span class="trust-val">{{ $t['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="d-card">
                <div class="d-card-head"><div class="d-h">Quick actions</div></div>
                <div style="padding:8px;">
                    <a href="{{ route('admin.orders.create') }}" class="qa-row">
                        <span class="qa-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
                        New order
                    </a>
                    <a href="{{ route('admin.drivers.create') }}" class="qa-row">
                        <span class="qa-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/></svg></span>
                        Add driver
                    </a>
                    <a href="{{ route('admin.drivers.index') }}" class="qa-row">
                        <span class="qa-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                        Review queue
                        @if($pendingReview > 0)<span class="qa-count">{{ $pendingReview }}</span>@endif
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>{{-- /.ov --}}

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
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:8px;overflow:hidden;">

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
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:8px;padding:56px 32px;text-align:center;">
        <div style="width:64px;height:64px;border-radius:8px;background:#f0fde4;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <svg width="30" height="30" fill="none" stroke="#6bc630" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/>
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Book your first errand or parcel</h3>
        <p class="text-sm text-gray-400 max-w-xs mx-auto mb-6">
            Need a grocery run, document drop, or intercity delivery? Real riders and drivers, ready today.
        </p>
        <a href="{{ route('send') }}"
           class="inline-flex items-center gap-2 px-6 py-3 rounded-md text-sm font-semibold text-white"
           style="background:#6bc630;"
           onmouseover="this.style.background='#5aad28'"
           onmouseout="this.style.background='#6bc630'">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Get started
        </a>
    </div>
    @endif

    {{-- ── Order history ────────────────────────────────────── --}}
    @if($pastOrders->count() > 0)
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:8px;overflow:hidden;">
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

    @php
        $tier    = Auth::user()->transporterProfile?->trust_tier?->value ?? 'unverified';
        $tierCfg = [
            'verified'          => ['label'=>'Nhume Verified', 'bg'=>'#dcfce7','txt'=>'#15803d','dot'=>'#22c55e'],
            'manually_reviewed' => ['label'=>'Nhume Reviewed', 'bg'=>'#dbeafe','txt'=>'#1d4ed8','dot'=>'#3b82f6'],
            'id_submitted'      => ['label'=>'ID Submitted',   'bg'=>'#fef3c7','txt'=>'#b45309','dot'=>'#f59e0b'],
            'unverified'        => ['label'=>'Unverified',     'bg'=>'#f3f4f6','txt'=>'#6b7280','dot'=>'#9ca3af'],
        ];
        $tc = $tierCfg[$tier] ?? $tierCfg['unverified'];
    @endphp

    <div class="ov space-y-5">

    {{-- Trust banner --}}
    @if($tier !== 'verified')
    <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-radius:12px;font-size:13.5px;background:#FFFBEB;border:1px solid #FDE68A;">
        <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <div class="flex-1">
            <span class="text-amber-800 font-medium">
                Your account is <strong>{{ $tc['label'] }}</strong>.
                <a href="{{ route('partner') }}" class="underline ml-1">Complete verification →</a>
            </span>
        </div>
    </div>
    @endif

    {{-- 4-stat strip --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Journeys posted</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold"
                      style="background:{{ $tc['bg'] }};color:{{ $tc['txt'] }};">
                    <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $tc['dot'] }};"></span>
                    {{ $tc['label'] }}
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $totalJourneys }}</div>
            <div class="text-xs text-gray-400 mt-1">{{ $upcomingJourneys }} upcoming</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Assigned tasks</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#EDE9FE;">
                    <svg width="14" height="14" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">{{ $assignedTasks }}</div>
            <div class="text-xs text-gray-400 mt-1">All time</div>
        </div>

        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Completed</span>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#DCFCE7;">
                    <svg width="14" height="14" fill="none" stroke="#15803d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                    <svg width="14" height="14" fill="none" stroke="#6bc630" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 tabular-nums">—</div>
            <div class="text-xs text-gray-400 mt-1">Coming soon</div>
        </div>

    </div>

    {{-- Main grid: journeys (2/3) + sidebar (1/3) --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;align-items:start">

        {{-- My journeys — 2/3 --}}
        <div style="grid-column:span 2;display:flex;flex-direction:column">
            <div class="d-card" style="flex:1;display:flex;flex-direction:column;padding:0;overflow:hidden;">
                <div class="d-card-head">
                    <div class="d-h">My Journeys</div>
                    <a href="{{ route('transporter.journeys.create') }}" class="d-link">
                        + Post journey
                    </a>
                </div>

                @if($recentJourneys->isEmpty())
                <div class="flex flex-col items-center justify-center text-center px-6 py-14 flex-1">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:#F0FDE4;">
                        <svg width="22" height="22" fill="none" stroke="#6bc630" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                            <line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">No journeys posted yet</p>
                    <p class="text-xs text-gray-400 mb-5 max-w-xs leading-relaxed">Post your first trip and senders on the marketplace can WhatsApp you to book space.</p>
                    <a href="{{ route('transporter.journeys.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white"
                       style="background:#6bc630;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Post your first journey
                    </a>
                </div>
                @else

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom:1px solid #F0F1F0;">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Route</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden sm:table-cell">Departs</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentJourneys as $j)
                            @php
                                $sc = match($j->status->value) {
                                    'scheduled'   => ['bg'=>'#f0fde4','txt'=>'#15803d','dot'=>'#6bc630', 'label'=>'Scheduled'],
                                    'in_progress' => ['bg'=>'#fef3c7','txt'=>'#d97706','dot'=>'#f59e0b', 'label'=>'In Progress'],
                                    'completed'   => ['bg'=>'#dbeafe','txt'=>'#1d4ed8','dot'=>'#3b82f6', 'label'=>'Completed'],
                                    'cancelled'   => ['bg'=>'#fee2e2','txt'=>'#dc2626','dot'=>'#ef4444', 'label'=>'Cancelled'],
                                    default       => ['bg'=>'#f3f4f6','txt'=>'#6b7280','dot'=>'#9ca3af', 'label'=>'Draft'],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-6 py-3.5">
                                    <div class="font-semibold text-gray-800 text-sm">
                                        {{ $j->route?->origin_city }}
                                        <span class="text-green-500 mx-1">→</span>
                                        {{ $j->route?->destination_city }}
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 hidden sm:table-cell">
                                    <div class="text-sm text-gray-700">{{ $j->departs_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $j->departs_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                          style="background:{{ $sc['bg'] }};color:{{ $sc['txt'] }};">
                                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:{{ $sc['dot'] }};"></span>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3.5" style="border-top:1px solid #F0F1F0;">
                    <a href="{{ route('transporter.journeys.index') }}" class="d-link">View all journeys →</a>
                </div>

                @endif
            </div>
        </div>

        {{-- Sidebar: tasks + quick actions --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Assigned tasks --}}
            <div class="d-card" style="padding:0;overflow:hidden;">
                <div class="d-card-head">
                    <div class="d-h">Assigned Tasks</div>
                </div>
                @if($recentOrders->isEmpty())
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-400 leading-relaxed">No tasks yet. Tasks appear here when an admin assigns an order to you.</p>
                </div>
                @else
                <div class="divide-y divide-gray-50">
                    @foreach($recentOrders as $task)
                    @php
                        $ts = match($task->status->value) {
                            'assigned'    => ['bg'=>'#dbeafe','txt'=>'#1d4ed8','dot'=>'#3b82f6','label'=>'Assigned'],
                            'in_progress' => ['bg'=>'#fef3c7','txt'=>'#d97706','dot'=>'#f59e0b','label'=>'In Progress'],
                            'delivered'   => ['bg'=>'#dcfce7','txt'=>'#15803d','dot'=>'#22c55e','label'=>'Delivered'],
                            'cancelled'   => ['bg'=>'#fee2e2','txt'=>'#dc2626','dot'=>'#ef4444','label'=>'Cancelled'],
                            default       => ['bg'=>'#f3f4f6','txt'=>'#6b7280','dot'=>'#9ca3af','label'=>ucfirst($task->status->value)],
                        };
                    @endphp
                    <div class="flex items-center justify-between px-5 py-3.5 gap-3 hover:bg-gray-50/60 transition-colors">
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-gray-800">#{{ $task->order_number }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $task->pickup_address }}</div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold flex-shrink-0"
                              style="background:{{ $ts['bg'] }};color:{{ $ts['txt'] }};">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $ts['dot'] }};"></span>
                            {{ $ts['label'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Quick actions --}}
            <div class="d-card">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Quick actions</div>
                <div class="space-y-1">
                    <a href="{{ route('transporter.journeys.create') }}" class="qa-row">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>
                        Post a journey
                    </a>
                    <a href="{{ route('transporter.journeys.index') }}" class="qa-row">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                        All my journeys
                    </a>
                    <a href="{{ route('journeys') }}" class="qa-row">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Browse marketplace
                    </a>
                    <a href="{{ route('profile.edit') }}" class="qa-row">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Edit profile
                    </a>
                </div>
            </div>

        </div>

    </div>

    </div>{{-- end .ov --}}

    <style>
    @media(max-width:900px){
        div[style*="grid-template-columns:1fr 1fr 1fr"]{grid-template-columns:1fr!important}
        div[style*="grid-column:span 2"]{grid-column:span 1!important}
        div[style*="repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important}
    }
    @media(max-width:480px){
        div[style*="repeat(4,1fr)"]{grid-template-columns:repeat(2,1fr)!important}
    }
    </style>

    @endif

</div>
</x-dashboard-layout>
