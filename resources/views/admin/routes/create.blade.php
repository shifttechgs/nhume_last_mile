<x-dashboard-layout title="Add Route">
<div class="p-6 lg:p-8 space-y-6">

    <div>
        <a href="{{ route('admin.routes.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All routes
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Add route</h1>
        <p class="text-sm text-gray-400 mt-0.5">Define a new delivery corridor available to transporters.</p>
    </div>

    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="flex gap-6 items-start" style="flex-wrap:wrap">

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.routes.store') }}"
              class="space-y-5" style="flex:1 1 460px;min-width:0"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
                <h2 class="text-sm font-semibold text-gray-800">Cities</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Origin city <span class="text-red-400">*</span></label>
                        <input type="text" name="origin_city" value="{{ old('origin_city') }}" required
                               placeholder="e.g. Harare"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Origin code</label>
                        <input type="text" name="origin_code" value="{{ old('origin_code') }}"
                               placeholder="e.g. HRE"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Destination city <span class="text-red-400">*</span></label>
                        <input type="text" name="destination_city" value="{{ old('destination_city') }}" required
                               placeholder="e.g. Bulawayo"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Destination code</label>
                        <input type="text" name="destination_code" value="{{ old('destination_code') }}"
                               placeholder="e.g. BYO"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                </div>
            </div>

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
                <h2 class="text-sm font-semibold text-gray-800">Details</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Distance (km)</label>
                        <input type="number" name="distance_km" value="{{ old('distance_km') }}"
                               step="0.1" min="1" placeholder="e.g. 440"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Typical duration (mins)</label>
                        <input type="number" name="typical_duration_mins" value="{{ old('typical_duration_mins') }}"
                               min="1" placeholder="e.g. 300"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fafafa;">
                    </div>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="bidirectional" value="1" checked
                           class="text-green-500 rounded focus:ring-green-400">
                    <div>
                        <div class="text-sm font-medium text-gray-700">Also add reverse route</div>
                        <div class="text-xs text-gray-400">Creates the return corridor at the same time</div>
                    </div>
                </label>
            </div>

            <div class="flex items-center justify-between gap-4 pt-2">
                <a href="{{ route('admin.routes.index') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white"
                        style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.25);"
                        :style="loading ? 'opacity:0.65;cursor:not-allowed' : ''"
                        :disabled="loading"
                        onmouseover="if(!loading) this.style.background='#5aad28'"
                        onmouseout="this.style.background='#6bc630'">
                    <svg x-show="loading" x-cloak class="form-spinner" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    <span x-text="loading ? 'Saving…' : 'Save route'"></span>
                </button>
            </div>
        </form>

        {{-- Context panel --}}
        <div style="flex:0 0 280px;position:sticky;top:88px;align-self:flex-start;display:flex;flex-direction:column;gap:16px">

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
                <div class="px-5 py-4" style="border-bottom:1px solid #F0F1F0;">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">How routes work</p>
                </div>
                <div class="px-5 py-5 space-y-4">
                    @foreach([
                        ['Transporters post journeys', 'Transporters choose a route when posting a trip. Only active routes appear in their dropdown.'],
                        ['Senders filter by route', 'The marketplace lets senders browse journeys filtered by corridor — so routes determine discoverability.'],
                        ['Bidirectional is standard', 'Most corridors need both directions. The checkbox saves you creating the return route separately.'],
                    ] as $i => [$title, $desc])
                    <div class="flex gap-3">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white flex-shrink-0 mt-0.5"
                             style="background:#6bc630;">{{ $i + 1 }}</div>
                        <div>
                            <p class="text-xs font-semibold text-gray-700">{{ $title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Airport codes</p>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Use IATA city codes where they exist — HRE (Harare), BUQ (Bulawayo), UTA (Mutare), VFA (Vic Falls). These are optional but help with future integrations.
                </p>
            </div>

        </div>

    </div>
</div>
</x-dashboard-layout>
