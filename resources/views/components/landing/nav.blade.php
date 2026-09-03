@props(['frosted' => false])
<style>
/* ═══════════════════════════════════════════
   NAV — transparent on hero, solid on scroll
═══════════════════════════════════════════ */
.nav-outer {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    background: transparent;
    border-bottom: 1px solid transparent;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
.nav-outer.is-scrolled {
    background: #fff;
    border-bottom: 1px solid #e5e9e3;
    box-shadow: 0 2px 20px rgba(28,56,41,0.08);
}
.nav-bar {
    max-width: 1360px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    /* Airy at rest — sits lower on the hero */
    padding: clamp(22px,3.4vh,40px) clamp(20px,3vw,40px) clamp(18px,2.4vh,26px);
    transition: padding 0.3s ease;
}
/* Compact once stuck */
.nav-outer.is-scrolled .nav-bar {
    padding-top: 12px;
    padding-bottom: 12px;
}
.nav-logo { display: flex; align-items: center; text-decoration: none; flex-shrink: 0; }

/* ── Center links — flex flow, not absolute (responsive) ── */
.nav-center {
    display: flex; align-items: center; gap: 2px;
    margin: 0 auto;
    background: none; border: none; padding: 0;
}
.nav-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

/* ── Nav links — light on dark hero, dark when scrolled ── */
.nav-link {
    display: inline-flex; align-items: center; gap: 4px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 15.5px; font-weight: 500;
    color: rgba(255,255,255,0.82);
    padding: 9px 15px;
    border-radius: 6px;
    transition: color 0.2s, background 0.2s;
    text-decoration: none; white-space: nowrap;
    cursor: pointer; border: none; background: transparent;
}
.nav-link:hover { color: #fff; }
.nav-link.active { color: #fff; }
/* Light hero (welcome page — no dark-hero class) */
.nav-outer:not(.dark-hero) .nav-link { color: #374151; }
.nav-outer:not(.dark-hero) .nav-link:hover { color: #1C3829; }
/* Always dark when scrolled */
.nav-outer.is-scrolled .nav-link { color: #374151; }
.nav-outer.is-scrolled .nav-link:hover { color: #1C3829; }
.nav-outer.is-scrolled .nav-link.active { color: #1C3829; }

/* Logo: light variant on dark hero, dark variant always scrolled or light hero */
.logo-light { display: none; }
.logo-dark  { display: block; }
.nav-outer.dark-hero:not(.is-scrolled) .logo-light { display: block; }
.nav-outer.dark-hero:not(.is-scrolled) .logo-dark  { display: none; }

/* ── Login link ── */
.nav-login {
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 15.5px; font-weight: 500;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    padding: 9px 14px;
    border-radius: 6px;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
}
.nav-login:hover { color: #fff; }
.nav-outer:not(.dark-hero) .nav-login { color: #374151; }
.nav-outer:not(.dark-hero) .nav-login:hover { color: #1C3829; }
.nav-outer.is-scrolled .nav-login { color: #374151; }
.nav-outer.is-scrolled .nav-login:hover { color: #1C3829; }

/* ── Pill buttons — white outline on dark hero, green outline scrolled ── */
.btn-nav-outline {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 16px; font-weight: 600;
    color: #fff;
    padding: 10px 24px;
    border-radius: 9999px;
    border: 1.5px solid rgba(255,255,255,0.6);
    background: transparent;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s, background 0.2s;
    white-space: nowrap; cursor: pointer;
}
.btn-nav-outline:hover { border-color: #fff; background: rgba(255,255,255,0.08); }
.nav-outer:not(.dark-hero) .btn-nav-outline { color: #1C3829; border-color: #6bc630; }
.nav-outer:not(.dark-hero) .btn-nav-outline:hover { background: #f0fde4; }
.nav-outer.is-scrolled .btn-nav-outline { color: #1C3829; border-color: #6bc630; }
.nav-outer.is-scrolled .btn-nav-outline:hover { background: #f0fde4; }

.btn-nav-fill {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 16px; font-weight: 600;
    color: #fff;
    padding: 10px 26px;
    border-radius: 9999px; border: none;
    background: #6bc630;
    text-decoration: none;
    transition: background 0.15s;
    white-space: nowrap;
}
.btn-nav-fill:hover { background: #5aad28; }

/* ── Dropdown ── */
.nav-dropdown-wrap { position: relative; }
.nav-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    left: 50%; transform: translateX(-50%);
    min-width: 200px;
    background: #fff;
    border: 1px solid #e5e9e3;
    border-radius: 10px;
    box-shadow: 0 8px 32px rgba(28,56,41,0.12);
    padding: 6px;
    z-index: 200;
}
.nav-dropdown a {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 6px;
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 13.5px; font-weight: 500;
    color: #374151; text-decoration: none;
    transition: background 0.12s, color 0.12s;
}
.nav-dropdown a:hover { background: #f4f6f3; color: #1C3829; }
.nav-dropdown a span.dd-icon {
    width: 28px; height: 28px; flex-shrink: 0;
    border-radius: 5px; background: #f4f6f3;
    display: flex; align-items: center; justify-content: center;
}
.nav-dropdown-divider { height: 1px; background: #f0f2ef; margin: 4px 0; }

/* ── Mobile ── */
.nav-mobile-dropdown {
    position: fixed;
    top: 68px; left: 0; right: 0; z-index: 99;
    background: #fff;
    border-top: 1px solid #f0f2ef;
    box-shadow: 0 12px 36px rgba(28,56,41,0.1);
    padding: 12px 20px 20px;
    max-height: calc(100vh - 68px);
    overflow-y: auto;
}
.nav-mobile-btn {
    display: flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 8px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    color: #fff; cursor: pointer;
    transition: background 0.15s;
}
.nav-outer:not(.dark-hero) .nav-mobile-btn,
.nav-outer.is-scrolled .nav-mobile-btn {
    background: #f4f6f3;
    border: none;
    color: #1C3829;
}
.mobile-section-label {
    font-family: 'DM Sans', system-ui, sans-serif;
    font-size: 10px; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: #9ca3af; padding: 10px 4px 4px;
}
.nav-desktop { display: none; }
@media (min-width: 1024px) {
    .nav-desktop    { display: flex; }
    .nav-mobile-btn { display: none; }
}
/* Tighten spacing on smaller desktops so nothing cramps */
@media (min-width: 1024px) and (max-width: 1200px) {
    .nav-center { gap: 0; }
    .nav-link   { padding: 9px 11px; font-size: 15px; }
    .nav-right  { gap: 6px; }
    .btn-nav-outline, .btn-nav-fill { font-size: 15px; padding-left: 18px; padding-right: 18px; }
}
/* Keep the bar compact on mobile so the dropdown stays aligned */
@media (max-width: 1023px) {
    .nav-bar { padding-top: 14px; padding-bottom: 14px; }
    .nav-outer.is-scrolled .nav-bar { padding-top: 12px; padding-bottom: 12px; }
}
</style>

<script>
(function(){
    function onScroll(){
        var nav = document.getElementById('site-nav');
        if(!nav) return;
        if(window.pageYOffset > 10){ nav.classList.add('is-scrolled'); }
        else { nav.classList.remove('is-scrolled'); }
    }
    document.addEventListener('DOMContentLoaded', function(){
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    });
})();
</script>

<div id="site-nav" x-data="{ open: false, dd: '' }"
     class="nav-outer{{ $frosted ? ' dark-hero' : '' }}">
    <div class="nav-bar">

        {{-- Logo --}}
        <a href="/" class="nav-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_dark_bg.png" alt="Nhume" class="logo-light" style="width:150px;height:auto;">
            <img src="/images/nhume_logo_v4.png"      alt="Nhume" class="logo-dark"  style="width:150px;height:auto;">
        </a>

        {{-- Centered links (desktop) --}}
        <nav class="nav-center nav-desktop" @mouseleave="dd = ''">

            <a href="/#how-it-works"        class="nav-link">How it works</a>
            <a href="{{ route('journeys') }}" class="nav-link {{ request()->routeIs('journeys') ? 'active' : '' }}">Marketplace</a>
            <a href="/#transporters"        class="nav-link">For transporters</a>

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
                <a href="{{ route('login') }}" class="nav-login">Login</a>
                <button type="button" @click="trackOpen = true; $nextTick(() => $refs.trackInput?.focus())" class="btn-nav-outline">Track my parcel</button>
                <a href="{{ route('send') }}" class="btn-nav-fill">Get started</a>
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
