<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $orderNumber ? 'Tracking '.$orderNumber : 'Track a parcel' }} — Nhume</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css'])
<style>
/* ── Tokens ── */
:root{
  --f:           'DM Sans',system-ui,sans-serif;
  --fh:          'Inter','DM Sans',system-ui,sans-serif;
  --font:        'DM Sans',system-ui,sans-serif;
  --head:        'Inter','DM Sans',system-ui,sans-serif;
  --forest:      #1C3829;
  --forest-d:    #0f2a1d;
  --forest-deep: #062e14;
  --green:       #6bc630;
  --green-dark:  #5aad28;
  --green-light: #edf8df;
  --green-mid:   #4a9a1f;
  --gl:          #edf8df;
  --gm:          #4a9a1f;
  --ink:         #111827;
  --ink2:        #374151;
  --text:        #0b130a;
  --text-2:      #3d4a3a;
  --muted:       #6b7280;
  --line:        #e5e7eb;
  --border:      #DDD9D0;
  --bg:          #f7f8fa;
  --shade:       #f7f6f3;
  --white:       #ffffff;
  --sh:          0 1px 3px rgba(0,0,0,.07),0 1px 2px rgba(0,0,0,.04);
  --sh2:         0 4px 16px rgba(0,0,0,.06),0 1px 3px rgba(0,0,0,.04);
  --btn-radius:  12px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--f);color:var(--ink);background:#fff;-webkit-font-smoothing:antialiased;}
[x-cloak]{display:none!important;}

@keyframes spin   {to{transform:rotate(360deg)}}
@keyframes fadeUp {from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
@keyframes ripple {0%{box-shadow:0 0 0 0 currentColor}70%{box-shadow:0 0 0 8px transparent}100%{box-shadow:0 0 0 0 transparent}}

/* ════════════════════════════════
   NAV  (floating pill — landing-identical)
════════════════════════════════ */
.nav-outer{
  position:fixed;
  top:clamp(24px,3vw,36px);
  left:clamp(16px,2vw,24px);
  right:clamp(16px,2vw,24px);
  z-index:100;
  background:transparent;
  border-radius:16px;
  border:1px solid transparent;
  transition:top .35s ease,left .35s ease,right .35s ease,
             border-radius .35s ease,background .35s ease,
             box-shadow .35s ease,border-color .35s ease;
  pointer-events:all;
}
.nav-outer.is-scrolled{
  top:0;left:0;right:0;border-radius:0;
  background:rgba(255,255,255,.95);
  backdrop-filter:blur(20px) saturate(180%);
  -webkit-backdrop-filter:blur(20px) saturate(180%);
  border-color:rgba(12,26,15,.07);
  box-shadow:0 2px 16px rgba(28,56,41,.07);
}
.nav-bar{
  max-width:1360px;margin:0 auto;
  display:flex;align-items:center;justify-content:space-between;
  position:relative;
  padding:clamp(12px,2vh,20px) clamp(20px,3vw,40px);
}
.nav-logo{display:flex;align-items:center;text-decoration:none;flex-shrink:0;}
.nav-center{
  position:absolute;left:50%;transform:translateX(-50%);
  display:flex;align-items:center;gap:2px;pointer-events:all;
  background:rgba(255,255,255,.88);border:1px solid rgba(0,0,0,.07);
  border-radius:14px;padding:6px;
  backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
}
.nav-right{display:flex;align-items:center;gap:8px;pointer-events:all;}
.nav-link{
  display:inline-flex;align-items:center;
  font-family:var(--font);font-size:14px;font-weight:500;
  color:var(--text-2);padding:10px 14px;border-radius:10px;
  transition:color .15s,background .15s;text-decoration:none;white-space:nowrap;
}
.nav-link:hover{color:var(--text);background:rgba(0,0,0,.05);}
.btn-nav-outline{
  display:inline-flex;align-items:center;gap:6px;cursor:pointer;
  font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest);
  padding:10px 18px;border-radius:14px;border:1px solid rgba(12,26,15,.08);
  background:rgba(255,255,255,.75);text-decoration:none;
  transition:background .15s,transform .15s;white-space:nowrap;
}
.btn-nav-outline:hover{background:#fff;transform:translateY(-1px);}
.nav-outer.is-scrolled .btn-nav-outline{background:rgba(255,255,255,.9);}
.btn-nav-fill{
  display:inline-flex;align-items:center;gap:7px;cursor:pointer;
  font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);
  padding:10px 20px;border-radius:14px;border:none;background:var(--green);
  box-shadow:0 4px 16px rgba(107,198,48,.28);text-decoration:none;
  transition:background .15s,transform .15s;white-space:nowrap;
}
.btn-nav-fill:hover{background:var(--green-dark);transform:translateY(-1px);}
.nav-mobile-dropdown{
  position:fixed;top:84px;left:20px;right:20px;z-index:99;
  background:#fff;border-radius:20px;border:1px solid rgba(12,26,15,.08);
  box-shadow:0 12px 36px rgba(28,56,41,.12);padding:16px;
}
.nav-mobile-btn{
  display:flex;align-items:center;justify-content:center;
  width:44px;height:44px;border-radius:9999px;cursor:pointer;
  background:#fff;border:1px solid rgba(12,26,15,.08);
  box-shadow:0 4px 16px rgba(28,56,41,.06);color:var(--text);pointer-events:all;
}
.nav-desktop{display:none;}
@media(min-width:1024px){
  .nav-desktop{display:flex;}
  .nav-mobile-btn{display:none;}
}

