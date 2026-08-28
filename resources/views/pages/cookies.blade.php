@extends('layouts.landing')
@section('title', 'Cookie Policy — Nhume')
@section('description', 'How Nhume uses cookies and similar technologies on our platform.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Legal</span>
    <h1>Cookie Policy</h1>
    <p>A plain-language explanation of the cookies we use and why.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body" style="max-width:760px">

    <div class="lp-card" style="margin-bottom:12px;background:var(--green-light);border-color:rgba(107,198,48,0.3)">
        <p style="font-family:var(--font);font-size:13px;color:#2d5a0e;line-height:1.65;margin:0"><strong>Last updated:</strong> August 2026.</p>
    </div>

    {{-- What are cookies --}}
    <div class="lp-card" style="margin-bottom:12px" id="what">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">What are cookies?</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 12px">Cookies are small text files placed on your device when you visit a website. They help the website remember information about your visit — such as whether you are logged in — so you don't have to re-enter it every time.</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0">Nhume uses cookies and similar technologies (such as local storage) to operate our platform, keep you logged in, and understand how our service is being used so we can improve it.</p>
    </div>

    {{-- Cookie types table --}}
    <div class="lp-card" style="margin-bottom:12px" id="types">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 20px">The cookies we use</p>
        <div style="display:flex;flex-direction:column;gap:0">
            @foreach([
                [
                    'Essential',
                    'Required for the platform to function. These include session cookies that keep you logged in and CSRF protection tokens that keep your account secure. You cannot opt out of these without ceasing to use the platform.',
                    'Always active'
                ],
                [
                    'Functional',
                    'Remember your preferences — for example, your language or any settings you have configured. These make the platform easier to use but are not strictly essential.',
                    'Active by default'
                ],
                [
                    'Analytics',
                    'Help us understand how visitors interact with our platform — which pages are visited, how long people spend on them, and where errors occur. We use this data to improve the service. This data is aggregated and not linked to individual users.',
                    'Active by default'
                ],
                [
                    'Marketing',
                    'Used to show you relevant content about Nhume on other websites you visit. We use these sparingly and only with your explicit consent.',
                    'Requires consent'
                ],
            ] as $i => [$type, $desc, $status])
            <div style="display:grid;grid-template-columns:160px 1fr 140px;gap:20px;align-items:start;padding:18px 0;{{ $i > 0 ? 'border-top:1px solid var(--border)' : '' }}">
                <div>
                    <p style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest);margin:0">{{ $type }}</p>
                </div>
                <p style="font-family:var(--font);font-size:13.5px;color:var(--text-2);line-height:1.65;margin:0">{{ $desc }}</p>
                <span style="font-family:var(--font);font-size:11px;font-weight:600;color:{{ $status === 'Always active' ? 'var(--green-mid)' : ($status === 'Requires consent' ? '#b45309' : 'var(--text-2)') }};background:{{ $status === 'Always active' ? 'var(--green-light)' : ($status === 'Requires consent' ? '#fef3c7' : 'var(--shade)') }};padding:4px 10px;border-radius:4px;display:inline-block;white-space:nowrap">{{ $status }}</span>
            </div>
            @endforeach
        </div>
        <style>@media(max-width:640px){.lp-body .lp-card div[style*="grid-template-columns:160px"]{grid-template-columns:1fr!important}}</style>
    </div>

    {{-- Third-party cookies --}}
    <div class="lp-card" style="margin-bottom:12px" id="third-party">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">Third-party cookies</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 12px">Some of our service providers may set their own cookies. These include analytics platforms (such as Google Analytics, if enabled) and payment processors. These providers have their own privacy and cookie policies.</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0">We do not allow third parties to set marketing or advertising cookies without your explicit consent.</p>
    </div>

    {{-- Control --}}
    <div class="lp-card" style="margin-bottom:12px" id="control">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">How to control cookies</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 12px">You can manage your cookie preferences at any time through your browser settings. Most browsers allow you to refuse cookies, delete existing cookies, or alert you when a site tries to set one.</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 12px">Note: if you disable essential cookies, some parts of the Nhume platform will not work correctly — for example, you will not be able to stay logged in.</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0">For more information on managing cookies, visit <span style="color:var(--forest);font-weight:500">aboutcookies.org</span> or your browser's help documentation.</p>
    </div>

    {{-- Changes --}}
    <div class="lp-card" style="margin-bottom:12px" id="changes">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">Changes to this policy</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0">We may update this Cookie Policy as our use of cookies changes or in response to legal requirements. The updated date at the top of this page reflects the most recent revision. We will notify you of material changes through the platform.</p>
    </div>

    {{-- Contact --}}
    <div class="lp-card" id="contact">
        <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">Questions?</p>
        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 16px">If you have questions about how we use cookies, please contact us at <span style="color:var(--forest);font-weight:500">privacy@nhume.co.zw</span> or through our Contact page.</p>
        <a href="{{ route('contact') }}" class="lp-btn-ghost">Go to Contact</a>
    </div>

</div>
</div>
@endsection
