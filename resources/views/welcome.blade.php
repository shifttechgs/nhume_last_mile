<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nhume — Moving parcels with drivers already in motion</title>
    <meta name="description" content="Someone is already driving to your city. Book their space, track your parcel live, and have it there today. Nhume — Zimbabwe's parcel marketplace.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@500,600,700,800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script>
    @endif

<style>
:root {
    --font: 'DM Sans', system-ui, sans-serif;
    --head: 'General Sans', 'Inter', 'DM Sans', system-ui, sans-serif;

    /* ── Primary brand green ── */
    --green:        #6bc630;
    --green-dark:   #5aad28;
    --green-light:  #edf8df;
    --green-mid:    #4a9a1f;

    /* ── Forest (dark green for sections, logo, decorative) ── */
    --forest:       #1C3829;
    --forest-deep:  #062e14;
    --amber:        #C9A96E;
    --amber-light:  #F7F0E3;

    /* ── Neutrals ── */
    --text:         #0b130a;
    --text-2:       #3d4a3a;
    --border:       #DDD9D0;
    --cream:        #f9fbf3;
    --cream-2:      #f1f5e8;
    --shade:        #f7f6f3;   /* unified 60% dominant — section backgrounds */
    --white:        #ffffff;   /* card / UI element surfaces */

    /* ── Spacing scale ── */
    --section-y:    112px;
    --container:    1200px;
    --card-radius:  8px;
    --btn-radius:   6px;
}

* { box-sizing: border-box; }
body { font-family: var(--font); color: var(--text); background: #fff; -webkit-font-smoothing: antialiased; }
[x-cloak] { display: none !important; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Nav link ── */
.nav-link {
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 500;
    color: var(--text-2);
    transition: color 0.15s;
    text-decoration: none;
}
.nav-link:hover { color: var(--text); }

/* ── Buttons ── */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--green);
    color: var(--forest-deep);
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 600;
    padding: 14px 28px;
    border-radius: var(--btn-radius);
    border: none;
    cursor: pointer;
    transition: background 0.18s, transform 0.18s;
    text-decoration: none;
    letter-spacing: 0.01em;
}
.btn-primary:hover { background: var(--green-dark); transform: translateY(-1px); }

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--white);
    color: var(--text);
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 600;
    padding: 13px 28px;
    border-radius: var(--btn-radius);
    border: 1.5px solid var(--border);
    cursor: pointer;
    transition: border-color 0.18s, background 0.18s;
    text-decoration: none;
    letter-spacing: 0.01em;
}
.btn-secondary:hover { border-color: #b5b0a5; background: var(--cream); }

/* ── Section label ── */
.eyebrow {
    font-family: var(--font);
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--green-mid);
}

/* ── Shared section headings (light-bg sections) ── */
.section-head {
    text-align: center;
    max-width: 660px;
    margin: 0 auto 60px;
}
.section-title {
    font-family: var(--head);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 700;
    letter-spacing: -0.03em;
    line-height: 1.12;
    color: var(--forest);
    margin: 12px 0 0;
}
.section-sub {
    font-family: var(--font);
    font-size: 16.5px;
    color: var(--text-2);
    line-height: 1.6;
    margin: 14px 0 0;
}
.eyebrow-ic {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
}

/* ══ How it works — Trackeo-style split (accordion + visual panel) ══ */
.how-grid {
    display: grid;
    grid-template-columns: 0.85fr 1fr;
    gap: 60px;
    align-items: center;
    max-width: 1120px;
    margin: 0 auto;
}
/* left — accordion */
.how-acc { border-top: 1px solid var(--border); }
.how-item { border-bottom: 1px solid var(--border); }
.how-item-head {
    display: flex;
    align-items: center;
    width: 100%;
    background: none;
    border: none;
    cursor: pointer;
    padding: 20px 2px;
    text-align: left;
    -webkit-tap-highlight-color: transparent;
}
.how-item-title {
    flex: 1;
    font-family: var(--head);
    font-size: 21px;
    font-weight: 500;
    letter-spacing: -0.02em;
    color: #8a9187;
    transition: color 0.2s ease;
}
.how-item-head:hover .how-item-title { color: var(--forest); }
.how-item.is-open .how-item-title { color: var(--forest); font-weight: 600; }
.how-item-body {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.32s ease;
}
.how-item-body.open { grid-template-rows: 1fr; }
.how-item-body-inner { overflow: hidden; }
.how-item-body p {
    font-family: var(--font);
    font-size: 15px;
    line-height: 1.72;
    color: var(--text-2);
    margin: 0 0 20px;
    padding-right: 16px;
}
.how-cta {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-top: 36px;
    background: var(--forest-deep);
    color: #fff;
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 600;
    padding: 15px 30px;
    border-radius: var(--btn-radius);
    text-decoration: none;
    transition: background 0.18s ease, transform 0.18s ease;
}
.how-cta:hover { background: var(--forest-deep); transform: translateY(-1px); }
.how-cta svg { transition: transform 0.18s ease; }
.how-cta:hover svg { transform: translateX(3px); }

/* right — Trackeo-style screenshot panel (light warm gray) */
.how-visual {
    position: relative;
    aspect-ratio: 1 / 0.9;
    background: #f1f0eb;
    border: 1px solid #e8e6df;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
}

/* crossfading scenes fill the panel like a screenshot */
.how-scene {
    position: absolute;
    inset: 0;
    opacity: 0;
    visibility: hidden;
    transform: scale(1.025);
    transition: opacity 0.45s cubic-bezier(0.4,0,0.2,1),
                transform 0.6s cubic-bezier(0.4,0,0.2,1),
                visibility 0.45s;
    pointer-events: none;
}
.how-scene.is-active { opacity: 1; visibility: visible; transform: none; }

/* map backdrop (soft streets) */
.hv-map-bg { position: absolute; inset: 0; background: #e7e5df; }
.hv-streets { position: absolute; inset: 0; width: 100%; height: 100%; }

/* soft ambient backdrop for form/list scenes */
.hv-soft {
    position: absolute; inset: 0;
    background:
        radial-gradient(90% 70% at 78% 12%, rgba(107,198,48,0.10) 0%, transparent 60%),
        radial-gradient(70% 60% at 12% 92%, rgba(28,56,41,0.06) 0%, transparent 60%);
}

/* floating white UI card — screenshot style */
.hv-float {
    position: absolute;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 20px 44px rgba(20,32,20,0.15), 0 4px 12px rgba(20,32,20,0.06);
}
.hv-pad { padding: 17px; }
.hv-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.hv-title { font-family: 'General Sans', var(--font), sans-serif; font-size: 14px; font-weight: 700; color: var(--forest); }
.hv-pill { font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--green-mid); background: var(--green-light); border-radius: 9999px; padding: 3px 9px; }
.hv-row { display: flex; align-items: center; gap: 11px; }
.hv-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.hv-label { font-family: var(--font); font-size: 9px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: #9aa096; }
.hv-val { font-family: var(--font); font-size: 13px; font-weight: 600; color: var(--text); margin-top: 1px; }
.hv-divider { height: 1px; background: var(--border); margin: 10px 0; }
.hv-chips { display: flex; gap: 6px; margin-top: 13px; }
.hv-chip { font-family: var(--font); font-size: 10.5px; font-weight: 600; color: var(--text-2); background: var(--shade); border: 1px solid var(--border); border-radius: 8px; padding: 5px 9px; }
.hv-btn { margin-top: 14px; background: var(--green); color: var(--forest-deep); font-family: var(--font); font-size: 12px; font-weight: 700; text-align: center; padding: 10px; border-radius: 9px; }

/* driver rows */
.hv-driver { display: flex; align-items: center; gap: 10px; padding: 9px; border-radius: 11px; border: 1px solid transparent; }
.hv-driver + .hv-driver { margin-top: 3px; }
.hv-driver.is-pick { background: var(--green-light); border-color: rgba(107,198,48,0.3); }
.hv-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.hv-dname { font-family: var(--font); font-size: 12.5px; font-weight: 700; color: var(--text); }
.hv-badge { display: inline-flex; align-items: center; gap: 4px; font-family: var(--font); font-size: 9.5px; font-weight: 700; color: var(--green-mid); margin-top: 2px; }
.hv-price { font-family: var(--font); font-size: 13px; font-weight: 800; color: var(--forest); margin-left: auto; }

/* track status card row */
.hv-track-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }
.hv-status-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 4px rgba(107,198,48,0.18); flex-shrink: 0; }
.hv-eta { font-family: var(--font); font-size: 11.5px; font-weight: 700; color: var(--green-mid); }

/* small chip that floats on the map */
.hv-mapchip {
    position: absolute;
    display: inline-flex; align-items: center; gap: 6px;
    background: #fff; border-radius: 9999px; padding: 6px 12px;
    box-shadow: 0 8px 20px rgba(20,32,20,0.14);
    font-family: var(--font); font-size: 11px; font-weight: 700; color: var(--forest);
}

@media (max-width: 900px) {
    .how-grid { grid-template-columns: 1fr; gap: 36px; max-width: 560px; }
    .how-visual { order: -1; }
}

/* ── Scroll reveal ── */
.reveal {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.reveal.visible { opacity: 1; transform: none; }

.reveal-group > * {
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.reveal-group.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay: 0ms; }
.reveal-group.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay: 80ms; }
.reveal-group.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay: 160ms; }
.reveal-group.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay: 240ms; }
.reveal-group.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay: 320ms; }
.reveal-group.visible > *:nth-child(6) { opacity:1; transform:none; transition-delay: 400ms; }

/* ── Feature card ── */
.feature-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--card-radius);
    padding: 36px 32px;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.feature-card:hover { border-color: rgba(107,198,48,0.4); }

/* ── Stats band — open Stripe-style layout ── */
.stats-band {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}
.stat-cell {
    padding: clamp(40px, 5vw, 64px) clamp(20px, 3vw, 48px);
    text-align: center;
    border-top: 1px solid var(--border);
    border-left: 1px solid var(--border);
}
.stat-cell:nth-child(-n+2) { border-top: 0; }
.stat-cell:nth-child(odd)  { border-left: 0; }
.stat-num {
    font-family: var(--head);
    font-size: clamp(52px, 6.5vw, 80px);
    font-weight: 800;
    letter-spacing: -0.05em;
    color: var(--forest);
    line-height: 1;
}
.stat-label {
    font-family: var(--font);
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin-top: 14px;
}
.stat-sub {
    font-family: var(--font);
    font-size: 13px;
    color: #9aa096;
    margin-top: 5px;
    line-height: 1.5;
}
@media (min-width: 1024px) {
    .stats-band { grid-template-columns: repeat(4, 1fr); }
    .stat-cell:nth-child(odd)   { border-left: 1px solid var(--border); }
    .stat-cell:nth-child(-n+4)  { border-top: 0; }
    .stat-cell:nth-child(4n+1)  { border-left: 0; }
}

/* ── How it works — steps ── */
.steps-grid {
    position: relative;
    display: grid;
    gap: 28px;
}
.steps-connector { display: none; }
.step-card {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--card-radius);
    padding: 32px 30px;
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
}
.step-card:hover {
    border-color: rgba(107,198,48,0.4);
}
.step-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}
.step-icon {
    position: relative;
    z-index: 1;
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--green-light);
    color: var(--green-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(107,198,48,0.22);
    transition: background 0.2s ease, color 0.2s ease;
}
.step-card:hover .step-icon { background: var(--green); color: var(--forest-deep); }
.step-num {
    font-family: 'General Sans', var(--font), sans-serif;
    font-size: 46px;
    font-weight: 800;
    line-height: 1;
    color: #eef1ea;
    letter-spacing: -0.04em;
}
@media (min-width: 768px) {
    .steps-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; }
    /* dashed progression line behind the step icons */
    .steps-connector {
        display: block;
        position: absolute;
        top: 58px;               /* aligns with icon centre (padding 32 + icon 26) */
        left: 16%;
        right: 16%;
        height: 2px;
        background-image: linear-gradient(90deg, rgba(107,198,48,0.45) 0 8px, transparent 8px 18px);
        background-size: 18px 2px;
        z-index: 0;
    }
}

/* ── Journey card ── */
.journey-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--card-radius);
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.journey-card:hover { border-color: rgba(107,198,48,0.4); }

