<x-dashboard-layout title="Routes">
<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Routes</h1>
            <p class="text-sm text-gray-400 mt-0.5">Delivery corridors — city pairs available on the platform</p>
        </div>
        <a href="{{ route('admin.routes.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 16px rgba(107,198,48,0.28);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add route
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"
         style="background:#f0fde4;border:1px solid #bbf7d0;color:#15803d;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Route</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Distance</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Est. Duration</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($routes as $route)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:#6bc630;"></div>
                                    <span class="font-semibold text-gray-800">{{ $route->origin_city }}</span>
                                    @if($route->origin_code)
                                    <span class="text-xs text-gray-400 font-mono">({{ $route->origin_code }})</span>
                                    @endif
                                </div>
                                <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:#3b82f6;"></div>
                                    <span class="font-semibold text-gray-800">{{ $route->destination_city }}</span>
                                    @if($route->destination_code)
                                    <span class="text-xs text-gray-400 font-mono">({{ $route->destination_code }})</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 hidden md:table-cell">
                            {{ $route->distance_km ? number_format($route->distance_km) . ' km' : '—' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 hidden md:table-cell">
                            @if($route->typical_duration_mins)
                                @php
                                    $h = intdiv($route->typical_duration_mins, 60);
                                    $m = $route->typical_duration_mins % 60;
                                @endphp
                                {{ $h > 0 ? "{$h}h " : '' }}{{ $m > 0 ? "{$m}m" : '' }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('admin.routes.toggle', $route) }}" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold hover:opacity-80 transition-opacity"
                                        style="background:{{ $route->is_active ? '#dcfce7' : '#f3f4f6' }};color:{{ $route->is_active ? '#15803d' : '#6b7280' }};">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $route->is_active ? '#22c55e' : '#9ca3af' }};"></span>
                                    {{ $route->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.routes.edit', $route) }}"
                                   class="text-xs font-medium text-gray-500 hover:text-gray-800 inline-flex items-center gap-1">
                                    Edit
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.routes.destroy', $route) }}" class="inline"
                                      onsubmit="return confirm('Delete this route?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-600 transition-colors">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="text-2xl mb-2">🗺️</div>
                            <div class="text-sm font-medium text-gray-500">No routes yet</div>
                            <div class="text-xs text-gray-400 mt-1 mb-4">Add the corridors you operate on</div>
                            <a href="{{ route('admin.routes.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white"
                               style="background:#6bc630;">
                                Add first route
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-dashboard-layout>
