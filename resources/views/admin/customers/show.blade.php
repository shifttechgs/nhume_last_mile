<x-dashboard-layout title="{{ $customer->name }}">
@php
    $statusColors = [
        'draft'       => ['bg' => '#f3f4f6', 'text' => '#6b7280'],
        'posted'      => ['bg' => '#fef3c7', 'text' => '#b45309'],
        'assigned'    => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
        'in_progress' => ['bg' => '#ede9fe', 'text' => '#6d28d9'],
        'delivered'   => ['bg' => '#dcfce7', 'text' => '#15803d'],
        'cancelled'   => ['bg' => '#fee2e2', 'text' => '#dc2626'],
    ];
@endphp
<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.customers.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All customers
        </a>
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg font-bold text-white"
                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">{{ $customer->name }}</h1>
                    <div class="text-sm text-gray-400 mt-0.5">{{ $customer->phone ?? '' }}{{ $customer->phone && !str_contains($customer->email, '@nhume.local') ? ' · ' : '' }}{{ str_contains($customer->email, '@nhume.local') ? '' : $customer->email }}</div>
                </div>
            </div>
            <a href="{{ route('admin.orders.create', ['customer_id' => $customer->id]) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
               style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.25);">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New order
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['label' => 'Total orders',  'value' => $orders->total()],
            ['label' => 'Delivered',     'value' => $customer->tasks()->where('status','delivered')->count()],
            ['label' => 'In progress',   'value' => $customer->tasks()->whereIn('status',['posted','assigned','in_progress'])->count()],
            ['label' => 'Customer since','value' => $customer->created_at->format('M Y'), 'text' => true],
        ] as $stat)
        <div class="stat-card py-4 px-4">
            @if(isset($stat['text']))
                <div class="text-base font-bold text-gray-800">{{ $stat['value'] }}</div>
            @else
                <div class="text-2xl font-bold tabular-nums" style="color:#6bc630;">{{ $stat['value'] }}</div>
            @endif
            <div class="text-xs text-gray-400 mt-0.5">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Orders table --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F0F1F0;">
            <h2 class="text-sm font-semibold text-gray-800">Order history</h2>
        </div>
        @forelse($orders as $order)
        @php
            $sv = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
            $sc = $statusColors[$sv] ?? $statusColors['draft'];
        @endphp
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 group transition-colors">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <span class="font-mono text-xs font-semibold text-gray-700">{{ $order->order_number ?? '#'.str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold"
                          style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                        {{ $order->status instanceof \App\Enums\TaskStatus ? $order->status->label() : ucfirst(str_replace('_',' ',$sv)) }}
                    </span>
                </div>
                <div class="text-xs text-gray-500">{{ Str::limit($order->pickup_address,30) }} → {{ Str::limit($order->dropoff_address,30) }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $order->item_description ?? 'No description' }}</div>
            </div>
            <div class="text-xs text-gray-400 whitespace-nowrap">{{ $order->created_at->diffForHumans() }}</div>
            <a href="{{ route('admin.orders.show', $order) }}"
               class="opacity-0 group-hover:opacity-100 text-gray-300 hover:text-gray-600 transition-all">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
            </a>
        </div>
        @empty
        <div class="px-6 py-12 text-center text-sm text-gray-400">No orders yet.</div>
        @endforelse
        @if($orders->hasPages())
        <div class="px-6 py-4" style="border-top:1px solid #F0F1F0;">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
</x-dashboard-layout>
