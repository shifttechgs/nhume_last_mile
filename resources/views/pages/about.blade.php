@extends('layouts.landing')
@section('title', 'About Nhume')
@section('description', 'Nhume started in Kuwadzana with a simple frustration — why is it so hard to move things between people who are already going the same way?')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Our story</span>
    <h1>From Kuwadzana,<br>for Zimbabwe.</h1>
    <p>We built Nhume because we lived the problem — and we got tired of watching people stress over something that should be simple.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Origin story --}}
    <div class="lp-section">
        <div style="display:grid;grid-template-columns:1fr 420px;gap:56px;align-items:start">
            <div>
                <p class="lp-sh">It started with a stress we all know</p>
                <p style="font-family:var(--font);font-size:16px;color:var(--text-2);line-height:1.8;margin:0 0 20px">
                    Growing up in Kuwadzana, you learn quickly that getting something from one place to another is never simple. You call a relative in Bulawayo. They need the package by the weekend. You spend two days asking everyone you know: <em>"Do you know anyone going that way?"</em>
                </p>
                <p style="font-family:var(--font);font-size:16px;color:var(--text-2);line-height:1.8;margin:0 0 20px">
                    Sometimes it works. Mostly it's a favour owed, a last-minute arrangement, a prayer that it arrives safely. And the stress that comes with all of it — the follow-up messages, the uncertainty, the waiting — that stress falls entirely on the person who needs something moved.
                </p>
                <p style="font-family:var(--font);font-size:16px;color:var(--text-2);line-height:1.8;margin:0">
                    We saw this everywhere. Not just across cities, but around the corner. A mother in Mbare who needs groceries from town. A vendor in Avondale who can't leave her stand to deliver to a client five suburbs away. A small business owner in Gweru trying to grow, losing customers because delivery is too unreliable to promise.
                </p>
            </div>
            <div style="position:sticky;top:100px">
                <img src="/images/nhume-store-interior.jpg"
                     alt="Nhume Store interior — Drop off. Pick up. Done."
                     style="width:100%;display:block;border-radius:10px;box-shadow:0 8px 32px rgba(28,56,41,0.12)">
                <img src="/images/nhume-store-lady.jpg"
                     alt="Nhume Store — parcel handoff"
                     style="width:100%;display:block;border-radius:10px;box-shadow:0 8px 32px rgba(28,56,41,0.12);margin-top:16px">
                <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:10px 0 0;text-align:center">Nhume Store, Harare</p>
            </div>
        </div>
        <style>@media(max-width:900px){div[style*="grid-template-columns:1fr 420px"]{grid-template-columns:1fr!important}div[style*="position:sticky;top:100px"]{position:static!important}}</style>
    </div>

    {{-- The real problem --}}
    <div class="lp-section">
        <div class="lp-grid-2" style="gap:24px;align-items:stretch">
            <div class="lp-card" style="border-left:3px solid var(--green);padding-left:32px">
                <p style="font-family:var(--head);font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--green-mid);margin:0 0 14px">The gap we kept seeing</p>
                <p style="font-family:var(--font);font-size:15px;color:var(--text-2);line-height:1.75;margin:0 0 14px">Zimbabwe has people moving everywhere, every day — by car, by bike, by kombi. Most of them travel with empty space and no way to put that space to use. Meanwhile, someone else is desperate to get a parcel on exactly that route.</p>
                <p style="font-family:var(--font);font-size:15px;color:var(--text-2);line-height:1.75;margin:0">The logistics industry calls it the last-mile problem. We call it a missed connection between people who needed each other all along.</p>
            </div>
            <div class="lp-card" style="border-left:3px solid var(--forest);padding-left:32px">
                <p style="font-family:var(--head);font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--forest);margin:0 0 14px">What we did about it</p>
                <p style="font-family:var(--font);font-size:15px;color:var(--text-2);line-height:1.75;margin:0 0 14px">We built Nhume to be the connection. A platform that finds the driver already going to Bulawayo, the rider already covering Borrowdale, the neighbour who can drop something off on their way home.</p>
                <p style="font-family:var(--font);font-size:15px;color:var(--text-2);line-height:1.75;margin:0">No extra trips. No inflated courier fees. No spending your afternoon chasing someone for an update. Just a booking, a real person, and a delivery that actually happens.</p>
            </div>
        </div>
    </div>

    {{-- Who we're for --}}
    <div class="lp-section">
        <p class="lp-sh">Who Nhume is for</p>
        <p class="lp-sp">We built this for three kinds of people — and we think about all three every time we make a decision.</p>
        {{-- Top row: two audience cards --}}
        <div class="lp-grid-2" style="margin-bottom:16px">
            @foreach([
                [
                    'Individuals and families',
                    'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'The person who needs to send clothes to their mother in Mutare. The student waiting for documents from home. Anyone who has ever had to ask a favour just to move something from A to B. You deserve a reliable, affordable way to do that without the stress.',
                ],
                [
                    'Emerging entrepreneurs',
                    'M13 10V3L4 14h7v7l9-11h-7z',
                    'The home baker who takes orders but can\'t deliver. The fashion designer whose clients are spread across Harare. The small trader who loses sales because "delivery" is still a manual, unreliable process. Nhume is your logistics team — without the overhead.',
                ],
            ] as [$title, $icon, $body])
            <div class="lp-card" style="display:flex;flex-direction:column;gap:16px">
                <div style="width:44px;height:44px;border-radius:8px;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg width="20" height="20" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <div>
                    <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0 0 10px">{{ $title }}</p>
                    <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.7;margin:0">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Full-width transporter card with rider image --}}
        <div class="lp-card" style="padding:0;overflow:hidden">
            <div style="display:grid;grid-template-columns:1fr 420px;min-height:260px">
                <div style="padding:32px 36px;display:flex;flex-direction:column;justify-content:center;gap:16px">
                    <div style="width:44px;height:44px;border-radius:8px;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg width="20" height="20" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <div>
                        <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 10px">Transporters and riders</p>
                        <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.75;margin:0 0 20px;max-width:500px">You're already making the journey. Your car, your bike, your time — they have value that goes unused every single day. Nhume lets you earn from the space you already have, without changing your route or your schedule.</p>
                        <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:7px;font-family:var(--font);font-size:13px;font-weight:600;color:var(--forest);background:var(--green-light);padding:9px 18px;border-radius:6px;text-decoration:none;transition:background 0.15s" onmouseover="this.style.background='#d4f0b0'" onmouseout="this.style.background='var(--green-light)'">
                            Join as a driver or rider
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                <div style="position:relative;overflow:hidden">
                    <img src="/images/nhume-store-lady.jpg" alt="Nhume Store — parcel handoff"
                         style="width:100%;height:100%;object-fit:cover;object-position:center 20%;display:block">
                    <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(255,255,255,0.06) 0%,transparent 30%)"></div>
                </div>
            </div>
        </div>
        <style>@media(max-width:768px){.lp-card div[style*="grid-template-columns:1fr 420px"]{grid-template-columns:1fr!important} .lp-card div[style*="grid-template-columns:1fr 420px"]>div:last-child{height:220px}}</style>
    </div>

    {{-- Vision --}}
    <div class="lp-section">
        <div class="lp-card" style="background:var(--forest-deep);border-color:transparent;padding:40px 36px">
            <p style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--green-mid);margin:0 0 16px">Where we're going</p>
            <p style="font-family:var(--head);font-size:clamp(20px,2.8vw,28px);font-weight:700;letter-spacing:-0.02em;color:#fff;line-height:1.3;margin:0 0 20px;max-width:640px">"A Zimbabwe where moving something is never a source of stress — for anyone."</p>
            <p style="font-family:var(--font);font-size:15px;color:rgba(255,255,255,0.5);line-height:1.75;margin:0;max-width:620px">We started with Harare. We're building toward Bulawayo, Mutare, Gweru, Victoria Falls — and every corridor in between. Our goal is simple: wherever you are in Zimbabwe, if you need something moved, Nhume finds a way.</p>
        </div>
    </div>

    {{-- Values --}}
    <div class="lp-section">
        <p class="lp-sh">What we stand for</p>
        <p class="lp-sp">These aren\'t posters on a wall. They\'re the decisions we make when something is hard.</p>
        <div class="lp-grid-2">
            @foreach([
                ['Community first', 'We grew up in communities where people help each other move things, watch each other\'s businesses grow, and celebrate each other\'s wins. Nhume is built on that same spirit — just with a booking system.'],
                ['Honest about trust', 'We don\'t pretend that handing your parcel to a stranger is nothing. Every driver and rider on Nhume has been personally reviewed by our team before going live. We\'ll tell you exactly who is carrying your parcel and why we trust them.'],
                ['Built for the real Zimbabwe', 'Not a copy of a Western logistics app. We designed for the routes people actually travel, the prices people can actually afford, and the realities of how business gets done here.'],
                ['The entrepreneur\'s corner', 'Small businesses are the backbone of this economy. Nhume gives them delivery capability that was previously only available to companies with warehouses and fleets. That\'s the point.'],
            ] as [$title, $body])
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 9px">{{ $title }}</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.7;margin:0">{{ $body }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Stats --}}
    <div class="lp-section">
        <p class="lp-sh">Where we are today</p>
        <p class="lp-sp">Early days. Building carefully. Moving fast.</p>
        <div class="lp-grid-3">
            @foreach([
                ['4', 'Intercity routes', 'Harare, Bulawayo, Mutare and Gweru'],
                ['20+', 'Reviewed drivers & riders', 'Personally vetted before going live'],
                ['$3', 'Starting price', 'Delivery that anyone can afford'],
            ] as [$num, $label, $sub])
            <div class="lp-card" style="text-align:center">
                <p style="font-family:var(--head);font-size:52px;font-weight:800;letter-spacing:-0.04em;color:var(--forest);line-height:1;margin:0 0 10px">{{ $num }}</p>
                <p style="font-family:var(--head);font-size:14px;font-weight:600;color:var(--text);margin:0 0 4px">{{ $label }}</p>
                <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:0">{{ $sub }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="lp-section">
        <div class="lp-card" style="display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap">
            <div>
                <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 5px">Be part of this.</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">Send your first parcel, join as a transporter, or just say hello. We\'re a real team and we read every message.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;flex-shrink:0">
                <a href="{{ route('send') }}" class="lp-btn">Send a parcel</a>
                <a href="{{ route('contact') }}" class="lp-btn-ghost">Get in touch</a>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
