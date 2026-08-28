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
    display: inline-flex; align-items: center;
    font-size: 14px; font-weight: 500;
    color: #6b7280;
    padding: 13px 16px;
    border-radius: 6px;
    transition: color 0.15s, background 0.15s;
    text-decoration: none; white-space: nowrap;
}
.nav-link:hover { color: #0b130a; background: rgba(0,0,0,0.05); }
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

<div id="site-nav" x-data="{ open: false }"
     class="nav-outer{{ $frosted ? ' is-scrolled' : '' }}">
    <div class="nav-bar">

        {{-- Logo --}}
        <a href="/" class="nav-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_v4.png" alt="Nhume" style="width:140px;height:auto;">
        </a>

        {{-- Centered links (desktop) --}}
        <nav class="nav-center nav-desktop">
            <a href="/#how-it-works" class="nav-link">How it works</a>
            <a href="/#routes"     class="nav-link">Routes</a>
            <a href="/#transporters" class="nav-link">For transporters</a>
            <a href="/#faq"          class="nav-link">FAQ</a>
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
        <button @click="open = !open" class="nav-mobile-btn" aria-label="Menu">
            <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" x-cloak width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile dropdown --}}
    <div x-show="open" x-cloak class="nav-mobile-dropdown">
        <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:12px;">
            @foreach(['/#how-it-works' => 'How it works', '/#routes' => 'Routes', '/#transporters' => 'For transporters', '/#faq' => 'FAQ'] as $href => $label)
            <a href="{{ $href }}" @click="open=false"
               style="display:block;padding:10px 12px;font-size:14px;font-weight:500;color:#374151;border-radius:6px;text-decoration:none;transition:background 0.15s;"
               onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">{{ $label }}</a>
            @endforeach
        </nav>
        <div style="border-top:1px solid #f3f4f6;padding-top:12px;display:flex;flex-direction:column;gap:8px;">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill" style="justify-content:center;">Dashboard</a>
            @else
                <a href="{{ route('send') }}"     class="btn-nav-fill"    style="justify-content:center;">Book an errand</a>
            @endauth
        </div>
    </div>
</div>
