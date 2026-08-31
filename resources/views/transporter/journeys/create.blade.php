<x-dashboard-layout title="Post a Journey">

<div class="p-6 lg:p-8 space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('transporter.journeys.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            My journeys
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Post a journey</h1>
        <p class="text-sm text-gray-400 mt-0.5">Tell senders when you're travelling and how much space you have.</p>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <div class="font-semibold mb-1">Please fix the following:</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Two-column layout --}}
    <form method="POST" action="{{ route('transporter.journeys.store') }}"
          x-data="{ loading: false, route_label: '', departs: '', weight: '', slots: '', price: '', notes: '' }"
          @submit="loading = true">
        @csrf

        <div class="flex gap-6 items-start" style="flex-wrap:wrap">

            {{-- ── LEFT: form sections ─────────────────────── --}}
            <div class="space-y-5" style="flex:1 1 480px;min-width:0">

                {{-- Trip details --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:28px;" class="space-y-5">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">Trip details</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Where are you going and when do you depart?</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                            Route <span class="text-red-400">*</span>
                        </label>
                        <select name="route_id" required
                                @change="route_label = $event.target.options[$event.target.selectedIndex].text"
                                class="w-full text-sm text-gray-700 rounded-xl border px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-colors"
                                style="background:#fafafa;border-color:{{ $errors->has('route_id') ? '#fca5a5' : '#e5e7eb' }}">
                            <option value="">Select a route…</option>
                            @foreach($routes as $r)
                                <option value="{{ $r->id }}" @selected(old('route_id') == $r->id)>
                                    {{ $r->origin_city }} → {{ $r->destination_city }}
                                    @if($r->distance_km)({{ number_format($r->distance_km) }} km)@endif
                                </option>
                            @endforeach
                        </select>
                        @error('route_id')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                            Departure date & time <span class="text-red-400">*</span>
                        </label>
                        <input type="datetime-local" name="departs_at"
                               value="{{ old('departs_at') }}"
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                               required
                               @change="departs = $event.target.value"
                               class="w-full text-sm text-gray-700 rounded-xl border px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-colors"
                               style="background:#fafafa;border-color:{{ $errors->has('departs_at') ? '#fca5a5' : '#e5e7eb' }}">
                        @error('departs_at')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Available space --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:28px;" class="space-y-5">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">Available space</h2>
                        <p class="text-xs text-gray-400 mt-0.5">How much can you carry? Senders use this to judge if their parcel fits.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Max weight (kg)</label>
                            <input type="number" name="available_weight_kg"
                                   value="{{ old('available_weight_kg') }}"
                                   min="0.1" max="9999" step="0.1" placeholder="e.g. 50"
                                   @input="weight = $event.target.value"
                                   class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                                   style="background:#fafafa;">
                            @error('available_weight_kg')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                                Parcel slots <span class="text-red-400">*</span>
                            </label>
                            <input type="number" name="available_slots"
                                   value="{{ old('available_slots', 1) }}"
                                   min="1" max="100" required
                                   @input="slots = $event.target.value"
                                   class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                                   style="background:#fafafa;">
                            <p class="text-xs text-gray-400 mt-1">Separate parcels you can take</p>
                            @error('available_slots')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:28px;" class="space-y-5">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">Pricing</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Leave blank to negotiate directly with each sender on WhatsApp.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Price per kg (USD)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium select-none">$</span>
                                <input type="number" name="price_per_kg"
                                       value="{{ old('price_per_kg') }}"
                                       min="0" step="0.01" placeholder="0.00"
                                       @input="price = $event.target.value"
                                       class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 pl-7 pr-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                                       style="background:#fafafa;">
                            </div>
                            @error('price_per_kg')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5">Minimum charge (USD)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium select-none">$</span>
                                <input type="number" name="min_price"
                                       value="{{ old('min_price') }}"
                                       min="0" step="0.01" placeholder="0.00"
                                       class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 pl-7 pr-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                                       style="background:#fafafa;">
                            </div>
                            @error('min_price')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:28px;" class="space-y-3">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">Notes <span class="font-normal text-gray-400">(optional)</span></h2>
                        <p class="text-xs text-gray-400 mt-0.5">Restrictions, stops along the way, cargo preferences. Senders read this before they WhatsApp you.</p>
                    </div>
                    <textarea name="notes" rows="4"
                              placeholder="e.g. Fragile items welcome. No food or liquids. Will stop in Gweru for 30 mins."
                              @input="notes = $event.target.value"
                              class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 resize-none"
                              style="background:#fafafa;border-color:{{ $errors->has('notes') ? '#fca5a5' : '#e5e7eb' }}">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit row --}}
                <div class="flex items-center justify-between gap-4 pt-2">
                    <a href="{{ route('transporter.journeys.index') }}"
                       class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all"
                            style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.28);"
                            :style="loading ? 'opacity:0.65;cursor:not-allowed' : ''"
                            :disabled="loading"
                            onmouseover="if(!loading) this.style.background='#5aad28'"
                            onmouseout="this.style.background='#6bc630'">
                        <svg x-show="loading" x-cloak class="form-spinner" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                        <span x-text="loading ? 'Posting…' : 'Post journey'"></span>
                    </button>
                </div>

            </div>

            {{-- ── RIGHT: sticky context panel ─────────────── --}}
            <div class="space-y-4" style="flex:0 0 300px;position:sticky;top:88px;align-self:flex-start">

                {{-- Live preview --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;">
                    <div class="px-5 py-4" style="border-bottom:1px solid #F0F1F0;border-radius:16px 16px 0 0;">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Marketplace preview</p>
                        <p class="text-xs text-gray-400 mt-0.5">How senders will see your journey</p>
                    </div>
                    <div class="px-5 pt-5 pb-6">

                        {{-- Route --}}
                        <p class="text-sm font-bold text-gray-900 leading-snug mb-1"
                           x-text="route_label || 'Harare → Bulawayo'"></p>

                        {{-- Departs --}}
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-5">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                            <span x-text="departs ? new Date(departs).toLocaleDateString('en-GB', {weekday:'short',day:'numeric',month:'short',year:'numeric'}) + ' · ' + new Date(departs).toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'}) : 'Fri, 05 Sep 2026 · 05:30'"></span>
                        </div>

                        <div style="border-top:1px solid #F0F1F0;" class="pt-4 mb-4">
                            {{-- Avatar + name + badge --}}
                            @php
                                $tier = Auth::user()->transporterProfile?->trust_tier?->value ?? 'unverified';
                                [$tbg, $tc, $tl] = match($tier) {
                                    'verified'          => ['#dcfce7','#15803d','Nhume Verified'],
                                    'manually_reviewed' => ['#dbeafe','#1d4ed8','Nhume Reviewed'],
                                    'id_submitted'      => ['#fef3c7','#d97706','ID Submitted'],
                                    default             => ['#f3f4f6','#6b7280','Unverified'],
                                };
                            @endphp
                            <div class="flex items-center gap-2.5 mb-4">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-800 leading-tight mb-0.5">{{ Auth::user()->name }}</p>
                                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded"
                                          style="background:{{ $tbg }};color:{{ $tc }}">{{ $tl }}</span>
                                </div>
                            </div>

                            {{-- Space chips --}}
                            <div class="flex gap-2 flex-wrap mb-4">
                                <span class="inline-flex items-center text-[11px] text-gray-500 border border-gray-200 rounded-md px-2.5 py-1 leading-none"
                                      x-text="weight ? weight + ' kg space' : '— kg space'"></span>
                                <span class="inline-flex items-center text-[11px] text-gray-500 border border-gray-200 rounded-md px-2.5 py-1 leading-none"
                                      x-text="(slots || '1') + ' slot' + ((slots || '1') != '1' ? 's' : '')"></span>
                            </div>

                            {{-- Notes --}}
                            <p class="text-[11px] text-gray-400 italic leading-relaxed"
                               x-show="notes" x-cloak
                               x-text="'\"' + notes.slice(0,80) + (notes.length > 80 ? '…' : '') + '\"'"></p>
                        </div>

                        {{-- Price + WhatsApp --}}
                        <div style="border-top:1px solid #F0F1F0;" class="pt-4 flex items-center justify-between gap-2">
                            <div>
                                <p class="text-base font-bold text-gray-900 leading-tight"
                                   x-text="price ? '$' + parseFloat(price).toFixed(2) : 'Negotiate'"></p>
                                <p class="text-[10px] text-gray-400 mt-0.5" x-show="price" x-cloak>per kg</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-[11px] font-bold text-white"
                                  style="background:#25D366;">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                                WhatsApp
                            </span>
                        </div>

                    </div>
                </div>

                {{-- What happens next --}}
                <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">What happens next</p>
                    <div class="space-y-4">
                        @foreach([
                            ['Your journey goes live', 'Senders browsing the marketplace can see your trip immediately after posting.'],
                            ['Senders WhatsApp you', 'They tap the WhatsApp button on your card and a pre-filled message opens directly to you.'],
                            ['You agree and collect', 'Arrange the handoff on WhatsApp — pickup point, parcel details, payment method.'],
                        ] as $i => [$step, $desc])
                        <div class="flex gap-3">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0 mt-0.5"
                                 style="background:#6bc630;">{{ $i + 1 }}</div>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">{{ $step }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            {{-- end right panel --}}

        </div>
    </form>

</div>

</x-dashboard-layout>
