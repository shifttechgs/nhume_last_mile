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
    --font:         'DM Sans', system-ui, sans-serif;
    --head:         'Inter', 'DM Sans', system-ui, sans-serif;
    --green:        #6bc630;
    --green-dark:   #5aad28;
    --green-light:  #edf8df;
    --green-mid:    #4a9a1f;
    --forest:       #1C3829;
    --forest-deep:  #062e14;
    --border:       #e5e7eb;
    --text:         #0b130a;
    --text-2:       #6b7280;
    --white:        #ffffff;
    --shade:        #f9fafb;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font); color: var(--text); background: var(--shade); -webkit-font-smoothing: antialiased; }

/* ── Page shell ── */
.send-page {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.send-nav {
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.send-nav-logo { display: flex; align-items: center; text-decoration: none; }
.send-nav-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: var(--font); font-size: 14px; font-weight: 500;
    color: var(--text-2); text-decoration: none;
    transition: color 0.15s;
}
.send-nav-back:hover { color: var(--text); }

.send-main {
    flex: 1;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 48px 24px 80px;
}

/* ── Wizard shell ── */
.wizard-wrap {
    width: 100%;
    max-width: 560px;
}

/* ── Progress ── */
.wizard-progress {
    display: flex;
    align-items: center;
    margin-bottom: 36px;
}
.wizard-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}
.wizard-step-dot {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #e5e7eb;
    color: #9ca3af;
    font-size: 13px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, color 0.2s;
}
.wizard-step.active .wizard-step-dot { background: var(--forest); color: #fff; }
.wizard-step.done .wizard-step-dot   { background: var(--green); color: #fff; }
.wizard-step-label {
    font-size: 11.5px; font-weight: 600;
    color: #9ca3af;
    white-space: nowrap;
}
.wizard-step.active .wizard-step-label { color: var(--forest); }
.wizard-step.done .wizard-step-label   { color: var(--green-mid); }
.wizard-step-line {
    flex: 1;
    height: 2px;
    background: #e5e7eb;
    margin: 0 8px;
    margin-bottom: 18px;
    transition: background 0.2s;
}
.wizard-step-line.done { background: var(--green); }

/* ── Wizard body ── */
.wizard-body {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
}
.wizard-title {
    font-family: var(--head);
    font-size: 22px;
    font-weight: 700;
    color: var(--forest);
    letter-spacing: -0.02em;
    margin: 0 0 6px;
    padding: 32px 32px 0;
}
.wizard-sub {
    font-size: 14.5px;
    color: var(--text-2);
    padding: 0 32px 28px;
    border-bottom: 1px solid var(--border);
}

/* ── Pickup cards ── */
.pickup-cards {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 28px 32px;
}
.pickup-card {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--shade);
    border: 2px solid transparent;
    border-radius: 14px;
    padding: 18px 20px;
    cursor: pointer;
    text-align: left;
    transition: border-color 0.18s, background 0.18s;
    width: 100%;
}
.pickup-card:hover { border-color: #d1d5db; }
.pickup-card.selected { border-color: var(--forest); background: #f0f7ec; }
.pickup-card-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--forest);
    border: 1px solid var(--border);
}
.pickup-card.selected .pickup-card-icon { background: var(--forest); color: #fff; border-color: var(--forest); }
.pickup-card-body { flex: 1; display: flex; flex-direction: column; gap: 3px; }
.pickup-card-title { font-weight: 700; font-size: 15px; color: var(--forest); }
.pickup-card-desc  { font-size: 13px; color: var(--text-2); line-height: 1.5; }
.pickup-card-badge {
    display: inline-block;
    margin-top: 4px;
    font-size: 11px; font-weight: 700;
    padding: 2px 8px;
    border-radius: 9999px;
    background: var(--green-light);
    color: var(--green-mid);
    width: fit-content;
}
.pickup-card-badge.collection { background: #fff3e0; color: #e65100; }
.pickup-card-check {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--forest);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    opacity: 0;
    transition: opacity 0.18s;
}
.pickup-card-check.visible { opacity: 1; }

/* ── Fields ── */
.wizard-fields { padding: 28px 32px; display: flex; flex-direction: column; gap: 20px; }
.field-group { margin-bottom: 0; }
.field-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: var(--forest);
    margin-bottom: 8px;
    letter-spacing: 0.01em;
}
.field-optional { font-weight: 400; color: var(--text-2); margin-left: 4px; }
.field-hint { font-size: 12.5px; color: var(--text-2); }
.field-input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-family: var(--font);
    font-size: 14.5px;
    color: var(--text);
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
}
.field-input:focus { border-color: var(--forest); }
.field-error { font-size: 12.5px; color: #e53e3e; margin-top: 5px; }

/* ── Category chips ── */
.category-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.category-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 14px;
    border: 1.5px solid var(--border);
    border-radius: 9999px;
    background: #fff;
    font-family: var(--font);
    font-size: 13px; font-weight: 500;
    color: var(--text-2);
    cursor: pointer;
    transition: border-color 0.15s, color 0.15s, background 0.15s;
}
.category-chip:hover { border-color: #9ca3af; color: var(--text); }
.category-chip.selected { border-color: var(--forest); background: var(--forest); color: #fff; }

/* ── Toggle ── */
.toggle-wrap { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.toggle-input { display: none; }
.toggle-track {
    width: 40px; height: 22px;
    background: #e5e7eb;
    border-radius: 9999px;
    position: relative;
    transition: background 0.2s;
    flex-shrink: 0;
}
.toggle-input:checked + .toggle-track { background: var(--green); }
.toggle-thumb {
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #fff;
    transition: left 0.2s;
}
.toggle-input:checked + .toggle-track .toggle-thumb { left: 21px; }
.toggle-label { font-size: 14px; font-weight: 500; color: var(--text); }

/* ── Schedule buttons ── */
.schedule-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    background: #fff;
    font-family: var(--font);
    font-size: 14px; font-weight: 500;
    color: var(--text-2);
    cursor: pointer;
    transition: border-color 0.15s, color 0.15s;
}
.schedule-btn.selected { border-color: var(--forest); color: var(--forest); font-weight: 700; }

/* ── Price estimate bar ── */
.price-estimate-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--green-light);
    border: 1.5px solid #c6e9a0;
    border-radius: 12px;
    padding: 14px 18px;
}
.price-label { font-size: 13px; font-weight: 700; color: var(--green-mid); display: block; }
.price-hint  { font-size: 11.5px; color: #6aaa30; display: block; margin-top: 2px; }
.price-value { font-family: var(--head); font-size: 22px; font-weight: 700; color: var(--forest); }

/* ── Review card ── */
.review-card {
    margin: 0 32px;
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}
.review-row {
    display: grid;
    grid-template-columns: 130px 1fr auto;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
}
.review-row:last-child { border-bottom: none; }
.review-key { font-size: 12.5px; font-weight: 600; color: var(--text-2); }
.review-val { font-size: 14px; color: var(--text); }
.review-edit {
    font-size: 12px; font-weight: 600;
    color: var(--green-mid);
    background: none; border: none;
    cursor: pointer; padding: 4px 8px;
    border-radius: 6px;
    transition: background 0.15s;
}
.review-edit:hover { background: var(--green-light); }
.review-divider { height: 1px; background: var(--border); margin: 4px 0; }

/* ── Order confirmation ── */
.order-number-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    background: var(--shade);
    border: 1.5px solid var(--border);
    border-radius: 16px;
    padding: 24px 32px;
    margin: 0 auto 24px;
    max-width: 320px;
}
.order-number-label { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-2); }
.order-number-value { font-family: var(--head); font-size: 28px; font-weight: 700; color: var(--forest); letter-spacing: 0.04em; }
.order-number-copy {
    font-size: 12px; font-weight: 600;
    color: var(--green-mid);
    background: var(--green-light);
    border: none;
    border-radius: 9999px;
    padding: 5px 16px;
    cursor: pointer;
    transition: background 0.15s;
}
.order-number-copy:hover { background: #d4f0b0; }
.order-next-step {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: var(--green-light);
    border-radius: 12px;
    padding: 16px 20px;
    font-size: 14px;
    color: var(--green-mid);
    text-align: left;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}

/* ── Actions ── */
.wizard-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 20px 32px;
    border-top: 1px solid var(--border);
    background: var(--shade);
}
.btn-wizard-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--forest);
    color: #fff;
    font-family: var(--font);
    font-size: 14.5px; font-weight: 700;
    padding: 12px 28px;
    border: none; border-radius: 12px;
    cursor: pointer; text-decoration: none;
    transition: background 0.18s, transform 0.18s;
}
.btn-wizard-primary:hover:not(:disabled) { background: #0f2a1d; transform: translateY(-1px); }
.btn-wizard-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-wizard-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    background: none;
    color: var(--text-2);
    font-family: var(--font);
    font-size: 14px; font-weight: 500;
    padding: 12px 20px;
    border: 1.5px solid var(--border); border-radius: 12px;
    cursor: pointer; text-decoration: none;
    transition: border-color 0.15s, color 0.15s;
}
.btn-wizard-ghost:hover { border-color: #9ca3af; color: var(--text); }

@media (max-width: 600px) {
    .wizard-title, .wizard-sub { padding-left: 20px; padding-right: 20px; }
    .pickup-cards, .wizard-fields { padding: 20px; }
    .review-card { margin: 0 20px; }
    .wizard-actions { padding: 16px 20px; }
    .wizard-title { font-size: 20px; }
    .review-row { grid-template-columns: 100px 1fr auto; }
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

    {{-- Wizard --}}
    <main class="send-main">
        @livewire('parcel.create-order-wizard')
    </main>

    @livewireScripts
</body>
</html>