/* ══ Who it's for — roles section ══ */
.roles-section {
    background: var(--forest-deep);
    margin: 0;
    border-radius: 0;
    overflow: hidden;
}
.roles-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 80px 40px 72px;
}
.roles-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.55);
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.roles-heading {
    font-family: var(--head);
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.03em;
    line-height: 1.08;
    margin: 0 0 60px;
}
.roles-header {
    text-align: center;
}
.roles-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    align-items: stretch;
}
/* ── The column is a padded "frame" holding two stacked cards ── */
.role-card {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 10px;
    background: rgba(255,255,255,0.02);
    border: 2px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    transition: border-color 0.2s ease, background 0.2s ease;
}
.role-card:hover {
    background: rgba(255,255,255,0.035);
    border-color: rgba(255,255,255,0.18);
}
.role-card .role-body { flex: 1; }
/* top card — the mockup */
.role-mockup {
    width: 100%;
    aspect-ratio: 16/9;
    overflow: hidden;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.07);
    background: rgba(0,0,0,0.2);
    position: relative;
}
/* map background mockups */
.rm-map-bg { background: #0e2318; }
.rm-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 32px 32px;
}
.rm-route-svg { position: absolute; inset: 0; width: 100%; height: 100%; }
/* booking card overlay */
.rm-ui-card {
    position: absolute; bottom: 16px; left: 16px;
    background: rgba(15,35,22,0.92);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px; padding: 14px; width: 200px;
    backdrop-filter: blur(8px);
}
.rm-ui-row { display: flex; align-items: center; gap: 10px; }
.rm-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.rm-ui-label { font-family: var(--font); font-size: 9px; color: rgba(255,255,255,0.4); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; }
.rm-ui-val { font-family: var(--font); font-size: 12px; color: rgba(255,255,255,0.9); font-weight: 600; margin-top: 1px; }
.rm-ui-divider { height: 1px; background: rgba(255,255,255,0.07); margin: 10px 0; }
.rm-ui-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 12px; }
.rm-ui-price { font-family: var(--font); font-size: 13px; font-weight: 700; color: var(--green); }
.rm-ui-btn { font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--forest-deep); background: var(--green); padding: 5px 12px; border-radius: 9999px; }
/* photo background (drivers card) */
.rm-photo-bg { background: #111; }
.rm-bg-photo { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: 42% 20%; filter: grayscale(1) contrast(1.05); opacity: 0.55; }
.rm-photo-overlay { position: absolute; inset: 0; background: linear-gradient(160deg, rgba(6,30,14,0.3) 0%, rgba(6,30,14,0.7) 100%); }
/* driver chip */
.rm-driver-chip {
    position: absolute; top: 16px; left: 16px;
    display: flex; align-items: center; gap: 10px;
    background: rgba(10,28,18,0.88);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px; padding: 10px 14px;
    backdrop-filter: blur(8px);
}
.rm-chip-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; filter: grayscale(1); object-position: 26% 20%; }
.rm-chip-name { font-family: var(--font); font-size: 12px; font-weight: 700; color: #fff; }
.rm-chip-badge { display: flex; align-items: center; gap: 5px; font-family: var(--font); font-size: 9px; font-weight: 700; color: var(--green); letter-spacing: 0.06em; margin-top: 2px; }
.rm-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); }
/* action bar */
.rm-action-bar { position: absolute; bottom: 16px; left: 16px; display: flex; gap: 8px; }
.rm-action-btn { display: inline-flex; align-items: center; gap: 6px; font-family: var(--font); font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.8); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12); border-radius: 9999px; padding: 7px 14px; }
.rm-action-call { background: rgba(107,198,48,0.2); border-color: rgba(107,198,48,0.4); color: var(--green); }
/* shipment panel */
.rm-shipment-panel {
    position: absolute; top: 16px; right: 16px;
    background: rgba(10,28,18,0.88);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px; padding: 12px 14px; width: 174px;
    backdrop-filter: blur(8px);
}
.rm-sp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.rm-sp-title { font-family: var(--font); font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.05em; }
.rm-sp-count { font-family: var(--font); font-size: 11px; font-weight: 700; color: var(--green); background: rgba(107,198,48,0.15); border-radius: 9999px; padding: 1px 8px; }
.rm-sp-row { display: flex; align-items: center; gap: 8px; padding: 5px 0; border-top: 1px solid rgba(255,255,255,0.06); }
/* bottom card — same width as the mockup; pulled down so its bottom overlaps the frame border */
.role-body {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    min-height: 230px;
    padding: 28px 24px 34px;
    border-radius: 0 0 8px 8px;
    background: #14311f;
    border: 1px solid rgba(255,255,255,0.09);
    margin: 0 0 -18px;
}
.role-title {
    font-family: var(--head);
    font-size: 22px;
    font-weight: 600;
    color: #fff;
    letter-spacing: -0.02em;
    margin: 0 0 10px;
}
.role-desc {
    font-family: var(--font);
    font-size: 14.5px;
    color: rgba(255,255,255,0.55);
    line-height: 1.65;
    margin: 0 0 24px;
}
.role-link {
    display: inline-flex;
    align-self: flex-start;
    align-items: center;
    gap: 6px;
    margin-top: auto;
    font-family: var(--font);
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    padding-left: 14px;
    border-left: 2px solid rgba(255,255,255,0.18);
    transition: gap 0.2s ease, border-color 0.2s ease;
}
.role-link:hover { gap: 10px; border-left-color: var(--green); }
@media (max-width: 900px) {
    .roles-grid { grid-template-columns: 1fr; }
    .roles-inner { padding: 56px 24px 48px; }
}

/* ══ Why Nhume — Trackeo about bento (exact structure) ══ */
.why-bento {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.why-card {
    background: var(--white);
    border-radius: 8px;
    padding: 24px;
    display: flex;
    flex-direction: column;
}
.why-c1     { grid-column: 1; grid-row: 1 / 4; justify-content: space-between; }
.why-c2-top { grid-column: 2; grid-row: 1; flex-direction: row; align-items: center; }
.why-c2-mid { grid-column: 2; grid-row: 2; gap: 6px; }
.why-c3     { grid-column: 3; grid-row: 1 / 3; }
.why-bot    { grid-column: 2 / 4; grid-row: 3; flex-direction: row; align-items: center; gap: 16px; }
.why-logo-wrap {
    width: 46px; height: 46px; border-radius: 50%;
    background: #f0ede6;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px; flex-shrink: 0;
}
.why-name { font-family: var(--head); font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: var(--forest); margin: 0 0 10px; }
.why-desc { font-family: var(--font); font-size: 14.5px; line-height: 1.68; color: var(--text-2); flex: 1; }
.why-cta { display: inline-flex; align-items: center; gap: 6px; font-family: var(--font); font-size: 14px; font-weight: 600; color: var(--forest); text-decoration: none; margin-top: 28px; transition: gap 0.18s; }
.why-cta:hover { gap: 10px; }
.why-stat-title { font-family: var(--head); font-size: 15px; font-weight: 600; color: var(--forest); letter-spacing: -0.01em; }
.why-stat-sub { font-family: var(--font); font-size: 12.5px; color: #9aa096; margin-top: 3px; }
.why-badges { display: flex; gap: 7px; margin-left: auto; }
.why-badge-ic { width: 30px; height: 30px; border-radius: 50%; background: #f0ede6; display: flex; align-items: center; justify-content: center; }
.why-big { font-family: var(--head); font-size: clamp(46px, 5.5vw, 72px); font-weight: 600; letter-spacing: -0.04em; line-height: 1; color: var(--forest); margin-top: 6px; }
.why-person-img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; object-position: 26% 20%; flex-shrink: 0; }
.why-person-name { font-family: var(--head); font-size: 15px; font-weight: 600; color: var(--forest); }
.why-person-role { font-family: var(--font); font-size: 12.5px; color: #9aa096; margin-top: 2px; }
.why-soc { display: flex; gap: 20px; margin-left: auto; align-items: center; }
.why-soc svg { color: #b3b8b0; transition: color 0.18s; }
.why-soc a:hover svg { color: var(--forest); }
@media (max-width: 860px) {
    .why-bento { grid-template-columns: 1fr 1fr; }
    .why-c1 { grid-column: 1 / -1; grid-row: auto; }
    .why-c2-top { grid-column: 1; grid-row: auto; }
    .why-c2-mid { grid-column: 1; grid-row: auto; }
    .why-c3 { grid-column: 2; grid-row: auto; }
    .why-bot { grid-column: 1 / -1; grid-row: auto; }
}
@media (max-width: 540px) {
    .why-bento { grid-template-columns: 1fr; }
    .why-c3 { grid-column: 1; }
    .why-bot { flex-direction: column; align-items: flex-start; }
    .why-soc { margin-left: 0; margin-top: 12px; }
}
@media (max-width: 540px) {
    .roles-section { margin: 0; }
}

/* ══════════════════════════════════════════
   RESPONSIVE — section-level grids
══════════════════════════════════════════ */

/* Routes 3-card grid */
.routes-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 52px;
}
@media (max-width: 900px) { .routes-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .routes-grid { grid-template-columns: 1fr; } }

/* Routes heading row */
.routes-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
    margin-bottom: 52px;
}
@media (max-width: 700px) {
    .routes-head { align-items: flex-start; flex-direction: column; gap: 16px; }
}

/* Testimonials top (heading + photo) */
.testimonials-top {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    margin-bottom: 64px;
}
@media (max-width: 768px) {
    .testimonials-top { grid-template-columns: 1fr; }
    .testimonials-top > div:last-child { display: none; } /* hide photo on mobile */
}

/* Testimonials 2-column grid */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}
@media (max-width: 640px) { .testimonials-grid { grid-template-columns: 1fr; } }

/* FAQ two-column */
.faq-layout {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 80px;
    align-items: start;
    margin-bottom: 48px;
}
@media (max-width: 860px) {
    .faq-layout { grid-template-columns: 1fr; gap: 36px; }
    .faq-sticky  { position: static !important; }
}

/* Transporter section */
.transporter-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
}
@media (max-width: 768px) {
    .transporter-grid { grid-template-columns: 1fr; }
    .transporter-photo { min-height: 320px; }
}

/* CTA hero scene — hide on small screens */
@media (max-width: 640px) {
    .cta-scene { display: none; }
}

/* General mobile spacing */
@media (max-width: 640px) {
    :root { --section-y: 64px; }
    .nav-outer { top: 10px !important; left: 8px !important; right: 8px !important; }
}

/* Mobile text adjustments */
@media (max-width: 480px) {
    .section-title  { font-size: clamp(26px, 7vw, 36px); }
    .roles-heading  { font-size: clamp(26px, 7vw, 36px); }
    .why-big        { font-size: clamp(38px, 10vw, 56px); }
}

/* Testimonials card border on dark bg */
@media (max-width: 580px) {
    .testimonials-grid > div { border-radius: 12px; }
}

/* FAQ bottom bar stack */
@media (max-width: 560px) {
    .faq-layout + div { flex-direction: column; align-items: flex-start; }
}

/* Journey card CTA — matches hero submit */
.journey-book {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    background: var(--green-light);
    color: var(--forest);
    font-family: var(--font);
    font-size: 13.5px;
    font-weight: 600;
    padding: 11px;
    border-radius: 10px;
    border: 1px solid rgba(107,198,48,0.3);
    text-decoration: none;
    transition: background 0.18s, color 0.18s, border-color 0.18s, transform 0.18s;
}
.journey-book svg { transition: transform 0.18s; }
.journey-book:hover {
    background: var(--forest);
    color: #fff;
    border-color: var(--forest);
    transform: translateY(-1px);
}
.journey-book:hover svg { transform: translateX(3px); }

/* ── Trust tier ── */
.tier-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--card-radius);
    padding: 28px;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.tier-card:hover { border-color: rgba(107,198,48,0.4); }
.tier-featured { border-color: rgba(107,198,48,0.55); }
.tier-featured:hover { border-color: var(--green); }

/* ── Route pill ── */
.route-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
    font-size: 14px;
    font-weight: 500;
    color: var(--text-2);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 9999px;
    padding: 10px 20px;
    transition: border-color 0.18s, color 0.18s, box-shadow 0.18s, transform 0.18s;
    cursor: default;
}
.route-pill:hover {
    border-color: rgba(107,198,48,0.5);
    color: var(--text);
    box-shadow: 0 4px 14px rgba(28,56,41,0.06);
    transform: translateY(-1px);
}
.route-pill-more {
    color: var(--green-mid);
    background: var(--green-light);
    border-color: rgba(107,198,48,0.28);
    font-weight: 600;
}

/* ── FAQ item ── */
.faq-item {
    border: 1px solid #eef0ec;
    border-radius: 14px;
    overflow: hidden;
    background: var(--white);
    transition: border-color 0.18s, box-shadow 0.18s;
}
.faq-item:hover { border-color: #dfe3da; box-shadow: 0 4px 16px rgba(28,56,41,0.05); }

/* ── Testimonial card ── */
.testimonial-card {
    position: relative;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--card-radius);
    padding: 34px 30px 26px;
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
}
.testimonial-card:hover {
    border-color: rgba(107,198,48,0.35);
}
.quote-mark {
    position: absolute;
    top: 6px;
    right: 22px;
    font-family: 'General Sans', var(--font), serif;
    font-size: 96px;
    line-height: 1;
    font-weight: 800;
    color: var(--green-light);
    pointer-events: none;
    z-index: 0;
}

/* ── Footer ── */
.site-footer::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(107,198,48,0.5), transparent);
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1fr;
    gap: 40px;
}
.footer-social {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.18s, border-color 0.18s, transform 0.18s;
}
.footer-social svg { fill: rgba(255,255,255,0.45); transition: fill 0.18s; }
.footer-social:hover {
    background: rgba(107,198,48,0.16);
    border-color: rgba(107,198,48,0.35);
    transform: translateY(-2px);
}
.footer-social:hover svg { fill: var(--green); }
@media (max-width: 860px) {
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px 24px; }
    .footer-grid > div:first-child { grid-column: 1 / -1; }
}
@media (max-width: 520px) {
    .footer-grid { grid-template-columns: 1fr; }
}

/* ── FAQ ── */
.faq-body {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.3s ease;
}
.faq-body.open { grid-template-rows: 1fr; }
.faq-inner { overflow: hidden; }

/* ── Nav: transparent at top, frosted full-width on scroll ── */
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
    top: 0;
    left: 0;
    right: 0;
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
    padding: clamp(16px,2vh,24px) clamp(20px,3vw,40px);
}
.nav-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    flex-shrink: 0;
}

/* centered links group */
.nav-center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 2px;
    pointer-events: all;
    background: rgba(255,255,255,0.88);
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 8px;
    padding: 6px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.nav-right {
    display: flex;
    align-items: center;
    gap: 8px;
    pointer-events: all;
}

/* Nav link (pill on hover) */
.nav-link {
    display: inline-flex;
    align-items: center;
    font-size: 14px;
    font-weight: 500;
    color: var(--text-2);
    padding: 13px 16px;
    border-radius: 6px;
    transition: color 0.15s, background 0.15s;
    text-decoration: none;
    white-space: nowrap;
}
.nav-link:hover { color: var(--text); background: rgba(0,0,0,0.05); }

