<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send a Parcel — Nhume</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@700,800&display=swap" rel="stylesheet">

    @livewireStyles
    @vite(['resources/css/app.css'])

<style>
:root {
    --font:        'DM Sans', system-ui, sans-serif;
    --head:        'Inter', 'DM Sans', system-ui, sans-serif;
    --green:       #6bc630;
    --green-dark:  #5aad28;
    --green-light: #edf8df;
    --green-mid:   #4a9a1f;
    --forest:      #1C3829;
    --border:      #e5e7eb;
    --text:        #0b130a;
    --text-2:      #6b7280;
    --shade:       #f9fafb;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font); color: var(--text); background: var(--shade); -webkit-font-smoothing: antialiased; }

/* ── Page shell ── */
.send-page { min-height: 100vh; display: flex; flex-direction: column; }
.send-nav {
    background: #fff; border-bottom: 1px solid var(--border);
    padding: 0 32px; height: 62px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
}
.send-nav-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 14px; font-weight: 500; color: var(--text-2);
    text-decoration: none; transition: color 0.15s;
}
.send-nav-back:hover { color: var(--text); }

.send-main {
    flex: 1;
    display: flex;
    justify-content: center;
    padding: 0 32px 0 32px;
}

/* ── Two-column layout ── */
.wiz-layout {
    display: grid;
    grid-template-columns: 7fr 5fr;
    gap: 0;
    width: 100%;
    max-width: 1100px;
    align-items: start;
}

/* ── LEFT — scrolls with the page ── */
.wiz-left {
    display: flex;
    flex-direction: column;
    gap: 0;
    padding: 36px 36px 80px 0;
    border-right: 1px solid var(--border);
}

