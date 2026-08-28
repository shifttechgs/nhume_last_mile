@extends('layouts.landing')
@section('title', 'Blog — Nhume')
@section('description', 'Updates, stories, and insights from the Nhume team.')

@section('content')
<div class="lp-hero">
    <span class="lp-eyebrow">Blog</span>
    <h1>Stories from Nhume</h1>
    <p>How we're building Zimbabwe's community-first delivery network — one route at a time.</p>
</div>

<div style="background:var(--shade)">
<div class="lp-body">

    {{-- Featured post --}}
    <div class="lp-section">
        <a href="#" style="text-decoration:none;display:block">
            <div class="lp-card" style="overflow:hidden;padding:0;transition:box-shadow 0.2s" onmouseover="this.style.boxShadow='0 4px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow=''">
                <div style="background:var(--forest-deep);padding:40px 36px 36px">
                    <span style="display:inline-block;font-family:var(--font);font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--green-mid);margin-bottom:16px">Featured</span>
                    <h2 style="font-family:var(--head);font-size:clamp(22px,3vw,30px);font-weight:700;letter-spacing:-0.02em;color:#fff;line-height:1.2;margin:0 0 14px">Why we built Nhume: the problem with courier services in Zimbabwe</h2>
                    <p style="font-family:var(--font);font-size:14px;color:rgba(255,255,255,0.5);line-height:1.7;margin:0;max-width:600px">Every day, thousands of cars travel between Harare and Bulawayo with empty boots. Every day, people pay courier companies to drive the exact same road. We asked: what if we connected them?</p>
                </div>
                <div style="padding:20px 36px;display:flex;align-items:center;gap:16px;background:#fff;border-top:1px solid var(--border)">
                    <div style="width:32px;height:32px;border-radius:50%;background:var(--green-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg width="14" height="14" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p style="font-family:var(--font);font-size:13px;font-weight:600;color:var(--text);margin:0">Nhume Team</p>
                        <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:0">August 2026 · 5 min read</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

    {{-- Post grid --}}
    <div class="lp-section">
        <p class="lp-sh">Latest posts</p>
        <p class="lp-sp">Thoughts on logistics, community, and building in Africa.</p>
        <div class="lp-grid-3">
            @foreach([
                ['How we vet every driver before they go live', 'The manual verification process we use while automated systems are being built — and why we think talking to people is irreplaceable.', 'Trust & Safety', '4 min'],
                ['Harare to Bulawayo: what our first intercity routes taught us', 'Data, surprises, and lessons from our first 30 days of intercity deliveries on the most popular corridor in Zimbabwe.', 'Product', '6 min'],
                ['Why we chose community over scale', 'Most logistics startups optimise for transaction volume. We\'re optimising for trust. Here\'s why that changes everything.', 'Company', '3 min'],
                ['The economics of empty vehicle space', 'A transporter driving Harare–Bulawayo has capacity they\'re not monetising. We built a model that changes that.', 'Insights', '5 min'],
                ['What "Nhume" means — and why names matter', 'Nhume is a Shona word meaning messenger or envoy. Choosing the name shaped how we think about our role in every delivery.', 'Company', '2 min'],
                ['Building for Zimbabwe: why local context beats global templates', 'How we designed our verification flow, pricing, and trust signals specifically for the Zimbabwean market.', 'Product', '7 min'],
            ] as [$title, $excerpt, $tag, $read])
            <a href="#" style="text-decoration:none">
                <div class="lp-card" style="height:100%;display:flex;flex-direction:column;gap:16px;transition:box-shadow 0.2s" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow=''">
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span style="font-family:var(--font);font-size:10px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--green-mid)">{{ $tag }}</span>
                        <span style="font-family:var(--font);font-size:11px;color:var(--text-2)">{{ $read }} read</span>
                    </div>
                    <div style="flex:1">
                        <p style="font-family:var(--head);font-size:15px;font-weight:700;color:var(--forest);line-height:1.4;margin:0 0 10px">{{ $title }}</p>
                        <p style="font-family:var(--font);font-size:13px;color:var(--text-2);line-height:1.65;margin:0">{{ $excerpt }}</p>
                    </div>
                    <p style="font-family:var(--font);font-size:12px;color:var(--text-2);margin:0">Nhume Team · August 2026</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Subscribe --}}
    <div class="lp-section">
        <div class="lp-card" x-data="{ done: false }" style="max-width:560px;margin:0 auto;text-align:center;padding:40px">
            <div x-show="!done">
                <p style="font-family:var(--head);font-size:18px;font-weight:700;color:var(--forest);margin:0 0 8px">Get new posts in your inbox</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0 0 24px">No spam. Just occasional posts when we have something worth saying.</p>
                <form style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center"
                      @submit.prevent="done = true">
                    <input type="email" class="lp-input" placeholder="you@example.com" required style="flex:1;min-width:200px;max-width:280px">
                    <button type="submit" class="lp-btn">Subscribe</button>
                </form>
            </div>
            <div x-show="done" x-cloak>
                <div style="width:44px;height:44px;background:var(--green-light);border-radius:8px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                    <svg width="20" height="20" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p style="font-family:var(--head);font-size:16px;font-weight:700;color:var(--forest);margin:0 0 6px">You're subscribed</p>
                <p style="font-family:var(--font);font-size:14px;color:var(--text-2);margin:0">We'll be in touch when we post something new.</p>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