/* ════════════════════════════════
   TRACK MODAL BACKDROP
════════════════════════════════ */
.track-backdrop{
  position:fixed;inset:0;z-index:1000;
  background:rgba(11,19,10,.55);
  backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);
  display:flex;align-items:center;justify-content:center;padding:24px;
}

/* ════════════════════════════════
   FOOTER
════════════════════════════════ */
.site-footer{position:relative;}
.site-footer::before{
  content:"";position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,rgba(107,198,48,.5),transparent);
}
.footer-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1fr;gap:40px;}
.footer-social{
  width:34px;height:34px;border-radius:9px;
  background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.06);
  display:flex;align-items:center;justify-content:center;text-decoration:none;
  transition:background .18s,border-color .18s,transform .18s;
}
.footer-social svg{fill:rgba(255,255,255,.45);transition:fill .18s;}
.footer-social:hover{background:rgba(107,198,48,.16);border-color:rgba(107,198,48,.35);transform:translateY(-2px);}
.footer-social:hover svg{fill:var(--green);}
@media(max-width:860px){
  .footer-grid{grid-template-columns:1fr 1fr;gap:32px 24px;}
  .footer-grid>div:first-child{grid-column:1/-1;}
}
@media(max-width:520px){.footer-grid{grid-template-columns:1fr;}}

/* ════════════════════════════════
   PAGE SHELL
════════════════════════════════ */
.shell{
  height:100vh;
  padding-top:100px;
  display:flex;flex-direction:column;
  overflow:hidden;
}

