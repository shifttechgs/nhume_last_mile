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
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@700,800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.14.1/dist/cdn.min.js"></script>
    @endif

<style>
:root {
    --font: 'DM Sans', system-ui, sans-serif;
    --head: 'Inter', 'DM Sans', system-ui, sans-serif;

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
    --card-radius:  16px;
    --btn-radius:   12px;
}

* { box-sizing: border-box; }
body { font-family: var(--font); color: var(--text); background: #fff; -webkit-font-smoothing: antialiased; }
[x-cloak] { display: none !important; }

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
    border-radius: 22px;
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
.feature-card:hover { box-shadow: 0 6px 28px rgba(28,56,41,0.08); transform: translateY(-2px); }

/* ── Stats band ── */
.stats-band {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 20px;
    box-shadow: 0 10px 34px rgba(28,56,41,0.05);
    overflow: hidden;
}
.stat-cell {
    padding: 34px 22px;
    text-align: center;
    border-top: 1px solid var(--border);
    border-left: 1px solid var(--border);
}
/* internal dividers only — clear outer edges (2-col layout) */
.stat-cell:nth-child(-n+2) { border-top: 0; }
.stat-cell:nth-child(odd)  { border-left: 0; }
.stat-num {
    font-family: var(--font);
    font-size: clamp(38px, 4.4vw, 48px);
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--green);
    line-height: 1;
}
.stat-label {
    font-family: var(--font);
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    margin-top: 10px;
}
.stat-sub {
    font-family: var(--font);
    font-size: 12px;
    color: #9aa096;
    margin-top: 3px;
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
    box-shadow: 0 10px 32px rgba(28,56,41,0.08);
    transform: translateY(-3px);
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
.journey-card:hover { box-shadow: 0 6px 28px rgba(28,56,41,0.08); transform: translateY(-2px); }

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
    border-radius: 22px;
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
    border-radius: 13px;
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
    border-radius: 13px 13px 15px 15px;
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
    border-radius: 20px;
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

/* Testimonials 3-card grid */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 900px) { .testimonials-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 580px) { .testimonials-grid { grid-template-columns: 1fr; } }

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
.tier-card:hover { box-shadow: 0 6px 24px rgba(28,56,41,0.07); transform: translateY(-2px); }
.tier-featured {
    border-color: rgba(107,198,48,0.55);
    box-shadow: 0 0 0 3px var(--green-light), 0 12px 32px rgba(28,56,41,0.08);
}
.tier-featured:hover { box-shadow: 0 0 0 3px var(--green-light), 0 16px 36px rgba(28,56,41,0.12); }

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
    box-shadow: 0 12px 34px rgba(28,56,41,0.08);
    transform: translateY(-3px);
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
    border-radius: 16px;
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
    border-radius: 14px;
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
    border-radius: 10px;
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
    border-radius: 14px;
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
    border-radius: 14px;
    border: none;
    background: var(--green);
    box-shadow: 0 4px 16px rgba(107,198,48,0.28);
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    white-space: nowrap;
}
.btn-nav-fill:hover { background: var(--green-dark); transform: translateY(-1px); }

/* Mobile dropdown card */
.nav-mobile-dropdown {
    position: fixed;
    top: 84px;
    left: 20px;
    right: 20px;
    z-index: 99;
    background: #fff;
    border-radius: 20px;
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
    box-shadow: 0 8px 20px rgba(107,198,48,0.28), inset 0 1px 0 rgba(255,255,255,0.25);
    transition: background 0.18s, transform 0.18s, box-shadow 0.18s;
}
.hero-submit:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
    box-shadow: 0 12px 26px rgba(107,198,48,0.34), inset 0 1px 0 rgba(255,255,255,0.25);
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
    max-width: 1040px;
    margin: auto auto 0;
    flex: 1 1 auto;
    min-height: 200px;
    z-index: 0;
    opacity: 0.55;
    transition: opacity 0.3s ease;
}
.hero-scene:hover { opacity: 0.8; }
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
    background: #fff;
    border: 1px solid #e8e5df;
    border-radius: 16px;
    box-shadow: none;
    padding: 14px 16px 14px;
    padding-bottom: 0;
    opacity: 0.45;
    width: max-content;
    max-width: 240px;
    animation-timing-function: cubic-bezier(0.45, 0, 0.55, 1);
    animation-iteration-count: infinite;
    will-change: transform;
}
.sc-status { top: 5%;    left: 0;   animation-name: floatA; animation-duration: 7.5s; animation-delay: -0.4s; }
.sc-order  { bottom: 12%; left: 4%;  display: flex; align-items: center; gap: 11px; animation-name: floatB; animation-duration: 8.6s; animation-delay: -2.3s; }
.sc-driver { top: 12%;   right: 0;  display: flex; align-items: center; gap: 11px; animation-name: floatC; animation-duration: 7.9s; animation-delay: -3.6s; }
.sc-pickup { bottom: 8%; right: 2%; animation-name: floatA; animation-duration: 9.2s; animation-delay: -1.1s; }

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
.sparkle-a { top: 8%;    right: 15%; }
.sparkle-b { bottom: 30%; left: 22%; animation-delay: -1.5s; }
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
    .scene-van, .scene-card, .scene-pin-pulse, .scene-sparkle { animation: none; }
    .scene-van { transform: translate(-50%, -50%); }
}

/* ── Ping dot ── */
@keyframes ping { 75%,100% { transform: scale(2); opacity: 0; } }

/* ── Marquee ── */
@keyframes marquee { from { transform: translateX(0) } to { transform: translateX(-50%) } }
.marquee { animation: marquee 36s linear infinite; }
@keyframes marquee-routes { from { transform: translateX(0) } to { transform: translateX(-50%) } }
@keyframes livepulse { 0%,100% { opacity:1 } 50% { opacity:0.4 } }

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

<body style="background:#fff">

