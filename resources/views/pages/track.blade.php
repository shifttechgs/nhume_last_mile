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
:root {
    --f:           'DM Sans', system-ui, sans-serif;
    --fh:          'Inter', 'DM Sans', system-ui, sans-serif;
    --font:        'DM Sans', system-ui, sans-serif;
    --head:        'Inter', 'DM Sans', system-ui, sans-serif;
    --forest:      #1C3829;
    --forest-d:    #0f2a1d;
    --forest-deep: #062e14;
    --green:       #6bc630;
    --green-dark:  #5aad28;
    --green-light: #edf8df;
    --green-mid:   #4a9a1f;
    --ink:         #111827;
    --text:        #0b130a;
    --text-2:      #6b7280;
    --muted:       #6b7280;
    --line:        #e5e7eb;
    --border:      #e5e7eb;
    --bg:          #f9fafb;
    --shade:       #f9fafb;
    --white:       #ffffff;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--f); color: var(--ink); background: var(--shade); -webkit-font-smoothing: antialiased; }
[x-cloak] { display: none !important; }

@keyframes spin    { to { transform: rotate(360deg); } }
@keyframes fadeUp  { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
@keyframes ripple  { 0% { box-shadow: 0 0 0 0 currentColor; } 70% { box-shadow: 0 0 0 8px transparent; } 100% { box-shadow: 0 0 0 0 transparent; } }

/* ── Page shell (matches send page) ── */
.track-page { min-height: 100vh; display: flex; flex-direction: column; }
.track-main {
    flex: 1;
    display: flex;
    justify-content: center;
    padding: 160px 40px 80px;
}

/* ── Two-card layout (mirrors send page wiz-layout) ── */
.track-layout {
    display: grid;
    grid-template-columns: 7fr 5fr;
    gap: 0;
    width: 100%;
    max-width: 1080px;
    align-items: start;
}
.track-left {
    display: flex;
    flex-direction: column;
    min-width: 0;
    padding-right: 48px;
}
.track-right {
    position: sticky;
    top: 180px;
}

/* ── Card shell (identical to wiz-card) ── */
.tk-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
}
.tk-card-head {
    padding: 28px 28px 20px;
    border-bottom: 1px solid var(--border);
}
.tk-title {
    font-family: var(--fh);
    font-size: 20px; font-weight: 700;
    color: var(--forest); letter-spacing: -0.02em;
    margin-bottom: 4px;
}
.tk-sub { font-size: 13.5px; color: var(--muted); }
.tk-card-body { padding: 24px 28px; }
.tk-card-foot {
    padding: 16px 28px;
    border-top: 1px solid var(--border);
    background: var(--shade);
    display: flex; flex-direction: column; gap: 10px;
}

/* ── Status badge ── */
.tk-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
    padding: 3px 9px; border-radius: 5px; margin-bottom: 10px;
}
.tk-pulse { display: inline-block; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

.status-posted      .tk-badge { background: var(--green-light); color: var(--forest); }
.status-assigned    .tk-badge { background: #fef3c7; color: #92400e; }
.status-in_progress .tk-badge { background: var(--forest); color: var(--green); }
.status-delivered   .tk-badge { background: var(--green-light); color: var(--green-mid); }
.status-cancelled   .tk-badge { background: #fee2e2; color: #b91c1c; }
.status-draft       .tk-badge { background: #f3f4f6; color: #6b7280; }

.status-posted      .tk-pulse { background: var(--green-mid); animation: ripple 2s ease-in-out infinite; color: var(--green-mid); }
.status-in_progress .tk-pulse { background: var(--green); animation: ripple 2s ease-in-out infinite; color: var(--green); }

/* ── Order number (monospaced, serial feel) ── */
.tk-order-num {
    font-family: 'DM Mono', ui-monospace, 'Courier New', monospace;
    font-size: 13px; font-weight: 500;
    color: var(--muted); letter-spacing: .05em;
    display: flex; align-items: center; gap: 8px; margin-top: 2px;
}
.tk-copy {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 11px; font-weight: 600; font-family: var(--f);
    color: var(--muted); background: var(--shade);
    border: 1px solid var(--border); border-radius: 5px;
    padding: 2px 8px; cursor: pointer; letter-spacing: 0;
    transition: border-color .15s, color .15s;
}
.tk-copy:hover { border-color: #9ca3af; color: var(--ink); }

/* ── Timeline ── */
.tl { display: flex; flex-direction: column; }
.tl-step { display: flex; position: relative; }
.tl-spine { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; width: 44px; }
.tl-dot {
    border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    position: relative; z-index: 1;
}
.tl-dot.done { width: 28px; height: 28px; background: var(--green); box-shadow: 0 0 0 4px rgba(107,198,48,.1); }
.tl-dot.cur  { width: 34px; height: 34px; background: var(--forest); box-shadow: 0 0 0 5px rgba(28,56,41,.08); }
.tl-dot.fut  { width: 22px; height: 22px; background: #fff; border: 2px solid #dde0d8; }
.tl-dot.canc { width: 28px; height: 28px; background: #fee2e2; border: 2px solid #fca5a5; }
.tl-line { width: 2px; flex: 1; min-height: 14px; margin: 4px 0; border-radius: 9999px; }
.tl-line.done    { background: var(--green); }
.tl-line.pending { background: repeating-linear-gradient(to bottom,#dde0d8 0,#dde0d8 3px,transparent 3px,transparent 7px); }

.tl-body { flex: 1; min-width: 0; }
.tl-step.done  .tl-body { padding: 1px 0 24px 16px; }
.tl-step.cur   .tl-body { padding: 0   0 24px 12px; }
.tl-step.fut   .tl-body { padding: 4px 0 18px 20px; }
.tl-step.canc  .tl-body { padding: 1px 0 24px 16px; }
.tl-step:last-child .tl-body { padding-bottom: 0; }

.tl-cur-wrap {
    background: #f5f8f4;
    border-left: 3px solid var(--forest);
    border-radius: 0 9px 9px 0;
    padding: 13px 18px;
}
.tl-step-name { font-family: var(--fh); font-size: 14px; font-weight: 700; color: var(--ink); line-height: 1.3; margin-bottom: 5px; }
.tl-step-name.done-lbl { font-size: 13px; color: var(--forest); font-weight: 600; margin-bottom: 0; }
.tl-step-name.fut  { font-size: 13px; color: #b8beb6; font-weight: 400; font-family: var(--f); margin-bottom: 0; }
.tl-step-name.canc { color: #b91c1c; }
.tl-step-desc { font-size: 12.5px; color: var(--muted); line-height: 1.6; }

/* ── Right card — summary rows (mirrors send page summary) ── */
.tk-summary-title {
    font-size: 11px; font-weight: 700;
    color: var(--text-2); letter-spacing: 0.1em; text-transform: uppercase;
    padding: 20px 24px 18px;
    border-bottom: 1px solid var(--border);
}
.tk-summary-sec { padding: 18px 24px; border-bottom: 1px solid var(--border); }
.tk-summary-sec:last-child { border-bottom: none; }
.tk-sec-lbl {
    font-size: 9.5px; font-weight: 700; letter-spacing: .11em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 12px;
    display: flex; align-items: center; gap: 6px;
}
.tk-rows { display: flex; flex-direction: column; gap: 9px; }
.tk-row { display: flex; align-items: baseline; }
.tk-rk { width: 80px; flex-shrink: 0; font-size: 12px; color: var(--muted); font-weight: 500; }
.tk-rv { flex: 1; font-size: 13.5px; font-weight: 500; color: var(--ink); line-height: 1.45; }
.tk-rv.e { color: #d1d5db; font-weight: 400; font-style: italic; }
.ftag {
    display: inline-flex; align-items: center; gap: 3px;
    font-size: 10.5px; font-weight: 700;
    background: #fff3e0; color: #c2410c;
    padding: 2px 8px; border-radius: 5px;
}

/* Price + CTA footer */
.tk-price-area {
    padding: 16px 24px 0;
    background: var(--shade);
    border-top: 1px solid var(--border);
}
.tk-price-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 13px; color: var(--text-2); margin-bottom: 6px;
}
.tk-price-total {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 15px; font-weight: 700; color: var(--forest);
    padding: 12px 0 16px;
    border-top: 1px solid var(--border);
    margin-top: 4px;
}
.tk-cta-area { padding: 0 24px 20px; background: var(--shade); display: flex; flex-direction: column; gap: 9px; }

.btn-p {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; background: var(--forest); color: #fff;
    border: none; border-radius: 11px;
    font-family: var(--f); font-size: 14px; font-weight: 700;
    padding: 13px; cursor: pointer; text-decoration: none;
    transition: background .18s;
}
.btn-p:hover { background: var(--forest-d); }
.btn-g {
    display: flex; align-items: center; justify-content: center;
    background: none; color: var(--muted);
    border: 1.5px solid var(--border); border-radius: 11px;
    font-family: var(--f); font-size: 13px; font-weight: 500;
    padding: 11px; cursor: pointer; text-decoration: none;
    transition: border-color .15s, color .15s;
}
.btn-g:hover { border-color: #9ca3af; color: var(--ink); }

/* ── Landing state (no order yet) ── */
.tk-landing {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 22px; padding: 0; width: 100%;
}
.landing-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--forest);
    display: flex; align-items: center; justify-content: center;
}
.l-h1 {
    font-family: var(--fh); font-size: 26px; font-weight: 700;
    color: var(--forest); letter-spacing: -.025em;
    margin-bottom: 4px; text-align: center;
}
.l-sub { font-size: 14px; color: var(--muted); text-align: center; line-height: 1.6; }
.l-form {
    width: 100%; max-width: 400px;
    display: flex; align-items: center;
    background: var(--white); border: 1.5px solid var(--border);
    border-radius: 11px; padding: 6px 6px 6px 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: border-color .15s, box-shadow .15s;
}
.l-form:focus-within { border-color: var(--forest); box-shadow: 0 4px 20px rgba(28,56,41,.1); }
.l-form input {
    flex: 1; border: none; background: transparent; outline: none;
    font-family: var(--f); font-size: 14px; font-weight: 500;
    color: var(--ink); letter-spacing: .03em;
}
.l-form input::placeholder { color: #9ca3af; font-weight: 400; }
.l-form button {
    flex-shrink: 0; height: 38px; padding: 0 18px;
    background: var(--forest); color: #fff; border: none; border-radius: 7px;
    font-family: var(--f); font-size: 13px; font-weight: 700; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px; transition: background .18s;
}
.l-form button:hover { background: var(--forest-d); }
.l-hint { font-size: 12px; color: #9ca3af; }
.l-hint strong { color: var(--muted); font-weight: 600; }
.btn-pi {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--forest); color: #fff;
    font-family: var(--f); font-size: 14px; font-weight: 700;
    padding: 13px 30px; border: none; border-radius: 10px;
    cursor: pointer; text-decoration: none; transition: background .18s;
}
.btn-pi:hover { background: var(--forest-d); }

/* ── Not found ── */
.tk-nf {
    flex: 1; display: flex; align-items: center; justify-content: center;
    width: 100%;
}
.nf-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: 18px; padding: 48px 36px;
    text-align: center; max-width: 380px; width: 100%;
}
.nf-icon {
    width: 46px; height: 46px; border-radius: 12px;
    background: #fef3c7; margin: 0 auto 18px;
    display: flex; align-items: center; justify-content: center;
}
.nf-h { font-family: var(--fh); font-size: 18px; font-weight: 700; color: var(--forest); margin-bottom: 9px; letter-spacing: -.02em; }
.nf-p { font-size: 13.5px; color: var(--muted); line-height: 1.65; margin-bottom: 24px; }
.nf-p code {
    font-family: 'DM Mono', ui-monospace, monospace;
    font-size: 12px; font-weight: 500; color: var(--forest);
    background: var(--shade); padding: 2px 7px; border-radius: 4px;
}

/* ── Mobile ── */
@media (max-width: 768px) {
    .track-main { padding: 130px 16px 60px; }
    .track-layout { grid-template-columns: 1fr; }
    .track-left { padding-right: 0; padding-bottom: 20px; }
    .track-right { position: static; }
}
</style>
</head>

<body class="track-page" x-data="{ trackOpen: false, trackNum: '' }" @keydown.escape.window="trackOpen = false">

<x-landing.nav :frosted="true" />

<main class="track-main">

@if(!$orderNumber)
{{-- ── LANDING STATE ── --}}
<div class="tk-landing">
    <div class="landing-icon">
        <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg>
    </div>
    <div style="text-align:center">
        <h1 class="l-h1">Track your parcel</h1>
        <p class="l-sub">Real-time updates on every delivery.</p>
    </div>
    <div x-data="{ open:false, num:'' }" x-init="$watch('open', v => v && $nextTick(() => $refs.ti?.focus()))" style="display:flex;flex-direction:column;align-items:center;gap:14px;width:100%;">
        <button type="button" class="btn-pi" x-show="!open" @click="open=true">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            Track a parcel
        </button>
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             style="width:100%;max-width:420px;display:flex;flex-direction:column;align-items:center;gap:10px;">
            <form class="l-form" style="width:100%" @submit.prevent="if(num.trim()) window.location='/track/'+num.trim().toUpperCase()">
                <input x-model="num" x-ref="ti" type="text" placeholder="e.g. NHM-20260812-XXXX" autocomplete="off" spellcheck="false">
                <button type="submit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
                    Track
                </button>
            </form>
            <p class="l-hint">Order numbers look like <strong>NHM-20260812-XXXX</strong></p>
        </div>
    </div>
</div>

@elseif(!$task)
{{-- ── NOT FOUND ── --}}
<div class="tk-nf">
    <div class="nf-card">
        <div class="nf-icon">
            <svg width="20" height="20" fill="none" stroke="#b45309" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.98L13.74 4a2 2 0 00-3.48 0L3.25 16.02A2 2 0 005.07 19z"/></svg>
        </div>
        <h2 class="nf-h">Order not found</h2>
        <p class="nf-p">No order matches <code>{{ $orderNumber }}</code>.<br>Double-check the number and try again.</p>
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

<div class="track-layout">

    {{-- ══ LEFT CARD: Status + Timeline ══ --}}
    <div class="track-left">
        <div class="tk-card status-{{ $sv }}">
            <div class="tk-card-head">
                <div class="tk-badge">
                    @if(in_array($sv, ['posted','in_progress']))<span class="tk-pulse"></span>@endif
                    {{ $status->label() }}
                </div>
                <h2 class="tk-title">{{ $status->description() }}</h2>
                <p class="tk-order-num">
                    {{ $task->order_number }}
                    <button type="button" class="tk-copy" x-data
                            x-on:click="navigator.clipboard.writeText('{{ $task->order_number }}').then(()=>{ $el.textContent='Copied!'; setTimeout(()=>$el.textContent='Copy',1500) })">
                        Copy
                    </button>
                </p>
            </div>
            <div class="tk-card-body">
                <div class="tl">
                    @if($isCan)
                    <div class="tl-step canc">
                        <div class="tl-spine">
                            <div class="tl-dot canc">
                                <svg width="11" height="11" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                        </div>
                        <div class="tl-body">
                            <div class="tl-cur-wrap">
                                <p class="tl-step-name canc">Order cancelled</p>
                                <p class="tl-step-desc">{{ $status->description() }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    @foreach($timeline as $i => $step)
                    @php
                        $si        = array_search($step, $timeline);
                        $done      = $ci !== false && $ci > $si;
                        $cur       = $status === $step;
                        $fut       = $ci === false || $ci < $si;
                        $last      = $i === count($timeline) - 1;
                        $stepClass = $done ? 'done' : ($cur ? 'cur' : 'fut');
                    @endphp
                    <div class="tl-step {{ $stepClass }}">
                        <div class="tl-spine">
                            <div class="tl-dot {{ $stepClass }}">
                                @if($done)
                                    <svg width="11" height="11" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @elseif($cur)
                                    <svg width="7" height="7" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" fill="white"/></svg>
                                @endif
                            </div>
                            @if(!$last)
                                <div class="tl-line {{ $done ? 'done' : 'pending' }}"></div>
                            @endif
                        </div>
                        <div class="tl-body">
                            @if($cur)
                                <div class="tl-cur-wrap">
                                    <p class="tl-step-name">{{ $step->label() }}</p>
                                    <p class="tl-step-desc">{{ $step->description() }}</p>
                                </div>
                            @elseif($done)
                                <p class="tl-step-name done-lbl">{{ $step->label() }}</p>
                            @else
                                <p class="tl-step-name fut">{{ $step->label() }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ══ RIGHT CARD: Order Summary ══ --}}
    <div class="track-right">
        <div class="tk-card">
            <p class="tk-summary-title">Order Summary</p>

            <div class="tk-summary-sec">
                <p class="tk-sec-lbl">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    Journey
                </p>
                <div class="tk-rows">
                    <div class="tk-row"><span class="tk-rk">Pickup</span><span class="tk-rv">{{ $task->pickup_type === \App\Enums\PickupType::WalkIn ? 'Drop at shop' : 'Biker collection' }}</span></div>
                    @if($task->pickup_address)<div class="tk-row"><span class="tk-rk">From</span><span class="tk-rv">{{ $task->pickup_address }}</span></div>@endif
                    <div class="tk-row"><span class="tk-rk">To</span><span class="tk-rv {{ !$task->dropoff_address ? 'e' : '' }}">{{ $task->dropoff_address ?: '—' }}</span></div>
                    <div class="tk-row"><span class="tk-rk">When</span><span class="tk-rv">{{ $task->scheduled_at ? $task->scheduled_at->format('D d M, H:i') : 'As soon as possible' }}</span></div>
                </div>
            </div>

            <div class="tk-summary-sec">
                <p class="tk-sec-lbl">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg>
                    Parcel
                </p>
                <div class="tk-rows">
                    <div class="tk-row"><span class="tk-rk">Category</span><span class="tk-rv {{ !$task->package_category ? 'e' : '' }}">{{ $task->package_category?->label() ?? '—' }}</span></div>
                    @if($task->weight_kg)<div class="tk-row"><span class="tk-rk">Weight</span><span class="tk-rv">{{ $task->weight_kg }} kg</span></div>@endif
                    @if($task->is_fragile)
                    <div class="tk-row"><span class="tk-rk">Handling</span><span class="tk-rv"><span class="ftag">Fragile</span></span></div>
                    @endif
                    @if($task->notes)<div class="tk-row"><span class="tk-rk">Notes</span><span class="tk-rv">{{ $task->notes }}</span></div>@endif
                </div>
            </div>

            <div class="tk-summary-sec">
                <p class="tk-sec-lbl">
                    <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Recipient
                </p>
                <div class="tk-rows">
                    <div class="tk-row"><span class="tk-rk">Name</span><span class="tk-rv {{ !$task->recipient_name ? 'e' : '' }}">{{ $task->recipient_name ?: '—' }}</span></div>
                    <div class="tk-row"><span class="tk-rk">Phone</span><span class="tk-rv {{ !$task->recipient_phone ? 'e' : '' }}">{{ $task->recipient_phone ?: '—' }}</span></div>
                </div>
            </div>

            <div class="tk-price-area">
                <div class="tk-price-row">
                    <span>Base delivery</span>
                    <span>${{ number_format($task->price_estimate ?? 0, 2) }}</span>
                </div>
                <div class="tk-price-total">
                    <span>Estimated total</span>
                    <span>${{ number_format($task->price_estimate ?? 0, 2) }}</span>
                </div>
            </div>
            <div class="tk-cta-area">
                <a href="/send" class="btn-p">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Send another parcel
                </a>
                <a href="/" class="btn-g">Back to home</a>
            </div>
        </div>
    </div>

</div>{{-- /track-layout --}}
@endif

</main>

<x-landing.footer />
<x-landing.track-modal />

@vite(['resources/js/app.js'])
</body>
</html>
