<x-dashboard-layout title="Post a Journey">

<div class="p-6 lg:p-8 max-w-[720px] mx-auto space-y-6">

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

    <form method="POST" action="{{ route('transporter.journeys.store') }}" class="space-y-5"
          x-data="{ loading: false }" @submit="loading = true">
        @csrf

        {{-- Trip details --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800">Trip details</h2>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">
                    Route <span class="text-red-400">*</span>
                </label>
                <select name="route_id" required
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
                       class="w-full text-sm text-gray-700 rounded-xl border px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-colors"
                       style="background:#fafafa;border-color:{{ $errors->has('departs_at') ? '#fca5a5' : '#e5e7eb' }}">
                @error('departs_at')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Available space --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Available space</h2>
                <p class="text-xs text-gray-400 mt-0.5">How much can you carry? Senders use this to judge if their parcel fits.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Max weight (kg)</label>
                    <input type="number" name="available_weight_kg"
                           value="{{ old('available_weight_kg') }}"
                           min="0.1" max="9999" step="0.1" placeholder="e.g. 50"
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
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                    <p class="text-xs text-gray-400 mt-1">Number of separate parcels you can take</p>
                    @error('available_slots')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Pricing</h2>
                <p class="text-xs text-gray-400 mt-0.5">Leave both blank if you prefer to negotiate with senders directly.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Price per kg (USD)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">$</span>
                        <input type="number" name="price_per_kg"
                               value="{{ old('price_per_kg') }}"
                               min="0" step="0.01" placeholder="0.00"
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
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">$</span>
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
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-3">
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Notes <span class="text-gray-400 font-normal">(optional)</span></h2>
                <p class="text-xs text-gray-400 mt-0.5">Any restrictions or helpful info for senders — fragile items, stops along the way, cargo type restrictions.</p>
            </div>
            <textarea name="notes" rows="3"
                      placeholder="e.g. Fragile items welcome. No food. Will stop in Gweru for 30 mins."
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

    </form>
</div>

</x-dashboard-layout>
