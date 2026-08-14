<x-dashboard-layout title="Edit Route">
<div class="p-6 lg:p-8 max-w-[640px] mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.routes.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All routes
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">
            {{ $route->origin_city }} → {{ $route->destination_city }}
        </h1>
    </div>

    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.routes.update', $route) }}" class="space-y-5">
        @csrf @method('PUT')

        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800">Cities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Origin city</label>
                    <input type="text" name="origin_city" value="{{ old('origin_city', $route->origin_city) }}" required
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Origin code</label>
                    <input type="text" name="origin_code" value="{{ old('origin_code', $route->origin_code) }}"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Destination city</label>
                    <input type="text" name="destination_city" value="{{ old('destination_city', $route->destination_city) }}" required
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Destination code</label>
                    <input type="text" name="destination_code" value="{{ old('destination_code', $route->destination_code) }}"
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
                    <input type="number" name="distance_km" value="{{ old('distance_km', $route->distance_km) }}"
                           step="0.1" min="1"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Typical duration (mins)</label>
                    <input type="number" name="typical_duration_mins" value="{{ old('typical_duration_mins', $route->typical_duration_mins) }}"
                           min="1"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
            </div>
            <input type="hidden" name="is_active" value="{{ $route->is_active ? '1' : '0' }}">
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('admin.routes.index') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50">Cancel</a>
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white"
                    style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.25);"
                    onmouseover="this.style.background='#5aad28'"
                    onmouseout="this.style.background='#6bc630'">
                Save changes
            </button>
        </div>
    </form>
</div>
</x-dashboard-layout>
