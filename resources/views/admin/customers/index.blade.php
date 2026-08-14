<x-dashboard-layout title="Customers">

<div class="p-6 lg:p-8 max-w-[1280px] mx-auto space-y-6">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Customers</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ $total }} registered sender{{ $total !== 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('admin.customers.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white"
           style="background:#6bc630;box-shadow:0 4px 16px rgba(107,198,48,0.28);">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add customer
        </a>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"
         style="background:#f0fde4;border:1px solid #bbf7d0;color:#15803d;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Search --}}
    <form method="GET" class="flex items-center gap-2 max-w-sm">
        <div class="flex items-center gap-2 px-3 py-2 rounded-xl flex-1" style="background:#fff;border:1px solid #E9EAEC;">
            <svg width="15" height="15" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search name, email, phone…"
                   class="bg-transparent border-0 p-0 text-sm text-gray-700 placeholder-gray-400 focus:ring-0 outline-none w-full">
        </div>
        @if(request('search'))
        <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-500 px-2 hover:text-gray-700">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom:1px solid #F0F1F0;">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Customer</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden md:table-cell">Phone</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Orders</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide hidden lg:table-cell">Joined</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50/60 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $customer->name }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ str_contains($customer->email, '@nhume.local') ? '' : $customer->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-mono text-xs hidden md:table-cell">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold"
                                  style="{{ $customer->tasks_count > 0 ? 'background:#f0fde4;color:#15803d;' : 'background:#f3f4f6;color:#6b7280;' }}">
                                {{ $customer->tasks_count }} order{{ $customer->tasks_count !== 1 ? 's' : '' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 hidden lg:table-cell">{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.orders.create', ['customer_id' => $customer->id]) }}"
                                   class="text-xs font-medium px-2.5 py-1 rounded-lg transition-colors"
                                   style="background:#f0fde4;color:#15803d;">
                                    + Order
                                </a>
                                <a href="{{ route('admin.customers.show', $customer) }}"
                                   class="text-xs font-medium text-gray-500 hover:text-gray-800 inline-flex items-center gap-1">
                                    View
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="text-2xl mb-2">👤</div>
                            <div class="text-sm font-medium text-gray-500">No customers yet</div>
                            <div class="text-xs text-gray-400 mt-1 mb-4">Add your first customer to get started</div>
                            <a href="{{ route('admin.customers.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white"
                               style="background:#6bc630;">
                                Add customer
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="px-6 py-4" style="border-top:1px solid #F0F1F0;">{{ $customers->links() }}</div>
        @endif
    </div>
</div>
</x-dashboard-layout>