{{-- ══════════════════════════════════════════════════
     NAV — floating pill (Bobgo pattern)
══════════════════════════════════════════════════ --}}
<div x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset || document.documentElement.scrollTop) > 24"
     :class="scrolled ? 'is-scrolled' : ''"
     class="nav-outer">
    <div class="nav-bar">

        {{-- Logo (left) --}}
        <a href="/" class="nav-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_v2.png" alt="Nhume" style="height:50px;width:auto;">
        </a>

        {{-- Centered links pill (desktop) --}}
        <nav class="nav-center nav-desktop">
            <a href="#how-it-works" class="nav-link">How it works</a>
            <a href="#journeys"     class="nav-link">Journeys</a>
            <a href="#transporters" class="nav-link">For transporters</a>
            <a href="#faq"          class="nav-link">FAQ</a>
        </nav>

        {{-- Right CTAs (desktop) --}}
        <div class="nav-right nav-desktop">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-fill">Dashboard</a>
            @else
                <a href="{{ route('login') }}"    class="nav-link">Sign in</a>
                <a href="{{ route('register') }}" class="btn-nav-outline">Track Parcel</a>
                <a href="{{ route('register') }}" class="btn-nav-fill">Send Parcel
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endauth
        </div>

        {{-- Mobile hamburger (right) --}}
        <button @click="open = !open" class="nav-mobile-btn" aria-label="Menu">
            <svg x-show="!open" width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" x-cloak width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Mobile dropdown card --}}
    <div x-show="open" x-cloak class="nav-mobile-dropdown">
        <nav style="display:flex;flex-direction:column;gap:2px;margin-bottom:12px;">
            @foreach(['#how-it-works' => 'How it works', '#journeys' => 'Journeys', '#transporters' => 'For transporters', '#faq' => 'FAQ'] as $href => $label)
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
                <a href="{{ route('register') }}" class="btn-nav-fill"    style="justify-content:center;">Send Parcel</a>
            @endauth
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     HERO — two-column: copy left, form card right
══════════════════════════════════════════════════ --}}
@php $cities = ['Harare','Bulawayo','Mutare','Gweru','Victoria Falls']; @endphp
<div style="background:#fff;padding:clamp(16px,2vw,24px)">
<section style="position:relative;overflow:hidden;background:var(--shade);display:flex;flex-direction:column;min-height:96svh;border-radius:20px;">

    {{-- Soft brand glow — depth without a busy background --}}
    <div style="position:absolute;inset:0;pointer-events:none;
        background:
            radial-gradient(ellipse 45% 45% at 6% 92%, rgba(28,56,41,0.06) 0%, transparent 70%);">
    </div>

    <div class="mx-auto px-6 sm:px-8" style="position:relative;z-index:2;max-width:1180px;flex:1;display:flex;flex-direction:column;width:100%;">
        <div style="flex:1;display:flex;flex-direction:column;padding-top:clamp(180px,22vh,240px);padding-bottom:0;">

            {{-- ── Centered copy ── --}}
            <div class="reveal" style="max-width:1000px;margin:0 auto;text-align:center;">
                <h1 style="font-family:var(--head);font-size:clamp(38px,5.6vw,68px);font-weight:600;letter-spacing:-0.03em;line-height:1.06;color:var(--forest);margin:0 0 22px;">
                    <span class="h1-nowrap">Move parcels with drivers</span><br><span style="color:var(--green-mid)">already in motion.</span>
                </h1>

                <p style="font-family:var(--font);font-size:19px;color:#5f6560;line-height:1.6;margin:0 auto 34px;max-width:560px;">
                    Someone is already driving to your city. Book their space, track it live, and have it there today.
                </p>

                {{-- Hero CTAs ── --}}
                <div class="hero-cta-wrap">
                    <div class="hero-cta-btns">
                        <a href="{{ route('register') }}" class="hero-cta-primary">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg>
                            Send a parcel
                        </a>
                        <a href="{{ route('register') }}" class="hero-cta-secondary">
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/></svg>
                            Track parcel
                        </a>
                    </div>
                    <div class="hero-trust-chips">
                        <span class="hero-chip">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Upfront fare
                        </span>
                        <span class="hero-chip-dot"></span>
                        <span class="hero-chip">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Driver details
                        </span>
                        <span class="hero-chip-dot"></span>
                        <span class="hero-chip">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Cash + digital
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Floating scene: van, route & live cards ── --}}
            <div class="hero-scene reveal" aria-hidden="true">

                {{-- faint dotted world map backdrop (like the reference) --}}
                <svg class="scene-globe" viewBox="0 0 1000 500" fill="none" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <pattern id="mapDots" width="13" height="13" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.7" fill="rgba(28,56,41,0.17)"/>
                        </pattern>
                    </defs>
                    <g fill="url(#mapDots)">
                        {{-- North America --}}
                        <path d="M120 90 C100 120 105 150 130 165 C120 200 155 220 185 205 C200 235 235 235 250 210 C270 215 285 190 275 165 C295 150 295 120 270 108 C260 85 225 78 200 88 C175 78 140 78 120 90 Z"/>
                        {{-- South America --}}
                        <path d="M300 250 C280 260 275 290 290 320 C292 360 312 408 332 406 C354 400 350 360 342 330 C352 300 345 270 328 258 C320 250 310 249 300 250 Z"/>
                        {{-- Europe --}}
                        <path d="M500 105 C486 110 484 128 496 140 C491 158 513 164 530 157 C548 161 560 146 552 130 C561 115 548 100 528 103 C518 98 508 101 500 105 Z"/>
                        {{-- Africa --}}
                        <path d="M520 180 C500 195 500 228 515 256 C515 300 535 352 560 356 C584 351 598 314 590 282 C608 252 603 210 580 194 C560 178 538 174 520 180 Z"/>
                        {{-- Asia --}}
                        <path d="M620 85 C596 93 591 122 611 143 C601 176 640 204 685 199 C734 208 798 194 843 172 C876 156 880 120 850 103 C814 82 746 76 696 80 C671 78 646 79 620 85 Z"/>
                        {{-- Australia --}}
                        <path d="M792 335 C772 345 774 372 794 388 C817 402 853 400 873 385 C889 371 884 346 863 337 C839 328 812 328 792 335 Z"/>
                    </g>
                </svg>

                {{-- one dotted route: Driver status → Msasa Depot (road-like) --}}
                <svg class="scene-route" viewBox="0 0 1000 380" fill="none" preserveAspectRatio="none">
                    <circle cx="132" cy="120" r="5.5" fill="var(--green)"/>
                    <path d="M132 120 C 300 170, 300 244, 480 257 C 640 268, 660 293, 792 305"
                          stroke="var(--green)" stroke-width="2.4" stroke-dasharray="1.5 12" stroke-linecap="round" opacity="0.9"/>
                </svg>

                {{-- delivery van --}}
                <svg class="scene-van" viewBox="0 0 240 150" fill="none">
                    <ellipse cx="118" cy="128" rx="98" ry="9" fill="rgba(28,56,41,0.08)"/>
                    <rect x="22" y="34" width="118" height="66" rx="10" fill="#fff" stroke="var(--forest)" stroke-width="3.5"/>
                    <path d="M140 34 H176 L206 66 V100 H140 Z" fill="#fff" stroke="var(--forest)" stroke-width="3.5" stroke-linejoin="round"/>
                    <path d="M150 46 H172 L191 64 H150 Z" fill="var(--green-light)" stroke="var(--forest)" stroke-width="2.5" stroke-linejoin="round"/>
                    <path d="M84 36 V98" stroke="var(--forest)" stroke-width="2.5"/>
                    <path d="M28 82 H132" stroke="var(--green)" stroke-width="6" stroke-linecap="round"/>
                    <circle cx="200" cy="86" r="4" fill="var(--green)"/>
                    <circle cx="62" cy="100" r="18" fill="#fff" stroke="var(--forest)" stroke-width="3.5"/>
                    <circle cx="62" cy="100" r="6.5" fill="var(--forest)"/>
                    <circle cx="176" cy="100" r="18" fill="#fff" stroke="var(--forest)" stroke-width="3.5"/>
                    <circle cx="176" cy="100" r="6.5" fill="var(--forest)"/>
                </svg>

                {{-- destination marker near Msasa Depot (route end) --}}
                <div class="scene-pin scene-pin-depot">
                    <span class="scene-pin-pulse"></span>
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="var(--forest)"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
                </div>

                {{-- twinkle sparkles (human touch) --}}
                <span class="scene-sparkle sparkle-a"><svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 C 12.5 8, 16 11.5, 22 12 C 16 12.5, 12.5 16, 12 22 C 11.5 16, 8 12.5, 2 12 C 8 11.5, 11.5 8, 12 2 Z"/></svg></span>
                <span class="scene-sparkle sparkle-b"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 C 12.5 8, 16 11.5, 22 12 C 16 12.5, 12.5 16, 12 22 C 11.5 16, 8 12.5, 2 12 C 8 11.5, 11.5 8, 12 2 Z"/></svg></span>

                {{-- card: driver status (top-left) --}}
                <div class="scene-card sc-status">
                    <div class="sc-row" style="margin-bottom:11px;">
                        <span class="sc-ic"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg></span>
                        <span class="sc-title">Driver status</span>
                    </div>
                    <span class="sc-tag">In transit</span>
                    <div class="sc-row" style="margin-top:12px;gap:9px;">
                        <span class="sc-photo-avatar"><img src="/images/driver-2.jpg" alt="" style="object-position:26% 42%"></span>
                        <div>
                            <p class="sc-strong">NHM-4821</p>
                            <p class="sc-sub">Harare → Bulawayo</p>
                        </div>
                    </div>
                </div>

                {{-- card: create shipment (bottom-left) --}}
                <div class="scene-card sc-order">
                    <span class="sc-avatar" style="background:var(--green)"><svg width="15" height="15" fill="none" stroke="var(--forest-deep)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14m-7-7h14"/></svg></span>
                    <div>
                        <p class="sc-strong">Create a shipment</p>
                        <p class="sc-sub">60 seconds · no account</p>
                    </div>
                </div>

                {{-- card: reviewed driver (right) — photo card --}}
                <div class="scene-card sc-driver sc-photo">
                    <img class="sc-photo-img" src="/images/driver-1.jpg" alt="Nhume driver on the road" style="object-position:42% 16%">
                    <span class="sc-photo-tag">
                        <svg width="11" height="11" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Tendai Moyo
                    </span>
                </div>

                {{-- card: pickup (bottom-right) --}}
                <div class="scene-card sc-pickup">
                    <div class="sc-row" style="justify-content:space-between;margin-bottom:9px;">
                        <span class="sc-title">Pickup</span>
                        <svg width="15" height="15" fill="none" stroke="#9aa096" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17L17 7M7 7h10v10"/></svg>
                    </div>
                    <p class="sc-strong">Msasa Depot</p>
                    <p class="sc-sub">Cnr Mutare Rd · Harare</p>
                </div>

            </div>

        </div>
    </div>