/* Flat pill CTA buttons — nav */
.btn-nav-outline {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font);
    font-size: 14px;
    font-weight: 600;
    color: var(--forest);
    padding: 11px 20px;
    border-radius: 6px;
    border: 1px solid rgba(12,26,15,0.08);
    background: rgba(255,255,255,0.75);
    box-shadow: none;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    white-space: nowrap;
}
.btn-nav-outline:hover { background: #fff; transform: translateY(-1px); }
.nav-outer.is-scrolled .btn-nav-outline { background: rgba(255,255,255,0.9); }

.btn-nav-fill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 14px;
    font-weight: 600;
    color: var(--forest-deep);
    padding: 11px 22px;
    border-radius: 6px;
    border: none;
    background: var(--green);
    text-decoration: none;
    transition: background 0.15s;
    white-space: nowrap;
}
.btn-nav-fill:hover { background: var(--green-dark); }

/* Mobile dropdown card */
.nav-mobile-dropdown {
    position: fixed;
    top: 84px;
    left: 20px;
    right: 20px;
    z-index: 99;
    background: #fff;
    border-radius: 8px;
    border: 1px solid rgba(12,26,15,0.08);
    box-shadow: 0 12px 36px rgba(28,56,41,0.12);
    padding: 16px;
}

/* Mobile menu button — flat white pill */
.nav-mobile-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 9999px;
    background: #fff;
    border: 1px solid rgba(12,26,15,0.08);
    box-shadow: 0 4px 16px rgba(28,56,41,0.06);
    color: var(--text);
    pointer-events: all;
}

/* Responsive show/hide */
.nav-desktop { display: none; }
@media (min-width: 1024px) {
    .nav-desktop    { display: flex; }
    .nav-mobile-btn { display: none; }
}

/* ── Hero responsive ── */
.hero-form {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 1160px;
    margin: 0 auto;
    margin-bottom: -40px;
    background: #fff;
    border-radius: 9999px;
    box-shadow: 0 24px 80px rgba(6,46,20,0.18), 0 8px 24px rgba(6,46,20,0.1), 0 2px 6px rgba(0,0,0,0.06);
    padding: 10px;
    border: 1px solid rgba(6,46,20,0.13);
}
.hero-form-field {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    min-width: 0;
}
.hero-form-divider { border-right: 1px solid var(--border); }
.hero-form-swap { padding: 0 10px; flex-shrink: 0; }
.hero-form-btn {
    flex-shrink: 0;
    background: var(--green);
    color: var(--forest-deep);
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 700;
    padding: 18px 36px;
    border-radius: 9999px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    letter-spacing: 0.01em;
    transition: background 0.15s, transform 0.15s;
}
.hero-form-btn:hover { background: var(--green-dark); transform: translateY(-1px); }

@media (max-width: 700px) {
    .hero-form { flex-direction: column; gap: 0; border-radius: 24px; padding: 8px; }
    .hero-form-field { width: 100%; border-right: none !important; padding: 10px 14px; }
    .hero-form-divider { border-right: none; border-bottom: 1px solid var(--border); }
    .hero-form-swap { display: none; }
    .hero-form-btn { width: 100%; justify-content: center; border-radius: 10px; padding: 14px 24px; margin-top: 4px; }
}

/* ══ Hero form card ══ */
.hero-card {
    background: #fff;
    border-radius: 22px;
    box-shadow:
        0 28px 64px rgba(6,46,20,0.14),
        0 8px 20px rgba(6,46,20,0.06),
        0 1px 2px rgba(0,0,0,0.04),
        inset 0 1px 0 rgba(255,255,255,0.6);
    border: 1px solid #ebe8e2;
    overflow: hidden;
    position: relative;
}
/* subtle brand accent line across the top */
.hero-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--green) 0%, var(--green-dark) 55%, var(--forest) 100%);
    opacity: 0.9;
}
.hero-card-head {
    padding: 24px 24px 0;
    background: linear-gradient(180deg, #fcfdfa 0%, #ffffff 100%);
}
.hero-card-body { padding: 22px 24px 24px; }

/* Panels are stacked in one grid cell so the card height never jumps
   between tabs; the inactive panel keeps its space (visibility:hidden)
   and both cross-fade smoothly. */
.hero-panels { display: grid; }
.hero-panel {
    grid-area: 1 / 1;
    opacity: 0;
    visibility: hidden;
    transform: translateY(6px);
    transition: opacity 0.28s cubic-bezier(0.4,0,0.2,1),
                transform 0.28s cubic-bezier(0.4,0,0.2,1),
                visibility 0.28s;
    pointer-events: none;
}
.hero-panel.is-active {
    opacity: 1;
    visibility: visible;
    transform: none;
    pointer-events: auto;
    transition-delay: 0.06s; /* let the outgoing panel start fading first */
}
@media (prefers-reduced-motion: reduce) {
    .hero-panel { transition: opacity 0.15s linear, visibility 0.15s; transform: none; }
}

/* ── Segmented tabs ── */
.hero-tabs {
    position: relative;
    display: flex;
    background: #f0efe9;
    border: 1px solid #e6e3db;
    border-radius: 12px;
    padding: 4px;
    transform: translateY(1px);
}
.hero-tab-glider {
    position: absolute;
    top: 4px;
    left: 4px;
    width: calc(50% - 4px);
    height: calc(100% - 8px);
    background: #fff;
    border-radius: 9px;
    box-shadow: 0 1px 3px rgba(12,26,15,0.12), 0 1px 1px rgba(0,0,0,0.04), inset 0 0 0 1px rgba(0,0,0,0.02);
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
    z-index: 1;
}
.hero-tab {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 13.5px;
    font-weight: 600;
    padding: 10px 12px;
    border: none;
    background: transparent;
    color: #8a8f88;
    cursor: pointer;
    border-radius: 9px;
    transition: color 0.2s ease;
    -webkit-tap-highlight-color: transparent;
}
.hero-tab svg { color: #b3b8b0; transition: color 0.2s ease; }
.hero-tab.is-active { color: #0c1a0f; }
.hero-tab.is-active svg { color: var(--green-mid); }
.hero-tab:not(.is-active):hover { color: #5c6459; }

/* ── Inputs ── */
.hero-label {
    display: block;
    font-family: var(--font);
    font-size: 12px;
    font-weight: 600;
    color: #3d4a3a;
    margin: 0 0 8px;
    letter-spacing: 0.01em;
}
.hero-input {
    width: 100%;
    font-family: var(--font);
    font-size: 14px;
    color: #111;
    background: #f8f7f2;
    border: 1.5px solid #e4e1db;
    border-radius: 11px;
    padding: 13px 14px;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
}
.hero-input::placeholder { color: #a7ada3; }
.hero-input.is-focus,
.hero-input:focus {
    border-color: var(--green);
    background: #fff;
    box-shadow: 0 0 0 3.5px rgba(107,198,48,0.14);
}
.hero-select {
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    padding-right: 32px;
}

/* ── Submit button ── */
.hero-submit {
    margin-top: 16px;
    width: 100%;
    background: var(--green);
    color: var(--forest-deep);
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 700;
    padding: 15px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    letter-spacing: 0.01em;
    transition: background 0.18s;
}
.hero-submit:hover {
    background: var(--green-dark);
}
.hero-submit:active { transform: translateY(0); }

/* ── Reassurance note ── */
.hero-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-family: var(--font);
    font-size: 11.5px;
    color: #9aa096;
    text-align: center;
    margin: 14px 0 0;
    font-weight: 500;
}

/* Keep the headline's first line unbroken on larger screens (2-line headline) */
.h1-nowrap { white-space: nowrap; }
@media (max-width: 640px) { .h1-nowrap { white-space: normal; } }

/* ══ Hero CTAs ══ */
.hero-cta-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 22px;
}
.hero-cta-btns {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
}
.hero-cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-family: var(--font);
    font-size: 15.5px;
    font-weight: 700;
    color: var(--forest-deep);
    background: var(--green);
    border: none;
    border-radius: 14px;
    padding: 16px 32px;
    text-decoration: none;
    transition: background 0.18s, transform 0.18s;
}
.hero-cta-primary:hover { background: var(--green-dark); transform: translateY(-1px); }
.hero-cta-secondary {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-family: var(--font);
    font-size: 15.5px;
    font-weight: 600;
    color: var(--forest);
    background: #fff;
    border: 1.5px solid rgba(28,56,41,0.12);
    border-radius: 14px;
    padding: 15px 32px;
    text-decoration: none;
    transition: border-color 0.18s, transform 0.18s;
}
.hero-cta-secondary:hover { border-color: var(--green-mid); transform: translateY(-1px); }

/* trust chips */
.hero-trust-chips {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}
.hero-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font);
    font-size: 13px;
    font-weight: 500;
    color: #6b7168;
}
.hero-chip svg { color: var(--green-mid); }
.hero-chip-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #c8cbc6;
    flex-shrink: 0;
}
@media (max-width: 480px) {
    .hero-chip-dot { display: none; }
    .hero-trust-chips { gap: 12px 8px; }
}

