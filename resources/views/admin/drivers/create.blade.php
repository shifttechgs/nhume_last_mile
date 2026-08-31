<x-dashboard-layout title="Add Driver">

<div class="p-6 lg:p-8 space-y-6">

    <div>
        <a href="{{ route('admin.drivers.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-700 transition-colors mb-4">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
            All drivers
        </a>
        <h1 class="text-[22px] font-bold text-gray-900 tracking-tight">Add driver</h1>
        <p class="text-sm text-gray-400 mt-0.5">Create a new transporter account and profile.</p>
    </div>

    @if($errors->any())
    <div class="px-4 py-3 rounded-xl text-sm" style="background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;">
        <div class="font-semibold mb-1">Please fix the following:</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="flex gap-6 items-start" style="flex-wrap:wrap">
    <form method="POST" action="{{ route('admin.drivers.store') }}" class="space-y-5"
          style="flex:1 1 480px;min-width:0"
          x-data="{ loading: false }" @submit="loading = true">
        @csrf

        {{-- Account --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800">Account details</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Full name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Tafadzwa Moyo"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="driver@example.com"
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
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                           placeholder="Same as phone if blank"
                           class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                           style="background:#fafafa;">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Bio</label>
                <textarea name="bio" rows="2"
                          placeholder="Brief description — routes they cover, vehicle type, experience…"
                          class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400 resize-none"
                          style="background:#fafafa;">{{ old('bio') }}</textarea>
            </div>
        </div>

        {{-- Driver source + service types --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-4">
            <h2 class="text-sm font-semibold text-gray-800">Driver profile</h2>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Driver source <span class="text-red-400">*</span></label>
                <select name="driver_source"
                        class="w-full text-sm text-gray-700 rounded-xl border border-gray-200 px-3 py-2.5 focus:ring-1 focus:ring-green-400 focus:border-green-400"
                        style="background:#fafafa;">
                    @foreach(\App\Enums\DriverSource::cases() as $src)
                    <option value="{{ $src->value }}" {{ old('driver_source') === $src->value ? 'selected' : '' }}>
                        {{ $src->label() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">Service types <span class="text-red-400">*</span></label>
                <div class="flex flex-wrap gap-2">
                    @foreach(\App\Enums\ServiceType::cases() as $svc)
                    <label class="flex items-center gap-2 px-3 py-2 rounded-xl border cursor-pointer transition-all text-sm font-medium"
                           x-data="{ checked: {{ old('service_types') ? (in_array($svc->value, old('service_types', [])) ? 'true' : 'false') : 'false' }} }"
                           :class="checked ? 'border-green-400 bg-green-50 text-green-700' : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                           @click="checked = !checked">
                        <input type="checkbox" name="service_types[]" value="{{ $svc->value }}"
                               x-model="checked" class="text-green-500 rounded focus:ring-green-400">
                        {{ $svc->label() }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Trust tier --}}
        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:24px;" class="space-y-3">
            <h2 class="text-sm font-semibold text-gray-800">Trust tier</h2>
            @php
                $tierConfig = [
                    'unverified'        => ['label' => 'Unverified',      'desc' => 'Newly added, not yet vetted',           'bg' => '#f3f4f6', 'text' => '#6b7280'],
                    'manually_reviewed' => ['label' => 'Nhume Reviewed',  'desc' => 'Team has spoken to this person',        'bg' => '#dbeafe', 'text' => '#1d4ed8'],
                    'id_submitted'      => ['label' => 'ID Submitted',    'desc' => 'Documents uploaded, pending review',    'bg' => '#fef3c7', 'text' => '#b45309'],
                    'verified'          => ['label' => 'Verified',        'desc' => 'Fully vetted, all features unlocked',   'bg' => '#dcfce7', 'text' => '#15803d'],
                ];
            @endphp
            <div class="space-y-2" x-data="{ tier: '{{ old('trust_tier', 'unverified') }}' }">
                @foreach(\App\Enums\TrustTier::cases() as $t)
                @php $tc = $tierConfig[$t->value] ?? $tierConfig['unverified']; @endphp
                <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all"
                       :class="tier === '{{ $t->value }}' ? 'border-green-400' : 'border-gray-200'"
                       :style="tier === '{{ $t->value }}' ? 'background:{{ $tc['bg'] }}' : ''"
                       @click="tier = '{{ $t->value }}'">
                    <input type="radio" name="trust_tier" value="{{ $t->value }}" x-model="tier"
                           class="text-green-500 focus:ring-green-400">
                    <div>
                        <div class="text-sm font-semibold" style="color:{{ $tc['text'] }}">{{ $tc['label'] }}</div>
                        <div class="text-xs text-gray-400">{{ $tc['desc'] }}</div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('admin.drivers.index') }}"
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
                <span x-text="loading ? 'Saving…' : 'Add driver'"></span>
            </button>
        </div>
    </form>

    {{-- Context panel --}}
    <div style="flex:0 0 280px;position:sticky;top:88px;align-self:flex-start;display:flex;flex-direction:column;gap:16px">

        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;overflow:hidden;">
            <div class="px-5 py-4" style="border-bottom:1px solid #F0F1F0;">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Trust tier guide</p>
                <p class="text-xs text-gray-400 mt-0.5">What senders see on each transporter</p>
            </div>
            <div class="px-5 py-5 space-y-4">
                @foreach([
                    ['Unverified',     '#f3f4f6','#6b7280','#9ca3af', 'Just signed up. Can post journeys — senders see the badge and decide.'],
                    ['Nhume Reviewed', '#dbeafe','#1d4ed8','#3b82f6', 'Team has spoken to this person offline. Blue badge builds confidence.'],
                    ['ID Submitted',   '#fef3c7','#b45309','#f59e0b', 'Documents uploaded, pending full check.'],
                    ['Nhume Verified', '#dcfce7','#15803d','#22c55e', 'Fully vetted. Preferred for high-value parcels.'],
                ] as [$label, $bg, $txt, $dot, $desc])
                <div class="flex gap-3 items-start">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 mt-0.5"
                          style="background:{{ $bg }};color:{{ $txt }};">
                        <span class="w-1.5 h-1.5 rounded-full" style="background:{{ $dot }};"></span>
                        {{ $label }}
                    </span>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div style="background:#fff;border:1px solid #E9EAEC;border-radius:16px;padding:20px;">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Password</p>
            <p class="text-xs text-gray-400 leading-relaxed">
                A random password is assigned. The driver can use "Forgot password" to set their own when they first log in.
            </p>
        </div>

    </div>

    </div>{{-- end flex --}}
</div>

</x-dashboard-layout>