</section>
</div>


{{-- ══════════════════════════════════════════════════
     WHO IT'S FOR — 3-column role cards (Trackeo pattern)
══════════════════════════════════════════════════ --}}
<section class="roles-section">
    <div class="roles-inner">

        {{-- Header --}}
        <div class="roles-header reveal">
            <p class="roles-eyebrow">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                For every role
            </p>
            <h2 class="roles-heading">Built for senders,<br>drivers, and businesses.</h2>
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
                    <p class="role-desc">Post your parcel in 60 seconds. Browse drivers heading your way, see upfront pricing, and track every step live.</p>
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
                    <h3 class="role-title">Drivers</h3>
                    <p class="role-desc">Already making the trip? List your available space, set your own fare, and earn on every journey you're taking anyway.</p>
                    <a href="{{ route('register') }}" class="role-link">Become a driver <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
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
        ['Harare → Bulawayo',      '14:00 today',     4, '$3.00',  true],
        ['Harare → Mutare',        '15:30 today',     2, '$4.00',  true],
        ['Harare → Gweru',         '16:00 today',     6, '$2.50',  false],
        ['Bulawayo → Vic Falls',   '17:15 today',     3, '$5.00',  false],
        ['Harare → Masvingo',      '18:00 today',     5, '$4.00',  false],
        ['Gweru → Harare',         '07:00 tomorrow',  4, '$3.00',  false],
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
            <p class="eyebrow eyebrow-ic">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                How it works
            </p>
            <h2 class="section-title">How to send<br>a parcel</h2>
        </div>

        <div class="how-grid" x-data="{ open: 1 }">
            {{-- LEFT: accordion of steps --}}
            <div class="reveal">
                <div class="how-acc">
                    @foreach ([
                        [1, 'Drop in your pickup address', 'Enter where the parcel is, add a note for the driver (gate codes, fragile items, anything useful), then pick your parcel type. Done in under a minute.'],
                        [2, 'Pick a driver already on the route', 'You see real names, verified badges, departure times, and prices. You know who is carrying your parcel before you confirm.'],
                        [3, 'Watch it move, kilometre by kilometre', 'The moment your driver picks up, a live map shows exactly where it is. Your recipient gets notified the second it arrives.'],
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

                <a href="{{ route('register') }}" class="how-cta">
                    Post a parcel
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
                            <span style="font-family:var(--head);font-size:14px;font-weight:700;color:var(--forest)">Send a parcel</span>
                            <span style="font-family:var(--font);font-size:10px;font-weight:700;color:var(--green-mid);background:var(--green-light);border-radius:9999px;padding:3px 9px">60 sec</span>
                        </div>
                        {{-- from field --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;gap:11px">
                            <span style="width:8px;height:8px;border-radius:50%;background:var(--green);flex-shrink:0"></span>
                            <div style="flex:1">
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">From</div>
                                <div style="font-family:var(--head);font-size:13.5px;font-weight:600;color:var(--forest);margin-top:2px">Harare</div>
                            </div>
                        </div>
                        {{-- to field --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6;display:flex;align-items:center;gap:11px">
                            <span style="width:8px;height:8px;border-radius:50%;background:#fff;border:2px solid var(--border);flex-shrink:0"></span>
                            <div style="flex:1">
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">To</div>
                                <div style="font-family:var(--head);font-size:13.5px;font-weight:600;color:var(--forest);margin-top:2px">Bulawayo</div>
                            </div>
                        </div>
                        {{-- parcel type chips --}}
                        <div style="padding:11px 17px;border-bottom:1px solid #f0ece6">
                            <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096;margin-bottom:8px">Parcel type</div>
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <span style="font-family:var(--font);font-size:11px;font-weight:700;color:var(--forest-deep);background:var(--green);border-radius:8px;padding:5px 10px">Documents</span>
                                <span style="font-family:var(--font);font-size:11px;font-weight:500;color:var(--text-2);background:#f5f3ef;border:1px solid var(--border);border-radius:8px;padding:5px 10px">Electronics</span>
                                <span style="font-family:var(--font);font-size:11px;font-weight:500;color:var(--text-2);background:#f5f3ef;border:1px solid var(--border);border-radius:8px;padding:5px 10px">Clothing</span>
                            </div>
                        </div>
                        {{-- find drivers button --}}
                        <div style="padding:12px 17px">
                            <div style="width:100%;background:var(--forest);color:#fff;font-family:var(--font);font-size:12.5px;font-weight:700;text-align:center;padding:10px;border-radius:10px;display:flex;align-items:center;justify-content:center;gap:7px">
                                Find drivers
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
                                <div style="font-family:var(--font);font-size:9.5px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;color:#9aa096">Drivers today</div>
                                <div style="font-family:var(--head);font-size:22px;font-weight:700;color:var(--green-mid);letter-spacing:-0.02em;margin-top:2px">4</div>
                            </div>
                        </div>
                        {{-- ETA row --}}
                        <div style="padding:12px 17px;display:flex;align-items:center;gap:8px">
                            <svg width="13" height="13" fill="none" stroke="#c9a96e" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="font-family:var(--font);font-size:12px;color:var(--text-2)">Next departure <strong style="color:var(--forest)">14:00 today</strong></span>
                        </div>
                    </div>
                </div>

                {{-- Scene 2 — Choose a driver --}}
                <div class="how-scene" :class="open === 2 ? 'is-active' : ''">
                    <div class="hv-soft"></div>
                    <div class="hv-float hv-pad" style="left:11%;right:11%;top:17%">
                        <div class="hv-head">
                            <span class="hv-title">Drivers heading there</span>
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
                                <div class="hv-badge" style="color:#9aa096">Departs 15:30</div>
                            </div>
                            <span class="hv-price">$3.50</span>
                        </div>
                        <div class="hv-driver">
                            <div style="width:36px;height:36px;border-radius:50%;background:#1C3829;display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:12px;font-weight:700;color:#fff;flex-shrink:0">SM</div>
                            <div>
                                <div class="hv-dname">Sifiso Mhlanga</div>
                                <div class="hv-badge" style="color:#9aa096">Departs 16:00</div>
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
                            <span class="hv-title">Harare → Bulawayo</span>
                            <span class="hv-eta">42 km left</span>
                        </div>
                        <div class="hv-row">
                            <img src="/images/driver-1.jpg" alt="" class="hv-track-avatar">
                            <div style="flex:1">
                                <div class="hv-val">Tendai is on the way</div>
                                <div class="hv-label" style="margin-top:2px">In transit · near Kadoma</div>
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
                    <div class="why-logo-wrap">
                        <img src="/images/nhume_brand.png" alt="Nhume" style="width:28px;height:28px;object-fit:contain;">
                    </div>
                    <p class="why-name">Nhume.</p>
                    <p class="why-desc">Parcels travel in vehicles already heading your way. No depots, no fixed schedules, no anonymous drivers.</p>
                </div>
                <a href="{{ route('register') }}" class="why-cta">
                    Get started
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- COL 2 top: stat + badges row --}}
            <div class="why-card why-c2-top">
                <div>
                    <p class="why-stat-title">Verified Drivers</p>
                    <p class="why-stat-sub">Nhume Reviewed, minimum</p>
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
                <p class="why-big">4</p>
                <p class="why-name" style="margin-top:14px">Active routes</p>
                <p class="why-desc">Harare, Bulawayo, Mutare and Gweru. More opening as drivers join.</p>
            </div>

            {{-- BOTTOM WIDE: driver card spanning cols 2+3 --}}
            <div class="why-card why-bot">
                <img src="/images/driver-2.jpg" alt="" class="why-person-img">
                <div>
                    <p class="why-person-name">Tendai Moyo</p>
                    <p class="why-person-role">Driver, Harare to Bulawayo</p>
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
        <p class="eyebrow" style="color:var(--green);margin-bottom:18px">For transport operators</p>
        <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:#fff;margin:0 0 26px">
            You are already making the trip. Get paid for the space you are not using.
        </h2>
        <ul style="list-style:none;padding:0;margin:0 0 36px;display:flex;flex-direction:column;gap:16px">
            @foreach ([
                'Earn on trips you are already making. No extra driving.',
                'Set your own price and when you are available. No fixed hours.',
                'We find the parcels. You focus on driving.',
            ] as $pt)
            <li style="display:flex;align-items:flex-start;gap:13px;font-family:var(--font);font-size:15px;line-height:1.65;color:rgba(255,255,255,0.75)">
                <span style="width:20px;height:20px;border-radius:50%;background:rgba(107,198,48,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px">
                    <svg width="11" height="11" fill="none" stroke="var(--green)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </span>
                {{ $pt }}
            </li>
            @endforeach
        </ul>
        <div>
            <a href="{{ route('register') }}" class="btn-primary">
                Register as a transporter
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.4);margin-top:14px">Free to join. Commission only when you earn.</p>
        </div>
    </div>

    {{-- RIGHT: full-bleed driver face photo --}}
    <div class="reveal transporter-photo" style="position:relative;overflow:hidden;min-height:0">
        <img src="/images/driver-1.jpg" alt="Nhume driver Tendai"
             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:15% 18%">
        {{-- subtle dark gradient on left edge to blend into section bg --}}
        <div style="position:absolute;inset:0;background:linear-gradient(90deg,rgba(6,30,14,0.55) 0%,transparent 35%)"></div>
        {{-- name chip bottom-left --}}
        <div style="position:absolute;bottom:28px;left:28px;display:flex;align-items:center;gap:12px;background:rgba(4,16,8,0.78);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:12px 18px">
            <div>
                <p style="font-family:var(--head);font-size:14px;font-weight:700;color:#fff;margin:0">Tendai Moyo</p>
                <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.5);margin:3px 0 0">Harare to Bulawayo, 3x a week</p>
            </div>
            <span style="display:inline-flex;align-items:center;gap:5px;font-family:var(--font);font-size:11px;font-weight:700;color:var(--green);background:rgba(107,198,48,0.14);border-radius:9999px;padding:4px 10px;white-space:nowrap">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Reviewed
            </span>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     ROUTES
══════════════════════════════════════════════════ --}}
<section style="padding:var(--section-y) 0;background:var(--shade);overflow:hidden">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        {{-- Heading row --}}
        <div class="reveal routes-head">
            <div>
                <p class="eyebrow mb-4" style="display:inline-flex;align-items:center;gap:6px">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Coverage
                </p>
                <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:var(--forest-deep);margin:0">Starts in Zimbabwe.<br>Built for the region.</h2>
            </div>
            <p style="font-family:var(--font);font-size:15px;color:#6b7280;max-width:340px;line-height:1.65;margin:0;padding-bottom:6px">We launch where we can earn trust and grow route by route. Harare–Bulawayo is live, with more corridors to follow.</p>
        </div>

        {{-- Route cards --}}
        <div class="reveal routes-grid">

            {{-- Card 1: LIVE --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column">
                <span style="display:inline-flex;align-items:center;gap:7px;background:var(--green-mid);color:#fff;font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.07em;padding:5px 11px;border-radius:6px;width:fit-content;margin-bottom:32px">
                    <span style="width:6px;height:6px;background:#fff;border-radius:50%;animation:livepulse 1.8s ease-in-out infinite;flex-shrink:0"></span>
                    LIVE NOW
                </span>
                <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 8px">Zimbabwe</p>
                <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 12px;line-height:1.2">Harare → Bulawayo</h3>
                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 28px;flex:1">Zimbabwe's busiest corridor. Drivers available daily, both directions.</p>
                <a href="/journeys" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">View drivers →</a>
            </div>

            {{-- Card 2: LIVE --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column">
                <span style="display:inline-flex;align-items:center;gap:7px;background:var(--green-mid);color:#fff;font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.07em;padding:5px 11px;border-radius:6px;width:fit-content;margin-bottom:32px">
                    <span style="width:6px;height:6px;background:#fff;border-radius:50%;animation:livepulse 1.8s ease-in-out infinite 0.3s;flex-shrink:0"></span>
                    LIVE NOW
                </span>
                <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 8px">Zimbabwe</p>
                <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 12px;line-height:1.2">Harare → Mutare</h3>
                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 28px;flex:1">Eastern highlands route. Growing fast, with new drivers weekly.</p>
                <a href="/journeys" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">View drivers →</a>
            </div>

            {{-- Card 3: NEXT --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:28px;display:flex;flex-direction:column;opacity:0.6">
                <span style="display:inline-flex;align-items:center;background:var(--forest-deep);color:rgba(255,255,255,0.7);font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.07em;padding:5px 11px;border-radius:6px;width:fit-content;margin-bottom:32px">NEXT</span>
                <p style="font-family:var(--font);font-size:10.5px;font-weight:700;letter-spacing:0.1em;color:#9ca3af;text-transform:uppercase;margin:0 0 8px">Zimbabwe</p>
                <h3 style="font-family:var(--head);font-size:21px;font-weight:700;color:var(--forest-deep);letter-spacing:-0.02em;margin:0 0 12px;line-height:1.2">Bulawayo → Victoria Falls</h3>
                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.65;margin:0 0 28px;flex:1">Tourist-ready corridor. Drivers and senders signing up now.</p>
                <a href="{{ route('register') }}" style="font-family:var(--font);font-size:14px;font-weight:600;color:var(--forest-deep);text-decoration:none">Join the waitlist →</a>
            </div>

        </div>

        {{-- City marquee --}}
        <div style="overflow:hidden;-webkit-mask-image:linear-gradient(to right,transparent,black 12%,black 88%,transparent);mask-image:linear-gradient(to right,transparent,black 12%,black 88%,transparent)">
            <div style="display:flex;width:max-content;animation:marquee-routes 28s linear infinite">
                @foreach(array_merge(
                    ['Harare','Bulawayo','Mutare','Gweru','Victoria Falls','Masvingo','Kadoma','Kwekwe','Chinhoyi','Bindura','Marondera','Chegutu'],
                    ['Harare','Bulawayo','Mutare','Gweru','Victoria Falls','Masvingo','Kadoma','Kwekwe','Chinhoyi','Bindura','Marondera','Chegutu']
                ) as $city)
                <span style="display:inline-flex;align-items:center;gap:24px;font-family:var(--font);font-size:14px;color:#9ca3af;padding:0 24px;white-space:nowrap">
                    {{ $city }}
                    <span style="width:5px;height:5px;border-radius:50%;background:var(--green-mid);flex-shrink:0"></span>
                </span>
                @endforeach
            </div>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     TESTIMONIALS — Trackeo style
══════════════════════════════════════════════════ --}}
<section style="padding:var(--section-y) 0;background:var(--forest-deep)">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        {{-- TOP: heading left + photo right --}}
        <div class="reveal testimonials-top">
            <div>
                <p class="eyebrow" style="color:rgba(255,255,255,0.5);margin-bottom:16px;display:inline-flex;align-items:center;gap:7px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    Trusted by senders and drivers
                </p>
                <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:#fff;margin:0">See how Nhume moves parcels for people across Zimbabwe</h2>
            </div>
            <div style="border-radius:18px;overflow:hidden;aspect-ratio:16/10">
                <img src="/images/team.jpg" alt="Nhume team" style="width:100%;height:100%;object-fit:cover;object-position:center 30%">
            </div>
        </div>

        {{-- 3x2 GRID: borderless testimonials on dark bg --}}
        @php
        $reviews = [
            ['Ruvimbo T.',   '/images/driver-2.jpg',  true,  'Harare · Sender',       'Sent documents to Bulawayo. Arrived in under 5 hours. The driver collected from my office. I did not move.'],
            ['Blessing M.',  null,                    false, 'Bulawayo · Driver',      'I drive Harare to Byo three times a week. I earn an extra $30 to $40 per trip just from parcels. Straightforward.'],
            ['Tariro S.',    null,                    false, 'Harare · Business',      'We send spare parts between branches weekly. Nhume is faster than the depot schedule and the pricing is fair.'],
            ['Chipo N.',     null,                    false, 'Mutare · Sender',        'Booked a space in 2 minutes. My parcel was in Harare by 3pm the same day. Faster than I expected.'],
            ['Sifiso M.',    '/images/driver-1.jpg',  true,  'Gweru · Driver',         'I was already driving. Now I earn on every trip. No pressure, no fixed schedule. Just extra income when I want it.'],
            ['Rudo K.',      null,                    false, 'Harare · SME owner',     'Consistent, affordable, and the drivers actually pick up when you call. Nothing else on this route compares.'],
        ];
        @endphp
        <div class="reveal testimonials-grid">
            @foreach ($reviews as [$name, $img, $hasImg, $role, $quote])
            <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:14px;padding:24px;display:flex;flex-direction:column;gap:16px">
                {{-- name row --}}
                <div style="display:flex;align-items:center;gap:11px">
                    @if($hasImg)
                    <img src="{{ $img }}" alt="{{ $name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;object-position:26% 15%;flex-shrink:0">
                    @else
                    <span style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;font-family:var(--head);font-size:14px;font-weight:700;color:rgba(255,255,255,0.7);flex-shrink:0">{{ substr($name,0,1) }}</span>
                    @endif
                    <span style="font-family:var(--head);font-size:15px;font-weight:600;color:#fff;letter-spacing:-0.01em;flex:1">{{ $name }}</span>
                    <span style="font-family:Georgia,serif;font-size:22px;font-weight:700;color:rgba(255,255,255,0.18);line-height:1">&rdquo;</span>
                </div>
                {{-- quote --}}
                <p style="font-family:var(--font);font-size:14px;line-height:1.72;color:rgba(255,255,255,0.55);margin:0;flex:1">{{ $quote }}</p>
                <p style="font-family:var(--font);font-size:11.5px;color:rgba(255,255,255,0.28);margin:0">{{ $role }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════ --}}
<section id="faq" style="padding:var(--section-y) 0;background:var(--shade)">
    <div style="max-width:1120px;margin:0 auto;padding:0 clamp(20px,4vw,48px)">

        <div class="reveal faq-layout">

            {{-- Left: sticky heading --}}
            <div class="faq-sticky" style="position:sticky;top:100px">
                <p style="font-family:var(--font);font-size:12px;font-weight:600;letter-spacing:0.06em;color:#6b7280;display:inline-flex;align-items:center;gap:7px;margin:0 0 20px">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Need help?
                </p>
                <h2 style="font-family:var(--head);font-size:clamp(32px,4vw,52px);font-weight:700;letter-spacing:-0.03em;line-height:1.1;color:var(--forest-deep);margin:0">Answers to common questions about Nhume's services</h2>
            </div>

            {{-- Right: accordion --}}
            @php $faqs = [
                ['Is my parcel insured?', 'Every booking on Nhume includes basic parcel cover. For high-value items, you can declare the value and add extended cover at checkout. We always show you your cover details before you confirm.'],
                ["What if the transporter doesn't show up?", 'You only pay after the transporter confirms pickup. If they cancel, you get a full refund instantly. We also have backup transporter options on all popular routes.'],
                ['How are transporters verified?', 'Our team speaks personally to every transporter before they go live. That is the minimum. Higher tiers require ID and background checks.'],
                ['What can I send?', 'Documents, clothing, electronics, food items, and small household goods. No hazardous materials, no live animals. Maximum dimensions are shown at checkout.'],
                ['How does the transporter pick up my parcel?', 'Once booked, you agree on a pickup point with the transporter, usually somewhere central. You will not hand over a parcel without a confirmed booking first.'],
                ['Do I need an account to book?', 'You can browse all trips without an account. You only need to sign up when you are ready to book. It takes under 60 seconds.'],
            ]; @endphp

            <div x-data="{ open: 0 }" style="background:#fff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden">
                @foreach ($faqs as $i => $faq)
                <div style="{{ $i > 0 ? 'border-top:1px solid #e5e7eb' : '' }}">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:22px 24px;text-align:left;background:none;border:none;cursor:pointer;gap:20px">
                        <span style="font-family:var(--font);font-size:15px;font-weight:500;color:#1c1c1c;line-height:1.4">{{ $faq[0] }}</span>
                        <span style="flex-shrink:0;line-height:0">
                            {{-- Plus: shown when closed --}}
                            <svg x-show="open !== {{ $i }}" width="18" height="18" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" viewBox="0 0 18 18">
                                <line x1="9" y1="3" x2="9" y2="15"/><line x1="3" y1="9" x2="15" y2="9"/>
                            </svg>
                            {{-- X: shown when open --}}
                            <svg x-show="open === {{ $i }}" width="18" height="18" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" viewBox="0 0 18 18">
                                <line x1="4" y1="4" x2="14" y2="14"/><line x1="14" y1="4" x2="4" y2="14"/>
                            </svg>
                        </span>
                    </button>
                    <div class="faq-body" :class="open === {{ $i }} ? 'open' : ''">
                        <div class="faq-inner">
                            <div style="padding:0 24px 22px">
                                <p style="font-family:var(--font);font-size:14px;color:#6b7280;line-height:1.75;margin:0">{{ $faq[1] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        {{-- Bottom: still have questions bar --}}
        <div class="reveal" style="background:#fff;border-radius:16px;padding:28px 32px;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap">
            <div>
                <p style="font-family:var(--head);font-size:19px;font-weight:700;color:#1c1c1c;margin:0 0 5px">Still have questions?</p>
                <p style="font-family:var(--font);font-size:14px;color:#6b7280;margin:0">Our support team can help you out.</p>
            </div>
            <a href="/contact" style="display:inline-flex;align-items:center;gap:8px;background:var(--forest-deep);color:#fff;font-family:var(--font);font-size:14px;font-weight:600;padding:13px 24px;border-radius:10px;text-decoration:none;white-space:nowrap;transition:opacity 0.2s" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                Get in touch
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════
     CTA
══════════════════════════════════════════════════ --}}
<div style="background:#fff;padding:clamp(40px,6vw,80px) clamp(16px,3vw,40px)">
<section style="background:var(--forest-deep);border-radius:20px;overflow:hidden;position:relative">

    {{-- Full-width heading --}}
    <div class="reveal" style="padding:clamp(24px,3vw,40px) clamp(20px,4vw,48px) 14px;text-align:center">
        <h2 style="font-family:var(--head);font-size:clamp(32px,5.5vw,72px);font-weight:700;letter-spacing:-0.04em;line-height:1.06;color:#fff;margin:0">Moving Parcels With<br>Drivers Already in Motion.</h2>
    </div>

    {{-- Subtitle + buttons + social proof --}}
    <div class="reveal" style="max-width:560px;margin:0 auto;padding:0 clamp(20px,4vw,48px) 40px;text-align:center">

        <p style="font-family:var(--font);font-size:16px;color:rgba(255,255,255,0.5);line-height:1.65;margin:0 auto 32px">Connect your parcel with transporters already heading your way. Fast, trusted, and community-driven.</p>

        <div style="display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:32px">
            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:8px;background:var(--green);color:var(--forest-deep);font-family:var(--font);font-size:15px;font-weight:700;padding:14px 28px;border-radius:12px;text-decoration:none;transition:background 0.2s" onmouseover="this.style.background='#5aad28'" onmouseout="this.style.background='var(--green)'">
                Browse drivers
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;font-family:var(--font);font-size:15px;font-weight:600;padding:13px 26px;border-radius:12px;text-decoration:none;border:1.5px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.65);transition:all 0.2s" onmouseover="this.style.borderColor='rgba(255,255,255,0.45)';this.style.color='#fff'" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)';this.style.color='rgba(255,255,255,0.65)'">
                Become a transporter
            </a>
        </div>

        <div style="display:inline-flex;align-items:center;gap:14px">
            <div style="display:flex;align-items:center">
                <img src="/images/driver-1.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:26% 15%;border:2.5px solid var(--forest-deep);margin-right:-10px;position:relative;z-index:3">
                <img src="/images/driver-2.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:26% 15%;border:2.5px solid var(--forest-deep);margin-right:-10px;position:relative;z-index:2">
                <img src="/images/driver-3.jpg" style="width:34px;height:34px;border-radius:50%;object-fit:cover;object-position:50% 20%;border:2.5px solid var(--forest-deep);position:relative;z-index:1">
            </div>
            <p style="font-family:var(--font);font-size:12.5px;color:rgba(255,255,255,0.38);margin:0;text-align:left">Trusted by senders &amp; drivers<br>across Zimbabwe</p>
        </div>

    </div>

    {{-- Hero scene reused --}}
    <div class="hero-scene cta-scene" aria-hidden="true" style="min-height:160px;max-height:180px">

        <svg class="scene-globe" viewBox="0 0 1000 500" fill="none" preserveAspectRatio="xMidYMid meet">
            <defs>
                <pattern id="ctaMapDots" width="13" height="13" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1.7" fill="rgba(255,255,255,0.07)"/>
                </pattern>
            </defs>
            <g fill="url(#ctaMapDots)">
                <path d="M120 90 C100 120 105 150 130 165 C120 200 155 220 185 205 C200 235 235 235 250 210 C270 215 285 190 275 165 C295 150 295 120 270 108 C260 85 225 78 200 88 C175 78 140 78 120 90 Z"/>
                <path d="M300 250 C280 260 275 290 290 320 C292 360 312 408 332 406 C354 400 350 360 342 330 C352 300 345 270 328 258 C320 250 310 249 300 250 Z"/>
                <path d="M500 105 C486 110 484 128 496 140 C491 158 513 164 530 157 C548 161 560 146 552 130 C561 115 548 100 528 103 C518 98 508 101 500 105 Z"/>
                <path d="M520 180 C500 195 500 228 515 256 C515 300 535 352 560 356 C584 351 598 314 590 282 C608 252 603 210 580 194 C560 178 538 174 520 180 Z"/>
                <path d="M620 85 C596 93 591 122 611 143 C601 176 640 204 685 199 C734 208 798 194 843 172 C876 156 880 120 850 103 C814 82 746 76 696 80 C671 78 646 79 620 85 Z"/>
                <path d="M792 335 C772 345 774 372 794 388 C817 402 853 400 873 385 C889 371 884 346 863 337 C839 328 812 328 792 335 Z"/>
            </g>
        </svg>

        <svg class="scene-route" viewBox="0 0 1000 380" fill="none" preserveAspectRatio="none">
            <circle cx="132" cy="120" r="5.5" fill="var(--green)"/>
            <path d="M132 120 C 300 170, 300 244, 480 257 C 640 268, 660 293, 792 305" stroke="var(--green)" stroke-width="2.4" stroke-dasharray="1.5 12" stroke-linecap="round" opacity="0.9"/>
        </svg>

        <svg class="scene-van" viewBox="0 0 240 150" fill="none">
            <ellipse cx="118" cy="128" rx="98" ry="9" fill="rgba(0,0,0,0.2)"/>
            <rect x="22" y="34" width="118" height="66" rx="10" fill="#fff" stroke="var(--forest-deep)" stroke-width="3.5"/>
            <path d="M140 34 H176 L206 66 V100 H140 Z" fill="#fff" stroke="var(--forest-deep)" stroke-width="3.5" stroke-linejoin="round"/>
            <path d="M150 46 H172 L191 64 H150 Z" fill="var(--green-light)" stroke="var(--forest-deep)" stroke-width="2.5" stroke-linejoin="round"/>
            <path d="M84 36 V98" stroke="var(--forest-deep)" stroke-width="2.5"/>
            <path d="M28 82 H132" stroke="var(--green)" stroke-width="6" stroke-linecap="round"/>
            <circle cx="200" cy="86" r="4" fill="var(--green)"/>
            <circle cx="62" cy="100" r="18" fill="#fff" stroke="var(--forest-deep)" stroke-width="3.5"/>
            <circle cx="62" cy="100" r="6.5" fill="var(--forest-deep)"/>
            <circle cx="176" cy="100" r="18" fill="#fff" stroke="var(--forest-deep)" stroke-width="3.5"/>
            <circle cx="176" cy="100" r="6.5" fill="var(--forest-deep)"/>
        </svg>

        <div class="scene-pin scene-pin-depot">
            <span class="scene-pin-pulse"></span>
            <svg width="30" height="30" viewBox="0 0 24 24" fill="var(--forest-deep)"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
        </div>

        <div class="scene-card sc-status">
            <div class="sc-row" style="margin-bottom:11px;">
                <span class="sc-ic"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m0-14L4 17m8 4V11"/></svg></span>
                <span class="sc-title">Driver status</span>
            </div>
            <span class="sc-tag">In transit</span>
            <div class="sc-row" style="margin-top:12px;gap:9px;">
                <span class="sc-photo-avatar"><img src="/images/driver-2.jpg" alt="" style="object-position:26% 42%"></span>
                <div><p class="sc-strong">NHM-4821</p><p class="sc-sub">Harare → Bulawayo</p></div>
            </div>
        </div>

        <div class="scene-card sc-driver sc-photo">
            <img class="sc-photo-img" src="/images/driver-1.jpg" alt="Nhume driver" style="object-position:42% 16%">
            <span class="sc-photo-tag">
                <svg width="11" height="11" fill="none" stroke="var(--green-mid)" viewBox="0 0 24 24" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Tendai Moyo
            </span>
        </div>

    </div>

</section>
</div>


{{-- ══════════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════════ --}}
<footer class="site-footer" style="background:#081510;overflow:hidden;position:relative;">

    {{-- Main grid --}}
    <div style="max-width:1200px;margin:0 auto;padding:60px 24px 44px;position:relative;z-index:1;">
        <div class="footer-grid" style="padding-bottom:44px;border-bottom:1px solid rgba(255,255,255,0.055);margin-bottom:32px;">

            {{-- Brand --}}
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
                ['Platform', ['How it works' => '#how-it-works', 'Send a parcel' => route('register'), 'Browse drivers' => '/journeys', 'For transporters' => '#transporters', 'Pricing' => '#']],
                ['Support',  ['FAQ' => '#faq', 'Contact us' => '/contact', 'Track a parcel' => '#', 'Report an issue' => '#', 'Safety' => '#']],
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

        {{-- Bottom bar --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <p style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.18);margin:0">© {{ date('Y') }} Nhume Technologies. All rights reserved. &nbsp;·&nbsp; <span style="color:rgba(255,255,255,0.28)">A <a href="#" style="color:rgba(255,255,255,0.35);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">ShiftTech</a> product</span></p>
            <div style="display:flex;gap:24px;">
                @foreach (['Terms of Service', 'Privacy Policy', 'Cookie Policy'] as $l)
                <a href="#" style="font-family:var(--font);font-size:12px;color:rgba(255,255,255,0.16);text-decoration:none;transition:color 0.15s" onmouseover="this.style.color='rgba(255,255,255,0.45)'" onmouseout="this.style.color='rgba(255,255,255,0.16)'">{{ $l }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Giant gradient watermark --}}
    <div style="overflow:hidden;line-height:0.78;pointer-events:none;user-select:none">
        <p style="font-family:var(--head);font-size:clamp(100px,17vw,220px);font-weight:800;letter-spacing:-0.03em;margin:0;padding:0 16px;white-space:nowrap;text-align:center;background:linear-gradient(180deg,rgba(255,255,255,0.05) 0%,rgba(255,255,255,0.01) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">NHUME</p>
    </div>

</footer>


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

</body>
</html>