/* ══════════════════════════════════════════════
   CINEMATIC HERO — full-bleed rider photo, graded
══════════════════════════════════════════════ */
.hero-cine {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    min-height: 92svh;
    display: flex;
    align-items: center;
    isolation: isolate;
}
.hero-cine-media {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: 66% center;
    z-index: -2;
}
.hero-cine-scrim {
    position: absolute; inset: 0;
    z-index: -1;
    background:
        linear-gradient(90deg, rgba(6,46,20,0.95) 0%, rgba(6,46,20,0.82) 30%, rgba(6,46,20,0.32) 58%, rgba(6,46,20,0) 80%),
        linear-gradient(0deg, rgba(6,46,20,0.58) 0%, rgba(6,46,20,0) 44%),
        linear-gradient(0deg, rgba(28,56,41,0.26), rgba(28,56,41,0.26));
}
.hero-cine-inner {
    position: relative;
    max-width: 1240px;
    width: 100%;
    margin: 0 auto;
    padding: clamp(150px,21vh,230px) clamp(24px,5vw,64px) clamp(56px,8vh,96px);
}
.hero-cine-eyebrow {
    display: inline-block;
    font-family: var(--font); font-size: 12px; font-weight: 700;
    letter-spacing: 0.16em; text-transform: uppercase;
    color: #8ed64a;
    margin-bottom: 22px;
}
.hero-cine-h1 {
    font-family: var(--head);
    font-size: clamp(38px,5.4vw,60px);
    font-weight: 800; letter-spacing: -0.04em; line-height: 1.05;
    color: #fff; margin: 0 0 22px; max-width: 1040px;
}
.hero-cine-sub {
    font-family: var(--font);
    font-size: clamp(16px,1.5vw,19px);
    color: rgba(255,255,255,0.74); line-height: 1.6;
    max-width: 500px; margin: 0 0 34px;
}
.hero-cine-cta { display: flex; align-items: center; gap: 26px; flex-wrap: wrap; margin-bottom: 30px; }
.hero-cine-textlink {
    display: inline-flex; align-items: center; gap: 7px;
    font-family: var(--font); font-size: 15.5px; font-weight: 600;
    color: #fff; background: none; border: none; cursor: pointer;
    padding: 0; text-decoration: none;
    border-bottom: 1.5px solid rgba(255,255,255,0.35);
    padding-bottom: 3px;
    transition: border-color 0.18s;
}
.hero-cine-textlink:hover { border-color: #fff; }
.hero-cine-served {
    font-family: var(--font); font-size: 14px; font-weight: 500;
    color: rgba(255,255,255,0.6); margin: 0;
}
.hero-cine-served strong { color: rgba(255,255,255,0.9); font-weight: 600; }
.hero-cta-ghost {
    display: inline-flex; align-items: center; gap: 9px;
    font-family: var(--font); font-size: 15.5px; font-weight: 600;
    color: #fff; background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.32);
    border-radius: 14px; padding: 15px 30px;
    text-decoration: none; cursor: pointer;
    transition: background 0.18s, border-color 0.18s, transform 0.18s;
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
}
.hero-cta-ghost:hover { background: rgba(255,255,255,0.16); border-color: rgba(255,255,255,0.55); transform: translateY(-1px); }
.hero-cine-trust { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.hct-item { display: inline-flex; align-items: center; gap: 7px; font-family: var(--font); font-size: 13.5px; font-weight: 500; color: rgba(255,255,255,0.85); }
.hct-item svg { color: #8ed64a; flex-shrink: 0; }
.hct-sep { width: 4px; height: 4px; border-radius: 50%; background: rgba(255,255,255,0.32); flex-shrink: 0; }
@media (max-width: 760px) {
    .hero-cine { min-height: 86svh; }
    .hero-cine-media { object-position: 60% center; }
    .hero-cine-scrim {
        background:
            linear-gradient(0deg, rgba(6,46,20,0.96) 0%, rgba(6,46,20,0.62) 46%, rgba(6,46,20,0.38) 100%),
            linear-gradient(0deg, rgba(28,56,41,0.22), rgba(28,56,41,0.22));
    }
    .hero-cine-inner { padding-top: clamp(120px,15vh,160px); }
}

/* ══ Hero tabbed form ══ */
.htf-wrap {
    width: 100%;
    max-width: 680px;
    margin: 0 auto;
}

/* tab switcher above the card */
.htf-tabs {
    position: relative;
    display: inline-flex;
    background: rgba(28,56,41,0.07);
    border-radius: 14px 14px 0 0;
    padding: 5px 5px 0;
    gap: 2px;
    margin-bottom: -2px;
}
.htf-glider {
    position: absolute;
    top: 5px;
    left: 5px;
    width: calc(50% - 5px);
    height: calc(100% - 5px);
    background: #fff;
    border-radius: 10px 10px 0 0;
    transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
    z-index: 1;
}
.htf-tab {
    position: relative;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 13.5px;
    font-weight: 600;
    color: #8a8f88;
    padding: 11px 22px;
    border: none;
    background: transparent;
    cursor: pointer;
    border-radius: 10px 10px 0 0;
    transition: color 0.2s;
    white-space: nowrap;
}
.htf-tab svg { color: #b3b8b0; transition: color 0.2s; }
.htf-tab.is-active { color: var(--forest); }
.htf-tab.is-active svg { color: var(--green-mid); }

/* form card — flat, no shadow */
.htf-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: none;
    border: 1px solid rgba(28,56,41,0.08);
    padding: 20px 22px;
}

.htf-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 14px;
    flex-wrap: wrap;
    gap: 10px;
}
.htf-send-cta {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-family: var(--font);
    font-size: 14px;
    font-weight: 600;
    color: var(--forest);
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 12px;
    border: 1.5px solid rgba(28,56,41,0.18);
    background: rgba(255,255,255,0.7);
    transition: background 0.18s, border-color 0.18s, transform 0.18s;
}
.htf-send-cta:hover {
    background: #fff;
    border-color: var(--green-mid);
    transform: translateY(-1px);
}

/* fields row */
.htf-fields {
    display: flex;
    align-items: flex-end;
    gap: 10px;
    flex-wrap: wrap;
}
.htf-field-group { flex: 1; min-width: 120px; }
.htf-label {
    display: block;
    font-family: var(--font);
    font-size: 11.5px;
    font-weight: 600;
    color: #5c6459;
    margin-bottom: 7px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

/* select */
.htf-select-wrap {
    position: relative;
    border: 1.5px solid #e4e1db;
    border-radius: 12px;
    background: var(--shade);
    transition: border-color 0.15s, box-shadow 0.15s;
}
.htf-select-wrap.is-focus {
    border-color: var(--green-mid);
    box-shadow: 0 0 0 3px rgba(74,154,31,0.12);
}
.htf-select {
    width: 100%;
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 500;
    color: var(--text);
    background: transparent;
    border: none;
    outline: none;
    padding: 13px 36px 13px 14px;
    appearance: none;
    cursor: pointer;
}
.htf-caret {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

/* text input */
.htf-input-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1.5px solid #e4e1db;
    border-radius: 12px;
    background: var(--shade);
    padding: 0 14px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.htf-input-wrap.is-focus {
    border-color: var(--green-mid);
    box-shadow: 0 0 0 3px rgba(74,154,31,0.12);
}
.htf-input {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    background: transparent;
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 500;
    color: var(--text);
    padding: 13px 0;
}
.htf-input::placeholder { color: #a7ada3; }

/* swap button */
.htf-swap {
    flex-shrink: 0;
    width: 38px; height: 38px;
    border-radius: 50%;
    background: var(--green-light);
    border: 1px solid rgba(107,198,48,0.25);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 2px;
    transition: background 0.15s, transform 0.25s ease;
}
.htf-swap:hover { background: #dcefc7; }

/* CTA button */
.htf-btn {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
    font-size: 14.5px;
    font-weight: 700;
    color: var(--forest-deep);
    background: var(--green);
    border: none;
    border-radius: 12px;
    padding: 14px 26px;
    cursor: pointer;
    white-space: nowrap;
    box-shadow: none;
    transition: background 0.18s, transform 0.18s;
    margin-bottom: 2px;
}
.htf-btn:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

.htf-note {
    font-family: var(--font);
    font-size: 12px;
    color: #9aa096;
    text-align: center;
    margin: 14px 0 0;
    font-weight: 500;
}

@media (max-width: 640px) {
    .htf-fields { flex-direction: column; }
    .htf-swap { transform: rotate(90deg); }
    .htf-field-group { width: 100%; }
    .htf-btn { width: 100%; justify-content: center; }
    .htf-tab { padding: 10px 14px; font-size: 12.5px; }
}

/* ══ Hero (centered) — inline form ══ */
.hero2-form {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: stretch;
    max-width: 520px;
    margin: 0 auto;
    flex-wrap: wrap;
}
.hero2-field {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 240px;
    background: #fff;
    border: 1.5px solid #e4e1db;
    border-radius: 14px;
    padding: 0 16px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.hero2-field:focus-within {
    border-color: var(--green);
    box-shadow: 0 0 0 3.5px rgba(107,198,48,0.14);
}
.hero2-input {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    background: transparent;
    font-family: var(--font);
    font-size: 15px;
    color: #111;
    padding: 15px 0;
}
.hero2-input::placeholder { color: #9aa096; }
.hero2-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--forest);
    color: #fff;
    font-family: var(--font);
    font-size: 15px;
    font-weight: 600;
    padding: 0 26px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    box-shadow: 0 10px 24px rgba(6,46,20,0.2);
    transition: background 0.18s, transform 0.18s, box-shadow 0.18s;
}
.hero2-btn:hover { background: var(--forest-deep); transform: translateY(-1px); box-shadow: 0 14px 30px rgba(6,46,20,0.26); }

/* ══ Hero scene ══ */
.hero-scene {
    position: relative;
    width: 100%;
    max-width: 960px;
    margin: clamp(20px,3vh,44px) auto 0;
    flex: 0 0 auto;
    z-index: 0;
    display: flex;
    justify-content: center;
}

/* ── Single-photo hero — a real Nhume GO rider ── */
.hero-photo-wrap {
    position: relative;
    width: 100%;
    max-width: 920px;
}
.hero-photo-wrap::before {
    content: "";
    position: absolute;
    inset: -6% -4% -10%;
    background: radial-gradient(58% 58% at 50% 46%, rgba(107,198,48,0.20), transparent 72%);
    z-index: 0;
    pointer-events: none;
}
.hero-photo {
    position: relative;
    z-index: 1;
    aspect-ratio: 16 / 9;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 44px 84px -34px rgba(6,46,20,0.38),
                0 14px 32px -20px rgba(6,46,20,0.22);
    border: 1px solid rgba(255,255,255,0.6);
}
.hero-photo img {
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
}
.hero-accent {
    position: absolute;
    z-index: 2;
    left: -20px; bottom: 28px;
    background: #fdfcfb;
    border: 1px solid #edece7;
    border-radius: 15px;
    box-shadow: 0 26px 50px -22px rgba(6,46,20,0.30),
                0 8px 18px -12px rgba(6,46,20,0.16);
    padding: 13px 15px;
    width: max-content;
    max-width: 220px;
    animation: floatA 7.5s cubic-bezier(0.45,0,0.55,1) infinite;
}
@media (max-width: 640px) {
    .hero-photo { aspect-ratio: 4 / 3; border-radius: 16px; }
    .hero-accent { left: 8px; bottom: 10px; transform: scale(0.88); transform-origin: left bottom; }
}
@media (max-width: 380px) { .hero-accent { display: none; } }
.cta-scene, .cta-scene:hover { opacity: 0.45; }
.cta-scene .scene-card { opacity: 0.85; }
/* form card sits above the scene */
.htf-wrap { position: relative; z-index: 2; }
.scene-globe {
    position: absolute;
    left: 50%; top: 50%;
    transform: translate(-50%, -50%);
    width: clamp(600px, 94%, 1000px);
    height: auto;
    pointer-events: none;
    z-index: 0;
}
.scene-route {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}
.scene-van {
    position: absolute;
    left: 50%; top: 54%;
    width: clamp(140px, 18vw, 210px);
    height: auto;
    z-index: 2;
    transform: translate(-50%, -50%);
    animation: vanfloat 6s ease-in-out infinite;
}
@keyframes vanfloat {
    0%,100% { transform: translate(-50%, -50%); }
    50%     { transform: translate(-50%, -58%); }
}
.scene-pin {
    position: absolute;
    z-index: 3;
    display: flex; align-items: center; justify-content: center;
    filter: drop-shadow(0 8px 10px rgba(6,46,20,0.25));
}
.scene-pin-depot { right: 19%; bottom: 22%; }
.scene-pin-pulse {
    position: absolute;
    bottom: 4px; left: 50%;
    width: 14px; height: 14px;
    margin-left: -7px;
    border-radius: 50%;
    background: rgba(107,198,48,0.5);
    animation: ping 1.8s cubic-bezier(0,0,0.2,1) infinite;
}
/* scene cards — flat, faded */
.scene-card {
    position: absolute;
    z-index: 4;
    background: #fdfcfb;               /* a hair of warmth so they sit in the scene */
    border: 1px solid #edece7;
    border-radius: 15px;
    /* soft, diffuse shadow — resting on light rather than punching out */
    box-shadow: 0 30px 60px -22px rgba(28,56,41,0.09),
                0 12px 28px -18px rgba(28,56,41,0.05);
    padding: 13px 15px;
    padding-bottom: 0;
    opacity: 1;
    width: max-content;
    max-width: 212px;
    animation-timing-function: cubic-bezier(0.45, 0, 0.55, 1);
    animation-iteration-count: infinite;
    will-change: transform;
}
/* Spread across the scene — balanced, airy composition */
.sc-status { top: 6%;     left: 3%;   animation-name: floatA; animation-duration: 7.5s; animation-delay: -0.4s; }
.sc-driver { top: 14%;    right: 4%;  display: flex; align-items: center; gap: 11px; animation-name: floatC; animation-duration: 7.9s; animation-delay: -3.6s; }
.sc-order  { bottom: 14%; left: 8%;   display: flex; align-items: center; gap: 11px; animation-name: floatB; animation-duration: 8.6s; animation-delay: -2.3s; z-index: 5; }
.sc-pickup { bottom: 9%;  right: 6%;  animation-name: floatA; animation-duration: 9.2s; animation-delay: -1.1s; }

/* organic, non-synced drift + micro-rotation — a subtle human touch */
@keyframes floatA {
    0%   { transform: translate(0, 0) rotate(0deg); }
    30%  { transform: translate(3px, -9px) rotate(-0.7deg); }
    60%  { transform: translate(-3px, -4px) rotate(0.5deg); }
    100% { transform: translate(0, 0) rotate(0deg); }
}
@keyframes floatB {
    0%   { transform: translate(0, 0) rotate(0deg); }
    35%  { transform: translate(-5px, -11px) rotate(0.8deg); }
    68%  { transform: translate(3px, -5px) rotate(-0.5deg); }
    100% { transform: translate(0, 0) rotate(0deg); }
}
@keyframes floatC {
    0%   { transform: translate(0, 0) rotate(0deg); }
    40%  { transform: translate(5px, -8px) rotate(-0.6deg); }
    72%  { transform: translate(-2px, -3px) rotate(0.7deg); }
    100% { transform: translate(0, 0) rotate(0deg); }
}
/* twinkle sparkles */
.scene-sparkle {
    position: absolute;
    z-index: 5;
    color: var(--green-mid);
    pointer-events: none;
    animation: twinkle 3.2s ease-in-out infinite;
}
.sparkle-a { top: 4%;    right: 30%; }
.sparkle-b { bottom: 26%; left: 23%; animation-delay: -1.5s; }
@keyframes twinkle {
    0%,100% { transform: scale(0.55) rotate(0deg); opacity: 0.3; }
    50%     { transform: scale(1) rotate(18deg); opacity: 0.95; }
}

.sc-row { display: flex; align-items: center; }
.sc-ic {
    width: 26px; height: 26px; border-radius: 8px;
    background: var(--green-light); color: var(--green-mid);
    display: flex; align-items: center; justify-content: center;
    margin-right: 9px; flex-shrink: 0;
}
.sc-title { font-family: var(--font); font-size: 13px; font-weight: 700; color: #0c1a0f; }
.sc-tag {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: var(--font); font-size: 11px; font-weight: 600;
    color: var(--green-mid); background: var(--green-light);
    border: 1px solid rgba(107,198,48,0.28);
    padding: 3px 10px; border-radius: 9999px;
}
.sc-tag::before { content: ""; width: 5px; height: 5px; border-radius: 50%; background: var(--green); }
.sc-avatar {
    width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-family: var(--font); font-size: 11px; font-weight: 700;
    flex-shrink: 0;
}
.sc-avatar-lg { width: 38px; height: 38px; font-size: 13px; }

/* circular grayscale photo avatar */
.sc-photo-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    display: block;
    box-shadow: inset 0 0 0 1px rgba(28,56,41,0.08);
}
.sc-photo-avatar img {
    width: 100%; height: 100%;
    object-fit: cover;
    filter: grayscale(1) contrast(1.03);
    display: block;
}

/* portrait photo card (John Smith pattern) */
.sc-photo {
    display: block;
    padding: 5px;
    overflow: visible;
}
.sc-photo-img {
    display: block;
    width: 104px;
    height: 128px;
    object-fit: cover;
    border-radius: 12px;
    filter: grayscale(1) contrast(1.03);
}
.sc-photo-tag {
    position: absolute;
    left: -16px;
    top: 32%;
    transform: translateY(-50%);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #fff;
    border: 1px solid #e8e5df;
    box-shadow: none;
    border-radius: 9999px;
    padding: 6px 12px;
    font-family: var(--font);
    font-size: 12px;
    font-weight: 700;
    color: #0c1a0f;
    white-space: nowrap;
}
.sc-strong { font-family: var(--font); font-size: 13px; font-weight: 700; color: #0c1a0f; margin: 0; }
.sc-sub { font-family: var(--font); font-size: 11.5px; color: #8a8f88; margin: 2px 0 0; }
.sc-review { display: inline-flex; align-items: center; gap: 4px; font-family: var(--font); font-size: 10.5px; font-weight: 600; color: var(--green-mid); margin-top: 3px; }

@media (max-width: 920px) {
    .scene-card, .scene-route, .scene-pin-depot, .scene-sparkle { display: none; }
    .hero-scene { min-height: 200px; margin-top: 12px; }
    .scene-globe { width: clamp(320px, 90vw, 520px); }
    .scene-van { width: clamp(180px, 46vw, 260px); }
}
@media (prefers-reduced-motion: reduce) {
    .scene-van, .scene-card, .scene-pin-pulse, .scene-sparkle, .hero-accent { animation: none; }
    .scene-van { transform: translate(-50%, -50%); }
}

/* ── Ping dot ── */
@keyframes ping { 75%,100% { transform: scale(2); opacity: 0; } }

/* ── Marquee ── */
@keyframes marquee         { from { transform: translateX(0);    } to { transform: translateX(-50%); } }
@keyframes marquee-reverse { from { transform: translateX(-50%); } to { transform: translateX(0);    } }
.marquee { animation: marquee 36s linear infinite; }
@keyframes marquee-routes { from { transform: translateX(0) } to { transform: translateX(-50%) } }
@keyframes livepulse { 0%,100% { opacity:1 } 50% { opacity:0.4 } }

/* ── Testimonial bento ── */
.t-bento {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    align-items: start;
}
.t-col { display: flex; flex-direction: column; gap: 16px; }
.t-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    padding: 24px;
}
@media (max-width: 900px) {
    .t-bento { grid-template-columns: 1fr 1fr; }
    .t-bento .t-col:last-child { display: none; }
}
@media (max-width: 580px) {
    .t-bento { grid-template-columns: 1fr; }
    .t-bento .t-col:last-child { display: flex; }
}

/* Auto-scroll city + stats band */
.marquee-band {
    position: relative;
    overflow: hidden;
    background: var(--forest-deep);
    border-top: 1px solid rgba(255,255,255,0.06);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 30px 0;
}
.marquee-track {
    display: flex;
    width: max-content;
    animation: marquee 50s linear infinite;
}
.marquee-band:hover .marquee-track { animation-play-state: paused; }
.marquee-half { display: flex; align-items: center; flex-shrink: 0; }

/* Ticker chips */
.mq-chip {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    white-space: nowrap;
    font-family: var(--font);
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 9999px;
    padding: 9px 18px;
    margin: 0 8px;
    flex-shrink: 0;
}
.mq-meta {
    display: inline-flex;
    align-items: center;
    color: rgba(255,255,255,0.5);
    font-size: 13.5px;
    font-weight: 500;
}
/* Bookable journey chip */
.mq-journey {
    text-decoration: none;
    cursor: pointer;
    transition: background 0.18s, border-color 0.18s, transform 0.18s;
}
.mq-journey:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(107,198,48,0.45);
    transform: translateY(-1px);
}
.mq-route {
    color: #fff;
    font-size: 14.5px;
    font-weight: 700;
    letter-spacing: -0.005em;
}
.mq-price {
    color: var(--green);
    font-size: 14px;
    font-weight: 700;
}
.mq-spaces {
    color: rgba(255,255,255,0.8);
    font-size: 11.5px;
    font-weight: 600;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 9999px;
    padding: 2px 9px;
    letter-spacing: 0.01em;
}
.mq-spaces.is-low {
    color: #f2d59a;
    background: rgba(230,178,74,0.12);
    border-color: rgba(230,178,74,0.3);
}
.mq-go {
    color: rgba(255,255,255,0.35);
    transition: color 0.18s, transform 0.18s;
}
.mq-journey:hover .mq-go { color: var(--green); transform: translateX(2px); }
.marquee-fade {
    position: absolute;
    top: 0; bottom: 0;
    width: 90px;
    z-index: 2;
    pointer-events: none;
}
.marquee-fade-l { left: 0;  background: linear-gradient(90deg, var(--forest), transparent); }
.marquee-fade-r { right: 0; background: linear-gradient(270deg, var(--forest), transparent); }

@media (prefers-reduced-motion: reduce) {
    .marquee, .marquee-track { animation: none; }
}

/* ── Product mockup card ── */
.mockup-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 12px 56px rgba(28,56,41,0.12), 0 2px 4px rgba(0,0,0,0.05);
}

/* ── Map truck pins are rendered inside the SVG via animateMotion ── */

@media (max-width: 860px) {
    .map-pin { display: none !important; }
}
</style>
</head>

<body style="background:#fff" x-data="{ trackOpen: false, trackNum: '' }" @keydown.escape.window="trackOpen = false">

{{-- ══════════════════════════════════════════════════
     NAV — floating pill (Bobgo pattern)
══════════════════════════════════════════════════ --}}
<x-landing.nav :frosted="true" />


{{-- ══════════════════════════════════════════════════
     HERO — two-column: copy left, form card right
══════════════════════════════════════════════════ --}}
@php $cities = ['Harare','Bulawayo','Mutare','Gweru','Victoria Falls']; @endphp
<div style="background:#fff;padding:clamp(12px,1.6vw,20px)">
<section class="hero-cine">

    {{-- Full-bleed rider photo, graded toward the brand --}}
    <img class="hero-cine-media" src="/images/nhume-rider-go.jpg"
         alt="A Nhume GO rider delivering a parcel across Harare"
         fetchpriority="high">
    <span class="hero-cine-scrim" aria-hidden="true"></span>

    {{-- Overlaid editorial copy --}}
    <div class="hero-cine-inner">
        <span class="hero-cine-eyebrow reveal">Harare &amp; intercity Zimbabwe</span>

        <h1 class="hero-cine-h1 reveal">
            <span class="h1-nowrap">Same-day errands and deliveries</span><br>
            <span class="h1-nowrap">across Harare. Intercity too.</span>
        </h1>

        <p class="hero-cine-sub reveal">
            Real riders in your suburb, real drivers on the road. Book in under a minute — from $3.
        </p>

        <div class="hero-cine-cta reveal">
            <a href="{{ route('send') }}" class="hero-cta-primary">
                Send a parcel
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <button type="button" @click="trackOpen = true; $nextTick(() => $refs.trackInput?.focus())" class="hero-cine-textlink">
                Track a parcel
            </button>
        </div>

        <p class="hero-cine-served reveal">
            Serving <strong>Harare</strong>, Bulawayo, Mutare, Gweru &amp; Masvingo.
        </p>
    </div>

</section>
</div>


{{-- ══════════════════════════════════════════════════
     STATS STRIP
══════════════════════════════════════════════════ --}}
<section style="background:#fff">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(16px,3vw,40px)">
        <div class="reveal stats-band">
            <div class="stat-cell">
                <div class="stat-num">4</div>
                <div class="stat-label">Active routes</div>
                <div class="stat-sub">Harare, Bulawayo, Mutare &amp; Gweru</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">60s</div>
                <div class="stat-label">To book</div>
                <div class="stat-sub">No account needed to start</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">$3</div>
                <div class="stat-label">Starting price</div>
                <div class="stat-sub">Intercity parcel delivery</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">10+</div>
                <div class="stat-label">Harare suburbs</div>
                <div class="stat-sub">Same-day local errands</div>
            </div>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     WHO IT'S FOR — 3-column role cards (Trackeo pattern)
══════════════════════════════════════════════════ --}}
<section class="roles-section">
    <div class="roles-inner">

        {{-- Header --}}
        <div class="roles-header reveal">
            <p class="roles-eyebrow">Who it's for</p>
            <h2 class="roles-heading">For senders. For drivers.<br>For businesses.</h2>
        </div>

        {{-- 3 cards --}}
        <div class="roles-grid reveal-group">

            {{-- Card 1: Senders — booking UI with map bg --}}
            <div class="role-card">
                <div class="role-mockup rm-map-bg">
                    {{-- map grid overlay --}}
                    <div class="rm-grid"></div>
                    {{-- route line --}}
                    <svg class="rm-route-svg" viewBox="0 0 400 220" fill="none">
                        <path d="M 60 180 C 120 160 180 80 340 60" stroke="rgba(107,198,48,0.7)" stroke-width="2.5" stroke-dasharray="6 6" stroke-linecap="round"/>
                        <circle cx="60" cy="180" r="7" fill="var(--green)" opacity="0.9"/>
                        <circle cx="60" cy="180" r="14" fill="var(--green)" opacity="0.2"/>
                        <circle cx="340" cy="60" r="7" fill="rgba(255,255,255,0.8)"/>
                        <circle cx="340" cy="60" r="14" fill="rgba(255,255,255,0.15)"/>
                    </svg>
                    {{-- booking card --}}
                    <div class="rm-ui-card">
                        <div class="rm-ui-row">
                            <span class="rm-dot" style="background:var(--green)"></span>
                            <div>
                                <div class="rm-ui-label">Pick-up</div>
                                <div class="rm-ui-val">Harare, Zimbabwe</div>
                            </div>
                        </div>
                        <div class="rm-ui-divider"></div>
                        <div class="rm-ui-row">
                            <span class="rm-dot" style="background:rgba(255,255,255,0.5);border:1.5px solid rgba(255,255,255,0.4)"></span>
                            <div>
                                <div class="rm-ui-label">Drop-off</div>
                                <div class="rm-ui-val">Bulawayo, Zimbabwe</div>
                            </div>
                        </div>
                        <div class="rm-ui-footer">
                            <span class="rm-ui-price">from $3.00</span>
                            <span class="rm-ui-btn">Book space</span>
                        </div>
                    </div>
                </div>
                <div class="role-body">
                    <h3 class="role-title">Senders</h3>
                    <p class="role-desc">Book an errand or send a parcel in 60 seconds. Pick a rider or driver near you, see upfront pricing, and track every step live.</p>
                    <a href="{{ route('register') }}" class="role-link">Get started <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                </div>
            </div>

            {{-- Card 2: Drivers — real photo + overlay --}}
            <div class="role-card">
                <div class="role-mockup rm-photo-bg">
                    <img src="/images/driver-1.jpg" alt="" class="rm-bg-photo">
                    <div class="rm-photo-overlay"></div>
                    {{-- driver chip --}}
                    <div class="rm-driver-chip">
                        <img src="/images/driver-2.jpg" alt="" class="rm-chip-avatar">
                        <div>
                            <div class="rm-chip-name">Tendai Moyo</div>
                            <div class="rm-chip-badge">
                                <span class="rm-badge-dot"></span>EN ROUTE
                            </div>
                        </div>
                    </div>
                    {{-- action bar --}}
                    <div class="rm-action-bar">
                        <span class="rm-action-btn">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </span>
                        <span class="rm-action-btn rm-action-call">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Call
                        </span>
                    </div>
                </div>
                <div class="role-body">
                    <h3 class="role-title">Drivers & Riders</h3>
                    <p class="role-desc">Driving intercity? Fill the empty space and earn on the way. Local rider? Take errands and deliveries across Harare on your own schedule.</p>
                    <a href="{{ route('register') }}" class="role-link">Become a driver or rider <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                </div>
            </div>

            {{-- Card 3: Businesses — map with multi-stops --}}
            <div class="role-card">
                <div class="role-mockup rm-map-bg">
                    <div class="rm-grid"></div>
                    {{-- multi-point route --}}
                    <svg class="rm-route-svg" viewBox="0 0 400 220" fill="none">
                        <path d="M 50 170 C 100 150 160 100 220 80 C 280 60 320 80 360 60" stroke="rgba(107,198,48,0.6)" stroke-width="2" stroke-dasharray="5 6" stroke-linecap="round"/>
                        <circle cx="50"  cy="170" r="6" fill="var(--green)" opacity="0.9"/>
                        <circle cx="50"  cy="170" r="13" fill="var(--green)" opacity="0.15"/>
                        <circle cx="220" cy="80"  r="6" fill="rgba(255,178,50,0.9)"/>
                        <circle cx="220" cy="80"  r="13" fill="rgba(255,178,50,0.15)"/>
                        <circle cx="360" cy="60"  r="6" fill="rgba(255,255,255,0.7)"/>
                        <circle cx="360" cy="60"  r="13" fill="rgba(255,255,255,0.1)"/>
                    </svg>
                    {{-- shipment panel --}}
                    <div class="rm-shipment-panel">
                        <div class="rm-sp-header">
                            <span class="rm-sp-title">Active shipments</span>
                            <span class="rm-sp-count">3</span>
                        </div>
                        @foreach([['var(--green)','Harare → Bulawayo','Delivered','#4a9a1f'],['rgba(255,178,50,0.9)','Harare → Mutare','In transit','#c9a96e'],['rgba(255,255,255,0.45)','Gweru → Harare','Pending','rgba(255,255,255,0.45)']] as [$dot,$route,$status,$sc])
                        <div class="rm-sp-row">
                            <span class="rm-dot" style="background:{{ $dot }};flex-shrink:0"></span>
                            <div style="flex:1;min-width:0">
                                <div class="rm-ui-val">{{ $route }}</div>
                                <div class="rm-ui-label">{{ $status }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="role-body">
                    <h3 class="role-title">Businesses</h3>
                    <p class="role-desc">Send spare parts, stock, and documents between branches on a consistent schedule. Faster than depots, fairer pricing.</p>
                    <a href="{{ route('register') }}" class="role-link">Talk to us <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     MARQUEE — live journeys ticker (auto-scroll, bookable)
     Real user value: bookable routes leaving soon — route,
     departure, price and space left. Each chip links to book.
     Seeded (pre-launch); swap for an UpcomingJourneys ViewModel
     once real journeys exist.
══════════════════════════════════════════════════ --}}
@php
    // [route, when, spacesLeft, priceFrom, soonBadge]
    $tickerJourneys = [
        ['Harare → Bulawayo',      'Leaving soon',       4, '$3.00',  true],
        ['Harare → Mutare',        'Available today',    2, '$4.00',  true],
        ['Harare → Gweru',         'Daily departures',   6, '$2.50',  false],
        ['Bulawayo → Vic Falls',   'Available today',    3, '$5.00',  false],
        ['Harare → Masvingo',      'Daily departures',   5, '$4.00',  false],
        ['Gweru → Harare',         'Daily departures',   4, '$3.00',  false],
    ];
@endphp
<section aria-label="Journeys leaving soon — book a space" class="marquee-band">
    <div class="marquee-fade marquee-fade-l"></div>
    <div class="marquee-fade marquee-fade-r"></div>

    <div class="marquee-track">
        @for ($half = 0; $half < 2; $half++)
        <div class="marquee-half" {{ $half === 1 ? 'aria-hidden=true' : '' }}>
            @foreach ($tickerJourneys as [$route, $when, $spaces, $price, $soon])
            <a href="{{ route('register') }}" class="mq-chip mq-journey" aria-label="Book {{ $route }}, departs {{ $when }}, from {{ $price }}">
                <span class="mq-route">{{ $route }}</span>
                <span class="mq-meta">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;vertical-align:-2px;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $when }}
                </span>
                <span class="mq-price">from {{ $price }}</span>
                <span class="mq-spaces {{ $spaces <= 2 ? 'is-low' : '' }}">{{ $spaces }} left</span>
                <svg class="mq-go" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @endforeach
        </div>
        @endfor
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════════ --}}
<section id="how-it-works" style="padding:var(--section-y) 0;background:var(--white)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal section-head">
            <p class="eyebrow">How it works</p>
            <h2 class="section-title">Done in three steps.</h2>
        </div>

        <div class="how-grid" x-data="{ open: 1 }">
            {{-- LEFT: accordion of steps --}}
            <div class="reveal">
                <div class="how-acc">
                    @foreach ([
                        [1, 'Tell us where to pick up and deliver', 'Enter the pickup address, add a note for the driver or rider (gate code, fragile items, anything useful), and you\'re done. Under a minute.'],
                        [2, 'Pick a driver or rider near you', 'You see real names, verified badges, availability, and prices. You know exactly who is handling your parcel or errand before you confirm.'],
                        [3, 'Watch it move, in real time', 'The moment your driver or rider picks up, a live map shows exactly where it is. Your recipient gets notified the second it arrives.'],
                    ] as [$n, $title, $body])
                    <div class="how-item" :class="open === {{ $n }} ? 'is-open' : ''">
                        <button type="button" class="how-item-head" @click="open = {{ $n }}" @mouseenter="open = {{ $n }}" @focus="open = {{ $n }}" :aria-expanded="open === {{ $n }}">
                            <span class="how-item-title">{{ $title }}</span>
                        </button>
                        <div class="how-item-body" :class="open === {{ $n }} ? 'open' : ''">
                            <div class="how-item-body-inner">
                                <p>{{ $body }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('send') }}" class="how-cta">
                    Get started
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- RIGHT: visual that swaps per active step --}}
            <div class="reveal how-visual" aria-hidden="true">

                {{-- Scene 1 — How to send: route form card + price/book card on map --}}
                <div class="how-scene" :class="open === 1 ? 'is-active' : ''">
                    {{-- map background --}}
                    <div style="position:absolute;inset:0">
                        <svg width="100%" height="100%" viewBox="0 0 560 460" preserveAspectRatio="xMidYMid slice" fill="none">
                            <rect width="560" height="460" fill="#eeece7"/>
                            <rect x="0"   y="0"   width="120" height="100" fill="#e6e3dc"/>
                            <rect x="0"   y="160" width="120" height="140" fill="#e6e3dc"/>
                            <rect x="180" y="0"   width="140" height="80"  fill="#e6e3dc"/>
                            <rect x="380" y="160" width="180" height="120" fill="#e6e3dc"/>
                            <rect x="380" y="330" width="180" height="130" fill="#e6e3dc"/>
                            <rect x="180" y="330" width="140" height="130" fill="#e6e3dc"/>
                            <g stroke="#ddd9d1" stroke-width="14"><path d="M140 0 V460"/><path d="M360 0 V460"/><path d="M0 110 H560"/><path d="M0 300 H560"/></g>
                            <g stroke="#e2dfd8" stroke-width="7"><path d="M0 55 H560"/><path d="M0 205 H560"/><path d="M250 0 V460"/><path d="M470 0 V460"/></g>
                        </svg>
                    </div>

                    {{-- CARD 1 (back, top-left): the send form --}}
                    <div class="hv-float" style="position:absolute;top:6%;left:4%;width:56%;overflow:hidden;border-radius:16px">
                        {{-- header --}}
                        <div style="padding:14px 17px 12px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;justify-content:space-between">
                            <span style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest)">Get Started</span>
                            <span style="font-family:var(--font);font-size:10px;font-weight:700;color:var(--green-mid);background:var(--green-light);border-radius:9999px;padding:3px 9px">60 sec</span>
                        </div>
                        {{-- from field --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;gap:11px">
                            <span style="width:8px;height:8px;border-radius:50%;background:var(--green);flex-shrink:0"></span>
                            <div style="flex:1">
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">From</div>
                                <div style="font-family:var(--head);font-size:13.5px;font-weight:600;color:var(--forest);margin-top:2px">Borrowdale, Harare</div>
                            </div>
                        </div>
                        {{-- to field --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;gap:11px">
                            <span style="width:8px;height:8px;border-radius:50%;background:#fff;border:2px solid var(--border);flex-shrink:0"></span>
                            <div style="flex:1">
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">To</div>
                                <div style="font-family:var(--head);font-size:13.5px;font-weight:600;color:var(--forest);margin-top:2px">Avondale, Harare</div>
                            </div>
                        </div>
                        {{-- service type chips --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6">
                            <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096;margin-bottom:8px">What is it?</div>
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <span style="font-family:var(--font);font-size:11px;font-weight:700;color:var(--forest-deep);background:var(--green);border-radius:8px;padding:5px 10px">Groceries</span>
                                <span style="font-family:var(--font);font-size:11px;font-weight:500;color:var(--text-2);background:#f5f3ef;border:1px solid var(--border);border-radius:8px;padding:5px 10px">Documents</span>
                                <span style="font-family:var(--font);font-size:11px;font-weight:500;color:var(--text-2);background:#f5f3ef;border:1px solid var(--border);border-radius:8px;padding:5px 10px">Parcel</span>
                            </div>
                        </div>
                        {{-- find button --}}
                        <div style="padding:12px 17px">
                            <div style="width:100%;background:var(--forest);color:#fff;font-family:var(--font);font-size:12.5px;font-weight:700;text-align:center;padding:10px;border-radius:10px;display:flex;align-items:center;justify-content:center;gap:7px">
                                Find drivers &amp; riders
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2 (front, bottom-right): pricing + available drivers --}}
                    <div class="hv-float" style="position:absolute;top:42%;left:32%;right:4%;overflow:hidden;border-radius:16px">
                        {{-- price row --}}
                        <div style="padding:14px 17px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;justify-content:space-between">
                            <div>
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">Price from</div>
                                <div style="font-family:var(--head);font-size:22px;font-weight:700;color:var(--forest);letter-spacing:-0.02em;margin-top:2px">$3.00</div>
                            </div>
                            <div style="text-align:right">
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">Available now</div>
                                <div style="font-family:var(--head);font-size:22px;font-weight:700;color:var(--green-mid);letter-spacing:-0.02em;margin-top:2px">4</div>
                            </div>
                        </div>
                        {{-- ETA row --}}
                        <div style="padding:12px 17px;display:flex;align-items:center;gap:8px">
                            <svg width="13" height="13" fill="none" stroke="#c9a96e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="font-family:var(--font);font-size:12px;color:var(--text-2)">First available <strong style="color:var(--forest)">right now</strong></span>
                        </div>
                    </div>
                </div>

                {{-- Scene 2 — Choose a driver --}}
                <div class="how-scene" :class="open === 2 ? 'is-active' : ''">
                    <div class="hv-soft"></div>
                    <div class="hv-float hv-pad" style="left:11%;right:11%;top:17%">
                        <div class="hv-head">
                            <span class="hv-title">Available near you</span>
                            <span class="hv-pill">3 today</span>
                        </div>
                        <div class="hv-driver is-pick">
                            <img src="/images/driver-2.jpg" alt="" class="hv-avatar">
                            <div>
                                <div class="hv-dname">Tendai Moyo</div>
                                <div class="hv-badge">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Nhume Reviewed
                                </div>
                            </div>
                            <span class="hv-price">$3.00</span>
                        </div>
                        <div class="hv-driver">
                            <img src="/images/driver-1.jpg" alt="" class="hv-avatar">
                            <div>
                                <div class="hv-dname">Rudo Kadenge</div>
                                <div class="hv-badge" style="color:#9aa096">Ready in 12 min</div>
                            </div>
                            <span class="hv-price">$3.50</span>
                        </div>
                        <div class="hv-driver">
                            <div style="width:36px;height:36px;border-radius:50%;background:#1C3829;display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:12px;font-weight:700;color:#fff;flex-shrink:0">SM</div>
                            <div>
                                <div class="hv-dname">Sifiso Mhlanga</div>
                                <div class="hv-badge" style="color:#9aa096">Ready in 28 min</div>
                            </div>
                            <span class="hv-price">$2.50</span>
                        </div>
                    </div>
                </div>

                {{-- Scene 3 — Track it to the door (full map + overlay card) --}}
                <div class="how-scene" :class="open === 3 ? 'is-active' : ''">
                    <div class="hv-map-bg">
                        {{-- soft street network --}}
                        <svg class="hv-streets" viewBox="0 0 400 360" fill="none" preserveAspectRatio="xMidYMid slice">
                            <rect width="400" height="360" fill="#e7e5df"/>
                            <g stroke="#dcd9d1" stroke-width="8"><path d="M-20 90 H420"/><path d="M-20 250 H420"/><path d="M120 -20 V380"/><path d="M300 -20 V380"/></g>
                            <g stroke="#d3d0c7" stroke-width="4"><path d="M-20 170 H420"/><path d="M60 -20 V380"/><path d="M220 -20 V380"/><path d="M360 -20 V380"/></g>
                            {{-- route --}}
                            <path d="M 70 300 C 140 270 150 180 210 150 C 270 120 300 120 340 78" stroke="var(--green)" stroke-width="4" stroke-dasharray="9 8" stroke-linecap="round"/>
                            <circle cx="70" cy="300" r="7" fill="var(--green)"/>
                            <circle cx="70" cy="300" r="15" fill="var(--green)" opacity="0.18"/>
                            <circle cx="340" cy="78" r="7" fill="#b98a3e"/>
                            <circle cx="340" cy="78" r="15" fill="#b98a3e" opacity="0.18"/>
                        </svg>
                    </div>
                    {{-- vehicle marker chip on the route --}}
                    <div class="hv-mapchip" style="left:44%;top:40%">
                        <span class="hv-status-dot"></span>En route
                    </div>
                    {{-- overlay tracking card --}}
                    <div class="hv-float hv-pad" style="left:8%;right:8%;bottom:9%">
                        <div class="hv-head" style="margin-bottom:12px">
                            <span class="hv-title">En route to you</span>
                            <span class="hv-eta">On the way</span>
                        </div>
                        <div class="hv-row">
                            <img src="/images/driver-1.jpg" alt="" class="hv-track-avatar">
                            <div style="flex:1">
                                <div class="hv-val">Tendai is on the way</div>
                                <div class="hv-label" style="margin-top:2px">In transit · nearby</div>
                            </div>
                            <span class="hv-status-dot"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




{{-- ══════════════════════════════════════════════════
     NHUME STORE — physical drop-off
══════════════════════════════════════════════════ --}}
<section style="padding:var(--section-y) 0;background:var(--shade)">
    <div style="max-width:1200px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        <div class="reveal" style="display:grid;grid-template-columns:1fr 1fr;gap:clamp(48px,6vw,80px);align-items:stretch">

            {{-- Left: store exterior + lady stacked --}}
            <div style="display:flex;flex-direction:column;gap:12px">

                {{-- Top: storefront exterior --}}
                <div style="position:relative;border-radius:16px;overflow:hidden;box-shadow:0 16px 48px rgba(28,56,41,0.13);flex:1">
                    <img src="/images/nhume-store-exterior.jpg"
                         alt="Nhume Store exterior"
                         style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 30%;display:block">
                    <div style="position:absolute;bottom:0;left:0;right:0;padding:16px;background:linear-gradient(to top,rgba(6,30,14,0.75) 0%,transparent 100%)">
                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                            @foreach(['Drop off', 'Pick up', 'Returns'] as $tag)
                            <span style="font-family:var(--font);font-size:10px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#fff;padding:4px 12px;border-radius:999px;border:1px solid rgba(255,255,255,0.3)">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Bottom: parcel handoff --}}
                <div style="position:relative;border-radius:16px;overflow:hidden;box-shadow:0 16px 48px rgba(28,56,41,0.13);flex:1">
                    <img src="/images/nhume-store-lady.jpg"
                         alt="Nhume Store — parcel handoff"
                         style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 20%;display:block">
                </div>

            </div>

            {{-- Right: copy --}}
            <div style="display:flex;flex-direction:column;justify-content:center">
                <p style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--green-mid);margin:0 0 14px">Nhume Store</p>
                <h2 style="font-family:var(--head);font-size:clamp(22px,2.2vw,28px);font-weight:700;letter-spacing:-0.03em;line-height:1.15;color:var(--forest);margin:0 0 18px">Your packages. Safe with us.<br>Ready for you.</h2>
                <p style="font-family:var(--font);font-size:15px;color:var(--text-2);line-height:1.75;margin:0 0 32px">Walk in, hand over your parcel, and we handle the rest. Every item is logged, tracked, and handed to a verified driver or rider heading to your destination.</p>

                <div style="display:flex;flex-direction:column;gap:0;margin-bottom:36px;border-top:1px solid var(--border)">
                    @foreach([
                        ['Drop off',      'Bring your parcel in. We log it and keep it safe until collection.'],
                        ['Pick up',       'Recipients collect from our store or we dispatch to their door.'],
                        ['Live tracking', 'You and your recipient get a tracking link the moment we scan it in.'],
                    ] as [$title, $desc])
                    <div style="display:flex;align-items:flex-start;gap:16px;padding:16px 0;border-bottom:1px solid var(--border)">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--green);flex-shrink:0;margin-top:7px"></span>
                        <div>
                            <p style="font-family:var(--head);font-size:13.5px;font-weight:700;color:var(--forest);margin:0 0 2px">{{ $title }}</p>
                            <p style="font-family:var(--font);font-size:13px;color:var(--text-2);line-height:1.6;margin:0">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('send') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--forest);color:#fff;font-family:var(--font);font-size:14px;font-weight:600;padding:13px 26px;border-radius:6px;text-decoration:none;transition:background 0.15s" onmouseover="this.style.background='var(--forest-deep)'" onmouseout="this.style.background='var(--forest)'">
                    Book a drop-off
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

        </div>
    </div>
    <style>
    @media (max-width: 860px) {
        .reveal[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
    }
    </style>
</section>

{{-- ══════════════════════════════════════════════════
     WHY NHUME — bento grid
══════════════════════════════════════════════════ --}}
<section style="padding:var(--section-y) 0;background:var(--shade)">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        <div class="reveal" style="text-align:center;margin-bottom:52px">
            <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:var(--forest);margin:0">Built for Zimbabwe.<br>Built on trust.</h2>
        </div>

        <div class="reveal why-bento">

            {{-- COL 1 tall: brand card --}}
            <div class="why-card why-c1">
                <div>
                    <div style="margin-bottom:22px;">
                        <img src="/images/nhume_logo_v4.png" alt="Nhume" style="width:120px;height:auto;">
                    </div>
                    <p class="why-desc">Errands and parcels handled by real people — riders in your suburb, drivers already on the road. No depots, no anonymous strangers.</p>
                </div>
                <a href="{{ route('send') }}" class="why-cta">
                    Get started
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- COL 2 top: stat + badges row --}}
            <div class="why-card why-c2-top">
                <div>
                    <p class="why-stat-title">Verified Drivers & Riders</p>
                    <p class="why-stat-sub">Nhume Reviewed as a minimum</p>
                </div>
                <div class="why-badges">
                    @foreach(['var(--green-mid)','var(--forest)','var(--amber)'] as $c)
                    <span class="why-badge-ic">
                        <svg width="14" height="14" fill="none" stroke="{{ $c }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- COL 2 mid: big stat --}}
            <div class="why-card why-c2-mid">
                <p class="why-stat-title">Same day delivery</p>
                <p class="why-stat-sub">Harare to Bulawayo</p>
                <p class="why-big">&lt;6hrs</p>
            </div>

            {{-- COL 3 tall: big number --}}
            <div class="why-card why-c3">
                <p class="why-big">10+</p>
                <p class="why-name" style="margin-top:14px">Harare suburbs</p>
                <p class="why-desc">Borrowdale, Highlands, Avondale, Mount Pleasant and more. Same-day, every day.</p>
            </div>

            {{-- BOTTOM WIDE: driver card spanning cols 2+3 --}}
            <div class="why-card why-bot">
                <img src="/images/driver-2.jpg" alt="" class="why-person-img">
                <div>
                    <p class="why-person-name">Tendai Moyo</p>
                    <p class="why-person-role">Driver · Harare intercity & local</p>
                </div>
                <div class="why-soc">
                    <svg width="16" height="16" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span style="font-family:var(--font);font-size:12px;font-weight:700;color:var(--green-mid)">Nhume Reviewed</span>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     FOR TRANSPORTERS
