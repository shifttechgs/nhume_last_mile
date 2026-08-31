@props(['frosted' => false])
<style>
.nav-outer {
    position: fixed;
    top: clamp(24px,3vw,36px);
    left: clamp(16px,2vw,24px);
    right: clamp(16px,2vw,24px);
    z-index: 100;
    background: transparent;
    border-radius: 8px;
    border: 1px solid transparent;
    transition: top 0.35s ease, left 0.35s ease, right 0.35s ease,
                border-radius 0.35s ease, background 0.35s ease,
                box-shadow 0.35s ease, border-color 0.35s ease;
    pointer-events: all;
}
.nav-outer.is-scrolled {
    top: 0; left: 0; right: 0;
    border-radius: 0;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-color: rgba(12,26,15,0.07);
    box-shadow: 0 2px 16px rgba(28,56,41,0.07);
}
.nav-bar {
    max-width: 1360px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    padding: clamp(10px,1.2vh,14px) clamp(20px,3vw,40px);
}
.nav-logo { display: flex; align-items: center; text-decoration: none; flex-shrink: 0; }
.nav-logo img { transition: width 0.35s ease; }
.nav-outer.is-scrolled .nav-logo img { width: 100px; }
.nav-center {
    position: absolute;
    left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 2px;
    pointer-events: all;
    background: rgba(255,255,255,0.88);
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 8px;
    padding: 6px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.nav-right { display: flex; align-items: center; gap: 8px; pointer-events: all; }
.nav-link {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 14px; font-weight: 500;
    color: #6b7280;
    padding: 13px 16px;
    border-radius: 6px;
    transition: color 0.15s, background 0.15s;
    text-decoration: none; white-space: nowrap;
    cursor: pointer; border: none; background: transparent; font-family: inherit;
}
.nav-link:hover { color: #0b130a; background: rgba(0,0,0,0.05); }
.nav-link.active { color: #0b130a; }

/* ── Logo swap (inner pages with dark hero only) ── */
.logo-light { display: none; }
.logo-dark  { display: block; }
/* When over a dark hero and nav is transparent */
.nav-outer.swap-logo:not(.is-scrolled) .logo-light { display: block; }
.nav-outer.swap-logo:not(.is-scrolled) .logo-dark  { display: none; }

/* ── Dropdown ── */
.nav-dropdown-wrap {
    position: relative;
}
.nav-dropdown {
    position: absolute;
    top: calc(100% + 10px);
    left: 50%; transform: translateX(-50%);
    min-width: 200px;
    background: #fff;
    border: 1px solid rgba(12,26,15,0.08);
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(28,56,41,0.12);
    padding: 6px;
    z-index: 200;
}
.nav-dropdown a {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    border-radius: 6px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 13.5px; font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: background 0.12s, color 0.12s;
}
.nav-dropdown a:hover { background: #f3f4f6; color: #0b130a; }
.nav-dropdown a span.dd-icon {
    width: 28px; height: 28px; flex-shrink: 0;
    border-radius: 5px; background: var(--shade);
    display: flex; align-items: center; justify-content: center;
}
.nav-dropdown-divider {
    height: 1px; background: #f3f4f6;
    margin: 4px 0;
}

.btn-nav-outline {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 14px; font-weight: 600;
    color: #1C3829;
    padding: 11px 20px;
    border-radius: 6px;
    border: 1px solid rgba(12,26,15,0.08);
    background: rgba(255,255,255,0.75);
    box-shadow: none; text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    white-space: nowrap; cursor: pointer;
}
.btn-nav-outline:hover { background: #fff; }
.nav-outer.is-scrolled .btn-nav-outline { background: rgba(255,255,255,0.9); }
.nav-outer.is-scrolled .nav-bar { padding-top: 8px; padding-bottom: 8px; }
.btn-nav-fill {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 14px; font-weight: 600;
    color: #062e14;
    padding: 11px 22px;
    border-radius: 6px; border: none;
    background: #6bc630;
    text-decoration: none;
    transition: background 0.15s;
    white-space: nowrap;
}
.btn-nav-fill:hover { background: #5aad28; }
.nav-mobile-dropdown {
    position: fixed;
    top: 84px; left: 20px; right: 20px; z-index: 99;
    background: #fff;
    border-radius: 8px;
    border: 1px solid rgba(12,26,15,0.08);
    box-shadow: 0 12px 36px rgba(28,56,41,0.12);
    padding: 16px;
    max-height: calc(100vh - 110px);
    overflow-y: auto;
}
.nav-mobile-btn {
    display: flex; align-items: center; justify-content: center;
    width: 44px; height: 44px;
    border-radius: 6px;
    background: #fff;
    border: 1px solid rgba(12,26,15,0.08);
    color: #0b130a;
    pointer-events: all; cursor: pointer;
}
.mobile-section-label {
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: #9ca3af;
    padding: 10px 12px 4px;
}
.nav-desktop { display: none; }
@media (min-width: 1024px) {
    .nav-desktop    { display: flex; }
    .nav-mobile-btn { display: none; }
}
@media (max-width: 767px) {
    .nav-outer { top: 10px !important; left: 8px !important; right: 8px !important; }
}
</style>

<script>
(function(){
    var threshold = 24;
    function onScroll(){
        var y = window.pageYOffset || document.documentElement.scrollTop;
        var nav = document.getElementById('site-nav');
        if(!nav) return;
        if(y > threshold){ nav.classList.add('is-scrolled'); }
        else { nav.classList.remove('is-scrolled'); }
    }
    document.addEventListener('DOMContentLoaded', function(){
        @if($frosted) document.getElementById('site-nav')?.classList.add('is-scrolled'); @endif
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    });
})();
</script>

<div id="site-nav" x-data="{ open: false, dd: '' }"
     class="nav-outer{{ $frosted ? ' is-scrolled swap-logo' : '' }}">
    <div class="nav-bar">

        {{-- Logo --}}
        <a href="/" class="nav-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_dark_bg.png" alt="Nhume" class="logo-light" style="width:140px;height:auto;">
            <img src="/images/nhume_logo_v4.png"      alt="Nhume" class="logo-dark"  style="width:140px;height:auto;">
        </a>

        {{-- Centered links (desktop) --}}
        <nav class="nav-center nav-desktop" @mouseleave="dd = ''">

            <a href="/#how-it-works"        class="nav-link">How it works</a>
            <a href="{{ route('journeys') }}" class="nav-link {{ request()->routeIs('journeys') ? 'active' : '' }}">Marketplace</a>
            <a href="/#transporters"        class="nav-link">For transporters</a>

            {{-- Company dropdown --}}
            <div class="nav-dropdown-wrap" @mouseenter="dd = 'company'">
                <button type="button" class="nav-link" :class="dd === 'company' ? 'active' : ''">
                    Company
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         style="transition:transform 0.2s" :style="dd==='company' ? 'transform:rotate(180deg)' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="dd === 'company'" x-cloak x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     class="nav-dropdown">
                    @foreach([
                        [route('about'),   'About Nhume',       'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        [route('blog'),    'Blog',              'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6'],
                        [route('careers'), 'Careers',           'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        [route('partner'), 'Become a partner',  'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ] as [$href, $label, $icon])
                    <a href="{{ $href }}">
                        <span class="dd-icon">
                            <svg width="14" height="14" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        </span>
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Support dropdown --}}
            <div class="nav-dropdown-wrap" @mouseenter="dd = 'support'">
                <button type="button" class="nav-link" :class="dd === 'support' ? 'active' : ''">
                    Support
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         style="transition:transform 0.2s" :style="dd==='support' ? 'transform:rotate(180deg)' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="dd === 'support'" x-cloak x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     class="nav-dropdown">
                    @foreach([
                        [route('safety'),  'Safety',            'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                        [route('contact'), 'Contact us',        'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        [route('report'),  'Report an issue',   'M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.98L13.74 4a2 2 0 00-3.48 0L3.25 16.02A2 2 0 005.07 19z'],
                    ] as [$href, $label, $icon])
                    <a href="{{ $href }}">
                        <span class="dd-icon">
                            <svg width="14" height="14" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        </span>
                        {{ $label }}
                    </a>
                    @endforeach
                    <div class="nav-dropdown-divider"></div>
                    <a href="/#faq">
                        <span class="dd-icon">
                            <svg width="14" height="14" fill="none" stroke="#6b7280" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        FAQ
                    </a>
                </div>
            </div>

        </nav>

        {{-- Right CTAs (desktop) --}}
        <div class="nav-right nav-desktop">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill">Dashboard</a>
            @else
                <button type="button" @click="trackOpen = true; $nextTick(() => $refs.trackInput?.focus())" class="btn-nav-outline">Track</button>
                <a href="{{ route('send') }}" class="btn-nav-fill">Book an errand
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button @click="open = !open; dd = ''" class="nav-mobile-btn" aria-label="Menu">
            <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" x-cloak width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div x-show="open" x-cloak class="nav-mobile-dropdown">

        <div class="mobile-section-label">Platform</div>
        <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:8px;">
            @foreach(['/#how-it-works' => 'How it works', route('journeys') => 'Marketplace', '/#transporters' => 'For transporters'] as $href => $label)
            <a href="{{ $href }}" @click="open=false"
               style="display:block;padding:10px 12px;font-size:14px;font-weight:500;color:#374151;border-radius:6px;text-decoration:none;transition:background 0.15s;"
               onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">{{ $label }}</a>
            @endforeach
        </nav>

        <div style="border-top:1px solid #f3f4f6;padding-top:8px;">
            <div class="mobile-section-label">Company</div>
            <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:8px;">
                @foreach([route('about') => 'About Nhume', route('blog') => 'Blog', route('careers') => 'Careers', route('partner') => 'Become a partner'] as $href => $label)
                <a href="{{ $href }}" @click="open=false"
                   style="display:block;padding:10px 12px;font-size:14px;font-weight:500;color:#374151;border-radius:6px;text-decoration:none;transition:background 0.15s;"
                   onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        <div style="border-top:1px solid #f3f4f6;padding-top:8px;">
            <div class="mobile-section-label">Support</div>
            <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:12px;">
                @foreach([route('safety') => 'Safety', route('contact') => 'Contact us', route('report') => 'Report an issue', '/#faq' => 'FAQ'] as $href => $label)
                <a href="{{ $href }}" @click="open=false"
                   style="display:block;padding:10px 12px;font-size:14px;font-weight:500;color:#374151;border-radius:6px;text-decoration:none;transition:background 0.15s;"
                   onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">{{ $label }}</a>
                @endforeach
            </nav>
        </div>

        <div style="border-top:1px solid #f3f4f6;padding-top:12px;display:flex;flex-direction:column;gap:8px;">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill" style="justify-content:center;">Dashboard</a>
            @else
                <a href="{{ route('send') }}" class="btn-nav-fill" style="justify-content:center;">Book an errand</a>
            @endauth
        </div>
    </div>
</div>
