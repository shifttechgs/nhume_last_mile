@extends('layouts.landing')
@section('title', 'Terms of Service — Nhume')
@section('description', 'The terms and conditions governing your use of the Nhume platform.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Legal</span>
    <h1>Terms of Service</h1>
    <p>Please read these terms carefully before using the Nhume platform.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    <div style="display:grid;grid-template-columns:220px 1fr;gap:48px;align-items:start">

        {{-- Sidebar TOC --}}
        <div style="position:sticky;top:100px">
            <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-2);margin:0 0 14px">On this page</p>
            <nav style="display:flex;flex-direction:column;gap:8px">
                @foreach([
                    ['#acceptance',   'Acceptance'],
                    ['#platform',     'The Platform'],
                    ['#accounts',     'Accounts'],
                    ['#senders',      'Sender Terms'],
                    ['#transporters', 'Transporter Terms'],
                    ['#payments',     'Payments'],
                    ['#liability',    'Liability'],
                    ['#prohibited',   'Prohibited Items'],
                    ['#termination',  'Termination'],
                    ['#governing',    'Governing Law'],
                    ['#contact',      'Contact'],
                ] as [$href, $label])
                <a href="{{ $href }}" style="font-family:var(--font);font-size:13px;color:var(--text-2);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='var(--forest)'" onmouseout="this.style.color='var(--text-2)'">{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        {{-- Body --}}
        <div style="display:flex;flex-direction:column;gap:0">

            <div class="lp-card" style="margin-bottom:12px;background:var(--green-light);border-color:rgba(107,198,48,0.3)">
                <p style="font-family:var(--font);font-size:13px;color:#2d5a0e;line-height:1.65;margin:0"><strong>Last updated:</strong> August 2026. These terms apply to all users of the Nhume platform, including senders, transporters, and visitors.</p>
            </div>

            @php
            $sections = [
                ['acceptance', 'Acceptance of Terms', '
                    By accessing or using the Nhume platform — including our website, mobile applications, and any related services — you agree to be bound by these Terms of Service and our Privacy Policy. If you do not agree to these terms, you may not use the platform.
                    These terms constitute a legally binding agreement between you and Nhume Technologies (Private) Limited, a company registered in Zimbabwe.
                '],
                ['platform', 'The Platform', '
                    Nhume is a two-sided logistics marketplace that connects people who need parcels or errands moved (Senders) with individuals who are already travelling to the destination (Transporters). Nhume does not itself provide delivery services. We provide the technology platform that facilitates connections between Senders and Transporters.
                    Nhume reserves the right to modify, suspend, or discontinue any part of the platform at any time with reasonable notice. We will not be liable for any such modification, suspension, or discontinuation.
                '],
                ['accounts', 'Accounts and Registration', '
                    To use certain features of the platform, you must create an account. You must provide accurate, complete, and current information and keep your account details up to date.
                    You are responsible for maintaining the confidentiality of your password and for all activities that occur under your account. You must notify us immediately of any unauthorised use of your account.
                    You must be at least 18 years old to create an account and use the platform. By registering, you represent and warrant that you meet this requirement.
                '],
                ['senders', 'Sender Terms', '
                    As a Sender, you are responsible for: (a) accurately describing the parcel or errand you need moved; (b) ensuring the parcel does not contain prohibited items (see below); (c) ensuring the parcel is appropriately packaged for transit; (d) providing accurate pickup and delivery addresses; and (e) being available or arranging for someone to be available for pickup and delivery.
                    Nhume will confirm the assigned Transporter and provide you with their contact details and a tracking reference once a booking is confirmed.
                '],
                ['transporters', 'Transporter Terms', '
                    As a Transporter, you agree to: (a) only accept bookings that you can genuinely fulfil on the confirmed journey; (b) collect and deliver parcels with reasonable care; (c) maintain the parcel safely throughout the journey; (d) communicate proactively with the Sender if there are any delays or issues; and (e) comply with all applicable laws, including traffic and customs laws.
                    Transporters must complete Nhume\'s verification process before accepting bookings. Providing false information during verification may result in immediate suspension.
                '],
                ['payments', 'Payments and Fees', '
                    All payments are processed through the Nhume platform. Senders pay the booking fee at the time of confirmation. Nhume deducts its commission and remits the remainder to the Transporter following confirmed delivery.
                    Prices are displayed in United States Dollars (USD) unless otherwise stated. Nhume reserves the right to update pricing at any time.
                '],
                ['liability', 'Limitation of Liability', '
                    Nhume provides basic cover for parcels in transit as described on the Safety page. Beyond this, Nhume\'s liability for loss, damage, or delay of a parcel is limited to the value of the booking fee paid.
                    Nhume is not liable for: indirect or consequential loss; loss of profits or business; delays caused by circumstances outside our or the Transporter\'s reasonable control; or the acts or omissions of Transporters, who are independent contractors and not employees of Nhume.
                '],
                ['prohibited', 'Prohibited Items', '
                    The following items may not be transported using the Nhume platform: illegal drugs or controlled substances; weapons, ammunition, or explosives; cash or negotiable instruments; live animals; perishable food that requires controlled temperature; items that are prohibited from transport under Zimbabwean law; and any item the Transporter has expressly declined to carry.
                    Nhume reserves the right to cancel any booking involving prohibited items without refund and to report the relevant parties to the appropriate authorities.
                '],
                ['termination', 'Termination', '
                    Either party may terminate the account relationship at any time. Nhume reserves the right to suspend or terminate any account immediately if we believe a user has breached these terms, engaged in fraudulent activity, or posed a risk to other users or to the platform.
                    Upon termination, any pending bookings will be handled at Nhume\'s discretion with appropriate notice to all affected parties.
                '],
                ['governing', 'Governing Law', '
                    These Terms of Service are governed by the laws of Zimbabwe. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the courts of Zimbabwe.
                '],
                ['contact', 'Contact Us', '
                    If you have questions about these Terms of Service, please contact us at legal@nhume.co.zw or through our Contact page.
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
