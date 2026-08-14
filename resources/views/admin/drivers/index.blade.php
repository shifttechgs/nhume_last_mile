<x-dashboard-layout title="Drivers">
@php
    $tierConfig = [
        'verified'         => ['label' => 'Verified',  'bg' => '#dcfce7', 'text' => '#15803d', 'dot' => '#22c55e'],
        'manually_reviewed'=> ['label' => 'Reviewed',  'bg' => '#dbeafe', 'text' => '#1d4ed8', 'dot' => '#3b82f6'],
        'id_submitted'     => ['label' => 'ID Sent',   'bg' => '#fef3c7', 'text' => '#b45309', 'dot' => '#f59e0b'],
        'unverified'       => ['label' => 'New',       'bg' => '#f3f4f6', 'text' => '#6b7280', 'dot' => '#9ca3af'],
    ];
@endphp

<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Drivers</h1>
            <p class="text-sm text-gray-400 mt-0.5">Manage transporter accounts and trust verification</p>
        </div>
        <a href="#"
           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 16px rgba(107,198,48,0.28);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Driver
        </a>
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
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        @foreach([
            ['label' => 'Total',    'value' => $counts['total'],    'color' => '#6b7280'],
            ['label' => 'Active',   'value' => $counts['active'],   'color' => '#6bc630'],
            ['label' => 'Verified', 'value' => $counts['verified'], 'color' => '#22c55e'],
            ['label' => 'Reviewed', 'value' => $counts['reviewed'], 'color' => '#3b82f6'],
            ['label' => 'Pending',  'value' => $counts['pending'],  'color' => '#f59e0b'],
        ] as $stat)
        <div class="stat-card py-4 px-4">
            <div class="text-2xl font-bold tabular-nums" style="color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5 font-medium">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── Filters ─────────────────────────────────────────── --}}
    <form method="GET" class="flex flex-wrap gap-3 items-center">
        <div class="flex items-center gap-2 px-3 py-2 rounded-xl flex-1 min-w-[200px]"
             style="background:#fff;border:1px solid #E9EAEC;">
            <svg width="15" height="15" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name, email, phone…"
                   class="bg-transparent border-0 p-0 text-sm text-gray-700 placeholder-gray-400 focus:ring-0 outline-none w-full">
        </div>

        <select name="tier"
                class="px-3 py-2 rounded-xl text-sm border text-gray-700 focus:ring-0 focus:border-gray-300"
                style="background:#fff;border:1px solid #E9EAEC;"
                onchange="this.form.submit()">
            <option value="">All tiers</option>
            @foreach(\App\Enums\TrustTier::cases() as $tier)
            <option value="{{ $tier->value }}" {{ request('tier') === $tier->value ? 'selected' : '' }}>
                {{ $tierConfig[$tier->value]['label'] ?? $tier->value }}
            </option>
            @endforeach
        </select>

        <select name="status"
                class="px-3 py-2 rounded-xl text-sm border text-gray-700 focus:ring-0 focus:border-gray-300"
                style="background:#fff;border:1px solid #E9EAEC;"
                onchange="this.form.submit()">
            <option value="">All status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        @if(request()->hasAny(['search','tier','status']))
        <a href="{{ route('admin.drivers.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 px-2 py-2">Clear</a>
        @endif
    </form>

    {{-- ── Table ───────────────────────────────────────────── --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Driver</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Phone</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Trust tier</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden lg:table-cell">Joined</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($drivers as $driver)
                    @php
                        $tier = $driver->trust_tier->value ?? 'unverified';
                        $tc   = $tierConfig[$tier] ?? $tierConfig['unverified'];
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                                    {{ strtoupper(substr($driver->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-gray-800 truncate">{{ $driver->user->name ?? 'Unknown' }}</div>
                                    <div class="text-xs text-gray-400 truncate">{{ $driver->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 hidden md:table-cell font-mono text-xs">
                            {{ $driver->phone ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                  style="background:{{ $tc['bg'] }};color:{{ $tc['text'] }};">
                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:{{ $tc['dot'] }};"></span>
                                {{ $tc['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 hidden lg:table-cell whitespace-nowrap">
                            {{ $driver->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.drivers.active', $driver) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold transition-opacity hover:opacity-80"
                                        style="background:{{ $driver->is_active ? '#dcfce7' : '#f3f4f6' }};color:{{ $driver->is_active ? '#15803d' : '#6b7280' }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $driver->is_active ? '#22c55e' : '#9ca3af' }};"></span>
                                    {{ $driver->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.drivers.show', $driver) }}"
                               class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors opacity-0 group-hover:opacity-100">
                                View
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="text-2xl mb-2">🚗</div>
                            <div class="text-sm font-medium text-gray-500">No drivers found</div>
                            <div class="text-xs text-gray-400 mt-1">
                                @if(request()->hasAny(['search','tier','status']))
                                    Try adjusting your filters
                                @else
                                    Run the seeder to add drivers
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($drivers->hasPages())
        <div class="px-6 py-4" style="border-top:1px solid #F0F1F0;">
            {{ $drivers->links() }}
        </div>
        @endif
    </div>

</div>
</x-dashboard-layout>
