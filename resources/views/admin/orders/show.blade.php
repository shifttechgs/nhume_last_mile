<x-dashboard-layout title="Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}">
@php
    $statusConfig = [
        'draft'       => ['label' => 'Draft',      'bg' => '#f3f4f6', 'text' => '#6b7280'],
        'posted'      => ['label' => 'Received',   'bg' => '#fef3c7', 'text' => '#b45309'],
        'assigned'    => ['label' => 'Assigned',   'bg' => '#dbeafe', 'text' => '#1d4ed8'],
        'in_progress' => ['label' => 'On the way', 'bg' => '#ede9fe', 'text' => '#6d28d9'],
        'delivered'   => ['label' => 'Delivered',  'bg' => '#dcfce7', 'text' => '#15803d'],
        'cancelled'   => ['label' => 'Cancelled',  'bg' => '#fee2e2', 'text' => '#dc2626'],
    ];
    $sv = $order->status instanceof \App\Enums\TaskStatus ? $order->status->value : $order->status;
    $sc = $statusConfig[$sv] ?? $statusConfig['draft'];
    $statusLabel = $order->status instanceof \App\Enums\TaskStatus ? $order->status->label() : $sc['label'];
@endphp

<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">

    {{-- ── Back + header ───────────────────────────────────── --}}
    <div>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All orders
        </a>

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-[22px] font-bold text-gray-900 font-mono tracking-tight">
                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h1>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold"
                          style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                        {{ $statusLabel }}
                    </span>
                </div>
                <p class="text-sm text-gray-400 mt-0.5">Created {{ $order->created_at->format('j F Y, g:i A') }}</p>
            </div>
        </div>
    </div>

    {{-- ── Flash ───────────────────────────────────────────── --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"
         style="background:#f0fde4;border:1px solid #bbf7d0;color:#15803d;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Status timeline ─────────────────────────────────── --}}
    @php
        $timeline = \App\Enums\TaskStatus::timeline();
        $currentIdx = collect($timeline)->search(fn ($s) => $s->value === $sv) ?? -1;
    @endphp
    @if($sv !== 'cancelled' && $sv !== 'draft')
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px 24px;">
        <div class="flex items-center gap-0">
            @foreach($timeline as $i => $step)
            @php $done = $currentIdx >= $i; @endphp
            <div class="flex items-center {{ $i < count($timeline)-1 ? 'flex-1' : '' }}">
                <div class="flex flex-col items-center gap-1.5">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all"
                         style="background:{{ $done ? '#6bc630' : '#F3F4F6' }};">
                        @if($done)
                        <svg width="13" height="13" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
                        @else
                        <div class="w-2 h-2 rounded-full" style="background:#D1D5DB;"></div>
                        @endif
                    </div>
                    <div class="text-[10px] font-semibold whitespace-nowrap"
                         style="color:{{ $done ? '#6bc630' : '#9ca3af' }};">
                        {{ $step->label() }}
                    </div>
                </div>
                @if($i < count($timeline)-1)
                <div class="h-px flex-1 mx-2 mb-5" style="background:{{ $currentIdx > $i ? '#6bc630' : '#E5E7EB' }};"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Main grid ───────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: order details --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Parcel info --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">Parcel details</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3">
                    @foreach([
                        ['label' => 'Item',        'value' => $order->item_description ?? '—'],
                        ['label' => 'Weight',      'value' => $order->weight_kg ? $order->weight_kg . ' kg' : '—'],
                        ['label' => 'Fragile',     'value' => $order->is_fragile ? 'Yes' : 'No'],
                        ['label' => 'Offered price','value' => $order->offered_price ? '$' . number_format($order->offered_price, 2) : '—'],
                        ['label' => 'Service type','value' => ucwords(str_replace('_', ' ', $order->service_type instanceof \App\Enums\ServiceType ? $order->service_type->value : $order->service_type))],
                    ] as $field)
                    <div class="flex items-start gap-3">
                        <dt class="text-xs font-semibold text-gray-400 w-28 flex-shrink-0 pt-0.5">{{ $field['label'] }}</dt>
                        <dd class="text-sm text-gray-700">{{ $field['value'] }}</dd>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Route --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">Route</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"
                             style="background:#f0fde4;border:2px solid #6bc630;">
                            <div class="w-2 h-2 rounded-full" style="background:#6bc630;"></div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 mb-0.5">Pickup</div>
                            <div class="text-sm font-medium text-gray-800">{{ $order->pickup_address }}</div>
                        </div>
                    </div>
                    <div class="ml-4 h-8 w-px" style="background:#E5E7EB;margin-left:15px;"></div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                             style="background:#dbeafe;border:2px solid #3b82f6;">
                            <div class="w-2 h-2 rounded-full" style="background:#3b82f6;"></div>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 mb-0.5">Dropoff</div>
                            <div class="text-sm font-medium text-gray-800">{{ $order->dropoff_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- People --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">People</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-3.5 rounded-xl" style="background:#f9fafb;border:1px solid #F0F1F0;">
                        <div class="text-xs font-semibold text-gray-400 mb-2">Sender</div>
                        <div class="font-medium text-gray-800 text-sm">{{ $order->user->name ?? '—' }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $order->user->email ?? '' }}</div>
                        @if($order->sender_phone)
                        <div class="text-xs text-gray-500 font-mono mt-1">{{ $order->sender_phone }}</div>
                        @endif
                    </div>
                    <div class="p-3.5 rounded-xl" style="background:#f9fafb;border:1px solid #F0F1F0;">
                        <div class="text-xs font-semibold text-gray-400 mb-2">Recipient</div>
                        <div class="font-medium text-gray-800 text-sm">{{ $order->recipient_name ?? '—' }}</div>
                        @if($order->recipient_phone)
                        <div class="text-xs text-gray-500 font-mono mt-1">{{ $order->recipient_phone }}</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: actions --}}
        <div class="space-y-4">

            {{-- Update status --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">Update status</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <div class="space-y-1.5">
                        @foreach(\App\Enums\TaskStatus::cases() as $s)
                        @php $scOpt = $statusConfig[$s->value] ?? $statusConfig['draft']; @endphp
                        <label class="flex items-center gap-3 px-3 py-2.5 rounded-xl border cursor-pointer transition-all"
                               style="border-color:{{ $sv === $s->value ? '#6bc630' : '#E9EAEC' }};background:{{ $sv === $s->value ? '#f0fde4' : '#fff' }};">
                            <input type="radio" name="status" value="{{ $s->value }}"
                                   {{ $sv === $s->value ? 'checked' : '' }}
                                   class="text-green-500 focus:ring-green-400">
                            <div class="flex items-center gap-2 flex-1">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold"
                                      style="background:{{ $scOpt['bg'] }};color:{{ $scOpt['text'] }};">
                                    {{ $s->label() }}
                                </span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all mt-1"
                            style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.25);"
                            onmouseover="this.style.background='#5aad28'"
                            onmouseout="this.style.background='#6bc630'">
                        Save status
                    </button>
                </form>
            </div>

            {{-- Assign driver --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-1">Assign driver</h2>
                @if($order->assignedDriver)
                <div class="flex items-center gap-2.5 py-3 mb-3 px-3 rounded-xl" style="background:#f0fde4;border:1px solid #bbf7d0;">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white"
                         style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                        {{ strtoupper(substr($order->assignedDriver->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-gray-800 truncate">{{ $order->assignedDriver->user->name }}</div>
                        <div class="text-xs text-gray-400">Currently assigned</div>
                    </div>
                </div>
                @endif
                <form method="POST" action="{{ route('admin.orders.assign', $order) }}" class="space-y-3">
                    @csrf @method('PATCH')
                    <select name="assigned_driver_id"
                            class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                            style="background:#fafafa;">
                        <option value="">— Unassigned —</option>
                        @foreach($availableDrivers as $d)
                        <option value="{{ $d->id }}"
                                {{ $order->assigned_driver_id == $d->id ? 'selected' : '' }}>
                            {{ $d->user->name ?? 'Unknown' }}
                            ({{ $d->trust_badge }})
                        </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-gray-700 border border-gray-200 hover:bg-gray-50 transition-colors">
                        {{ $order->assignedDriver ? 'Reassign driver' : 'Assign driver' }}
                    </button>
                </form>
            </div>

            {{-- Notes --}}
            @if($order->notes)
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-2">Notes</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $order->notes }}</p>
            </div>
            @endif

        </div>
    </div>

</div>
</x-dashboard-layout>
