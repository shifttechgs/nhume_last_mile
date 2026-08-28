@extends('layouts.landing')
@section('title', 'Safety — Nhume')
@section('description', 'How Nhume keeps senders, recipients, and drivers safe on every delivery.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Safety</span>
    <h1>Your safety, our priority</h1>
    <p>Real people move your parcels and run your errands. Here's how we make sure they're the right people.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Driver verification + store exterior side by side --}}
    <div class="lp-section">
        <div style="display:grid;grid-template-columns:1fr 440px;gap:48px;align-items:start">
            <div>
                <p class="lp-sh">How we verify drivers and riders</p>
                <p class="lp-sp">Every driver and rider on Nhume has been spoken to personally by our team. That's the minimum. Here's what each trust tier means.</p>
                <div style="display:flex;flex-direction:column;gap:12px">
                    @foreach([
                        ['Nhume Reviewed', 'Our team has spoken to this person in person or over the phone. We\'ve confirmed their identity and assessed their reliability before they go live.', '#edf8df', 'var(--green-mid)'],
                        ['ID Submitted', 'The driver or rider has submitted a valid national ID or passport for review. Our team has confirmed it matches the person we spoke to.', '#dbeafe', '#1d4ed8'],
                        ['Nhume Verified', 'Full background check completed. The highest level of trust on the platform. All details have been independently confirmed.', '#f0fdf4', '#15803d'],
                    ] as [$tier, $desc, $bg, $color])
                    <div class="lp-card" style="display:flex;align-items:flex-start;gap:16px">
                        <span style="display:inline-flex;align-items:center;padding:4px 12px;border-radius:4px;font-family:var(--font);font-size:11px;font-weight:700;background:{{ $bg }};color:{{ $color }};white-space:nowrap;flex-shrink:0;margin-top:2px">{{ $tier }}</span>
                        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div style="position:sticky;top:100px">
                <img src="/images/nhume-store-exterior.jpg"
                     alt="Nhume Store"
                     style="width:100%;border-radius:10px;display:block;box-shadow:0 8px 32px rgba(28,56,41,0.12)">
                <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:10px 0 0;text-align:center">Nhume Store, Harare — drop off, pick up, done.</p>
            </div>
        </div>
    </div>

    {{-- Cover --}}
    <div class="lp-section">
        <p class="lp-sh">Your parcel is covered</p>
        <p class="lp-sp">Every booking on Nhume includes basic cover for your parcel or errand item.</p>
        <div class="lp-grid-2">
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 8px">Basic cover — included</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">All bookings include basic cover for loss or damage during transit. The cover amount is shown to you before you confirm your booking.</p>
            </div>
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 8px">Extended cover — available</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">For high-value items, you can declare the value at checkout and add extended cover. We always show your full cover details before you confirm.</p>
            </div>
        </div>
    </div>

    {{-- If something goes wrong + counter image side by side --}}
    <div class="lp-section">
        <div style="display:grid;grid-template-columns:440px 1fr;gap:48px;align-items:start">
            <div style="position:sticky;top:100px">
                <img src="/images/nhume-store-lady.jpg"
                     alt="Nhume Store staff handing a parcel to a customer"
                     style="width:100%;border-radius:10px;display:block;box-shadow:0 8px 32px rgba(28,56,41,0.12)">
                <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:10px 0 0;text-align:center">Real people. Real help. Every time.</p>
            </div>
            <div>
                <p class="lp-sh">If something goes wrong</p>
                <p class="lp-sp">Here's exactly what to do, step by step.</p>
                <div class="lp-card" style="display:flex;flex-direction:column;gap:0">
                    @foreach([
                        ['Track first', 'Open your tracking link. Most concerns are resolved when you can see where your parcel actually is.'],
                        ['Contact the driver', 'Once assigned, you have the driver\'s contact details. A quick call often resolves delivery delays immediately.'],
                        ['Report to Nhume', 'If the issue isn\'t resolved, use our Report page. Our team reviews all reports within 24 hours.'],
                        ['Claim your cover', 'For loss or damage, file a claim through the report form. Include your order number and photos if available.'],
                    ] as $i => [$step, $desc])
                    <div style="display:flex;align-items:flex-start;gap:16px;padding:18px 0;{{ $i > 0 ? 'border-top:1px solid var(--border)' : '' }}">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;font-family:var(--head);font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px">{{ $i + 1 }}</span>
                        <div>
                            <p style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest);margin:0 0 4px">{{ $step }}</p>
                            <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.6;margin:0">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Tips --}}
    <div class="lp-section">
        <p class="lp-sh">Safety tips</p>
        <div class="lp-grid-2">
            @foreach([
                ['Always confirm before handover', 'Never hand over a parcel without a confirmed booking in the Nhume system. If someone claims to be your driver but can\'t confirm the order number, do not proceed.'],
                ['Use the app for payment', 'Nhume handles payment through the platform. If a driver asks for cash upfront outside the app, do not pay and report it to us immediately.'],
                ['Share tracking with your recipient', 'Send the tracking link to your recipient so they know when to expect the delivery and can confirm arrival.'],
                ['Report suspicious behaviour', 'If a driver or rider behaves in a way that concerns you, report it through our platform. Every report is reviewed by a real person.'],
            ] as [$title, $body])
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest);margin:0 0 7px">{{ $title }}</p>
                <p style="font-family:var(--font);font-size:13.5px;color:var(--text-2);line-height:1.65;margin:0">{{ $body }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="lp-section">
        <div class="lp-card" style="display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap">
            <div>
                <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0 0 4px">Have a concern right now?</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">Our team is available on WhatsApp and email.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <a href="{{ route('report') }}" class="lp-btn">Report an issue</a>
                <a href="{{ route('contact') }}" class="lp-btn-ghost">Contact us</a>
            </div>
        </div>
    </div>

</div>
</div>
@section('styles')
<style>
@media(max-width:900px){
    div[style*="grid-template-columns:1fr 440px"],
    div[style*="grid-template-columns:440px 1fr"] { grid-template-columns:1fr!important; }
    div[style*="position:sticky;top:100px"] { position:static!important; }
}
</style>
@endsection
@endsection
