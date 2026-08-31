<x-dashboard-layout title="Add Customer">
<div class="p-6 lg:p-8 space-y-6">

    <div>
        <a href="{{ route('admin.customers.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All customers
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Add customer</h1>
        <p class="text-sm text-gray-400 mt-0.5">Register a new sender profile.</p>
    </div>

    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="flex gap-6 items-start" style="flex-wrap:wrap">

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.customers.store') }}"
              class="space-y-4" style="flex:1 1 460px;min-width:0"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Full name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Tatenda Moyo"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Phone <span class="text-red-400">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           placeholder="+263 77 123 4567"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Email <span class="text-gray-300">(optional)</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="customer@example.com"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                    <p class="text-xs text-gray-400 mt-1">If left blank, a system placeholder is used.</p>
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 pt-2">
                <a href="{{ route('admin.customers.index') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50">Cancel</a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white"
                        style="background:#6bc630;box-shadow:0 4px 14px rgba(107,198,48,0.25);"
                        :style="loading ? 'opacity:0.65;cursor:not-allowed' : ''"
                        :disabled="loading"
                        onmouseover="if(!loading) this.style.background='#5aad28'"
                        onmouseout="this.style.background='#6bc630'">
                    <svg x-show="loading" x-cloak class="form-spinner" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    <span x-text="loading ? 'Saving…' : 'Add customer'"></span>
                </button>
            </div>
        </form>

        {{-- Context panel --}}
        <div style="flex:0 0 280px;position:sticky;top:88px;align-self:flex-start;display:flex;flex-direction:column;gap:16px">

            <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
                <div class="px-5 py-4" style="border-bottom:1px solid #F0F1F0;">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">What they get</p>
                </div>
                <div class="px-5 py-5 space-y-4">
                    @foreach([
                        ['Order history', 'They can view all their past and active orders from their dashboard.'],
                        ['Parcel tracking', 'A tracking link is generated for every order they place.'],
                        ['Platform access', 'They can log in and place new orders directly without admin involvement.'],
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
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Password setup</p>
                <p class="text-xs text-gray-400 leading-relaxed">
                    A random password is assigned. If an email is provided, they can use "Forgot password" to set their own. Otherwise, you can share credentials manually.
                </p>
            </div>

        </div>

    </div>
</div>
</x-dashboard-layout>