══════════════════════════════════════════════════ --}}
<section id="transporters" class="transporter-grid" style="background:var(--forest-deep)">

    {{-- LEFT: text --}}
    <div class="reveal" style="padding:var(--section-y) clamp(28px,5vw,72px);display:flex;flex-direction:column;justify-content:center">
        <p class="eyebrow" style="color:var(--green);margin-bottom:18px">Drive, ride &amp; earn</p>
        <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:#fff;margin:0 0 26px">
            Turn your wheels into income.
        </h2>

        {{-- Two pathway cards --}}
        <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:36px;">

            {{-- Intercity transporter --}}
            <div style="background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.09);border-radius:14px;padding:18px 20px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <span style="width:32px;height:32px;border-radius:8px;background:rgba(107,198,48,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="15" height="15" fill="none" stroke="var(--green)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </span>
                    <span style="font-family:var(--head);font-size:14px;font-weight:700;color:#fff;">Intercity transporter</span>
                    <span style="font-family:var(--font);font-size:10.5px;font-weight:600;color:var(--green);background:rgba(107,198,48,0.14);border-radius:9999px;padding:3px 9px;margin-left:auto;">Car · Van · Truck</span>
                </div>
                <p style="font-family:var(--font);font-size:13.5px;color:rgba(255,255,255,0.6);line-height:1.6;margin:0;">Already driving Harare–Bulawayo? Earn on the parcel space you would have left empty.</p>
            </div>

            {{-- Bike rider --}}
            <div style="background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.09);border-radius:14px;padding:18px 20px;">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <span style="width:32px;height:32px;border-radius:8px;background:rgba(107,198,48,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="15" height="15" fill="none" stroke="var(--green)" viewBox="0 0 24 24"><circle cx="5" cy="18" r="3" stroke-width="2"/><circle cx="19" cy="18" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4l-1 6h6l-3 5M5 18l4-5h2"/></svg>
                    </span>
                    <span style="font-family:var(--head);font-size:14px;font-weight:700;color:#fff;">Local bike rider</span>
                    <span style="font-family:var(--font);font-size:10.5px;font-weight:600;color:var(--amber);background:rgba(201,169,110,0.14);border-radius:9999px;padding:3px 9px;margin-left:auto;">Bicycle · Moto</span>
                </div>
                <p style="font-family:var(--font);font-size:13.5px;color:rgba(255,255,255,0.6);line-height:1.6;margin:0 0 8px;">Do local deliveries and errands within your city on your own schedule. No car needed.</p>
                <p style="font-family:var(--font);font-size:12px;color:var(--green);margin:0;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:-2px;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    No bike? Nhume fleet bikes available for approved riders.
                </p>
            </div>
        </div>

        <div>
            <a href="{{ route('register') }}" class="btn-primary">
                Join as a driver or rider
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.4);margin-top:14px">Free to join. Commission only when you earn.</p>
        </div>
    </div>

    {{-- RIGHT: full-bleed rider photo --}}
    <div class="reveal transporter-photo" style="position:relative;overflow:hidden;min-height:0">
        <img src="/images/nhume-rider-go.jpg" alt="Nhume GO rider"
             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:40% 30%">
        {{-- gradient left edge to blend into section --}}
        <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(6,30,14,0.65) 0%,transparent 40%)"></div>
        {{-- bottom gradient for chip legibility --}}
        <div style="position:absolute;inset:0;background:linear-gradient(0deg,rgba(6,30,14,0.7) 0%,transparent 40%)"></div>
        {{-- badge chip --}}
        <div style="position:absolute;bottom:28px;left:28px;display:flex;align-items:center;gap:12px;background:rgba(4,16,8,0.78);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:12px 18px">
            <div>
                <p style="font-family:var(--head);font-size:14px;font-weight:700;color:#fff;margin:0">Nhume GO</p>
                <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.5);margin:3px 0 0">Same-day errands &amp; local runs</p>
            </div>
            <span style="display:inline-flex;align-items:center;gap:5px;font-family:var(--font);font-size:11px;font-weight:700;color:var(--green);background:rgba(107,198,48,0.14);border-radius:9999px;padding:4px 10px;white-space:nowrap">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Moving what matters
            </span>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     ROUTES
