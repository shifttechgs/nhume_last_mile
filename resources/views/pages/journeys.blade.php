@extends('layouts.landing')
@section('title', 'Available Journeys — Nhume')
@section('description', 'Find verified transporters already travelling your route. Contact them on WhatsApp — your parcel moves for a fraction of courier prices.')

@section('content')

<div class="lp-hero">
    <span class="lp-eyebrow">Available journeys</span>
    <h1>Find someone going<br>your way.</h1>
    <p>Every trip here is a real person already heading to the destination. WhatsApp them directly — your parcel travels with them.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Filter bar --}}
    <div class="lp-section">
        <form method="GET" action="{{ route('journeys') }}" x-data="{ loading: false }" @submit="loading = true">
            <div class="lp-card" style="padding:20px 24px">
                <div style="display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap">

                    <div style="flex:1;min-width:180px">
                        <label class="lp-label">Route</label>
                        <select name="route_id" class="lp-input" style="cursor:pointer">
                            <option value="">All routes</option>
                            @foreach($routes as $r)
                                <option value="{{ $r->id }}" @selected(request('route_id') == $r->id)>
                                    {{ $r->origin_city }} → {{ $r->destination_city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="flex:0 0 180px">
                        <label class="lp-label">Departure date</label>
                        <input type="date" name="date" class="lp-input"
                               value="{{ request('date') }}"
                               min="{{ now()->toDateString() }}">
                    </div>

                    <div style="display:flex;gap:8px;align-items:center">
                        <button type="submit" class="lp-btn" :disabled="loading"
                                style="min-width:90px;justify-content:center;transition:opacity 0.15s"
                                :style="loading ? 'opacity:0.7;cursor:not-allowed' : ''">
                            <svg x-show="loading" x-cloak width="14" height="14" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                 style="animation:spin 0.7s linear infinite;flex-shrink:0">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                            <span x-show="!loading">Search</span>
                            <span x-show="loading" x-cloak>Searching…</span>
                        </button>
                        @if(request()->hasAny(['route_id','date']))
                            <a href="{{ route('journeys') }}" style="font-family:var(--font);font-size:13px;color:var(--text-2);text-decoration:none">Clear</a>
                        @endif
                    </div>

                </div>
            </div>
        </form>
    </div>

    @if($journeys->isEmpty())

    {{-- Empty state — single unified block, no separate CTA card --}}
    <div class="lp-card" style="padding:64px 40px;text-align:center;margin-bottom:0">

        {{-- Icon --}}
        <div style="width:52px;height:52px;border-radius:12px;background:var(--green-light);display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
            <svg width="24" height="24" fill="none" stroke="var(--green-mid)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polygon points="1,6 1,22 8,18 16,22 23,18 23,2 16,6 8,2"/>
                <line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/>
            </svg>
        </div>

        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 10px">
            @if(request()->hasAny(['route_id','date']))
                No journeys on that route yet
            @else
                No journeys available right now
            @endif
        </p>

        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.7;margin:0 auto 28px;max-width:380px">
            @if(request()->hasAny(['route_id','date']))
                Nobody has posted a trip matching those filters. Try a different route or date, or be the first to post this journey.
            @else
                Transporters post new journeys daily. Check back soon or sign up to get notified.
            @endif
        </p>

        <div style="display:flex;align-items:center;justify-content:center;gap:10px;flex-wrap:wrap">
            @if(request()->hasAny(['route_id','date']))
                <a href="{{ route('journeys') }}" class="lp-btn-ghost">View all journeys</a>
            @endif
            @auth
                @if(auth()->user()->role->value === 'transport_partner')
                    <a href="{{ route('transporter.journeys.create') }}" class="lp-btn">Post this journey</a>
                @else
                    <a href="{{ route('partner') }}" class="lp-btn">Become a transporter</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="lp-btn">Get started</a>
            @endauth
        </div>

        {{-- Divider + transporter note --}}
        <div style="border-top:1px solid var(--border);margin:36px 0 0;padding-top:28px">
            <p style="font-family:var(--font);font-size:13px;color:var(--text-2);margin:0;line-height:1.65">
                Travelling this route yourself?
                <a href="{{ route('partner') }}" style="color:var(--forest);font-weight:600;text-decoration:none">Post your journey</a>
                and let senders contact you on WhatsApp.
            </p>
        </div>

    </div>

    @else

    {{-- Results count + post CTA — only shown when there are results --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">
            <strong style="color:var(--text)">{{ $journeys->total() }}</strong>
            {{ Str::plural('journey', $journeys->total()) }}
            {{ request()->hasAny(['route_id','date']) ? 'matching your filters' : 'departing soon' }}
        </p>
        @auth
            @if(auth()->user()->role->value === 'transport_partner')
            <a href="{{ route('transporter.journeys.create') }}" class="lp-btn">+ Post your journey</a>
            @endif
        @endauth
    </div>

    {{-- 4-column grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:40px">
        @foreach($journeys as $journey)
        @php
            $tp       = $journey->transporter;
            $user     = $tp?->user;
            $tier     = $tp?->trust_tier?->value ?? 'unverified';
            $initials = $user ? strtoupper(substr($user->name, 0, 1)) : 'N';

            [$badgeBg, $badgeColor, $badgeLabel, $badgeCheck] = match($tier) {
                'verified'          => ['#edf8df', 'var(--green-mid)', 'Nhume Verified',  true],
                'manually_reviewed' => ['#dbeafe', '#1d4ed8',          'Nhume Reviewed',  true],
                'id_submitted'      => ['#fef3c7', '#d97706',          'ID Submitted',    false],
                default             => ['#f3f4f6', '#6b7280',          'Unverified',      false],
            };

            $waNumber  = preg_replace('/[^0-9]/', '', $tp?->whatsapp ?? $tp?->phone ?? '');
            $waMessage = urlencode("Hi {$user?->name}, I found your journey on Nhume. Are you still travelling from {$journey->route?->origin_city} to {$journey->route?->destination_city} on {$journey->departs_at->format('D d M Y')}? I'd like to send a parcel with you.");
            $waUrl     = $waNumber ? "https://wa.me/{$waNumber}?text={$waMessage}" : null;
        @endphp

        <div class="lp-card" style="padding:20px;display:flex;flex-direction:column;gap:0">

            {{-- Route --}}
            <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 2px;letter-spacing:-0.02em;line-height:1.3">
                {{ $journey->route?->origin_city }}
                <span style="color:var(--green-mid);font-size:13px;margin:0 2px">→</span>
                {{ $journey->route?->destination_city }}
            </p>
            @if($journey->route?->distance_km)
            <p style="font-family:var(--font);font-size:11px;color:var(--text-2);margin:0 0 12px">{{ number_format($journey->route->distance_km) }} km</p>
            @endif

            {{-- Departure --}}
            <p style="font-family:var(--font);font-size:12.5px;color:var(--text-2);margin:0 0 16px;display:flex;align-items:center;gap:5px">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                <strong style="color:var(--text);font-weight:600">{{ $journey->departs_at->format('D, d M Y') }}</strong>&nbsp;· {{ $journey->departs_at->format('H:i') }}
            </p>

            <div style="border-top:1px solid var(--border);padding-top:14px;margin-bottom:14px">

                {{-- Transporter --}}
                <div style="display:flex;align-items:center;gap:9px;margin-bottom:10px">
                    <div style="width:30px;height:30px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:11px;font-weight:700;color:var(--forest);flex-shrink:0;text-transform:uppercase">{{ $initials }}</div>
                    <div style="min-width:0">
                        <p style="font-family:var(--font);font-size:12.5px;font-weight:600;color:var(--text);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $user?->name ?? 'Nhume Transporter' }}</p>
                        <span style="display:inline-flex;align-items:center;gap:3px;font-family:var(--font);font-size:10px;font-weight:700;padding:2px 7px;border-radius:4px;background:{{ $badgeBg }};color:{{ $badgeColor }};margin-top:2px">
                            @if($badgeCheck)<svg width="8" height="8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>@endif
                            {{ $badgeLabel }}
                        </span>
                    </div>
                </div>

                {{-- Capacity --}}
                <div style="display:flex;gap:6px;flex-wrap:wrap">
                    @if($journey->available_weight_kg)
                    <span style="font-family:var(--font);font-size:11.5px;color:var(--text-2);background:#fff;border:1px solid var(--border);border-radius:4px;padding:3px 8px">
                        <strong style="color:var(--text)">{{ number_format($journey->available_weight_kg, 0) }} kg</strong> space
                    </span>
                    @endif
                    @if($journey->available_slots > 0)
                    <span style="font-family:var(--font);font-size:11.5px;color:var(--text-2);background:#fff;border:1px solid var(--border);border-radius:4px;padding:3px 8px">
                        <strong style="color:var(--text)">{{ $journey->available_slots }}</strong> {{ Str::plural('slot', $journey->available_slots) }}
                    </span>
                    @endif
                </div>

                {{-- Notes --}}
                @if($journey->notes)
                <p style="font-family:var(--font);font-size:11.5px;color:var(--text-2);line-height:1.55;margin:10px 0 0;font-style:italic">"{{ Str::limit($journey->notes, 80) }}"</p>
                @endif

            </div>

            {{-- Footer: price + WhatsApp --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:auto;padding-top:14px;border-top:1px solid var(--border)">
                <div>
                    @if($journey->price_per_kg)
                        <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0;letter-spacing:-0.02em">${{ number_format($journey->price_per_kg, 2) }} <span style="font-family:var(--font);font-size:11px;font-weight:400;color:var(--text-2)">/ kg</span></p>
                        @if($journey->min_price)
                        <p style="font-family:var(--font);font-size:10.5px;color:var(--text-2);margin:1px 0 0">min ${{ number_format($journey->min_price, 2) }}</p>
                        @endif
                    @elseif($journey->min_price)
                        <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0">From ${{ number_format($journey->min_price, 2) }}</p>
                    @else
                        <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:0;font-style:italic">Negotiate</p>
                    @endif
                </div>

                @if($waUrl)
                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:5px;padding:8px 13px;background:#25D366;color:#fff;font-family:var(--font);font-size:12.5px;font-weight:700;border-radius:6px;text-decoration:none;white-space:nowrap;flex-shrink:0;transition:background 0.15s"
                   onmouseover="this.style.background='#1da851'" onmouseout="this.style.background='#25D366'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
                @else
                <span style="font-family:var(--font);font-size:11.5px;color:var(--text-2)">Contact via Nhume</span>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($journeys->hasPages())
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:40px">
        <span style="font-family:var(--font);font-size:13px;color:var(--text-2)">
            Showing {{ $journeys->firstItem() }}–{{ $journeys->lastItem() }} of {{ $journeys->total() }}
        </span>
        <div style="display:flex;gap:6px">
            @if($journeys->onFirstPage())
                <span class="lp-btn-ghost" style="opacity:0.4;cursor:default;padding:8px 16px">← Prev</span>
            @else
                <a href="{{ $journeys->previousPageUrl() }}" class="lp-btn-ghost" style="padding:8px 16px;text-decoration:none">← Prev</a>
            @endif
            @if($journeys->hasMorePages())
                <a href="{{ $journeys->nextPageUrl() }}" class="lp-btn-ghost" style="padding:8px 16px;text-decoration:none">Next →</a>
            @else
                <span class="lp-btn-ghost" style="opacity:0.4;cursor:default;padding:8px 16px">Next →</span>
            @endif
        </div>
    </div>
    @endif

    @endif

    {{-- Transporter CTA — only shown when results exist; empty state has its own CTA --}}
    @if($journeys->isNotEmpty())
    <div class="lp-section">
        <div class="lp-card" style="display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap">
            <div>
                <p style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--green-mid);margin:0 0 6px">For transporters</p>
                <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0 0 4px">Travelling this weekend? Let your empty space earn.</p>
                <p style="font-family:var(--font);font-size:13.5px;color:var(--text-2);margin:0;line-height:1.65">Post your journey in two minutes. Senders WhatsApp you directly, you agree the price.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0">
                @auth
                    @if(auth()->user()->role->value === 'transport_partner')
                        <a href="{{ route('transporter.journeys.create') }}" class="lp-btn">Post a journey</a>
                    @else
                        <a href="{{ route('partner') }}" class="lp-btn">Become a partner</a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="lp-btn">Get started</a>
                    <a href="{{ route('partner') }}" class="lp-btn-ghost">Learn more</a>
                @endauth
            </div>
        </div>
    </div>
    @endif

</div>
</div>

@section('styles')
<style>
/* Override browser blue on form controls */
.lp-input { accent-color: var(--forest); }
.lp-input:focus-visible { outline: none; box-shadow: none; }
select.lp-input { appearance: none; -webkit-appearance: none; }
@keyframes spin { to { transform: rotate(360deg); } }

@media (max-width: 1100px) {
    div[style*="grid-template-columns:repeat(4,1fr)"] { grid-template-columns: repeat(3,1fr) !important; }
}
@media (max-width: 780px) {
    div[style*="grid-template-columns:repeat(4,1fr)"],
    div[style*="grid-template-columns: repeat(3,1fr)"] { grid-template-columns: repeat(2,1fr) !important; }
}
@media (max-width: 500px) {
    div[style*="grid-template-columns:repeat(4,1fr)"] { grid-template-columns: 1fr !important; }
}
</style>
@endsection

@endsection
