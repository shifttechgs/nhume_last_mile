@extends('layouts.landing')
@section('title', 'Careers — Nhume')
@section('description', 'Join the team building Zimbabwe\'s community-first delivery network.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Careers</span>
    <h1>Build something<br>that matters</h1>
    <p>We're a small team solving a real problem for real people across Zimbabwe. Every person we hire shapes what Nhume becomes.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Why join --}}
    <div class="lp-section">
        <p class="lp-sh">Why Nhume</p>
        <div class="lp-grid-2">
            @foreach([
                ['Real impact, fast', 'You\'ll see your work used by real people within weeks — not months. We move quickly and ship constantly.'],
                ['Small team, big scope', 'We\'re early. That means you\'ll own meaningful problems, not a tiny slice of a large one.'],
                ['Remote-friendly', 'We are based in Harare but work remotely. We care about results, not where you sit.'],
                ['Honest culture', 'We say what we think. No politics, no hierarchy for the sake of it. Just people trying to solve a hard problem well.'],
            ] as [$title, $body])
            <div class="lp-card">
                <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);margin:0 0 8px">{{ $title }}</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0">{{ $body }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Open roles --}}
    <div class="lp-section">
        <p class="lp-sh">Open roles</p>
        <p class="lp-sp">We're hiring across engineering, operations, and growth.</p>
        <div style="display:flex;flex-direction:column;gap:12px">
            @foreach([
                ['Senior Full-Stack Engineer', 'Engineering', 'Full-time · Remote', 'Laravel, PHP, Livewire, Tailwind CSS. You\'ll build and ship the features that grow Nhume from MVP to scale.'],
                ['Operations Lead — Harare', 'Operations', 'Full-time · Harare', 'Own our driver and rider network in Harare. Recruit, vet, onboard, and support the humans who power every delivery.'],
                ['Growth & Community Manager', 'Growth', 'Full-time · Harare or Remote', 'Grow our sender base and build community around the Nhume brand. WhatsApp groups, local events, word of mouth — this role is the connector.'],
                ['Customer Support Specialist', 'Support', 'Part-time · Remote', 'First line of support for senders and drivers. Turn problems into resolved tickets and every interaction into trust.'],
            ] as [$role, $dept, $type, $summary])
            <div class="lp-card" style="display:flex;align-items:flex-start;justify-content:space-between;gap:24px;flex-wrap:wrap">
                <div style="flex:1;min-width:200px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap">
                        <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0">{{ $role }}</p>
                        <span style="font-family:var(--font);font-size:10px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--green-mid);background:var(--green-light);padding:3px 8px;border-radius:4px">{{ $dept }}</span>
                    </div>
                    <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:0 0 10px">{{ $type }}</p>
                    <p style="font-family:var(--font);font-size:13.5px;color:var(--text-2);line-height:1.65;margin:0">{{ $summary }}</p>
                </div>
                <a href="{{ route('contact') }}" class="lp-btn-ghost" style="flex-shrink:0;white-space:nowrap">Apply now</a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Don't see your role --}}
    <div class="lp-section">
        <div class="lp-card" style="text-align:center;padding:40px 32px">
            <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 8px">Don't see your role?</p>
            <p style="font-family:var(--font);font-size:14px;color:var(--text-2);line-height:1.65;margin:0 0 24px;max-width:480px;margin-left:auto;margin-right:auto">We hire for character and capability as much as specific skills. If you care deeply about logistics, community, or building things in Africa — introduce yourself.</p>
            <a href="{{ route('contact') }}" class="lp-btn">Get in touch</a>
        </div>
    </div>

</div>
</div>
@endsection