══════════════════════════════════════════════════ --}}
<section id="routes" style="padding:var(--section-y) 0;background:var(--shade);overflow:hidden">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        {{-- Section heading --}}
        <div class="reveal routes-head" style="margin-bottom:clamp(40px,5vw,64px)">
            <div>
                <p class="eyebrow mb-4">Routes</p>
                <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:var(--forest-deep);margin:0">Local Harare errands.<br>Intercity parcels.</h2>
            </div>
            <p style="font-family:var(--font);font-size:15px;color:#6b7280;max-width:340px;line-height:1.65;margin:0;padding-bottom:6px">Two services, one platform. Get things done across Harare's upmarket suburbs or ship between cities — same-day, every day.</p>
        </div>

        {{-- ── HARARE LOCAL ──────────────────────────────────── --}}
        <div class="reveal" style="margin-bottom:48px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
                <div style="display:flex;align-items:center;gap:8px">
                    <svg width="16" height="16" fill="none" stroke="var(--green-mid)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
                    <span style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--forest-deep)">Harare Local Errands</span>
                </div>
                <div style="flex:1;height:1px;background:#e5e7eb"></div>
                <span style="font-family:var(--font);font-size:12px;color:#9ca3af">Same-day · Upmarket suburbs</span>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:16px">

                {{-- Local live card --}}
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column">
                    <span style="display:inline-flex;align-items:center;font-family:var(--font);font-size:11px;font-weight:600;color:var(--green-mid);margin-bottom:28px">Taking bookings</span>
                    <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 6px">Harare</p>
                    <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 10px;line-height:1.2">Upmarket Suburbs</h3>
                    <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 16px;flex:1">Same-day errands and deliveries across Harare's upmarket areas. Our riders handle pickups, drop-offs, and runs so you don't have to.</p>
                    {{-- Suburb tags --}}
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:20px">
                        @foreach(['Borrowdale','Highlands','Avondale','Mount Pleasant','Chisipite','Glen Lorne','Greystone Park','Mandara','Gunhill','Greendale'] as $suburb)
                        <span style="font-family:var(--font);font-size:11.5px;font-weight:500;color:var(--forest-deep);background:#f0fde4;border:1px solid #d1fae5;border-radius:20px;padding:3px 10px">{{ $suburb }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('send') }}" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">Book a local errand →</a>
                </div>

                {{-- What we handle --}}
                <div style="background:var(--forest-deep);border-radius:16px;padding:28px;display:flex;flex-direction:column;gap:0">
                    <p style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.1em;color:rgba(255,255,255,0.4);text-transform:uppercase;margin:0 0 20px">What we handle</p>
                    @foreach([
                        ['Parcel pickups & drop-offs', 'Collect from one address, deliver to another — within hours.'],
                        ['Document runs', 'Contracts, invoices, ID copies. Safe hands, fast delivery.'],
                        ['Grocery & pharmacy runs', 'We collect from your preferred store and bring it to your door.'],
                        ['Business errands', 'Bank deposits, stationery, anything you need moved around Harare.'],
                    ] as [$title, $desc])
                    <div style="display:flex;gap:12px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,0.08);">
                        <div style="width:7px;height:7px;border-radius:50%;background:var(--green-mid);flex-shrink:0;margin-top:6px"></div>
                        <div>
                            <p style="font-family:var(--head);font-size:14px;font-weight:600;color:#fff;margin:0 0 3px">{{ $title }}</p>
                            <p style="font-family:var(--font);font-size:13px;color:rgba(255,255,255,0.5);margin:0;line-height:1.5">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                    <div style="margin-top:24px">
                        <a href="{{ route('send') }}" style="display:inline-flex;align-items:center;gap:7px;font-family:var(--font);font-size:14px;font-weight:600;color:var(--green-mid);text-decoration:none">
                            Book now
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── INTERCITY ─────────────────────────────────────── --}}
        <div class="reveal">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
                <div style="display:flex;align-items:center;gap:8px">
                    <svg width="16" height="16" fill="none" stroke="var(--green-mid)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 17l2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/></svg>
                    <span style="font-family:var(--font);font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--forest-deep)">Intercity Routes</span>
                </div>
                <div style="flex:1;height:1px;background:#e5e7eb"></div>
                <span style="font-family:var(--font);font-size:12px;color:#9ca3af">Long-distance · Harare ↔ Zimbabwe</span>
            </div>

            <div class="routes-grid">

                {{-- Harare → Bulawayo LIVE --}}
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column">
                    <span style="display:inline-flex;align-items:center;font-family:var(--font);font-size:11px;font-weight:600;color:var(--green-mid);margin-bottom:28px">Taking bookings</span>
                    <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 6px">Zimbabwe</p>
                    <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 10px;line-height:1.2">Harare ↔ Bulawayo</h3>
                    <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 20px;flex:1">Zimbabwe's busiest corridor. Drivers running daily, both directions. Door collection available.</p>
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px">
                        <span style="font-family:var(--font);font-size:12px;color:#6b7280;display:inline-flex;align-items:center;gap:5px">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                            4–6 hrs
                        </span>
                        <span style="font-family:var(--font);font-size:12px;color:#6b7280;display:inline-flex;align-items:center;gap:5px">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Multiple drivers daily
                        </span>
                    </div>
                    <a href="{{ route('send') }}" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">Send a parcel →</a>
                </div>

                {{-- Harare → Mutare LIVE --}}
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column">
                    <span style="display:inline-flex;align-items:center;font-family:var(--font);font-size:11px;font-weight:600;color:var(--green-mid);margin-bottom:28px">Taking bookings</span>
                    <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 6px">Zimbabwe</p>
                    <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 10px;line-height:1.2">Harare ↔ Mutare</h3>
                    <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 20px;flex:1">Eastern highlands corridor. New drivers joining weekly, parcels and documents welcome.</p>
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px">
                        <span style="font-family:var(--font);font-size:12px;color:#6b7280;display:inline-flex;align-items:center;gap:5px">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                            3–4 hrs
                        </span>
                        <span style="font-family:var(--font);font-size:12px;color:#6b7280;display:inline-flex;align-items:center;gap:5px">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Growing driver pool
                        </span>
                    </div>
                    <a href="{{ route('send') }}" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">Send a parcel →</a>
                </div>

                {{-- More corridors --}}
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column;opacity:0.55">
                    <span style="display:inline-flex;align-items:center;background:var(--forest-deep);color:rgba(255,255,255,0.7);font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.07em;padding:5px 11px;border-radius:6px;width:fit-content;margin-bottom:28px">COMING SOON</span>
                    <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 6px">Zimbabwe</p>
                    <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 10px;line-height:1.2">Bulawayo → Vic Falls<br>+ more</h3>
                    <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 20px;flex:1">Gweru, Masvingo, and the SA corridor expanding soon. Register your interest now.</p>
                    <a href="{{ route('register') }}" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">Join the waitlist →</a>
                </div>

            </div>
        </div>


    </div>
