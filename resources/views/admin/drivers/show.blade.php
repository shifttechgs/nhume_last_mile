<x-dashboard-layout title="Driver — {{ $driver->user->name ?? 'Driver' }}">
@php
    $tierConfig = [
        'verified'         => ['label' => 'Verified',        'bg' => '#dcfce7', 'text' => '#15803d', 'dot' => '#22c55e'],
        'manually_reviewed'=> ['label' => 'Nhume Reviewed',  'bg' => '#dbeafe', 'text' => '#1d4ed8', 'dot' => '#3b82f6'],
        'id_submitted'     => ['label' => 'ID Submitted',    'bg' => '#fef3c7', 'text' => '#b45309', 'dot' => '#f59e0b'],
        'unverified'       => ['label' => 'Unverified',      'bg' => '#f3f4f6', 'text' => '#6b7280', 'dot' => '#9ca3af'],
    ];
    $tier = $driver->trust_tier->value ?? 'unverified';
    $tc   = $tierConfig[$tier] ?? $tierConfig['unverified'];

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

    {{-- ── Back + header ───────────────────────────────────── --}}
    <div>
        <a href="{{ route('admin.drivers.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All drivers
        </a>

        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-xl font-bold text-white flex-shrink-0"
                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                    {{ strtoupper(substr($driver->user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">{{ $driver->user->name ?? 'Unknown' }}</h1>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                              style="background:{{ $tc['bg'] }};color:{{ $tc['text'] }};">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $tc['dot'] }};"></span>
                            {{ $tc['label'] }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-400 mt-0.5">{{ $driver->user->email ?? '' }}</div>
                </div>
            </div>

            {{-- Active toggle --}}
            <form method="POST" action="{{ route('admin.drivers.active', $driver) }}">
                @csrf @method('PATCH')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border transition-colors"
                        style="background:{{ $driver->is_active ? '#fff' : '#f0fde4' }};border-color:{{ $driver->is_active ? '#E9EAEC' : '#bbf7d0' }};color:{{ $driver->is_active ? '#6b7280' : '#15803d' }};">
                    <span class="w-2 h-2 rounded-full" style="background:{{ $driver->is_active ? '#22c55e' : '#9ca3af' }};"></span>
                    {{ $driver->is_active ? 'Active — click to deactivate' : 'Inactive — click to activate' }}
                </button>
            </form>
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

    {{-- ── Stat strip ──────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['label' => 'Tasks assigned', 'value' => $taskCounts['total'],     'color' => '#6bc630'],
            ['label' => 'Delivered',      'value' => $taskCounts['delivered'],  'color' => '#22c55e'],
            ['label' => 'Joined',         'value' => $driver->created_at->format('M Y'), 'color' => '#6b7280', 'text' => true],
            ['label' => 'Last reviewed',  'value' => $driver->reviewed_at?->diffForHumans() ?? 'Never', 'color' => '#6b7280', 'text' => true],
        ] as $stat)
        <div class="stat-card py-4 px-4">
            @if(isset($stat['text']))
                <div class="text-base font-bold text-gray-800">{{ $stat['value'] }}</div>
            @else
                <div class="text-2xl font-bold tabular-nums" style="color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            @endif
            <div class="text-xs text-gray-400 mt-0.5 font-medium">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── Two-column: profile + trust form ───────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Profile info --}}
        <div class="lg:col-span-3 space-y-4">

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-4">Profile</h2>
                <dl class="space-y-3">
                    @foreach([
                        ['label' => 'Full name',  'value' => $driver->user->name ?? '—'],
                        ['label' => 'Email',      'value' => $driver->user->email ?? '—'],
                        ['label' => 'Phone',      'value' => $driver->phone ?? '—'],
                        ['label' => 'WhatsApp',   'value' => $driver->whatsapp ?? '—'],
                        ['label' => 'Source',     'value' => ucfirst(str_replace('_', ' ', $driver->driver_source ?? '—'))],
                    ] as $field)
                    <div class="flex items-start gap-4">
                        <dt class="text-xs font-semibold text-gray-400 w-28 flex-shrink-0 pt-0.5">{{ $field['label'] }}</dt>
                        <dd class="text-sm text-gray-700">{{ $field['value'] }}</dd>
                    </div>
                    @endforeach
                    @if($driver->bio)
                    <div class="flex items-start gap-4">
                        <dt class="text-xs font-semibold text-gray-400 w-28 flex-shrink-0 pt-0.5">Bio</dt>
                        <dd class="text-sm text-gray-600 leading-relaxed">{{ $driver->bio }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            {{-- Recent orders --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
                <div class="px-6 py-4" style="border-bottom:1px solid #F0F1F0;">
                    <h2 class="text-sm font-semibold text-gray-800">Assigned orders</h2>
                </div>
                @forelse($recentTasks as $task)
                @php
                    $sv = $task->status instanceof \App\Enums\TaskStatus ? $task->status->value : $task->status;
                    $sc = $statusColors[$sv] ?? $statusColors['draft'];
                @endphp
                <div class="flex items-center gap-3 px-6 py-3.5 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="font-mono text-xs font-semibold text-gray-600">#{{ str_pad($task->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold"
                                  style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                {{ $task->status instanceof \App\Enums\TaskStatus ? $task->status->label() : ucfirst(str_replace('_',' ', $sv)) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 truncate">
                            {{ Str::limit($task->pickup_address, 28) }} → {{ Str::limit($task->dropoff_address, 28) }}
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 whitespace-nowrap">{{ $task->created_at->diffForHumans() }}</div>
                    <a href="{{ route('admin.orders.show', $task) }}"
                       class="text-gray-300 hover:text-gray-600 transition-colors">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                    </a>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-gray-400">No orders assigned yet.</div>
                @endforelse
            </div>

        </div>

        {{-- Trust tier management --}}
        <div class="lg:col-span-2 space-y-4">

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-1">Trust tier</h2>
                <p class="text-xs text-gray-400 mb-5">Updating this controls the badge shown to senders and which features the driver can access.</p>

                <form method="POST" action="{{ route('admin.drivers.trust', $driver) }}" class="space-y-4"
                      x-data="{ loading: false }" @submit="loading = true">
                    @csrf @method('PATCH')

                    {{-- Tier selector --}}
                    <div class="space-y-2">
                        @foreach(\App\Enums\TrustTier::cases() as $t)
                        @php $tcOpt = $tierConfig[$t->value] ?? $tierConfig['unverified']; @endphp
                        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all"
                               style="border-color:{{ $tier === $t->value ? $tcOpt['dot'] : '#E9EAEC' }};background:{{ $tier === $t->value ? $tcOpt['bg'] : '#fff' }};">
                            <input type="radio" name="trust_tier" value="{{ $t->value }}"
                                   {{ $tier === $t->value ? 'checked' : '' }}
                                   class="text-green-500 focus:ring-green-400">
                            <div>
                                <div class="text-sm font-semibold" style="color:{{ $tcOpt['text'] }}">{{ $tcOpt['label'] }}</div>
                                @php
                                $tierDesc = [
                                    'verified'         => 'Fully vetted — all features unlocked',
                                    'manually_reviewed'=> 'Nhume team has spoken to this person',
                                    'id_submitted'     => 'Documents uploaded, pending review',
                                    'unverified'       => 'Newly registered, unvetted',
                                ];
                            @endphp
                            <div class="text-xs text-gray-400">{{ $tierDesc[$t->value] ?? $t->value }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Review notes (internal)</label>
                        <textarea name="trust_notes" rows="3"
                                  placeholder="Why was this tier assigned? Any flags?"
                                  class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 resize-none"
                                  style="background:#fafafa;">{{ $driver->trust_notes }}</textarea>
                    </div>

                    @if($driver->reviewed_by && $driver->reviewer)
                    <div class="text-xs text-gray-400">
                        Last updated by <strong class="text-gray-600">{{ $driver->reviewer->name }}</strong>
                        {{ $driver->reviewed_at?->diffForHumans() }}
                    </div>
                    @endif

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition-all"
                            style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.28);"
                            :style="loading ? 'opacity:0.65;cursor:not-allowed' : ''"
                            :disabled="loading"
                            onmouseover="if(!loading) this.style.background='#5aad28'"
                            onmouseout="this.style.background='#6bc630'">
                        <svg x-show="loading" x-cloak class="form-spinner" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        <span x-text="loading ? 'Saving…' : 'Save trust tier'"></span>
                    </button>
                </form>
            </div>

            {{-- Driver source info --}}
            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">Service types</h2>
                @php $services = is_array($driver->service_types) ? $driver->service_types : json_decode($driver->service_types ?? '[]', true); @endphp
                <div class="flex flex-wrap gap-2">
                    @forelse($services ?? [] as $svc)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium"
                          style="background:#f0fde4;color:#15803d;border:1px solid #bbf7d0;">
                        {{ ucwords(str_replace('_', ' ', $svc)) }}
                    </span>
                    @empty
                    <span class="text-sm text-gray-400">No service types set</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
</x-dashboard-layout>
