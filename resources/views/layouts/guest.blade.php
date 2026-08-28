<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nhume') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Inter:opsz,wght@14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    :root {
        --font: 'DM Sans', system-ui, sans-serif;
        --head: 'Inter', 'DM Sans', system-ui, sans-serif;
        --green: #6bc630; --green-dark: #5aad28; --green-mid: #4a9a1f; --green-light: #edf8df;
        --forest: #1C3829; --forest-deep: #062e14;
        --text: #0b130a; --text-2: #3d4a3a; --muted: #8a9187;
        --border: #DDD9D0; --shade: #f7f6f3;
    }
    * { box-sizing: border-box; }
    body { margin: 0; font-family: var(--font); color: var(--text); -webkit-font-smoothing: antialiased; background: var(--shade); }
    [x-cloak] { display: none !important; }

    .auth-page {
        min-height: 100vh;
        min-height: 100svh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .auth-logo {
        display: block;
        margin-bottom: 28px;
        text-decoration: none;
        flex-shrink: 0;
    }
    .auth-logo img { height: 100px; width: auto; display: block; }

    .auth-card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 36px 36px 32px;
    }

    .auth-back {
        margin-top: 24px;
        font-family: var(--font);
        font-size: 13px;
        color: var(--muted);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: color 0.15s;
    }
    .auth-back:hover { color: var(--forest); }

    /* ── Heading ── */
    .auth-head { margin-bottom: 26px; }
    .auth-title {
        font-family: var(--head);
        font-size: 22px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--forest);
        margin: 0 0 5px;
    }
    .auth-subtitle {
        font-family: var(--font);
        font-size: 14px;
        color: var(--muted);
        margin: 0;
    }

    /* ── Fields ── */
    .auth-form { display: flex; flex-direction: column; gap: 16px; }
    .auth-field { display: flex; flex-direction: column; }
    .auth-label-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 7px; }
    .auth-label {
        font-family: var(--font);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-2);
        margin-bottom: 7px;
        display: block;
    }
    .auth-field > .auth-label { margin-bottom: 7px; }

    .auth-forgot {
        font-family: var(--font);
        font-size: 12px;
        font-weight: 600;
        color: var(--green-mid);
        text-decoration: none;
        transition: color 0.15s;
    }
    .auth-forgot:hover { color: var(--green-dark); text-decoration: underline; }

    .auth-input {
        width: 100%;
        font-family: var(--font);
        font-size: 15px;
        color: var(--text);
        background: #f8f7f2;
        border: 1.5px solid #e4e1db;
        border-radius: 6px;
        padding: 12px 14px;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
    }
    .auth-input::placeholder { color: #a7ada3; }
    .auth-input:focus {
        border-color: var(--green);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(107,198,48,0.12);
    }
    .auth-input.has-error { border-color: #e06b6b; }
    .auth-input.has-error:focus { box-shadow: 0 0 0 3px rgba(224,107,107,0.12); }

    .auth-error {
        font-family: var(--font);
        font-size: 12px;
        color: #d64545;
        margin: 5px 0 0;
    }

    /* password reveal */
    .auth-input-wrap { position: relative; display: flex; align-items: center; }
    .auth-input-wrap .auth-input { padding-right: 44px; }
    .auth-reveal {
        position: absolute; right: 6px;
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        background: none; border: none; cursor: pointer;
        color: #9aa096; border-radius: 4px;
        transition: color 0.15s, background 0.15s;
    }
    .auth-reveal:hover { color: var(--text-2); background: var(--shade); }

    .auth-check {
        display: inline-flex; align-items: center; gap: 9px;
        font-family: var(--font); font-size: 13px; color: var(--text-2);
        cursor: pointer; user-select: none;
    }
    .auth-check input { width: 16px; height: 16px; accent-color: var(--green-mid); cursor: pointer; }

    /* ── Submit ── */
    .auth-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        font-family: var(--font);
        font-size: 15px;
        font-weight: 700;
        color: var(--forest-deep);
        background: var(--green);
        border: none;
        border-radius: 6px;
        padding: 13px;
        cursor: pointer;
        letter-spacing: 0.01em;
        transition: background 0.15s;
        margin-top: 6px;
    }
    .auth-btn:hover { background: var(--green-dark); }

    /* ── Footer links ── */
    .auth-alt {
        font-family: var(--font);
        font-size: 13.5px;
        color: var(--muted);
        text-align: center;
        margin: 22px 0 0;
    }
    .auth-alt a { color: var(--forest); font-weight: 600; text-decoration: none; }
    .auth-alt a:hover { color: var(--green-mid); text-decoration: underline; }

    .auth-status {
        font-family: var(--font); font-size: 13px; font-weight: 500;
        color: var(--green-mid); background: var(--green-light);
        border: 1px solid rgba(107,198,48,0.3); border-radius: 6px;
        padding: 10px 14px; margin: 0 0 18px;
    }

    .auth-divider {
        display: flex; align-items: center; gap: 12px;
        margin: 18px 0; color: var(--muted);
        font-size: 12px; font-family: var(--font);
    }
    .auth-divider::before, .auth-divider::after { content: ""; flex: 1; height: 1px; background: var(--border); }

    @keyframes auth-spin { to { transform: rotate(360deg); } }
    .auth-spinner { animation: auth-spin 0.75s linear infinite; flex-shrink: 0; }
    .auth-btn:disabled { opacity: 0.65; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="auth-page" x-data>

        <a href="/" class="auth-logo" aria-label="Nhume home">
            <img src="/images/nhume_logo_v4.png" alt="Nhume">
        </a>

        <div class="auth-card">
            {{ $slot }}
        </div>

        <a href="/" class="auth-back">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Back to Nhume
        </a>

    </div>
</body>
</html>