/* ── STATUS BANNER ── */
.banner{
  flex-shrink:0;padding:26px 36px;display:flex;align-items:center;
  justify-content:space-between;gap:24px;border-bottom:1px solid var(--line);
  animation:fadeUp .25s ease both;
}
.banner.posted     {background:linear-gradient(110deg,#eef4ff 0%,#f9fbff 100%);}
.banner.assigned   {background:linear-gradient(110deg,#fffbeb 0%,#fffef7 100%);}
.banner.in_progress{background:linear-gradient(110deg,#f4f0ff 0%,#fbf9ff 100%);}
.banner.delivered  {background:linear-gradient(110deg,#edfaf2 0%,#f9fdf8 100%);}
.banner.cancelled  {background:linear-gradient(110deg,#fff1f0 0%,#fff9f9 100%);}
.banner.draft      {background:var(--bg);}

.banner-left{display:flex;align-items:center;gap:16px;}
.b-icon{width:48px;height:48px;border-radius:14px;flex-shrink:0;display:flex;align-items:center;justify-content:center;}
.banner.posted      .b-icon{background:#dbeafe;color:#2563eb;}
.banner.assigned    .b-icon{background:#fef3c7;color:#d97706;}
.banner.in_progress .b-icon{background:#ede9fe;color:#7c3aed;}
.banner.delivered   .b-icon{background:#d1fae5;color:#059669;}
.banner.cancelled   .b-icon{background:#fee2e2;color:#dc2626;}
.banner.draft       .b-icon{background:#f3f4f6;color:#6b7280;}

.b-status-label{font-family:var(--fh);font-size:20px;font-weight:700;color:var(--ink);letter-spacing:-.02em;margin-bottom:3px;display:flex;align-items:center;gap:9px;}
.b-pulse{display:inline-block;width:9px;height:9px;border-radius:50%;flex-shrink:0;}
.banner.posted      .b-pulse{background:#3b82f6;animation:ripple 1.8s ease-in-out infinite;color:#3b82f6;}
.banner.in_progress .b-pulse{background:#8b5cf6;animation:ripple 1.8s ease-in-out infinite;color:#8b5cf6;}
.b-desc{font-size:13px;color:var(--muted);line-height:1.5;max-width:380px;}
.banner-right{text-align:right;flex-shrink:0;}
.b-num-lbl{font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--muted);margin-bottom:4px;}
.b-num{font-family:var(--fh);font-size:21px;font-weight:700;color:var(--forest);letter-spacing:.03em;margin-bottom:6px;}
.b-meta{display:flex;align-items:center;justify-content:flex-end;gap:10px;}
.b-placed{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:4px;}
.b-copy{
  display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:600;color:var(--muted);
  background:var(--white);border:1px solid var(--line);border-radius:9999px;padding:3px 11px;cursor:pointer;
  transition:border-color .15s,color .15s;
}
.b-copy:hover{border-color:#9ca3af;color:var(--ink);}

/* ── TWO-COLUMN CONTENT ── */
.content{flex:1;min-height:0;display:grid;grid-template-columns:1fr 1fr;overflow:hidden;}

.col-l{display:flex;flex-direction:column;overflow:hidden;border-right:1px solid var(--line);background:var(--white);}
.col-l-inner{flex:1;overflow-y:auto;padding:32px 36px;}
.tl-head{font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--muted);margin-bottom:28px;}

.tl{display:flex;flex-direction:column;}
.tl-step{display:flex;gap:0;position:relative;}
.tl-spine{display:flex;flex-direction:column;align-items:center;flex-shrink:0;width:48px;}
.tl-dot{width:36px;height:36px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;transition:transform .2s;}
.tl-dot.done{background:var(--green);box-shadow:0 0 0 4px rgba(107,198,48,.12);}
.tl-dot.cur {background:var(--forest);box-shadow:0 0 0 5px rgba(28,56,41,.1);}
.tl-dot.fut {background:var(--white);border:2px solid var(--line);}
.tl-dot.canc{background:#fee2e2;border:2px solid #fca5a5;}
.tl-line{width:2px;flex:1;min-height:20px;margin:4px 0;background:var(--line);border-radius:9999px;}
.tl-line.done{background:var(--green);}
.tl-body{flex:1;padding:8px 0 32px 8px;min-width:0;}
.tl-step:last-child .tl-body{padding-bottom:0;}
.tl-cur-wrap{background:var(--bg);border:1px solid var(--line);border-radius:12px;padding:16px 18px;margin-left:2px;}
.tl-step-name{font-family:var(--fh);font-size:14.5px;font-weight:700;color:var(--ink);line-height:1.3;margin-bottom:5px;}
.tl-step-name.fut{color:#9ca3af;font-weight:500;font-family:var(--f);}
.tl-step-name.canc{color:#b91c1c;}
.tl-step-desc{font-size:12.5px;color:var(--muted);line-height:1.55;}

.col-r{display:flex;flex-direction:column;overflow:hidden;background:var(--bg);}
.col-r-inner{flex:1;overflow-y:auto;padding:20px 18px;}
.col-r-stack{display:flex;flex-direction:column;gap:12px;}

.card{background:var(--white);border:1px solid var(--line);border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);animation:fadeUp .3s ease both;}
.card:nth-child(2){animation-delay:.04s;}
.card:nth-child(3){animation-delay:.08s;}

.sec{padding:20px 24px;border-bottom:1px solid var(--line);}
.sec:last-child{border-bottom:none;}
.sec-lbl{font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--muted);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.rows{display:flex;flex-direction:column;gap:11px;}
.row{display:flex;align-items:baseline;}
.rk{width:88px;flex-shrink:0;font-size:12px;color:var(--muted);font-weight:500;}
.rv{flex:1;font-size:13.5px;font-weight:500;color:var(--ink);line-height:1.45;}
.rv.e{color:#d1d5db;font-weight:400;}
.ftag{display:inline-flex;align-items:center;gap:3px;font-size:11px;font-weight:700;background:#fff3e0;color:#c2410c;padding:2px 8px;border-radius:9999px;}

.price-card{background:var(--white);border:1px solid var(--line);border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);animation:fadeUp .35s ease both;}
.price-row{padding:20px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--line);}
.price-lbl{font-size:13px;color:var(--muted);}
.price-val{font-family:var(--fh);font-size:22px;font-weight:700;color:var(--forest);}
.actions{padding:16px 24px;display:flex;flex-direction:column;gap:10px;}
.btn-p{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;background:var(--forest);color:#fff;border:none;border-radius:11px;font-family:var(--f);font-size:14px;font-weight:700;padding:13px;cursor:pointer;text-decoration:none;transition:background .18s;}
.btn-p:hover{background:var(--forest-d);}
.btn-g{display:flex;align-items:center;justify-content:center;width:100%;background:none;color:var(--muted);border:1.5px solid var(--line);border-radius:11px;font-family:var(--f);font-size:13px;font-weight:500;padding:11px;cursor:pointer;text-decoration:none;transition:border-color .15s,color .15s;}
.btn-g:hover{border-color:#9ca3af;color:var(--ink);}

/* ── LANDING (no order) ── */
.landing{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:28px;padding:40px 24px;}
.landing-icon{width:60px;height:60px;border-radius:16px;background:var(--forest);display:flex;align-items:center;justify-content:center;}
.l-h1{font-family:var(--fh);font-size:28px;font-weight:700;color:var(--forest);letter-spacing:-.02em;margin-bottom:6px;text-align:center;}
.l-sub{font-size:14px;color:var(--muted);text-align:center;}
.l-form{width:100%;max-width:420px;display:flex;align-items:center;background:var(--white);border:1.5px solid var(--line);border-radius:12px;padding:7px 7px 7px 18px;box-shadow:var(--sh2);transition:border-color .15s,box-shadow .15s;}
.l-form:focus-within{border-color:var(--forest);box-shadow:0 4px 20px rgba(28,56,41,.1);}
.l-form input{flex:1;border:none;background:transparent;outline:none;font-family:var(--f);font-size:14px;font-weight:500;color:var(--ink);letter-spacing:.02em;}
.l-form input::placeholder{color:#9ca3af;font-weight:400;}
.l-form button{flex-shrink:0;height:40px;padding:0 20px;background:var(--forest);color:#fff;border:none;border-radius:8px;font-family:var(--f);font-size:13.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:background .18s;}
.l-form button:hover{background:var(--forest-d);}
.l-hint{font-size:12px;color:#9ca3af;}
.l-hint strong{color:var(--muted);font-weight:600;}
.btn-pi{display:inline-flex;align-items:center;gap:7px;background:var(--forest);color:#fff;font-family:var(--f);font-size:14px;font-weight:700;padding:13px 28px;border:none;border-radius:10px;cursor:pointer;text-decoration:none;transition:background .18s;}
.btn-pi:hover{background:var(--forest-d);}

/* ── NOT FOUND ── */
.nf{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;}
.nf-card{background:var(--white);border:1px solid var(--line);border-radius:16px;padding:44px 32px;text-align:center;max-width:400px;width:100%;box-shadow:var(--sh2);}
.nf-icon{width:48px;height:48px;border-radius:50%;background:#fef3c7;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;}
.nf-h{font-family:var(--fh);font-size:19px;font-weight:700;color:var(--forest);margin-bottom:8px;}
.nf-p{font-size:13.5px;color:var(--muted);line-height:1.6;margin-bottom:22px;}
.nf-p code{font-family:var(--fh);font-size:12.5px;font-weight:700;color:var(--forest);background:var(--bg);padding:2px 7px;border-radius:5px;}

/* ── Mobile ── */
@media(max-width:768px){
  .shell{height:auto;min-height:100vh;}
  .banner{flex-direction:column;align-items:flex-start;gap:12px;}
  .banner-right{text-align:left;}
  .b-meta{justify-content:flex-start;}
  .content{grid-template-columns:1fr;height:auto;}
  .col-l{border-right:none;border-bottom:1px solid var(--line);}
  .col-l-inner,.col-r-inner{overflow:visible;max-height:none;}
  .nav-outer{top:10px;left:8px;right:8px;}
}
</style>
</head>

<body x-data="{ trackOpen: false, trackNum: '' }" @keydown.escape.window="trackOpen = false">

{{-- ═══════════ FLOATING NAV ═══════════ --}}
<div x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset || document.documentElement.scrollTop) > 24"
     :class="scrolled ? 'is-scrolled' : ''"
     class="nav-outer">
    <div class="nav-bar">

        <a href="/" class="nav-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_v2.png" alt="Nhume" style="height:44px;width:auto;">
        </a>

        <nav class="nav-center nav-desktop">
            <a href="/#how-it-works" class="nav-link">How it works</a>
            <a href="/journeys"       class="nav-link">Journeys</a>
            <a href="/#transporters"  class="nav-link">For transporters</a>
            <a href="/#faq"           class="nav-link">FAQ</a>
        </nav>

        <div class="nav-right nav-desktop">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Sign in</a>
                <button type="button" @click="trackOpen = true; $nextTick(() => $refs.trackInput?.focus())" class="btn-nav-outline">Track</button>
                <a href="{{ route('send') }}" class="btn-nav-fill">
                    Send Parcel
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endauth
        </div>

        <button @click="open = !open" class="nav-mobile-btn" aria-label="Menu">
            <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" x-cloak width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div x-show="open" x-cloak class="nav-mobile-dropdown">
        <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:12px;">
            @foreach(['/#how-it-works' => 'How it works', '/journeys' => 'Journeys', '/#transporters' => 'For transporters', '/#faq' => 'FAQ'] as $href => $label)
            <a href="{{ $href }}" @click="open=false"
               style="display:block;padding:10px 12px;font-size:14px;font-weight:500;color:#374151;border-radius:10px;text-decoration:none;transition:background 0.15s;"
               onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">{{ $label }}</a>
            @endforeach
        </nav>
        <div style="border-top:1px solid #f3f4f6;padding-top:12px;display:flex;flex-direction:column;gap:8px;">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill" style="justify-content:center;">Dashboard</a>
            @else
                <a href="{{ route('login') }}"    class="btn-nav-outline" style="justify-content:center;">Sign in</a>
                <a href="{{ route('send') }}"     class="btn-nav-fill"    style="justify-content:center;">Send Parcel</a>
            @endauth
        </div>
    </div>
</div>

{{-- ═══════════ SHELL ═══════════ --}}
<div class="shell">

@if(!$orderNumber)
{{-- ── LANDING ── --}}
<div class="landing" x-data="{ open:false, num:'' }" x-init="$watch('open', v => v && $nextTick(() => $refs.ti?.focus()))">
    <div class="landing-icon"><svg width="26" height="26" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg></div>
    <div style="text-align:center"><h1 class="l-h1">Track your parcel</h1><p class="l-sub">Real-time updates on every delivery.</p></div>
    <button type="button" class="btn-pi" x-show="!open" @click="open=true">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
        Track a parcel
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
         style="width:100%;max-width:420px;display:flex;flex-direction:column;align-items:center;gap:10px;">
        <form class="l-form" style="width:100%" @submit.prevent="if(num.trim()) window.location='/track/'+num.trim().toUpperCase()">
            <input x-model="num" x-ref="ti" type="text" placeholder="e.g. NHM-20260812-XXXX" autocomplete="off" spellcheck="false">
            <button type="submit"><svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>Track</button>
        </form>
        <p class="l-hint">Order numbers look like <strong>NHM-20260812-XXXX</strong></p>
    </div>
</div>

@elseif(!$task)
{{-- ── NOT FOUND ── --}}
<div class="nf">
    <div class="nf-card">
        <div class="nf-icon"><svg width="20" height="20" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.98L13.74 4a2 2 0 00-3.48 0L3.25 16.02A2 2 0 005.07 19z"/></svg></div>
        <h2 class="nf-h">Order not found</h2>
        <p class="nf-p">No order matches <code>{{ $orderNumber }}</code>.<br>Check the number and try the search bar above.</p>
        <a href="/send" class="btn-pi" style="display:inline-flex;">Send a parcel</a>
    </div>
</div>

@else
@php
    $status   = $task->status;
    $sv       = $status->value;
    $isCan    = $status === \App\Enums\TaskStatus::Cancelled;
    $timeline = \App\Enums\TaskStatus::timeline();
    $ci       = array_search($status, $timeline);
    $icons = [
        'posted'      => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'assigned'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'in_progress' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z',
        'delivered'   => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'cancelled'   => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'draft'       => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
    ];
    $iconPath = $icons[$sv] ?? $icons['draft'];
@endphp

{{-- STATUS BANNER --}}
<div class="banner {{ $sv }}">
    <div class="banner-left">
        <div class="b-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/></svg>
        </div>
        <div>
            <div class="b-status-label">
                @if(in_array($sv, ['posted','in_progress']))<span class="b-pulse"></span>@endif
                {{ $status->label() }}
            </div>
            <p class="b-desc">{{ $status->description() }}</p>
        </div>
    </div>
    <div class="banner-right">
        <p class="b-num-lbl">Order number</p>
        <p class="b-num">{{ $task->order_number }}</p>
        <div class="b-meta">
            <span class="b-placed">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $task->created_at->format('D d M Y, H:i') }}
            </span>
            <button type="button" class="b-copy" x-data
                    x-on:click="navigator.clipboard.writeText('{{ $task->order_number }}').then(()=>{ $el.textContent='Copied!'; setTimeout(()=>$el.textContent='Copy',1500) })">
                Copy
            </button>
        </div>
    </div>
</div>

{{-- TWO COLUMNS --}}
<div class="content">
    <div class="col-l">
        <div class="col-l-inner">
            <p class="tl-head">Delivery progress</p>
            <div class="tl">
                @if($isCan)
                <div class="tl-step">
                    <div class="tl-spine"><div class="tl-dot canc"><svg width="12" height="12" fill="none" stroke="#dc2626" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg></div></div>
                    <div class="tl-body"><div class="tl-cur-wrap"><p class="tl-step-name canc">Order cancelled</p><p class="tl-step-desc">{{ $status->description() }}</p></div></div>
                </div>
                @else
                @foreach($timeline as $i => $step)
                @php
                    $si   = array_search($step, $timeline);
                    $done = $ci !== false && $ci > $si;
                    $cur  = $status === $step;
                    $fut  = $ci === false || $ci < $si;
                    $last = $i === count($timeline) - 1;
                @endphp
                <div class="tl-step">
                    <div class="tl-spine">
                        <div class="tl-dot {{ $done ? 'done' : ($cur ? 'cur' : 'fut') }}">
                            @if($done)<svg width="13" height="13" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @elseif($cur)<svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" fill="white"/></svg>
                            @else<svg width="8" height="8" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" fill="#d1d5db"/></svg>
                            @endif
                        </div>
                        @if(!$last)<div class="tl-line {{ $done ? 'done' : '' }}"></div>@endif
                    </div>
                    <div class="tl-body">
                        @if($cur)
                        <div class="tl-cur-wrap"><p class="tl-step-name">{{ $step->label() }}</p><p class="tl-step-desc">{{ $step->description() }}</p></div>
                        @elseif($done)
                        <div style="padding:6px 0 0;"><p class="tl-step-name">{{ $step->label() }}</p><p class="tl-step-desc">{{ $step->description() }}</p></div>
                        @else
                        <div style="padding:6px 0 0;"><p class="tl-step-name fut">{{ $step->label() }}</p></div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="col-r">
        <div class="col-r-inner">
            <div class="col-r-stack">
                <div class="card">
                    <div class="sec">
                        <p class="sec-lbl"><svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>Journey</p>
                        <div class="rows">
                            <div class="row"><span class="rk">Pickup</span><span class="rv">{{ $task->pickup_type === \App\Enums\PickupType::WalkIn ? 'Drop at shop' : 'Biker collection' }}</span></div>
                            @if($task->pickup_address)<div class="row"><span class="rk">From</span><span class="rv">{{ $task->pickup_address }}</span></div>@endif
                            <div class="row"><span class="rk">To</span><span class="rv {{ !$task->dropoff_address ? 'e' : '' }}">{{ $task->dropoff_address ?: '—' }}</span></div>
                            <div class="row"><span class="rk">When</span><span class="rv">{{ $task->scheduled_at ? $task->scheduled_at->format('D d M Y, H:i') : 'As soon as possible' }}</span></div>
                        </div>
                    </div>
                    <div class="sec">
                        <p class="sec-lbl"><svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg>Parcel</p>
                        <div class="rows">
                            <div class="row"><span class="rk">Category</span><span class="rv {{ !$task->package_category ? 'e' : '' }}">{{ $task->package_category?->label() ?? '—' }}</span></div>
                            @if($task->weight_kg)<div class="row"><span class="rk">Weight</span><span class="rv">{{ $task->weight_kg }} kg</span></div>@endif
                            @if($task->is_fragile)<div class="row"><span class="rk">Handling</span><span class="rv"><span class="ftag"><svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.98L13.74 4a2 2 0 00-3.48 0L3.25 16.02A2 2 0 005.07 19z"/></svg>Fragile</span></span></div>@endif
                            @if($task->notes)<div class="row"><span class="rk">Notes</span><span class="rv">{{ $task->notes }}</span></div>@endif
                        </div>
                    </div>
                    <div class="sec">
                        <p class="sec-lbl"><svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>Recipient</p>
                        <div class="rows">
                            <div class="row"><span class="rk">Name</span><span class="rv {{ !$task->recipient_name ? 'e' : '' }}">{{ $task->recipient_name ?: '—' }}</span></div>
                            <div class="row"><span class="rk">Phone</span><span class="rv {{ !$task->recipient_phone ? 'e' : '' }}">{{ $task->recipient_phone ?: '—' }}</span></div>
                        </div>
                    </div>
                </div>
                <div class="price-card">
                    <div class="price-row">
                        <span class="price-lbl">Estimated total</span>
                        <span class="price-val">${{ number_format($task->price_estimate ?? 0, 2) }}</span>
                    </div>
                    <div class="actions">
                        <a href="/send" class="btn-p"><svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>Send another parcel</a>
                        <a href="/" class="btn-g">Back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

</div>{{-- /shell --}}

{{-- ═══════════ FULL FOOTER ═══════════ --}}
<footer class="site-footer" style="background:#081510;overflow:hidden;position:relative;">
    <div style="max-width:1200px;margin:0 auto;padding:60px 24px 44px;position:relative;z-index:1;">
        <div class="footer-grid" style="padding-bottom:44px;border-bottom:1px solid rgba(255,255,255,0.055);margin-bottom:32px;">
            <div>
                <div style="margin-bottom:14px;">
                    <img src="/images/nhume_logo_v2.png" alt="Nhume" style="height:46px;width:auto;filter:brightness(0) invert(1);">
                </div>
                <p style="font-family:var(--font);font-size:13.5px;color:rgba(255,255,255,0.28);line-height:1.7;margin-bottom:22px;max-width:210px">Moving parcels with drivers already in motion.</p>
                <div style="display:flex;gap:8px;">
                    @foreach (['M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z', 'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'] as $p)
                    <a href="#" class="footer-social"><svg width="15" height="15" viewBox="0 0 24 24"><path d="{{ $p }}"/></svg></a>
                    @endforeach
                </div>
            </div>
            @foreach ([
                ['Platform', ['How it works' => '/#how-it-works', 'Get Started' => route('register'), 'Browse journeys' => '/journeys', 'For transporters' => '/#transporters', 'Pricing' => '#']],
                ['Support',  ['FAQ' => '/#faq', 'Contact us' => '/contact', 'Track a parcel' => route('track'), 'Report an issue' => '#', 'Safety' => '#']],
                ['Company',  ['About Nhume' => '#', 'Blog' => '#', 'Careers' => '#', 'Become a partner' => '#', 'Press' => '#']],
            ] as [$heading, $links])
            <div>
                <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.22);margin-bottom:18px;">{{ $heading }}</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:11px;">
                    @foreach ($links as $label => $href)
                    <li><a href="{{ $href }}" style="font-family:var(--font);font-size:13.5px;color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.72)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.18);margin:0">© {{ date('Y') }} Nhume Technologies. All rights reserved. &nbsp;·&nbsp; <span style="color:rgba(255,255,255,0.28)">A <a href="#" style="color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">ShiftTech</a> product</span></p>
            <div style="display:flex;gap:24px;">
                @foreach (['Terms of Service', 'Privacy Policy', 'Cookie Policy'] as $l)
                <a href="#" style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.16);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.45)'" onmouseout="this.style.color='rgba(255,255,255,0.16)'">{{ $l }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div style="overflow:hidden;line-height:0.78;pointer-events:none;user-select:none">
        <p style="font-family:var(--head);font-size:clamp(100px,17vw,220px);font-weight:800;letter-spacing:-0.03em;margin:0;padding:0 16px;white-space:nowrap;text-align:center;background:linear-gradient(180deg,rgba(255,255,255,0.05) 0%,rgba(255,255,255,0.01) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">NHUME</p>
    </div>
</footer>

{{-- ═══════════ TRACK MODAL ═══════════ --}}
<div x-show="trackOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click.self="trackOpen = false"
     class="track-backdrop">

    <div x-show="trackOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="background:#fff;border-radius:22px;width:100%;max-width:460px;box-shadow:0 32px 80px rgba(11,19,10,0.25),0 8px 24px rgba(11,19,10,0.12);overflow:hidden;">

        <div style="padding:28px 28px 0;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
            <div>
                <div style="width:44px;height:44px;border-radius:12px;background:#edf8df;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                    <svg width="20" height="20" fill="none" stroke="#4a9a1f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h2 style="font-family:'Inter','DM Sans',sans-serif;font-size:20px;font-weight:700;color:#1C3829;letter-spacing:-0.02em;margin:0 0 6px;">Track your parcel</h2>
                <p style="font-size:14px;color:#6b7280;margin:0;">Enter your order number to see live delivery updates.</p>
            </div>
            <button type="button" @click="trackOpen = false"
                    style="flex-shrink:0;width:32px;height:32px;border-radius:50%;border:none;background:#f3f4f6;color:#6b7280;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s;"
                    onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form style="padding:20px 28px 28px;"
              x-data="{ loading: false }"
              @submit.prevent="if(trackNum.trim()){ loading = true; window.location='/track/'+trackNum.trim().toUpperCase() }">
            <input x-model="trackNum"
                   x-ref="trackInput"
                   type="text"
                   placeholder="e.g. NHM-20260812-XXXX"
                   autocomplete="off"
                   spellcheck="false"
                   :disabled="loading"
                   style="width:100%;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:500;color:#0b130a;background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:12px;padding:14px 16px;outline:none;letter-spacing:0.02em;transition:border-color 0.15s,box-shadow 0.15s,background 0.15s;"
                   @focus="$el.style.borderColor='#1C3829';$el.style.background='#fff';$el.style.boxShadow='0 0 0 3px rgba(28,56,41,0.08)'"
                   @blur="$el.style.borderColor='#e5e7eb';$el.style.background='#f9fafb';$el.style.boxShadow='none'">
            <p style="font-size:12px;color:#9ca3af;margin:8px 0 20px;">Order numbers look like <strong style="color:#6b7280;font-weight:600;">NHM-20260812-XXXX</strong></p>
            <button type="submit"
                    :disabled="loading"
                    :style="loading ? 'opacity:0.8;cursor:not-allowed;' : ''"
                    style="width:100%;background:#1C3829;color:#fff;font-family:'DM Sans',sans-serif;font-size:14.5px;font-weight:700;padding:14px;border:none;border-radius:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background 0.18s,opacity 0.18s;">
                <span x-show="!loading" style="display:inline-flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    Track parcel
                </span>
                <span x-show="loading" style="display:inline-flex;align-items:center;gap:9px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="animation:spin .8s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Looking up order…
                </span>
            </button>
        </form>
    </div>
</div>

@vite(['resources/js/app.js'])
</body>
</html>
