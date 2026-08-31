<x-dashboard-layout title="Post a Journey">

<div style="max-width:640px">

    {{-- Back link --}}
    <a href="{{ route('transporter.journeys.index') }}"
       style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--body);text-decoration:none;margin-bottom:24px;transition:color 0.15s"
       onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--body)'">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15,18 9,12 15,6"/></svg>
        Back to my journeys
    </a>

    <div style="margin-bottom:28px">
        <h1 style="font-family:inherit;font-size:20px;font-weight:700;color:var(--ink);margin:0 0 4px;letter-spacing:-0.02em">Post a journey</h1>
        <p style="font-size:13.5px;color:var(--body);margin:0;line-height:1.6">Tell senders when you're travelling and how much space you have. They'll book directly onto your trip.</p>
    </div>

    <form method="POST" action="{{ route('transporter.journeys.store') }}"
          x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Route --}}
            <div class="d-card" style="padding:24px">
                <h2 style="font-size:13px;font-weight:700;color:var(--ink);text-transform:uppercase;letter-spacing:0.07em;margin:0 0 18px">Trip details</h2>

                <div style="display:flex;flex-direction:column;gap:16px">

                    <div>
                        <label for="route_id" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Route *</label>
                        <select id="route_id" name="route_id" required
                                style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('route_id') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                            <option value="">Select a route…</option>
                            @foreach($routes as $r)
                                <option value="{{ $r->id }}" @selected(old('route_id') == $r->id)>
                                    {{ $r->origin_city }} → {{ $r->destination_city }}
                                    @if($r->distance_km) ({{ number_format($r->distance_km) }} km) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('route_id')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="departs_at" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Departure date & time *</label>
                        <input type="datetime-local" id="departs_at" name="departs_at"
                               value="{{ old('departs_at') }}"
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                               required
                               style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('departs_at') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                        @error('departs_at')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>

            {{-- Space & pricing --}}
            <div class="d-card" style="padding:24px">
                <h2 style="font-size:13px;font-weight:700;color:var(--ink);text-transform:uppercase;letter-spacing:0.07em;margin:0 0 18px">Available space & pricing</h2>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                    <div>
                        <label for="available_weight_kg" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Max weight (kg)</label>
                        <input type="number" id="available_weight_kg" name="available_weight_kg"
                               value="{{ old('available_weight_kg') }}"
                               min="0.1" max="9999" step="0.1" placeholder="e.g. 50"
                               style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('available_weight_kg') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                        @error('available_weight_kg')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="available_slots" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Parcel slots *</label>
                        <input type="number" id="available_slots" name="available_slots"
                               value="{{ old('available_slots', 1) }}"
                               min="1" max="100" required
                               style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('available_slots') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                        @error('available_slots')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="price_per_kg" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Price per kg (USD)</label>
                        <input type="number" id="price_per_kg" name="price_per_kg"
                               value="{{ old('price_per_kg') }}"
                               min="0" step="0.01" placeholder="e.g. 2.50"
                               style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('price_per_kg') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                        @error('price_per_kg')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="min_price" style="display:block;font-size:12px;font-weight:600;color:var(--body);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em">Minimum price (USD)</label>
                        <input type="number" id="min_price" name="min_price"
                               value="{{ old('min_price') }}"
                               min="0" step="0.01" placeholder="e.g. 5.00"
                               style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('min_price') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none">
                        @error('min_price')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
                    </div>

                </div>
                <p style="margin:14px 0 0;font-size:12px;color:var(--muted);line-height:1.55">Leave pricing blank if you prefer to negotiate with senders directly.</p>
            </div>

            {{-- Notes --}}
            <div class="d-card" style="padding:24px">
                <h2 style="font-size:13px;font-weight:700;color:var(--ink);text-transform:uppercase;letter-spacing:0.07em;margin:0 0 18px">Notes <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--muted)">(optional)</span></h2>
                <textarea id="notes" name="notes" rows="3"
                          placeholder="e.g. Fragile items welcome. No food. Will stop in Gweru."
                          style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('notes') ? '#ef4444' : 'var(--line)' }};border-radius:8px;font-family:inherit;font-size:14px;color:var(--ink);background:#fff;outline:none;resize:vertical;line-height:1.6">{{ old('notes') }}</textarea>
                @error('notes')<p style="margin:5px 0 0;font-size:12px;color:#ef4444">{{ $message }}</p>@enderror
            </div>

            {{-- Submit --}}
            <div style="display:flex;align-items:center;gap:12px">
                <button type="submit"
                        style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:var(--acc-2);color:#fff;font-family:inherit;font-size:14px;font-weight:600;border:none;border-radius:8px;cursor:pointer;transition:background 0.15s;min-width:140px;justify-content:center"
                        :style="loading ? 'opacity:0.65;cursor:not-allowed' : ''"
                        :disabled="loading"
                        onmouseover="if(!loading) this.style.background='var(--acc)'" onmouseout="this.style.background='var(--acc-2)'">
                    <svg x-show="loading" x-cloak class="form-spinner" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    <svg x-show="!loading" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
                    <span x-text="loading ? 'Posting…' : 'Post journey'"></span>
                </button>
                <a href="{{ route('transporter.journeys.index') }}"
                   style="font-size:13.5px;color:var(--body);text-decoration:none;font-weight:500">
                    Cancel
                </a>
            </div>

        </div>
    </form>

</div>

<style>
@media (max-width: 500px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>

</x-dashboard-layout>
