@extends('layouts.landing')
@section('title', 'Report an Issue — Nhume')
@section('description', 'Report a lost parcel, driver concern, or safety issue to the Nhume team.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Support</span>
    <h1>Report an issue</h1>
    <p>We take every report seriously. Our team reviews all submissions and follows up within 24 hours.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body" x-data="{ type: '', sent: false, loading: false }">

    <div x-show="!sent">
        {{-- Issue type --}}
        <div class="lp-section">
            <p class="lp-sh">What happened?</p>
            <div class="lp-grid-2" style="gap:12px;margin-top:20px">
                @foreach([
                    ['lost', 'Lost parcel', 'My parcel did not arrive and cannot be located.', 'M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11'],
                    ['damaged', 'Damaged parcel', 'My parcel arrived damaged or with items missing.', 'M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.98L13.74 4a2 2 0 00-3.48 0L3.25 16.02A2 2 0 005.07 19z'],
                    ['driver', 'Driver or rider concern', 'A concern about the conduct or behaviour of a driver or rider.', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['safety', 'Safety incident', 'A situation that affected the safety of a sender, recipient, or driver.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ] as [$val, $title, $desc, $icon])
                <button type="button"
                        @click="type = '{{ $val }}'"
                        :class="type === '{{ $val }}' ? 'border-[#1C3829]' : 'border-[#e5e7eb] hover:border-gray-300'"
                        style="background:#fff;border-width:2px;border-style:solid;border-radius:8px;padding:20px;text-align:left;cursor:pointer;transition:border-color 0.15s;width:100%">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                        <span style="width:34px;height:34px;border-radius:6px;background:var(--shade);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg width="16" height="16" fill="none" stroke="var(--text-2)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        </span>
                        <span style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest)">{{ $title }}</span>
                    </div>
                    <p style="font-family:var(--font);font-size:13px;color:var(--text-2);margin:0;line-height:1.5">{{ $desc }}</p>
                </button>
                @endforeach
            </div>
        </div>

        {{-- Form --}}
        <div class="lp-section" x-show="type">
            <form class="lp-card" style="display:flex;flex-direction:column;gap:18px"
                  @submit.prevent="loading = true; setTimeout(() => { sent = true; loading = false }, 900)">
                <div class="lp-grid-2">
                    <div>
                        <label class="lp-label">Order number <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#9ca3af">(if applicable)</span></label>
                        <input type="text" class="lp-input" placeholder="NHM-20260812-XXXX">
                    </div>
                    <div>
                        <label class="lp-label">Your email</label>
                        <input type="email" class="lp-input" placeholder="you@example.com" required>
                    </div>
                </div>
                <div>
                    <label class="lp-label">Describe what happened</label>
                    <textarea class="lp-input" rows="5" placeholder="Please include as much detail as possible — dates, times, names, and any evidence you have." required style="resize:vertical"></textarea>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                    <p style="font-family:var(--font);font-size:12.5px;color:var(--text-2)">We respond to all reports within 24 hours.</p>
                    <button type="submit" class="lp-btn" :disabled="loading">
                        <svg x-show="loading" class="lp-spinner" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span x-text="loading ? 'Submitting...' : 'Submit report'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="sent" x-cloak class="lp-card" style="text-align:center;padding:56px 32px;max-width:480px;margin:0 auto">
        <div style="width:52px;height:52px;background:var(--green-light);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px">
            <svg width="24" height="24" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 8px">Report received</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">Our team will review your report and get back to you within 24 hours. Thank you for helping us keep Nhume safe and reliable.</p>
    </div>

</div>
</div>
@endsection
