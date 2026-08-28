@extends('layouts.landing')
@section('title', 'Contact Us — Nhume')
@section('description', 'Get in touch with the Nhume team. We\'re here to help.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Contact</span>
    <h1>Get in touch</h1>
    <p>We're a small team and we read every message. Expect a reply within one business day.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">
<div style="display:grid;grid-template-columns:5fr 7fr;gap:48px;align-items:start">

    {{-- Left: contact details --}}
    <div>
        <p class="lp-sh" style="margin-bottom:24px">Reach us directly</p>
        <div style="display:flex;flex-direction:column;gap:14px">
            @foreach([
                ['Phone / WhatsApp', '+263 77 123 4567', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                ['Email', 'hello@nhume.co.zw', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ] as [$label, $value, $icon])
            <div style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:8px;padding:18px 20px">
                <span style="width:38px;height:38px;border-radius:6px;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="16" height="16" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </span>
                <div>
                    <p style="font-family:var(--font);font-size:11px;font-weight:600;color:var(--text-2);text-transform:uppercase;letter-spacing:0.06em;margin:0 0 2px">{{ $label }}</p>
                    <p style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--text);margin:0">{{ $value }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:32px;padding:20px;background:#fff;border:1px solid var(--border);border-radius:8px">
            <p style="font-family:var(--head);font-size:14px;font-weight:600;color:var(--forest);margin:0 0 6px">Response times</p>
            <p style="font-family:var(--font);font-size:13.5px;color:var(--text-2);line-height:1.65;margin:0">Mon–Fri: within a few hours.<br>Weekends: next business day.</p>
        </div>
    </div>

    {{-- Right: form --}}
    <div x-data="{ sent: false, loading: false }">
        <div x-show="!sent">
            <p class="lp-sh" style="margin-bottom:24px">Send a message</p>
            <form class="lp-card" style="display:flex;flex-direction:column;gap:18px"
                  @submit.prevent="loading = true; setTimeout(() => { sent = true; loading = false }, 900)">

                <div class="lp-grid-2">
                    <div>
                        <label class="lp-label">Name</label>
                        <input type="text" class="lp-input" placeholder="Your name" required>
                    </div>
                    <div>
                        <label class="lp-label">Email</label>
                        <input type="email" class="lp-input" placeholder="you@example.com" required>
                    </div>
                </div>
                <div>
                    <label class="lp-label">Subject</label>
                    <select class="lp-input" style="appearance:none;cursor:pointer">
                        <option>General enquiry</option>
                        <option>Booking help</option>
                        <option>Driver or rider enquiry</option>
                        <option>Business account</option>
                        <option>Other</option>
                    </select>
                </div>
                <div>
                    <label class="lp-label">Message</label>
                    <textarea class="lp-input" rows="5" placeholder="How can we help?" required style="resize:vertical"></textarea>
                </div>
                <button type="submit" class="lp-btn" :disabled="loading"
                        style="align-self:flex-start">
                    <svg x-show="loading" class="lp-spinner" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span x-text="loading ? 'Sending...' : 'Send message'"></span>
                </button>
            </form>
        </div>
        <div x-show="sent" x-cloak class="lp-card" style="text-align:center;padding:48px 32px">
            <div style="width:52px;height:52px;background:var(--green-light);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px">
                <svg width="24" height="24" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 8px">Message sent</p>
            <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">We'll get back to you within one business day.</p>
        </div>
    </div>

</div>

<style>@media(max-width:768px){.lp-body>div{grid-template-columns:1fr!important}}</style>
</div>
</div>
@endsection
