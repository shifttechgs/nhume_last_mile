<x-dashboard-layout title="My Journeys">

<div style="display:flex;flex-direction:column;gap:24px">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
        <div>
            <h1 style="font-family:var(--ink);font-size:20px;font-weight:700;color:var(--ink);margin:0 0 3px;letter-spacing:-0.02em">My Journeys</h1>
            <p style="font-family:inherit;font-size:13.5px;color:var(--body);margin:0">Trips you've posted for parcel bookings.</p>
        </div>
        <a href="{{ route('transporter.journeys.create') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:10px 18px;background:var(--acc-2);color:#fff;font-size:13.5px;font-weight:600;border-radius:8px;text-decoration:none;transition:background 0.15s;white-space:nowrap"
           onmouseover="this.style.background='var(--acc)'" onmouseout="this.style.background='var(--acc-2)'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Post a journey
        </a>
    </div>

    @if(session('success'))
    <div style="display:flex;align-items:center;gap:10px;padding:13px 16px;background:#DCFCE7;border:1px solid #86efac;border-radius:10px;">
        <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
        <span style="font-size:13.5px;font-weight:500;color:#15803d">{{ session('success') }}</span>
    </div>
    @endif

    @if($journeys->isEmpty())

    {{-- Empty state --}}
    <div class="d-card" style="text-align:center;padding:64px 24px">
        <div style="width:56px;height:56px;border-radius:16px;background:#F0FDE4;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
            <svg width="26" height="26" fill="none" stroke="var(--acc-2)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                <line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
            </svg>
        </div>
        <h3 style="font-size:15px;font-weight:700;color:var(--ink);margin:0 0 6px">No journeys posted yet</h3>
        <p style="font-size:13.5px;color:var(--body);margin:0 0 24px;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.6">Post your first journey and let senders book space on your trip. Takes two minutes.</p>
        <a href="{{ route('transporter.journeys.create') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:10px 20px;background:var(--acc-2);color:#fff;font-size:13.5px;font-weight:600;border-radius:8px;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Post your first journey
        </a>
    </div>

    @else

    {{-- Journeys table --}}
    <div class="d-card" style="padding:0;overflow:hidden">
        <table class="d-table" style="width:100%">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Departs</th>
                    <th>Space</th>
                    <th>Price / kg</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($journeys as $journey)
                @php
                    $statusCfg = match($journey->status->value) {
                        'scheduled'   => ['dot' => '#6bc630', 'bg' => '#F0FDE4', 'text' => '#15803d', 'label' => 'Scheduled'],
                        'in_progress' => ['dot' => '#f59e0b', 'bg' => '#FEF3C7', 'text' => '#d97706', 'label' => 'In Progress'],
                        'completed'   => ['dot' => '#6b7280', 'bg' => '#F3F4F6', 'text' => '#6b7280', 'label' => 'Completed'],
                        'cancelled'   => ['dot' => '#ef4444', 'bg' => '#FEF2F2', 'text' => '#dc2626', 'label' => 'Cancelled'],
                        default       => ['dot' => '#9ca3af', 'bg' => '#F9FAFB', 'text' => '#6b7280', 'label' => 'Draft'],
                    };
                @endphp
                <tr>
                    <td>
                        <span style="font-weight:600;color:var(--ink)">{{ $journey->route?->origin_city }}</span>
                        <span style="color:var(--acc);margin:0 4px">→</span>
                        <span style="font-weight:600;color:var(--ink)">{{ $journey->route?->destination_city }}</span>
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--ink)">{{ $journey->departs_at->format('d M Y') }}</div>
                        <div style="font-size:12px;color:var(--body)">{{ $journey->departs_at->format('H:i') }}</div>
                    </td>
                    <td>
                        @if($journey->available_weight_kg)
                            <span style="font-size:13px;color:var(--ink)">{{ number_format($journey->available_weight_kg, 1) }} kg</span>
                        @else
                            <span style="color:var(--muted)">—</span>
                        @endif
                    </td>
                    <td>
                        @if($journey->price_per_kg)
                            <span style="font-weight:600;color:var(--ink)">${{ number_format($journey->price_per_kg, 2) }}</span>
                        @elseif($journey->min_price)
                            <span style="font-size:12px;color:var(--body)">From ${{ number_format($journey->min_price, 2) }}</span>
                        @else
                            <span style="color:var(--muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:99px;background:{{ $statusCfg['bg'] }};font-size:11px;font-weight:700;color:{{ $statusCfg['text'] }}">
                            <span style="width:5px;height:5px;border-radius:50%;background:{{ $statusCfg['dot'] }};flex-shrink:0"></span>
                            {{ $statusCfg['label'] }}
                        </span>
                    </td>
                    <td style="text-align:right">
                        @if($journey->status->value === 'scheduled')
                        <form method="POST" action="{{ route('transporter.journeys.cancel', $journey) }}"
                              onsubmit="return confirm('Cancel this journey?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    style="font-size:12px;color:#dc2626;background:none;border:none;cursor:pointer;font-weight:500;padding:4px 8px;border-radius:6px;transition:background 0.15s"
                                    onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='none'">
                                Cancel
                            </button>
                        </form>
                        @else
                            <span style="color:var(--muted);font-size:12px">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($journeys->hasPages())
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 24px;border-top:1px solid var(--line);gap:12px">
            <span style="font-size:13px;color:var(--body)">
                Showing {{ $journeys->firstItem() }}–{{ $journeys->lastItem() }} of {{ $journeys->total() }}
            </span>
            <div style="display:flex;gap:6px">
                @if($journeys->onFirstPage())
                    <span class="qa-row" style="opacity:0.35;cursor:default;padding:6px 12px">← Prev</span>
                @else
                    <a href="{{ $journeys->previousPageUrl() }}" class="qa-row" style="padding:6px 12px;text-decoration:none">← Prev</a>
                @endif
                @if($journeys->hasMorePages())
                    <a href="{{ $journeys->nextPageUrl() }}" class="qa-row" style="padding:6px 12px;text-decoration:none">Next →</a>
                @else
                    <span class="qa-row" style="opacity:0.35;cursor:default;padding:6px 12px">Next →</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    @endif

</div>

</x-dashboard-layout>
