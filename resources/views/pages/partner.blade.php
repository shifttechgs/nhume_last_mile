@extends('layouts.landing')
@section('title', 'Become a Partner — Nhume')
@section('description', 'Partner with Nhume to expand your logistics reach across Zimbabwe.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Partners</span>
    <h1>Grow together<br>with Nhume</h1>
    <p>We work with businesses, courier companies, and community organisations to expand reliable delivery across Zimbabwe.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Partnership types --}}
    <div class="lp-section">
        <p class="lp-sh">Partnership types</p>
        <p class="lp-sp">We're open to a range of partnerships — here are the models that work best today.</p>
        <div class="lp-grid-3">
            @foreach([
                [
                    'Business Accounts',
                    'Send regular parcels or run errands on behalf of your business. Get a dedicated account manager, consolidated billing, and volume pricing.',
                    'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'Retailers, importers, small businesses'
                ],
                [
                    'Fleet Partners',
                    'You have vehicles making regular intercity or intracity runs. List your capacity on Nhume and earn from the space you\'re already using.',
                    'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'Transporters, logistics companies, fleet operators'
                ],
                [
                    'Community Partners',
                    'Churches, schools, community groups, or neighbourhood associations that want to offer Nhume as a trusted service to their members.',
                    'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'NGOs, churches, schools, SACCOs'
                ],
            ] as [$title, $desc, $icon, $examples])
            <div class="lp-card" style="display:flex;flex-direction:column;gap:16px">
                <div style="width:42px;height:42px;border-radius:8px;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="20" height="20" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <div style="flex:1">
                    <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0 0 8px">{{ $title }}</p>
                    <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0 0 12px">{{ $desc }}</p>
                    <p style="font-family:var(--font);font-size:11.5px;color:var(--text-2);border-top:1px solid var(--border);padding-top:12px;margin:0"><span style="font-weight:600;color:var(--text)">Best for:</span> {{ $examples }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Benefits --}}
    <div class="lp-section">
        <p class="lp-sh">What you get as a partner</p>
        <p class="lp-sp">Every partnership is different. These are the things we offer across all our models.</p>
        <div class="lp-grid-2">
            @foreach([
                ['Dedicated support', 'A real contact at Nhume. Not a ticket queue — an actual person you can call or WhatsApp when something needs attention.'],
                ['Flexible pricing', 'Volume pricing for high-frequency senders. Revenue share for fleet partners. We\'ll find a model that works for your situation.'],
                ['Co-marketing opportunities', 'We feature partners on our platform and across our community channels. If you serve a community we serve, we tell that story together.'],
                ['Early access to new features', 'Partners are the first to know about new routes, service types, and product improvements before public launch.'],
            ] as [$title, $body])
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 8px">{{ $title }}</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">{{ $body }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Enquiry form --}}
    <div class="lp-section">
        <p class="lp-sh">Tell us about your business</p>
        <p class="lp-sp">Fill in the form below and we'll get back to you within two business days.</p>

        <div x-data="{ sent: false, loading: false }">
            <div x-show="!sent">
                <form class="lp-card" style="display:flex;flex-direction:column;gap:18px"
                      @submit.prevent="loading = true; setTimeout(() => { sent = true; loading = false }, 900)">
                    <div class="lp-grid-2">
                        <div>
                            <label class="lp-label">Name</label>
                            <input type="text" class="lp-input" placeholder="Your name" required>
                        </div>
                        <div>
                            <label class="lp-label">Company / organisation</label>
                            <input type="text" class="lp-input" placeholder="Your company name" required>
                        </div>
                    </div>
                    <div class="lp-grid-2">
                        <div>
                            <label class="lp-label">Email</label>
                            <input type="email" class="lp-input" placeholder="you@company.com" required>
                        </div>
                        <div>
                            <label class="lp-label">Phone / WhatsApp</label>
                            <input type="tel" class="lp-input" placeholder="+263 77 ...">
                        </div>
                    </div>
                    <div>
                        <label class="lp-label">Partnership type</label>
                        <select class="lp-input" style="appearance:none;cursor:pointer">
                            <option value="">Select a type...</option>
                            <option>Business Account</option>
                            <option>Fleet Partner</option>
                            <option>Community Partner</option>
                            <option>Something else</option>
                        </select>
                    </div>
                    <div>
                        <label class="lp-label">Tell us about your needs</label>
                        <textarea class="lp-input" rows="5" placeholder="What are you trying to accomplish? How often do you need to send things, and on which routes?" style="resize:vertical"></textarea>
                    </div>
                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" class="lp-btn" :disabled="loading">
                            <svg x-show="loading" class="lp-spinner" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span x-text="loading ? 'Sending...' : 'Submit enquiry'"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div x-show="sent" x-cloak class="lp-card" style="text-align:center;padding:56px 32px;max-width:480px;margin:0 auto">
                <div style="width:52px;height:52px;background:var(--green-light);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px">
                    <svg width="24" height="24" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 8px">Enquiry received</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">Our team will review your enquiry and get back to you within two business days. We look forward to talking.</p>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
