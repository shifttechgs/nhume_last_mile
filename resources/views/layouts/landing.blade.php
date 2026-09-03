<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nhume')</title>
    <meta name="description" content="@yield('description', 'Same-day errands and intercity parcels, moved by real people across Zimbabwe.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Inter:opsz,wght@14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    :root {
        --font:        'DM Sans', system-ui, sans-serif;
        --head:        'Inter', 'DM Sans', system-ui, sans-serif;
        --green:       #6bc630;
        --green-dark:  #5aad28;
        --green-light: #edf8df;
        --green-mid:   #4a9a1f;
        --forest:      #1C3829;
        --forest-deep: #062e14;
        --text:        #0b130a;
        --text-2:      #6b7280;
        --border:      #e5e7eb;
        --shade:       #f9fafb;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: var(--font); color: var(--text); background: #fff; -webkit-font-smoothing: antialiased; }
    [x-cloak] { display: none !important; }

    /* ── Page hero banner ── */
    .lp-hero {
        background: var(--forest-deep);
        padding: clamp(200px, 26vh, 280px) clamp(20px, 4vw, 48px) clamp(48px, 6vw, 80px);
        text-align: center;
    }
    .lp-eyebrow {
        display: inline-block;
        font-family: var(--font);
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--green-mid); margin-bottom: 16px;
    }
    .lp-hero h1 {
        font-family: var(--head);
        font-size: clamp(32px, 4.5vw, 56px);
        font-weight: 700; letter-spacing: -0.03em;
        line-height: 1.08; color: #fff; margin: 0 0 16px;
    }
    .lp-hero p {
        font-family: var(--font);
        font-size: 16px; color: rgba(255,255,255,0.55);
        line-height: 1.65; max-width: 500px;
        margin: 0 auto;
    }

    /* ── Content shell ── */
    .lp-body {
        max-width: 1120px;
        margin: 0 auto;
        padding: clamp(48px, 7vw, 80px) clamp(20px, 4vw, 48px);
    }
    .lp-section { margin-bottom: clamp(40px, 6vw, 72px); }
    .lp-section:last-child { margin-bottom: 0; }

    /* ── Section heading ── */
    .lp-sh {
        font-family: var(--head);
        font-size: clamp(22px, 2.5vw, 30px);
        font-weight: 700; letter-spacing: -0.02em;
        color: var(--forest); margin: 0 0 8px;
    }
    .lp-sp {
        font-family: var(--font);
        font-size: 15px; color: var(--text-2);
        line-height: 1.65; margin: 0 0 32px;
        max-width: 640px;
    }

    /* ── Info card ── */
    .lp-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 28px;
    }

    /* ── Grid helpers ── */
    .lp-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
    .lp-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
    @media (max-width: 768px) { .lp-grid-2, .lp-grid-3 { grid-template-columns: 1fr; } }

    /* ── Form fields ── */
    .lp-label {
        display: block;
        font-size: 12px; font-weight: 600;
        color: #6b7280; text-transform: uppercase;
        letter-spacing: 0.06em; margin-bottom: 6px;
    }
    .lp-input {
        width: 100%; padding: 11px 14px;
        border: 1.5px solid var(--border); border-radius: 6px;
        font-family: var(--font); font-size: 14px; color: var(--text);
        background: var(--shade); outline: none;
        transition: border-color 0.15s, background 0.15s;
    }
    .lp-input:focus { border-color: var(--forest); background: #fff; }
    .lp-input::placeholder { color: #9ca3af; }

    /* ── Buttons ── */
    .lp-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--forest); color: #fff;
        font-family: var(--font); font-size: 14px; font-weight: 600;
        padding: 12px 24px; border: none; border-radius: 6px;
        cursor: pointer; text-decoration: none;
        transition: background 0.15s;
    }
    .lp-btn:hover { background: var(--forest-deep); }
    .lp-btn-ghost {
        display: inline-flex; align-items: center; gap: 8px;
        background: none; color: var(--text-2);
        font-family: var(--font); font-size: 14px; font-weight: 500;
        padding: 11px 22px; border: 1.5px solid var(--border); border-radius: 6px;
        cursor: pointer; text-decoration: none;
        transition: border-color 0.15s, color 0.15s;
    }
    .lp-btn-ghost:hover { border-color: #9ca3af; color: var(--text); }

    @keyframes lp-spin { to { transform: rotate(360deg); } }
    .lp-spinner { animation: lp-spin 0.75s linear infinite; flex-shrink: 0; }
    </style>

    @yield('styles')
</head>
<body x-data="{ trackOpen: false, trackNum: '' }" @keydown.escape.window="trackOpen = false">

    <x-landing.nav :frosted="true" />

    @yield('content')

    <x-landing.footer />
    <x-landing.track-modal />

</body>
</html>
