<x-dashboard-layout title="Orders">
@php
    $statusConfig = [
        'draft'       => ['label' => 'Draft',      'bg' => '#f3f4f6', 'text' => '#6b7280', 'dot' => '#9ca3af'],
        'posted'      => ['label' => 'Received',   'bg' => '#fef3c7', 'text' => '#b45309', 'dot' => '#f59e0b'],
        'assigned'    => ['label' => 'Assigned',   'bg' => '#dbeafe', 'text' => '#1d4ed8', 'dot' => '#3b82f6'],
        'in_progress' => ['label' => 'On the way', 'bg' => '#ede9fe', 'text' => '#6d28d9', 'dot' => '#8b5cf6'],
        'delivered'   => ['label' => 'Delivered',  'bg' => '#dcfce7', 'text' => '#15803d', 'dot' => '#22c55e'],
        'cancelled'   => ['label' => 'Cancelled',  'bg' => '#fee2e2', 'text' => '#dc2626', 'dot' => '#ef4444'],
    ];
@endphp

<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Orders</h1>
        <p class="text-sm text-gray-400 mt-0.5">All parcel delivery orders across the platform</p>
    </div>

    {{-- ── Flash ───────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"
         style="background:#f0fde4;border:1px solid #bbf7d0;color:#15803d;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Status tabs ─────────────────────────────────────── --}}
    <div class="flex items-center gap-1 flex-wrap">
        <a href="{{ route('admin.orders.index') }}"
           class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition-colors {{ !request('status') ? 'text-gray-800 bg-white shadow-sm border border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-white/60' }}">
            All
            <span class="ml-1.5 text-xs px-1.5 py-0.5 rounded-full {{ !request('status') ? 'bg-gray-100 text-gray-600' : 'bg-gray-100/60 text-gray-400' }}">
                {{ $counts['total'] }}
            </span>
        </a>
        @foreach($statusConfig as $val => $cfg)
        @if(($counts[$val] ?? 0) > 0 || request('status') === $val)
        <a href="{{ route('admin.orders.index', ['status' => $val] + request()->except('status', 'page')) }}"
           class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition-colors {{ request('status') === $val ? 'text-gray-800 bg-white shadow-sm border border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-white/60' }}">
            {{ $cfg['label'] }}
            <span class="ml-1.5 text-xs px-1.5 py-0.5 rounded-full {{ request('status') === $val ? 'bg-gray-100 text-gray-600' : 'bg-gray-100/60 text-gray-400' }}">
                {{ $counts[$val] ?? 0 }}
            </span>
        </a>
        @endif
        @endforeach
    </div>

    {{-- ── Search ───────────────────────────────────────────── --}}
    <form method="GET" class="flex items-center gap-3">
        @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <div class="flex items-center gap-2 px-3 py-2 rounded-xl flex-1 max-w-sm"
             style="background:#fff;border:1px solid #E9EAEC;">
            <svg width="15" height="15" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search order #, address, recipient…"
                   class="bg-transparent border-0 p-0 text-sm text-gray-700 placeholder-gray-400 focus:ring-0 outline-none w-full">
        </div>
        @if(request()->hasAny(['search']))
        <a href="{{ route('admin.orders.index', request()->except('search','page')) }}"
           class="text-sm text-gray-500 hover:text-gray-700 px-2">Clear</a>
        @endif
    </form>

    {{-- ── Table ───────────────────────────────────────────── --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Order</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Sender</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden lg:table-cell">Route</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden sm:table-cell">Driver</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden lg:table-cell">Date</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    @php
                        $sv = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
                        $sc = $statusConfig[$sv] ?? $statusConfig['draft'];
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-mono text-xs font-semibold text-gray-700">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[160px]">{{ $order->item_description ?? 'No description' }}</div>
                        </td>
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="text-sm text-gray-700">{{ $order->user->name ?? '—' }}</div>
                            <div class="text-xs text-gray-400 font-mono">{{ $order->sender_phone ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <div class="text-xs text-gray-500">{{ Str::limit($order->pickup_address, 22) }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">→ {{ Str::limit($order->dropoff_address, 22) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                  style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $sc['dot'] }};"></span>
                                {{ $order->status instanceof \App\Enums\TaskStatus ? $order->status->label() : $sc['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 hidden sm:table-cell">
                            @if($order->assignedDriver)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                                        {{ strtoupper(substr($order->assignedDriver->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-xs text-gray-600 truncate max-w-[100px]">
                                        {{ Str::of($order->assignedDriver->user->name ?? '')->explode(' ')->first() }}
                                    </span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap hidden lg:table-cell">
                            {{ $order->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors opacity-0 group-hover:opacity-100">
                                Manage
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="text-2xl mb-2">📦</div>
                            <div class="text-sm font-medium text-gray-500">No orders yet</div>
                            <div class="text-xs text-gray-400 mt-1">Orders will appear here once senders submit parcels</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="px-6 py-4" style="border-top:1px solid #F0F1F0;">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
</x-dashboard-layout>