</section>


{{-- ══════════════════════════════════════════════════
     TESTIMONIALS — Trackeo style
══════════════════════════════════════════════════ --}}
<section style="padding:var(--section-y) 0;background:var(--forest-deep)">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        {{-- Heading --}}
        <div class="reveal routes-head">
            <div>
                <p class="eyebrow" style="color:rgba(255,255,255,0.5);margin-bottom:14px">What people say</p>
                <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:#fff;margin:0">Trusted by senders, drivers,<br>and riders across Zimbabwe.</h2>
            </div>
            <p style="font-family:var(--font);font-size:15px;color:rgba(255,255,255,0.5);line-height:1.65;max-width:340px;margin:0;padding-bottom:6px">Real people. Real deliveries. Across Harare suburbs and intercity.</p>
        </div>

        @php
        $reviews = [
            ['Ruvimbo T.',  'Borrowdale · Sender',  'Had my prescription collected from Avenues Clinic and delivered home. The rider was there in under <span style="color:var(--green);font-weight:600">30 minutes</span>. I did not leave my house.'],
            ['Blessing M.', 'Bulawayo · Driver',    'I drive Harare to Byo three times a week. I earn an extra <span style="color:var(--green);font-weight:600">$30 to $40 per trip</span> just from parcels. Straightforward.'],
            ['Chipo N.',    'Mutare · Sender',      'Booked a space in <span style="color:var(--green);font-weight:600">2 minutes</span>. My parcel was in Harare by <span style="color:var(--green);font-weight:600">3pm the same day</span>. Faster than I expected.'],
            ['Rudo K.',     'Highlands · Business', 'We use Nhume for document runs around Harare every week. <span style="color:var(--green);font-weight:600">Replaced our company car</span> for anything under 10km. Costs half as much.'],
        ];
        @endphp

        {{-- Bento grid --}}
        <div class="reveal t-bento">

            {{-- Col 1: two testimonial cards --}}
            <div class="t-col">
                @foreach ([$reviews[0], $reviews[1]] as [$name, $role, $quote])
                <div class="t-card">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
                        <span style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:13px;font-weight:700;color:#fff;flex-shrink:0">{{ substr($name,0,1) }}</span>
                        <div style="min-width:0;flex:1">
                            <p style="font-family:var(--head);font-size:14px;font-weight:600;color:#fff;margin:0">{{ $name }}</p>
                            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.45);margin:2px 0 0">{{ $role }}</p>
                        </div>
                        <svg width="14" height="14" fill="none" stroke="var(--green)" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p style="font-family:var(--font);font-size:15px;line-height:1.72;color:rgba(255,255,255,0.78);margin:0">{!! $quote !!}</p>
                </div>
                @endforeach
            </div>

            {{-- Col 2: featured photo + stat --}}
            <div class="t-col">
                {{-- Photo card --}}
                <div style="border-radius:16px;overflow:hidden;position:relative;aspect-ratio:3/4">
                    <img src="/images/driver-1.jpg" alt="Nhume driver" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:15% 18%">
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(6,30,14,0.9) 0%,rgba(6,30,14,0.2) 50%,transparent 70%)"></div>
                    <div style="position:absolute;bottom:0;left:0;right:0;padding:22px">
                        <p style="font-family:var(--font);font-size:14px;color:rgba(255,255,255,0.85);line-height:1.65;margin:0 0 14px">"I've been driving this route for years. Nhume turned empty space into <span style="color:var(--green);font-weight:600">real income</span> every trip."</p>
                        <p style="font-family:var(--head);font-size:13px;font-weight:700;color:#fff;margin:0">Tendai Moyo</p>
                        <p style="font-family:var(--font);font-size:11px;color:rgba(255,255,255,0.5);margin:3px 0 0">Intercity &amp; local runs, Harare</p>
                    </div>
                </div>
            </div>

            {{-- Col 3: two testimonial cards --}}
            <div class="t-col">
                @foreach ([$reviews[2], $reviews[3]] as [$name, $role, $quote])
                <div class="t-card">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
                        <span style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:13px;font-weight:700;color:#fff;flex-shrink:0">{{ substr($name,0,1) }}</span>
                        <div style="min-width:0;flex:1">
                            <p style="font-family:var(--head);font-size:14px;font-weight:600;color:#fff;margin:0">{{ $name }}</p>
                            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.45);margin:2px 0 0">{{ $role }}</p>
                        </div>
                        <svg width="14" height="14" fill="none" stroke="var(--green)" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p style="font-family:var(--font);font-size:15px;line-height:1.72;color:rgba(255,255,255,0.78);margin:0">{!! $quote !!}</p>
                </div>
                @endforeach
            </div>

            {{-- Full-width stat bar --}}
            <div style="grid-column:1/-1;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:28px 36px;display:flex;align-items:center;gap:36px;flex-wrap:wrap">
                <p style="font-family:var(--head);font-size:64px;font-weight:800;letter-spacing:-0.05em;line-height:1;color:var(--green);margin:0;flex-shrink:0">20+</p>
                <div style="width:1px;height:52px;background:rgba(255,255,255,0.1);flex-shrink:0"></div>
                <div>
                    <p style="font-family:var(--head);font-size:18px;font-weight:600;color:#fff;margin:0 0 6px">Reviewed drivers &amp; riders</p>
                    <p style="font-family:var(--font);font-size:14px;color:rgba(255,255,255,0.5);line-height:1.6;margin:0;max-width:560px">Every driver personally vetted by the Nhume team before going live. No anonymous strangers.</p>
                </div>
            </div>

        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════ --}}
