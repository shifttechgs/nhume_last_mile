@extends('layouts.landing')
@section('title', 'Privacy Policy — Nhume')
@section('description', 'How Nhume collects, uses, and protects your personal information.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Legal</span>
    <h1>Privacy Policy</h1>
    <p>We respect your privacy and are committed to protecting your personal data.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    <div style="display:grid;grid-template-columns:220px 1fr;gap:48px;align-items:start">

        {{-- Sidebar TOC --}}
        <div style="position:sticky;top:100px">
            <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-2);margin:0 0 14px">On this page</p>
            <nav style="display:flex;flex-direction:column;gap:8px">
                @foreach([
                    ['#who',        'Who We Are'],
                    ['#collect',    'What We Collect'],
                    ['#how',        'How We Use It'],
                    ['#sharing',    'Sharing Data'],
                    ['#retention',  'Retention'],
                    ['#rights',     'Your Rights'],
                    ['#security',   'Security'],
                    ['#cookies',    'Cookies'],
                    ['#children',   'Children'],
                    ['#changes',    'Policy Changes'],
                    ['#contact',    'Contact'],
                ] as [$href, $label])
                <a href="{{ $href }}" style="font-family:var(--font);font-size:13px;color:var(--text-2);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--text-2)'">{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        {{-- Body --}}
        <div style="display:flex;flex-direction:column;gap:0">

            <div class="lp-card" style="margin-bottom:12px;background:var(--green-light);border-color:rgba(107,198,48,0.3)">
                <p style="font-family:var(--font);font-size:13px;color:#2d5a0e;line-height:1.65;margin:0"><strong>Last updated:</strong> August 2026. This policy applies to all users of the Nhume platform and website.</p>
            </div>

            @php
            $sections = [
                ['who', 'Who We Are', '
                    Nhume Technologies (Private) Limited ("Nhume", "we", "us", or "our") operates the Nhume logistics marketplace. We are registered in Zimbabwe and our principal place of business is Harare.
                    This Privacy Policy explains how we collect, use, store, and protect your personal information when you use our platform.
                '],
                ['collect', 'What We Collect', '
                    Account information: When you register, we collect your name, email address, phone number, and password.
                    Profile information: Transporters provide additional details including vehicle information, driver\'s licence, and national ID for verification purposes.
                    Booking data: We collect details about the parcels or errands you book, including pickup and delivery addresses, parcel descriptions, and booking history.
                    Communications: Messages you send to our support team or through the platform.
                    Usage data: How you interact with our website and app — pages visited, features used, and device information (IP address, browser type, operating system).
                    Location data: Pickup and delivery addresses you provide. We do not collect continuous background location data.
                '],
                ['how', 'How We Use Your Information', '
                    We use your information to: operate and improve the Nhume platform; process bookings and payments; verify Transporter identities; communicate with you about your bookings and account; provide customer support; send you service updates and, with your consent, marketing communications; detect and prevent fraud; and comply with our legal obligations.
                    We do not sell your personal data to third parties for marketing purposes.
                '],
                ['sharing', 'Sharing Your Data', '
                    We share limited data with other users as necessary to fulfil bookings — for example, a Sender\'s name and contact number are shared with the assigned Transporter, and the Transporter\'s name and contact details are shared with the Sender.
                    We use carefully selected third-party service providers to operate the platform, including payment processors, hosting providers, and communication services. These providers only access data necessary to provide their services and are bound by confidentiality obligations.
                    We may disclose personal data where required by law, by court order, or to protect the safety of users or the public.
                '],
                ['retention', 'How Long We Keep Your Data', '
                    We retain your account data for as long as your account is active. If you close your account, we retain data as required by law (typically seven years for financial records) and then delete it.
                    Booking records are retained for seven years for accounting and dispute purposes.
                    You can request deletion of your account data at any time — see Your Rights below.
                '],
                ['rights', 'Your Rights', '
                    You have the right to: access the personal data we hold about you; correct inaccurate data; request deletion of your data (subject to legal retention obligations); object to or restrict certain processing; and receive your data in a portable format.
                    To exercise any of these rights, contact us at privacy@nhume.co.zw or through our Contact page. We will respond within 30 days.
                '],
                ['security', 'Security', '
                    We use industry-standard security measures including encrypted data storage, secure HTTPS connections, and access controls to protect your personal data.
                    No system is completely secure. If you believe your account has been compromised, please contact us immediately.
                '],
                ['cookies', 'Cookies', '
                    We use cookies and similar technologies to operate the platform, remember your preferences, and understand how you use our service. See our Cookie Policy for full details.
                    You can control cookie preferences through your browser settings or our cookie consent tool.
                '],
                ['children', 'Children', '
                    The Nhume platform is not intended for use by anyone under 18 years of age. We do not knowingly collect personal data from children. If you believe we have collected data from a child, please contact us and we will delete it promptly.
                '],
                ['changes', 'Changes to This Policy', '
                    We may update this Privacy Policy from time to time. We will notify you of significant changes by email or through a prominent notice on the platform. The updated policy will be effective from the date shown at the top of this page.
                    Your continued use of the platform after changes constitutes acceptance of the updated policy.
                '],
                ['contact', 'Contact Us', '
                    If you have questions, concerns, or requests relating to your privacy, please contact our Privacy team at privacy@nhume.co.zw or through our Contact page. We take all privacy concerns seriously and will respond within 30 days.
                '],
            ];
            @endphp

            @foreach($sections as [$id, $heading, $body])
            <div class="lp-card" id="{{ $id }}" style="margin-bottom:12px;scroll-margin-top:100px">
                <p style="font-family:var(--head);font-size:17px;font-weight:700;color:var(--forest);margin:0 0 14px">{{ $heading }}</p>
                @foreach(array_filter(array_map('trim', explode("\n", $body))) as $para)
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 12px">{{ $para }}</p>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>

    <style>@media(max-width:768px){.lp-body>div{grid-template-columns:1fr!important} .lp-body>div>div:first-child{position:static!important}}</style>
</div>
</div>
@endsection
