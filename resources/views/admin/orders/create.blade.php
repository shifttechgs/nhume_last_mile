<x-dashboard-layout title="New Order">

<div class="p-6 lg:p-8 max-w-[900px] mx-auto space-y-6">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div>
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All orders
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Create order</h1>
        <p class="text-sm text-gray-400 mt-0.5">Fill in the details below to register a new delivery order.</p>
    </div>

    {{-- ── Validation errors ───────────────────────────────── --}}
    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <div class="font-semibold mb-1">Please fix the following:</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.store') }}" class="space-y-5"
          x-data="{ ...orderForm(), loading: false }" @submit="loading = true">
        @csrf

        {{-- ══ 1. CUSTOMER ════════════════════════════════════ --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-[11px] font-bold text-white flex items-center justify-center flex-shrink-0" style="background:#6bc630;">1</span>
                Sender / Customer
            </h2>

            {{-- Search existing --}}
            <div x-show="!newCustomer && !selectedCustomer">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Search existing customer</label>
                <div class="relative">
                    <input type="text"
                           x-model="searchQuery"
                           @input.debounce.300ms="searchCustomers()"
                           @focus="searchCustomers()"
                           placeholder="Type name or phone…"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                    <div x-show="results.length > 0"
                         class="absolute top-full mt-1 left-0 right-0 rounded-xl border border-gray-200 overflow-hidden z-20"
                         style="background:#fff;box-shadow:0 8px 24px rgba(0,0,0,0.1);">
                        <template x-for="c in results" :key="c.id">
                            <div @click="selectCustomer(c)"
                                 class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);"
                                     x-text="c.name.charAt(0).toUpperCase()"></div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-gray-800" x-text="c.name"></div>
                                    <div class="text-xs text-gray-400" x-text="c.phone || c.email || '—'"></div>
                                </div>
                                <div class="text-xs text-gray-400" x-text="c.tasks_count + ' order' + (c.tasks_count !== 1 ? 's' : '')"></div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-3">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400">or</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>
                <button type="button" @click="newCustomer = true"
                        class="w-full mt-3 py-2.5 rounded-xl text-sm font-semibold border border-dashed border-gray-300 text-gray-500 hover:border-green-400 hover:text-green-600 transition-colors">
                    + New customer
                </button>
            </div>

            {{-- Selected customer card --}}
            <div x-show="selectedCustomer" class="flex items-center gap-3 p-4 rounded-xl" style="background:#f0fde4;border:1px solid #bbf7d0;">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white flex-shrink-0"
                     style="background:linear-gradient(135deg,#6bc630,#3a7d1a);"
                     x-text="selectedCustomer?.name?.charAt(0)?.toUpperCase()"></div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-800 text-sm" x-text="selectedCustomer?.name"></div>
                    <div class="text-xs text-gray-500" x-text="selectedCustomer?.phone || selectedCustomer?.email || '—'"></div>
                </div>
                <button type="button" @click="clearCustomer()"
                        class="text-xs text-gray-400 hover:text-red-500 transition-colors px-2 py-1 rounded-lg hover:bg-red-50">
                    Change
                </button>
                <input type="hidden" name="customer_id" :value="selectedCustomer?.id">
                <input type="hidden" name="sender_phone" :value="selectedCustomer?.phone">
            </div>

            {{-- New customer form --}}
            <div x-show="newCustomer && !selectedCustomer" class="space-y-3 p-4 rounded-xl" style="background:#f9fafb;border:1px solid #F0F1F0;">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold text-gray-700">New customer</div>
                    <button type="button" @click="newCustomer = false; searchQuery = ''"
                            class="text-xs text-gray-400 hover:text-gray-600">Cancel</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Full name <span class="text-red-400">*</span></label>
                        <input type="text" name="sender_name" value="{{ old('sender_name') }}"
                               placeholder="e.g. Tatenda Moyo"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fff;">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Phone</label>
                        <input type="text" name="sender_phone" value="{{ old('sender_phone') }}"
                               placeholder="+263 77 123 4567"
                               class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                               style="background:#fff;">
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ 2. PICKUP TYPE ══════════════════════════════════ --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-[11px] font-bold text-white flex items-center justify-center flex-shrink-0" style="background:#6bc630;">2</span>
                Pickup type
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach(\App\Enums\PickupType::cases() as $pt)
                <label class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all hover:border-green-300"
                       :class="pickupType === '{{ $pt->value }}' ? 'border-green-400 bg-green-50' : 'border-gray-200'"
                       @click="pickupType = '{{ $pt->value }}'">
                    <input type="radio" name="pickup_type" value="{{ $pt->value }}"
                           x-model="pickupType"
                           class="mt-0.5 text-green-500 focus:ring-green-400 flex-shrink-0">
                    <div>
                        <div class="text-sm font-semibold text-gray-800">{{ $pt->label() }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $pt->description() }}</div>
                    </div>
                </label>
                @endforeach
            </div>

            {{-- Pickup address (biker only) --}}
            <div x-show="pickupType === 'biker_collection'">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Pickup address <span class="text-red-400">*</span></label>
                <input type="text" name="pickup_address" value="{{ old('pickup_address') }}"
                       placeholder="e.g. 14 Samora Machel Ave, Harare"
                       class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                       style="background:#fafafa;">
            </div>
        </div>

        {{-- ══ 3. DELIVERY DETAILS ════════════════════════════ --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-[11px] font-bold text-white flex items-center justify-center flex-shrink-0" style="background:#6bc630;">3</span>
                Delivery details
            </h2>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Dropoff address <span class="text-red-400">*</span></label>
                <input type="text" name="dropoff_address" value="{{ old('dropoff_address') }}"
                       placeholder="e.g. 5 Lobengula St, Bulawayo"
                       class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                       style="background:#fafafa;">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Recipient name <span class="text-red-400">*</span></label>
                    <input type="text" name="recipient_name" value="{{ old('recipient_name') }}"
                           placeholder="e.g. Blessing Ncube"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Recipient phone <span class="text-red-400">*</span></label>
                    <input type="text" name="recipient_phone" value="{{ old('recipient_phone') }}"
                           placeholder="+263 77 000 0000"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
            </div>
        </div>

        {{-- ══ 4. PACKAGE ═════════════════════════════════════ --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-[11px] font-bold text-white flex items-center justify-center flex-shrink-0" style="background:#6bc630;">4</span>
                Package
            </h2>

            {{-- Category --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">Category <span class="text-red-400">*</span></label>
                <div class="flex flex-wrap gap-2">
                    @foreach(\App\Enums\PackageCategory::cases() as $cat)
                    <label class="flex items-center gap-1.5 px-3 py-2 rounded-xl border cursor-pointer transition-all text-sm font-medium"
                           :class="category === '{{ $cat->value }}'
                               ? 'border-green-400 bg-green-50 text-green-700'
                               : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                           @click="category = '{{ $cat->value }}'">
                        <input type="radio" name="package_category" value="{{ $cat->value }}"
                               x-model="category" class="sr-only">
                        {{ $cat->label() }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Description</label>
                    <input type="text" name="item_description" value="{{ old('item_description') }}"
                           placeholder="e.g. School shoes, 2 pairs"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Weight (kg)</label>
                    <input type="number" name="weight_kg" value="{{ old('weight_kg') }}"
                           step="0.1" min="0.1" placeholder="0.5"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Price ($)</label>
                    <input type="number" name="offered_price" value="{{ old('offered_price') }}"
                           step="0.01" min="0" placeholder="Auto"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <div class="relative">
                    <input type="checkbox" name="is_fragile" value="1" class="sr-only peer">
                    <div class="w-10 h-5 rounded-full transition-colors peer-checked:bg-green-400 bg-gray-200"></div>
                    <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5 shadow-sm"></div>
                </div>
                <span class="text-sm text-gray-700 font-medium">Fragile — handle with care</span>
            </label>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Notes (internal)</label>
                <textarea name="notes" rows="2" placeholder="Any special instructions…"
                          class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 resize-none"
                          style="background:#fafafa;">{{ old('notes') }}</textarea>
            </div>
        </div>

        {{-- ══ 5. ASSIGN DRIVER (OPTIONAL) ════════════════════ --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                <span class="w-5 h-5 rounded-full text-[11px] font-bold text-white flex items-center justify-center flex-shrink-0" style="background:#6bc630;">5</span>
                Assign driver
                <span class="text-xs font-normal text-gray-400">(optional)</span>
            </h2>
            <select name="assigned_driver_id"
                    class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                    style="background:#fafafa;">
                <option value="">— Assign later —</option>
                @foreach($drivers as $driver)
                <option value="{{ $driver->id }}" {{ old('assigned_driver_id') == $driver->id ? 'selected' : '' }}>
                    {{ $driver->user->name ?? 'Unknown' }} · {{ $driver->trust_badge }}
                </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400">If a driver is selected, the order status will automatically advance to "Driver assigned".</p>
        </div>

        {{-- ── Submit ───────────────────────────────────────── --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('admin.orders.index') }}"
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
                <span x-text="loading ? 'Saving…' : 'Create order'"></span>
            </button>
        </div>

    </form>
</div>

<script>
function orderForm() {
    return {
        searchQuery: '{{ old("sender_name", $preselectedCustomer?->name ?? "") }}',
        results: [],
        selectedCustomer: @json($preselectedCustomer ? ['id' => $preselectedCustomer->id, 'name' => $preselectedCustomer->name, 'phone' => $preselectedCustomer->phone] : null),
        newCustomer: false,
        pickupType: '{{ old("pickup_type", "walk_in") }}',
        category: '{{ old("package_category", "") }}',

        async searchCustomers() {
            if (this.newCustomer || this.selectedCustomer) return;
            if (this.searchQuery.length < 1) { this.results = []; return; }
            try {
                const r = await fetch(`{{ route('admin.customers.search') }}?q=${encodeURIComponent(this.searchQuery)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                this.results = await r.json();
            } catch (e) { this.results = []; }
        },

        selectCustomer(c) {
            this.selectedCustomer = c;
            this.searchQuery = c.name;
            this.results = [];
            this.newCustomer = false;
        },

        clearCustomer() {
            this.selectedCustomer = null;
            this.searchQuery = '';
            this.results = [];
        }
    }
}
</script>
</x-dashboard-layout>