<section id="faq" style="padding:var(--section-y) 0;background:var(--shade)">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        <div class="reveal faq-layout">

            {{-- Left: sticky heading + contact + watermark --}}
            <div class="faq-sticky" style="position:sticky;top:100px;overflow:hidden">
                <p class="eyebrow" style="margin:0 0 18px">Need help?</p>
                <h2 style="font-family:var(--head);font-size:clamp(28px,3.5vw,46px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:var(--forest-deep);margin:0 0 16px">Your questions,<br>answered.</h2>
                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 32px">Can't find what you're looking for?<br>Reach out directly.</p>

                {{-- Contact items --}}
                <div style="display:flex;flex-direction:column;gap:14px">
                    <a href="https://wa.me/263771234567" style="display:inline-flex;align-items:center;gap:12px;text-decoration:none;color:var(--forest-deep)">
                        <span style="width:36px;height:36px;border-radius:10px;background:var(--green-light);border:1px solid rgba(107,198,48,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg width="16" height="16" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <span style="font-family:var(--font);font-size:14px;font-weight:500;color:var(--forest-deep)">+263 77 123 4567</span>
                    </a>
                    <a href="mailto:hello@nhume.co.zw" style="display:inline-flex;align-items:center;gap:12px;text-decoration:none;color:var(--forest-deep)">
                        <span style="width:36px;height:36px;border-radius:10px;background:var(--green-light);border:1px solid rgba(107,198,48,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg width="16" height="16" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <span style="font-family:var(--font);font-size:14px;font-weight:500;color:var(--forest-deep)">hello@nhume.co.zw</span>
                    </a>
                </div>

                {{-- Watermark --}}
                <p style="position:absolute;bottom:-10px;left:-8px;font-family:var(--head);font-size:clamp(120px,20vw,200px);font-weight:800;letter-spacing:-0.05em;line-height:1;color:rgba(28,56,41,0.05);pointer-events:none;user-select:none;margin:0">FAQ</p>
            </div>

            {{-- Right: individual question cards --}}
            @php $faqs = [
                ['Is my delivery covered?', 'Every booking includes basic cover for your parcel or errand. For high-value items you can declare the value and add extended cover at checkout. We show your cover details before you confirm.'],
                ["What if my driver or rider doesn't show up?", 'You only pay after the driver or rider confirms pickup. If they cancel, you get a full refund instantly. We also have backup options on all active routes and areas.'],
                ['How are drivers and riders verified?', 'Our team speaks personally to every driver and rider before they go live. That is the minimum. Higher trust tiers require ID submission and background checks.'],
                ['What can I send or have collected?', 'Documents, clothing, electronics, food items, groceries, and small household goods. No hazardous materials, no live animals. For errands, just describe what you need in the booking notes.'],
                ['How does pickup work?', 'Once booked, you agree on a pickup point with your driver or rider — usually your gate, office, or a nearby landmark. You will not hand anything over without a confirmed booking first.'],
                ['Do I need an account to book?', 'You can browse available drivers and riders without an account. You only need to sign up when you are ready to book. It takes under 60 seconds.'],
            ]; @endphp

            <div x-data="{ open: 0 }" style="display:flex;flex-direction:column;gap:8px">
                @foreach ($faqs as $i => $faq)
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            style="width:100%;display:flex;align-items:center;gap:16px;padding:20px 22px;text-align:left;background:none;border:none;cursor:pointer">
                        <span style="font-family:var(--head);font-size:12px;font-weight:700;color:#9ca3af;letter-spacing:0.04em;flex-shrink:0">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span style="font-family:var(--font);font-size:15px;font-weight:500;color:#1c1c1c;line-height:1.4;flex:1">{{ $faq[0] }}</span>
                        <span style="flex-shrink:0;line-height:0;transition:transform 0.2s" :style="open === {{ $i }} ? 'transform:rotate(180deg)' : ''">
                            <svg width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                        </span>
                    </button>
                    <div class="faq-body" :class="open === {{ $i }} ? 'open' : ''">
                        <div class="faq-inner">
                            <div style="padding:0 22px 20px 50px">
                                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.75;margin:0">{{ $faq[1] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════ --}}
<div style="background:#fff;padding:clamp(40px,6vw,80px) clamp(16px,3vw,40px)">
<section style="background:var(--forest-deep);border-radius:8px;overflow:hidden;position:relative">

    {{-- Full-width heading --}}
    <div class="reveal" style="padding:clamp(40px,5vw,72px) clamp(20px,4vw,48px) 14px;text-align:center">
        <h2 style="font-family:var(--head);font-size:clamp(32px,5.5vw,72px);font-weight:700;letter-spacing:-0.04em;line-height:1.06;color:#fff;margin:0">Errands done.<br>Parcels delivered.</h2>
    </div>

    {{-- Subtitle + buttons + social proof --}}
    <div class="reveal" style="max-width:560px;margin:0 auto;padding:0 clamp(20px,4vw,48px) 40px;text-align:center">

        <p style="font-family:var(--font);font-size:16px;color:rgba(255,255,255,0.5);line-height:1.65;margin:0 auto 32px">Run Harare errands or ship intercity to Bulawayo and beyond. Real people, real prices, same day.</p>

        <div style="display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:32px">
            <a href="{{ route('send') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--green);color:var(--forest-deep);font-family:var(--font);font-size:15px;font-weight:700;padding:14px 28px;border-radius:12px;text-decoration:none;transition:background 0.2s" onmouseover="this.style.background='#5aad28'" onmouseout="this.style.background='var(--green)'">
                Book an errand
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;font-family:var(--font);font-size:15px;font-weight:600;padding:13px 26px;border-radius:12px;text-decoration:none;border:1.5px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.65);transition:all 0.2s" onmouseover="this.style.borderColor='rgba(255,255,255,0.45)';this.style.color='#fff'" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='rgba(255,255,255,0.65)'">
                Become a driver or rider
            </a>
        </div>

        <div style="display:inline-flex;align-items:center;gap:14px">
            <div style="display:flex;align-items:center">
                <img src="/images/driver-1.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:26% 15%;border:2.5px solid var(--forest-deep);margin-right:-10px;position:relative;z-index:3">
                <img src="/images/driver-2.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:26% 15%;border:2.5px solid var(--forest-deep);margin-right:-10px;position:relative;z-index:2">
                <img src="/images/driver-3.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:50% 20%;border:2.5px solid var(--forest-deep);position:relative;z-index:1">
            </div>
            <p style="font-family:var(--font);font-size:12.5px;color:rgba(255,255,255,0.38);margin:0;text-align:left">Trusted by senders, drivers &amp; riders<br>across Zimbabwe</p>
        </div>

    </div>


</section>
</div>


{{-- ══════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════ --}}
<x-landing.footer />


<script>
(function () {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal, .reveal-group').forEach(el => io.observe(el));
})();
</script>


<x-landing.track-modal />


</body>
</html>
