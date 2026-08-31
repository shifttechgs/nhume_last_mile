@extends('layouts.landing')
@section('title', 'Become a Transporter — Nhume')
@section('description', 'Already making regular trips? List your empty space on Nhume and earn from journeys you were already going to make.')

@section('content')

<div class="lp-hero">
    <span class="lp-eyebrow">For transporters</span>
    <h1>Turn your regular trip<br>into extra income.</h1>
    <p>You're already driving to Bulawayo this Friday. List that space on Nhume and let senders WhatsApp you directly.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Success state --}}
    @if(session('applied'))
    <div class="lp-section">
        <div class="lp-card" style="text-align:center;padding:56px 32px;max-width:520px;margin:0 auto">
            <div style="width:52px;height:52px;background:var(--green-light);border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                <svg width="24" height="24" fill="none" stroke="var(--green-mid)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
            </div>
            <p style="font-family:var(--head);font-size:20px;font-weight:700;color:var(--forest);margin:0 0 10px">Application received</p>
            <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 8px">
                Our team will call you within <strong style="color:var(--text)">24–48 hours</strong> to verify your details and get you set up.
            </p>
            <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 28px">
                We've also sent a link to your email so you can set your password and explore the platform while you wait.
            </p>
            <a href="{{ route('journeys') }}" class="lp-btn-ghost">Browse the marketplace</a>
        </div>
    </div>
    @else

    {{-- How it works --}}
    <div class="lp-section">
        <p class="lp-sh">How it works</p>
        <p class="lp-sp">Three steps from application to your first parcel booking.</p>
        <div class="lp-grid-3">
            @foreach([
                ['1', 'Apply below', 'Fill in the form. Takes two minutes. Our team gets a notification immediately.'],
                ['2', 'We call you', 'Someone from the Nhume team calls to verify your details and answer any questions. Usually within 24 hours.'],
                ['3', 'Start posting', 'Log in, post your first journey, and let senders WhatsApp you directly to arrange pickups.'],
            ] as [$num, $title, $desc])
            <div class="lp-card" style="display:flex;align-items:flex-start;gap:16px">
                <div style="width:32px;height:32px;border-radius:50%;background:var(--forest);color:#fff;font-family:var(--head);font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px">{{ $num }}</div>
                <div>
                    <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 6px">{{ $title }}</p>
                    <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Application form --}}
    <div class="lp-section">
        <p class="lp-sh">Apply to join</p>
        <p class="lp-sp">Tell us a bit about yourself and the trips you make. We'll be in touch shortly.</p>

        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;padding:14px 18px;margin-bottom:20px">
            <p style="font-family:var(--font);font-size:13px;font-weight:600;color:#dc2626;margin:0 0 6px">Please fix the following:</p>
            <ul style="font-family:var(--font);font-size:13px;color:#dc2626;margin:0;padding-left:18px">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('partner.apply') }}"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf
            <div class="lp-card" style="display:flex;flex-direction:column;gap:20px">

                <div class="lp-grid-2">
                    <div>
                        <label class="lp-label">Full name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="lp-input" placeholder="e.g. Tafadzwa Moyo">
                    </div>
                    <div>
                        <label class="lp-label">Email address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="lp-input" placeholder="you@example.com">
                    </div>
                </div>

                <div class="lp-grid-2">
                    <div>
                        <label class="lp-label">Phone number *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               class="lp-input" placeholder="+263 77 123 4567">
                    </div>
                    <div>
                        <label class="lp-label">WhatsApp number</label>
                        <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}"
                               class="lp-input" placeholder="Same as phone if blank">
                    </div>
                </div>

                <div>
                    <label class="lp-label">Tell us about your trips</label>
                    <textarea name="bio" rows="4" class="lp-input" style="resize:vertical"
                              placeholder="e.g. I drive Harare to Bulawayo every Friday and Sunday in a Toyota Land Cruiser. I have plenty of boot space and I'm happy to carry parcels both ways.">{{ old('bio') }}</textarea>
                    <p style="font-family:var(--font);font-size:11.5px;color:var(--text-2);margin:6px 0 0">This becomes your profile bio on the marketplace. Senders read it before they WhatsApp you.</p>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding-top:4px">
                    <p style="font-family:var(--font);font-size:12.5px;color:var(--text-2);margin:0;max-width:400px;line-height:1.6">
                        By applying you agree to our
                        <a href="{{ route('terms') }}" style="color:var(--forest);font-weight:500;text-decoration:none">Terms</a>
                        and
                        <a href="{{ route('privacy') }}" style="color:var(--forest);font-weight:500;text-decoration:none">Privacy Policy</a>.
                    </p>
                    <button type="submit" class="lp-btn" :disabled="loading"
                            style="min-width:140px;justify-content:center"
                            :style="loading ? 'opacity:0.7;cursor:not-allowed' : ''">
                        <svg x-show="loading" x-cloak width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" viewBox="0 0 24 24"
                             style="animation:spin 0.7s linear infinite;flex-shrink:0">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                        <span x-show="!loading">Submit application</span>
                        <span x-show="loading" x-cloak>Submitting…</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- Trust tiers explained --}}
    <div class="lp-section">
        <p class="lp-sh">How trust works on Nhume</p>
        <p class="lp-sp">Every transporter starts as Unverified and moves up as our team gets to know them. Senders can see your tier.</p>
        <div style="display:flex;flex-direction:column;gap:0">
            @foreach([
                ['Unverified',    'unverified', '#f3f4f6', '#6b7280', 'You\'ve applied and created your account. You can post journeys immediately — senders see your tier and choose who to contact.'],
                ['Nhume Reviewed','reviewed',   '#dbeafe', '#1d4ed8', 'Our team has spoken to you offline and confirmed your identity. The blue badge builds sender confidence significantly.'],
                ['ID Submitted',  'id',         '#fef3c7', '#d97706', 'You\'ve submitted a valid national ID or passport. Pending full verification.'],
                ['Nhume Verified','verified',   '#edf8df', 'var(--green-mid)', 'Full verification complete. The highest trust level — senders prefer verified transporters for high-value parcels.'],
            ] as $i => [$label, $key, $bg, $color, $desc])
            <div class="lp-card" style="display:flex;align-items:flex-start;gap:16px;border-radius:{{ $i === 0 ? '8px 8px 0 0' : ($i === 3 ? '0 0 8px 8px' : '0') }};margin-bottom:{{ $i < 3 ? '-1px' : '0' }};position:relative;z-index:{{ $i === 0 ? 4 : (4 - $i) }}">
                <span style="display:inline-flex;align-items:center;padding:4px 12px;border-radius:4px;font-family:var(--font);font-size:11px;font-weight:700;background:{{ $bg }};color:{{ $color }};white-space:nowrap;flex-shrink:0;margin-top:2px">{{ $label }}</span>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Other partnership types --}}
    <div class="lp-section">
        <p class="lp-sh">Other partnership types</p>
        <p class="lp-sp">Not a transporter? We work with businesses and community organisations too.</p>
        <div class="lp-grid-2">
            @foreach([
                ['Business Accounts', 'Send regular parcels or run errands on behalf of your business. Get consolidated billing and volume pricing.', 'Retailers, importers, small businesses'],
                ['Community Partners', 'Churches, schools, and community groups that want to offer Nhume as a trusted service to their members.', 'NGOs, churches, schools, SACCOs'],
            ] as [$title, $desc, $examples])
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 8px">{{ $title }}</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0 0 12px">{{ $desc }}</p>
                <p style="font-family:var(--font);font-size:11.5px;color:var(--text-2);border-top:1px solid var(--border);padding-top:12px;margin:0"><strong style="color:var(--text)">Best for:</strong> {{ $examples }}</p>
            </div>
            @endforeach
        </div>
        <div style="margin-top:16px">
            <div class="lp-card" style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap">
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">Interested in a business or community partnership?</p>
                <a href="{{ route('contact') }}" class="lp-btn-ghost">Get in touch</a>
            </div>
        </div>
    </div>

    @endif

</div>
</div>

@section('styles')
<style>
.lp-input:focus-visible { outline: none; }
.lp-input { accent-color: var(--forest); }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@endsection