/* Progress */
.wiz-progress {
    display: flex; align-items: center;
    margin-bottom: 20px; padding: 0 4px;
}
.wiz-prog-step { display: flex; flex-direction: column; align-items: center; gap: 5px; }
.wiz-prog-dot {
    width: 30px; height: 30px; border-radius: 50%;
    background: #e5e7eb; color: #9ca3af;
    font-size: 12px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, color 0.2s;
}
.wiz-prog-step.active .wiz-prog-dot { background: var(--forest); color: #fff; }
.wiz-prog-step.done   .wiz-prog-dot { background: var(--green);  color: #fff; }
.wiz-prog-label { font-size: 11px; font-weight: 600; color: #9ca3af; white-space: nowrap; }
.wiz-prog-step.active .wiz-prog-label { color: var(--forest); }
.wiz-prog-step.done   .wiz-prog-label { color: var(--green-mid); }
.wiz-prog-line {
    flex: 1; height: 2px; background: #e5e7eb;
    margin: 0 10px 16px; transition: background 0.2s;
}
.wiz-prog-line.done { background: var(--green); }

/* Card shell */
.wiz-card { background: #fff; border: 1px solid var(--border); border-radius: 18px; overflow: hidden; }
.wiz-card-head { padding: 28px 28px 20px; border-bottom: 1px solid var(--border); }
.wiz-title {
    font-family: var(--head); font-size: 20px; font-weight: 700;
    color: var(--forest); letter-spacing: -0.02em; margin-bottom: 4px;
}
.wiz-sub { font-size: 13.5px; color: var(--text-2); }
.wiz-back {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; font-weight: 500; color: var(--text-2);
    background: none; border: none; cursor: pointer;
    margin-bottom: 12px; padding: 0;
    transition: color 0.15s;
}
.wiz-back:hover { color: var(--text); }
.wiz-card-body { padding: 24px 28px; }
.wiz-card-foot {
    padding: 16px 28px;
    border-top: 1px solid var(--border);
    background: var(--shade);
    display: flex; justify-content: flex-end; gap: 10px;
}

/* Pickup cards */
.pickup-cards { display: flex; flex-direction: column; gap: 10px; }
.pickup-card {
    display: flex; align-items: center; gap: 14px;
    background: var(--shade); border: 2px solid transparent;
    border-radius: 12px; padding: 16px 18px;
    cursor: pointer; position: relative;
    transition: border-color 0.18s, background 0.18s;
}
.pickup-card:hover { border-color: #d1d5db; }
.pickup-card.selected { border-color: var(--forest); background: #f0f7ec; }
.pickup-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: #fff; border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: var(--forest);
    transition: background 0.18s, border-color 0.18s;
}
.pickup-card.selected .pickup-icon { background: var(--forest); color: #fff; border-color: var(--forest); }
.pickup-body { flex: 1; display: flex; flex-direction: column; gap: 2px; }
.pickup-title { font-weight: 700; font-size: 14.5px; color: var(--forest); }
.pickup-desc  { font-size: 12.5px; color: var(--text-2); line-height: 1.5; }
.pickup-badge {
    display: inline-block; margin-top: 3px;
    font-size: 10.5px; font-weight: 700;
    padding: 2px 8px; border-radius: 9999px;
    background: var(--green-light); color: var(--green-mid); width: fit-content;
}
.pickup-badge.collection { background: #fff3e0; color: #e65100; }
.pickup-check {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--forest); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.18s;
}
.pickup-check.on { opacity: 1; }

/* Fields */
.fields { display: flex; flex-direction: column; gap: 18px; }
.field { display: flex; flex-direction: column; gap: 0; }
.field-row { display: flex; gap: 14px; }
.flabel { font-size: 12.5px; font-weight: 700; color: var(--forest); margin-bottom: 6px; letter-spacing: 0.01em; }
.fopt   { font-weight: 400; color: var(--text-2); margin-left: 3px; }
.finput {
    width: 100%; padding: 10px 13px;
    border: 1.5px solid var(--border); border-radius: 9px;
    font-family: var(--font); font-size: 14px; color: var(--text);
    background: #fff; outline: none; transition: border-color 0.15s;
}
.finput:focus { border-color: var(--forest); }
.field-err { font-size: 12px; color: #e53e3e; margin-top: 4px; }
.field-hint { font-size: 12px; color: var(--text-2); }

/* Category chips */
.chips { display: flex; flex-wrap: wrap; gap: 7px; }
.chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 7px 13px; border: 1.5px solid var(--border);
    border-radius: 9999px; background: #fff;
    font-family: var(--font); font-size: 12.5px; font-weight: 500;
    color: var(--text-2); cursor: pointer;
    transition: border-color 0.15s, color 0.15s, background 0.15s;
}
.chip:hover { border-color: #9ca3af; color: var(--text); }
.chip.on { border-color: var(--forest); background: var(--forest); color: #fff; }

/* Toggle */
.toggle { display: flex; align-items: center; gap: 9px; cursor: pointer; }
.toggle-track {
    width: 38px; height: 21px; background: #e5e7eb;
    border-radius: 9999px; position: relative;
    flex-shrink: 0; transition: background 0.2s;
}
input:checked + .toggle-track { background: var(--green); }
.toggle-thumb {
    position: absolute; top: 2.5px; left: 2.5px;
    width: 16px; height: 16px; border-radius: 50%;
    background: #fff; transition: left 0.18s;
}
input:checked + .toggle-track .toggle-thumb { left: 19.5px; }
.toggle-lbl { font-size: 13.5px; font-weight: 500; color: var(--text); }

/* Schedule */
.sched-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border: 1.5px solid var(--border);
    border-radius: 9px; background: #fff;
    font-family: var(--font); font-size: 13.5px; font-weight: 500;
    color: var(--text-2); cursor: pointer; transition: border-color 0.15s, color 0.15s;
}
.sched-btn.on { border-color: var(--forest); color: var(--forest); font-weight: 700; }

/* Recipient section label */
.field-section-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--text-2);
    padding-top: 6px; border-top: 1px solid var(--border);
}

/* ── RIGHT — fixed viewport height, scrolls internally ── */
.wiz-right {
    position: sticky;
    top: 62px;
    height: calc(100vh - 62px);
    overflow-y: auto;
    padding: 36px 0 36px 36px;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}
.wiz-right::-webkit-scrollbar { width: 4px; }
.wiz-right::-webkit-scrollbar-track { background: transparent; }
.wiz-right::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 9999px; }
.summary-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 18px; overflow: hidden;
    display: flex; flex-direction: column;
}
.summary-title {
    font-family: var(--head); font-size: 12px; font-weight: 700;
    color: var(--text-2); letter-spacing: 0.08em; text-transform: uppercase;
    padding: 0 0 16px; border-bottom: 1px solid var(--border);
}
.summary-rows { padding: 16px 0; display: flex; flex-direction: column; gap: 12px; }
.srow { display: flex; gap: 12px; align-items: baseline; }
.skey { font-size: 12px; font-weight: 600; color: var(--text-2); width: 78px; flex-shrink: 0; }
.sval { font-size: 13.5px; color: var(--text); line-height: 1.4; flex: 1; }
.sval.empty { color: #c4cdc0; }

/* Price breakdown */
.summary-price {
    border-top: 1px solid var(--border);
    padding: 14px 0 0;
    display: flex; flex-direction: column; gap: 7px;
}
.price-line {
    display: flex; justify-content: space-between;
    font-size: 13px; color: var(--text-2);
}
.price-total {
    display: flex; justify-content: space-between;
    font-size: 15px; font-weight: 700; color: var(--forest);
    margin-top: 4px; padding-top: 10px;
    border-top: 1px solid var(--border);
}

/* Summary CTA */
.summary-card .btn-wiz-primary { margin: 16px 0 0; }
.summary-note {
    font-size: 11.5px; color: var(--text-2); text-align: center;
    padding: 10px 0 4px;
}

/* Buttons */
.btn-wiz-primary {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--forest); color: #fff;
    font-family: var(--font); font-size: 14px; font-weight: 700;
    padding: 12px 24px; border: none; border-radius: 11px;
    cursor: pointer; text-decoration: none;
    transition: background 0.18s, transform 0.18s;
}
.btn-wiz-primary:hover:not(:disabled) { background: #0f2a1d; transform: translateY(-1px); }
.btn-wiz-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-wiz-ghost {
    display: inline-flex; align-items: center; gap: 7px;
    background: none; color: var(--text-2);
    font-family: var(--font); font-size: 13.5px; font-weight: 500;
    padding: 11px 18px; border: 1.5px solid var(--border);
    border-radius: 11px; cursor: pointer; text-decoration: none;
    transition: border-color 0.15s, color 0.15s;
}
.btn-wiz-ghost:hover { border-color: #9ca3af; color: var(--text); }

/* ── Confirmation screen ── */
.wiz-confirm {
    background: #fff; border: 1px solid var(--border);
    border-radius: 20px; padding: 56px 40px;
    text-align: center; max-width: 520px;
    margin: 0 auto; width: 100%;
}
.wiz-confirm-icon {
    width: 60px; height: 60px; border-radius: 50%;
    background: var(--green-light);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.wiz-confirm-title {
    font-family: var(--head); font-size: 26px; font-weight: 700;
    color: var(--forest); letter-spacing: -0.02em; margin-bottom: 8px;
}
.wiz-confirm-sub { font-size: 14.5px; color: var(--text-2); margin-bottom: 28px; }

.wiz-order-box {
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    background: var(--shade); border: 1.5px solid var(--border);
    border-radius: 14px; padding: 20px 28px; margin-bottom: 20px;
}
.wiz-order-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--text-2);
}
.wiz-order-num {
    font-family: var(--head); font-size: 26px; font-weight: 700;
    color: var(--forest); letter-spacing: 0.05em;
}
.wiz-order-copy {
    font-size: 12px; font-weight: 600; color: var(--green-mid);
    background: var(--green-light); border: none; border-radius: 9999px;
    padding: 4px 16px; cursor: pointer; transition: background 0.15s;
}
.wiz-order-copy:hover { background: #d4f0b0; }

.wiz-next-step {
    display: flex; align-items: flex-start; gap: 10px;
    background: var(--green-light); border-radius: 12px;
    padding: 14px 18px; font-size: 13.5px; color: var(--green-mid);
    text-align: left; line-height: 1.6; margin-bottom: 28px;
}
.wiz-confirm-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

/* ── Mobile ── */
@media (max-width: 768px) {
    .wiz-layout { grid-template-columns: 1fr; gap: 0; }
    .wiz-left { border-right: none; padding: 24px 16px 60px; }
    .wiz-right { position: static; height: auto; order: -1; padding: 24px 16px 0; border-bottom: 1px solid var(--border); }
    .send-main { padding: 0 0; }
    .wiz-card-head, .wiz-card-body, .wiz-card-foot { padding-left: 20px; padding-right: 20px; }
    .field-row { flex-direction: column; }
    .wiz-confirm { padding: 40px 24px; }
}
</style>
</head>
<body class="send-page">

    {{-- Nav --}}
    <header class="send-nav">
        <a href="/" class="send-nav-logo">
            <img src="/images/nhume_logo_v2.png" alt="Nhume" style="height:36px;width:auto;">
        </a>
        <a href="/" class="send-nav-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Back to home
        </a>
    </header>

    <main class="send-main">
        @livewire('parcel.create-order-wizard')
    </main>

    @livewireScripts
</body>
</html>
