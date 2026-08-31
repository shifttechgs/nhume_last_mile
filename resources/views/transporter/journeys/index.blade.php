<x-dashboard-layout title="My Journeys">

@php
    $profileId = Auth::user()->transporterProfile?->id;
    $counts = \App\Models\Journey::where('transporter_profile_id', $profileId)
        ->selectRaw("
            COUNT(*) as total,
            COUNT(CASE WHEN status = 'scheduled'   THEN 1 END) as scheduled,
            COUNT(CASE WHEN status = 'in_progress' THEN 1 END) as in_progress,
            COUNT(CASE WHEN status = 'completed'   THEN 1 END) as completed,
            COUNT(CASE WHEN status = 'cancelled'   THEN 1 END) as cancelled
        ")->first();
@endphp

<div class="p-6 lg:p-8 max-w-[1100px] mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">My Journeys</h1>
            <p class="text-sm text-gray-400 mt-0.5">Trips you've posted — senders contact you directly on WhatsApp.</p>
        </div>
        <a href="{{ route('transporter.journeys.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 16px rgba(107,198,48,0.28);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Post a journey
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"
         style="background:#f0fde4;border:1px solid #bbf7d0;color:#15803d;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stat strip --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['Total',       $counts->total,       '#6b7280'],
            ['Scheduled',   $counts->scheduled,   '#6bc630'],
            ['In Progress', $counts->in_progress, '#f59e0b'],
            ['Completed',   $counts->completed,   '#3b82f6'],
        ] as [$label, $value, $color])
        <div class="stat-card py-4 px-4">
            <div class="text-2xl font-bold tabular-nums" style="color:{{ $color }}">{{ $value }}</div>
            <div class="text-xs text-gray-400 mt-0.5 font-medium">{{ $label }}</div>
        </div>
        @endforeach
    </div>

    @if($journeys->isEmpty())

    {{-- Empty state --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;" class="px-6 py-16 text-center">
        <div class="w-14 h-14 rounded-2xl mx-auto mb-4 flex items-center justify-center" style="background:#f0fde4;">
            <svg width="26" height="26" fill="none" stroke="#6bc630" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                <line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
            </svg>
        </div>
        <p class="text-base font-semibold text-gray-800 mb-1">No journeys posted yet</p>
        <p class="text-sm text-gray-400 mb-6 max-w-sm mx-auto leading-relaxed">Post your first journey and let senders find you on the marketplace. Takes two minutes.</p>
        <a href="{{ route('transporter.journeys.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.28);">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Post your first journey
        </a>
    </div>

    @else

    {{-- Table --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Route</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Departs</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden sm:table-cell">Space</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Price</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($journeys as $journey)
                    @php
                        $sc = match($journey->status->value) {
                            'scheduled'   => ['bg' => '#f0fde4', 'text' => '#15803d', 'dot' => '#6bc630',  'label' => 'Scheduled'],
                            'in_progress' => ['bg' => '#fef3c7', 'text' => '#d97706', 'dot' => '#f59e0b',  'label' => 'In Progress'],
                            'completed'   => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'dot' => '#3b82f6',  'label' => 'Completed'],
                            'cancelled'   => ['bg' => '#fee2e2', 'text' => '#dc2626', 'dot' => '#ef4444',  'label' => 'Cancelled'],
                            default       => ['bg' => '#f3f4f6', 'text' => '#6b7280', 'dot' => '#9ca3af',  'label' => 'Draft'],
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors group">

                        {{-- Route --}}
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">
                                {{ $journey->route?->origin_city }}
                                <span class="text-green-500 mx-1">→</span>
                                {{ $journey->route?->destination_city }}
                            </div>
                            @if($journey->route?->distance_km)
                            <div class="text-xs text-gray-400 mt-0.5">{{ number_format($journey->route->distance_km) }} km</div>
                            @endif
                        </td>

                        {{-- Departs --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-800">{{ $journey->departs_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">{{ $journey->departs_at->format('H:i') }}</div>
                        </td>

                        {{-- Space --}}
                        <td class="px-6 py-4 hidden sm:table-cell">
                            @if($journey->available_weight_kg)
                                <div class="text-gray-700 font-medium">{{ number_format($journey->available_weight_kg, 0) }} kg</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $journey->available_slots }} {{ Str::plural('slot', $journey->available_slots) }}</div>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>

                        {{-- Price --}}
                        <td class="px-6 py-4 hidden md:table-cell">
                            @if($journey->price_per_kg)
                                <div class="font-semibold text-gray-800">${{ number_format($journey->price_per_kg, 2) }}<span class="text-xs font-normal text-gray-400"> /kg</span></div>
                                @if($journey->min_price)
                                <div class="text-xs text-gray-400 mt-0.5">min ${{ number_format($journey->min_price, 2) }}</div>
                                @endif
                            @elseif($journey->min_price)
                                <div class="text-gray-700">From ${{ number_format($journey->min_price, 2) }}</div>
                            @else
                                <span class="text-xs text-gray-400 italic">Negotiate</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold"
                                  style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:{{ $sc['dot'] }};"></span>
                                {{ $sc['label'] }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            @if($journey->status->value === 'scheduled')
                            <form method="POST" action="{{ route('transporter.journeys.cancel', $journey) }}"
                                  onsubmit="return confirm('Cancel this journey? Senders who have already contacted you should be notified.')">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs font-medium text-gray-400 hover:text-red-500 transition-colors px-2 py-1 rounded-lg hover:bg-red-50">
                                    Cancel
                                </button>
                            </form>
                            @else
                                <span class="text-gray-200 text-xs">—</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($journeys->hasPages())
        <div class="px-6 py-4 flex items-center justify-between gap-4" style="border-top:1px solid #F0F1F0;">
            <span class="text-sm text-gray-400">
                Showing {{ $journeys->firstItem() }}–{{ $journeys->lastItem() }} of {{ $journeys->total() }}
            </span>
            <div class="flex gap-2">
                @if($journeys->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-300 border border-gray-100 cursor-default">← Prev</span>
                @else
                    <a href="{{ $journeys->previousPageUrl() }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">← Prev</a>
                @endif
                @if($journeys->hasMorePages())
                    <a href="{{ $journeys->nextPageUrl() }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">Next →</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-300 border border-gray-100 cursor-default">Next →</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    @endif

</div>

</x-dashboard-layout>
