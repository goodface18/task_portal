<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') · onsoftarch</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #5cc820; --black: #0d0d0d; --surface: #131313;
            --off: #f0efe9; --white: #fff; --border: rgba(255,255,255,.08);
            --border2: rgba(255,255,255,.14); --muted: rgba(255,255,255,.52);
            --dim: rgba(255,255,255,.28); --red: #f2495c;
            --mono: 'DM Mono', monospace; --serif: 'DM Serif Display', serif;
            --sans: 'Instrument Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        html, body { min-height: 100%; margin: 0; }
        body { min-height: 100vh; background: var(--black); color: var(--off); font: 13px var(--sans); display: flex; flex-direction: column; }
        body::before { content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(92,200,32,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,.03) 1px, transparent 1px); background-size: 32px 32px; }
        .auth-topbar { position: relative; z-index: 1; height: 60px; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); background: rgba(13,13,13,.9); backdrop-filter: blur(12px); }
        .auth-brand { display: flex; align-items: center; gap: 12px; }
        .auth-logo { color: var(--white); font-size: 1.05rem; font-weight: 600; text-decoration: none; }
        .auth-logo span { color: var(--green); }
        .auth-divider { width: 1px; height: 22px; background: var(--border2); }
        .auth-context { color: var(--muted); font: .59rem var(--mono); letter-spacing: .12em; text-transform: uppercase; }
        .auth-top-link { padding: 7px 11px; border: 1px solid var(--border2); border-radius: 3px; color: var(--muted); font: .59rem var(--mono); letter-spacing: .06em; text-transform: uppercase; text-decoration: none; }
        .auth-top-link:hover { color: var(--green); border-color: rgba(92,200,32,.4); }
        .auth-main { position: relative; z-index: 1; flex: 1; width: 100%; display: flex; align-items: center; justify-content: center; padding: 45px 18px; }
        .auth-card { width: min(100%, 500px); overflow: hidden; background: rgba(10,10,10,.94); border: 1px solid var(--border2); border-radius: 6px; box-shadow: 0 28px 75px rgba(0,0,0,.48); }
        .auth-card-head { padding: 24px 26px 0; }
        .auth-eyebrow { margin-bottom: 8px; color: var(--green); font: .59rem var(--mono); letter-spacing: .16em; text-transform: uppercase; }
        .auth-card-title { margin: 0; color: var(--white); font: 1.8rem/1.1 var(--serif); }
        .auth-card-title em { color: var(--green); font-weight: 400; }
        .auth-description { margin: 9px 0 0; color: var(--muted); font-size: .84rem; line-height: 1.6; }
        .auth-card-body { padding: 22px 26px 26px; }
        .auth-status { margin-bottom: 16px; padding: 10px 12px; border: 1px solid rgba(92,200,32,.25); border-left: 3px solid var(--green); border-radius: 3px; background: rgba(92,200,32,.06); color: var(--green); font: .65rem var(--mono); line-height: 1.5; }
        .auth-field { margin-bottom: 16px; }
        .auth-label { display: block; margin-bottom: 7px; color: var(--green); font: .59rem var(--mono); letter-spacing: .08em; text-transform: uppercase; }
        .auth-input { width: 100%; padding: 11px 12px; border: 1px solid var(--border2); border-radius: 3px; background: rgba(255,255,255,.02); color: var(--off); font: .78rem var(--mono); outline: none; transition: border-color .2s, box-shadow .2s; }
        .auth-input::placeholder { color: var(--dim); }
        .auth-input:focus { border-color: rgba(92,200,32,.6); box-shadow: 0 0 0 3px rgba(92,200,32,.09); }
        .auth-error { display: block; margin-top: 6px; color: var(--red); font: .61rem var(--mono); }
        .auth-submit { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 14px; border: 1px solid var(--green); border-radius: 3px; background: var(--green); color: var(--black); font: .67rem var(--mono); font-weight: 500; letter-spacing: .08em; text-transform: uppercase; cursor: pointer; transition: transform .15s, opacity .15s; }
        .auth-submit:hover { opacity: .92; transform: translateY(-1px); }
        .auth-actions { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 16px; }
        .auth-back { color: var(--muted); font: .62rem var(--mono); text-decoration: none; }
        .auth-back:hover { color: var(--green); }
        .auth-footer { position: relative; z-index: 1; padding: 17px 18px 21px; text-align: center; color: var(--dim); font: .54rem var(--mono); letter-spacing: .1em; text-transform: uppercase; }
        .auth-footer span { color: var(--green); }
        @media (max-width: 560px) {
            .auth-topbar { padding: 0 14px; }
            .auth-context { display: none; }
            .auth-main { align-items: flex-start; padding: 32px 14px; }
            .auth-card-head { padding: 21px 19px 0; }
            .auth-card-body { padding: 19px; }
            .auth-card-title { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <header class="auth-topbar">
        <div class="auth-brand">
            <a class="auth-logo" href="{{ route('login') }}">onsoft<span>arch</span></a>
            <span class="auth-divider"></span>
            <span class="auth-context">BDC · Secure Access</span>
        </div>
        <a class="auth-top-link" href="{{ route('login') }}">← Sign in</a>
    </header>
    <main class="auth-main">
        <section class="auth-card">
            <div class="auth-card-head">
                <div class="auth-eyebrow">Account recovery</div>
                <h1 class="auth-card-title">@yield('heading')</h1>
                <p class="auth-description">@yield('description')</p>
            </div>
            <div class="auth-card-body">@yield('content')</div>
        </section>
    </main>
    <footer class="auth-footer">Banco di Caribe · <span>onsoftarch</span> · Secure Access</footer>
</body>
</html>
