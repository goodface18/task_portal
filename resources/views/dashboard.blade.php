<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $portal === 'client' ? 'Client Portal' : 'Team Hub' }} · onsoftarch</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green: #5cc820; --black: #0d0d0d; --surface: #131313; --surface2: #181818;
            --off: #f0efe9; --white: #fff; --border: rgba(255,255,255,0.08); --border2: rgba(255,255,255,0.12);
            --muted: rgba(255,255,255,0.45); --dim: rgba(255,255,255,0.2);
            --red: #f2495c; --amber: #fade2a; --blue: #5794f2; --orange: #ff9830; --purple: #b877d9;
            --bdc: #f08a3c;
            --mono: 'DM Mono', monospace; --serif: 'DM Serif Display', serif; --sans: 'Instrument Sans', sans-serif;
        }
        html { scroll-behavior: smooth; }
        body { background: var(--black); color: var(--off); font-family: var(--sans); min-height: 100vh; font-size: 13px; }
        body::before { content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(92,200,32,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,0.03) 1px, transparent 1px); background-size: 32px 32px; }
        body.locked { overflow: hidden; }

        /* Client portal styles */
        @scope (.client-portal) {

        
        
        
        body { background: var(--black); color: var(--off); font-family: var(--sans); min-height: 100vh; font-size: 13px; }
        body::before { content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(92,200,32,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,0.03) 1px, transparent 1px); background-size: 32px 32px; }
        body.locked { overflow: hidden; }

        /* ===== LOGIN GATE ===== */
        #gate { position: fixed; inset: 0; z-index: 9999; background: #0d0d0d; display: flex; align-items: center; justify-content: center; overflow: hidden; transition: opacity 0.6s ease, visibility 0.6s ease; }
        #gate.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        #gate .bg-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(92,200,32,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,0.04) 1px, transparent 1px); background-size: 40px 40px; -webkit-mask-image: radial-gradient(ellipse 70% 70% at 50% 45%, black 10%, transparent 80%); mask-image: radial-gradient(ellipse 70% 70% at 50% 45%, black 10%, transparent 80%); }
        #gate .bg-glow { position: absolute; width: 600px; height: 460px; top: 50%; left: 50%; transform: translate(-50%,-50%); background: radial-gradient(ellipse, rgba(240,138,60,0.10) 0%, transparent 70%); animation: pulse 7s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:0.7; transform:translate(-50%,-50%) scale(1);} 50%{opacity:1; transform:translate(-50%,-50%) scale(1.08);} }
        .gate-card { position: relative; z-index: 2; width: 100%; max-width: 400px; padding: 1.5rem; opacity: 0; transform: translateY(20px); animation: rise 0.7s cubic-bezier(0.22,1,0.36,1) forwards 0.15s; }
        @keyframes rise { to { opacity:1; transform: translateY(0);} }
        .gate-brand { text-align: center; margin-bottom: 1.5rem; }
        .gate-brand img { width: 88px; height: 88px; object-fit: contain; filter: drop-shadow(0 6px 20px rgba(240,138,60,0.3)); margin-bottom: 1rem; }
        .gate-cobrand { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.14em; color: var(--muted); text-transform: uppercase; }
        .gate-cobrand .x { color: var(--dim); margin: 0 6px; }
        .gate-cobrand b { color: var(--green); font-weight: 500; }
        .gate-sub { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.22em; color: var(--muted); text-transform: uppercase; margin-top: 0.7rem; }
        .gate-term { background: rgba(10,10,10,0.92); border: 1px solid var(--border2); border-radius: 8px; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.6); }
        .gate-bar { background: #131313; border-bottom: 1px solid var(--border); padding: 11px 15px; display: flex; align-items: center; gap: 8px; }
        .gate-bar .d { width: 11px; height: 11px; border-radius: 50%; }
        .gate-bar .t { font-family: var(--mono); font-size: 0.66rem; color: var(--muted); margin-left: 10px; }
        .gate-body { padding: 1.75rem; }
        .gate-field label { display: block; font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.08em; color: var(--green); text-transform: uppercase; margin-bottom: 0.5rem; }
        .gate-input-wrap { position: relative; display: flex; align-items: center; }
        .gate-input-wrap .pr { position: absolute; left: 12px; font-family: var(--mono); color: var(--green); font-size: 0.82rem; pointer-events: none; }
        .gate-field input { width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 4px; padding: 12px 12px 12px 30px; color: var(--off); font-family: var(--mono); font-size: 0.9rem; outline: none; letter-spacing: 0.1em; transition: border-color 0.2s, box-shadow 0.2s; }
        .gate-field input:focus { border-color: rgba(92,200,32,0.6); box-shadow: 0 0 0 3px rgba(92,200,32,0.1); }
        .gate-btn { width: 100%; margin-top: 1rem; background: var(--green); color: var(--black); font-family: var(--mono); font-size: 0.78rem; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; border: none; border-radius: 4px; padding: 13px; cursor: pointer; transition: opacity 0.2s, transform 0.15s; }
        .gate-btn:hover { opacity: 0.92; transform: translateY(-1px); }
        .gate-msg { font-family: var(--mono); font-size: 0.7rem; margin-top: 0.9rem; min-height: 16px; color: var(--red); }
        .gate-hint { font-family: var(--mono); font-size: 0.62rem; color: var(--dim); text-align: center; margin-top: 1.25rem; letter-spacing: 0.04em; }
        .gate-hint b { color: var(--muted); }
        @keyframes shake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-8px)} 40%{transform:translateX(8px)} 60%{transform:translateX(-5px)} 80%{transform:translateX(5px)} }

        /* ===== HEADER ===== */
        .header { position: sticky; top: 0; z-index: 100; background: rgba(13,13,13,0.92); backdrop-filter: blur(14px); border-bottom: 1px solid var(--border); padding: 0 24px; height: 60px; display: flex; align-items: center; justify-content: space-between; }
        .logo-wrap { display: flex; align-items: center; gap: 13px; }
        .bdc-logo { height: 34px; width: 34px; object-fit: contain; }
        .logo-divider { width: 1px; height: 22px; background: var(--border2); }
        .logo-mark { font-weight: 600; font-size: 1.05rem; color: var(--white); }
        .logo-mark span { color: var(--green); }
        .logo-sub { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.14em; color: var(--muted); text-transform: uppercase; margin-top: 2px; }
        .header-right { display: flex; align-items: center; gap: 12px; }
        .portal-link, .logout-btn { font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.08em; color: var(--muted); text-transform: uppercase; background: none; border: 1px solid var(--border2); padding: 6px 12px; border-radius: 3px; cursor: pointer; transition: color 0.2s, border-color 0.2s; text-decoration: none;}
        .logout-btn:hover { color: var(--red); border-color: rgba(242,73,92,0.4); }
        .sync-state { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--green); display: flex; align-items: center; gap: 6px; }
        .sync-state::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--green); }
        .sync-state.off { color: var(--dim); }
        .sync-state.off::before { background: var(--dim); }

        main { position: relative; z-index: 1; padding: 28px 24px 40px; max-width: 1500px; margin: 0 auto; }
        .page-head { margin-bottom: 26px; }
        .page-eyebrow { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.18em; color: var(--green); text-transform: uppercase; margin-bottom: 9px; display: flex; align-items: center; gap: 8px; }
        .page-eyebrow::before { content: ''; width: 3px; height: 3px; background: var(--green); border-radius: 50%; }
        .page-title { font-family: var(--serif); font-size: 2.1rem; line-height: 1.05; color: var(--white); margin-bottom: 7px; }
        .page-title em { font-style: italic; color: var(--green); }
        .page-sub { font-size: 0.95rem; color: var(--muted); line-height: 1.6; max-width: 720px; }

        .section-head { display: flex; align-items: center; justify-content: space-between; margin: 38px 0 16px; }
        .section-title { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.16em; color: var(--green); text-transform: uppercase; display: flex; align-items: center; gap: 8px; }
        .section-title::before { content: ''; width: 3px; height: 3px; background: var(--green); border-radius: 50%; }

        /* ===== PROJECT TABLE ===== */
        .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
        .toolbar .spacer { flex: 1; }
        .filter-group { display: flex; align-items: center; gap: 4px; background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 4px; flex-wrap: wrap; }
        .filter-btn { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--muted); background: none; border: none; padding: 5px 11px; border-radius: 2px; cursor: pointer; transition: background 0.2s, color 0.2s; white-space: nowrap; }
        .filter-btn:hover { color: var(--off); }
        .filter-btn.active { background: rgba(92,200,32,0.14); color: var(--green); }
        .search { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 8px 12px; color: var(--off); font-family: var(--mono); font-size: 0.72rem; outline: none; min-width: 200px; }
        .search:focus { border-color: rgba(92,200,32,0.5); }
        .btn { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 3px; padding: 9px 15px; cursor: pointer; transition: color 0.2s, border-color 0.2s; border: 1px solid var(--border2); background: none; color: var(--muted); }
        .btn:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }

        .summary { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 20px; }
        .sum-card { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 13px 15px; position: relative; overflow: hidden; }
        .sum-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; opacity: 0.6; }
        .sum-card.total::before { background: var(--green); } .sum-card.progress::before { background: var(--blue); }
        .sum-card.review::before { background: var(--purple); } .sum-card.blocked::before { background: var(--red); } .sum-card.done::before { background: var(--muted); }
        .sum-num { font-family: var(--serif); font-size: 1.7rem; line-height: 1; margin-bottom: 3px; }
        .sum-card.total .sum-num { color: var(--green); } .sum-card.progress .sum-num { color: var(--blue); }
        .sum-card.review .sum-num { color: var(--purple); } .sum-card.blocked .sum-num { color: var(--red); } .sum-card.done .sum-num { color: var(--white); }
        .sum-label { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.1em; color: var(--muted); text-transform: uppercase; }

        .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 920px; }
        thead th { position: sticky; top: 0; background: #0f0f0f; padding: 11px 14px; text-align: left; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; border-bottom: 1px solid var(--border2); white-space: nowrap; }
        tbody td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: top; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,0.018); }
        .t-task { font-weight: 600; color: var(--white); font-size: 0.86rem; margin-bottom: 3px; }
        .t-desc { font-size: 0.8rem; color: var(--muted); line-height: 1.5; max-width: 360px; }
        .t-latest { display: flex; align-items: flex-start; gap: 6px; margin-top: 7px; padding-top: 6px; border-top: 1px dashed rgba(255,255,255,0.07); }
        .t-latest .ini { flex-shrink: 0; font-family: var(--mono); font-size: 0.52rem; color: var(--green); background: rgba(92,200,32,0.12); border: 1px solid rgba(92,200,32,0.3); border-radius: 3px; padding: 1px 4px; }
        .t-latest .txt { font-size: 0.7rem; color: var(--muted); line-height: 1.4; }
        .t-docs { display: flex; flex-direction: column; gap: 4px; margin-top: 7px; padding-top: 6px; border-top: 1px dashed rgba(255,255,255,0.07); }
        .t-doc { display: inline-flex; align-items: center; gap: 7px; font-size: 0.72rem; color: var(--blue); text-decoration: none; transition: color 0.2s; }
        .t-doc:hover { color: #8fb8f7; }
        .t-doc-type { font-family: var(--mono); font-size: 0.5rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--blue); background: rgba(87,148,242,0.12); border-radius: 2px; padding: 1px 5px; }
        .pill { display: inline-block; font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.04em; text-transform: uppercase; border-radius: 3px; padding: 4px 9px; white-space: nowrap; }
        .st-Backlog { background: rgba(255,255,255,0.06); color: var(--muted); }
        .st-InProgress { background: rgba(87,148,242,0.14); color: var(--blue); }
        .st-InReview { background: rgba(184,119,217,0.14); color: var(--purple); }
        .st-Blocked { background: rgba(242,73,92,0.14); color: var(--red); }
        .st-Done { background: rgba(92,200,32,0.14); color: var(--green); }
        .pr-Low { background: rgba(255,255,255,0.06); color: var(--muted); }
        .pr-Medium { background: rgba(250,222,42,0.14); color: var(--amber); }
        .pr-High { background: rgba(255,152,48,0.14); color: var(--orange); }
        .pr-Urgent { background: rgba(242,73,92,0.16); color: var(--red); }
        .t-due { font-family: var(--mono); font-size: 0.74rem; color: var(--off); white-space: nowrap; }
        .t-due.soon { color: var(--amber); } .t-due.over { color: var(--red); }
        .t-owner { font-family: var(--mono); font-size: 0.72rem; color: var(--off); white-space: nowrap; }
        .empty { text-align: center; padding: 50px 20px; font-family: var(--mono); font-size: 0.72rem; letter-spacing: 0.1em; color: var(--dim); text-transform: uppercase; }

        /* ===== CALENDAR ===== */
        .cal-mode-toggle { display: flex; background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 4px; }
        .cal-mode-toggle button { font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--muted); background: none; border: none; padding: 5px 15px; border-radius: 2px; cursor: pointer; transition: background 0.2s, color 0.2s; }
        .cal-mode-toggle button:hover { color: var(--off); }
        .cal-mode-toggle button.active { background: rgba(92,200,32,0.14); color: var(--green); }
        .cal-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        .cal-top { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border); }
        .cal-month { font-family: var(--serif); font-size: 1.3rem; color: var(--white); }
        .cal-month span { color: var(--green); }
        .cal-nav { display: flex; gap: 8px; }
        .cal-nav button { font-family: var(--mono); font-size: 0.7rem; color: var(--muted); background: none; border: 1px solid var(--border2); border-radius: 3px; padding: 6px 12px; cursor: pointer; transition: color 0.2s, border-color 0.2s; }
        .cal-nav button:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .cal-nav .today-btn { color: var(--green); border-color: rgba(92,200,32,0.4); }
        .cal-dow-row { display: grid; grid-template-columns: repeat(7, 1fr); border-bottom: 1px solid var(--border); }
        .cal-dow { padding: 9px 0; text-align: center; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; }
        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); grid-auto-rows: minmax(104px, auto); }
        .cal-cell { border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 7px 8px; overflow: hidden; }
        .cal-cell:nth-child(7n) { border-right: none; }
        .cal-cell.other { background: rgba(0,0,0,0.25); } .cal-cell.other .cal-daynum { color: rgba(255,255,255,0.12); }
        .cal-cell.today { background: rgba(92,200,32,0.06); }
        .cal-daynum { font-family: var(--mono); font-size: 0.7rem; color: var(--muted); margin-bottom: 6px; }
        .cal-cell.today .cal-daynum { color: var(--green); font-weight: 500; }
        .cal-event { display: block; width: 100%; text-align: left; border: none; border-radius: 3px; padding: 4px 7px; margin-bottom: 4px; font-size: 0.66rem; line-height: 1.3; color: var(--off); cursor: default; border-left: 2px solid; background: rgba(255,255,255,0.04); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cal-event.ev-Low { border-left-color: rgba(255,255,255,0.3); } .cal-event.ev-Medium { border-left-color: var(--amber); }
        .cal-event.ev-High { border-left-color: var(--orange); } .cal-event.ev-Urgent { border-left-color: var(--red); }
        .cal-event.ev-Done { opacity: 0.5; text-decoration: line-through; }
        .cal-event .ev-ini { display: inline-block; font-family: var(--mono); font-size: 0.52rem; color: var(--green); background: rgba(92,200,32,0.14); border-radius: 2px; padding: 0 3px; margin-right: 5px; }
        .cal-more { font-family: var(--mono); font-size: 0.6rem; color: var(--dim); padding: 2px 4px; }
        .cal-legend { display: flex; gap: 16px; flex-wrap: wrap; padding: 12px 18px; border-top: 1px solid var(--border); }
        .cal-leg { display: flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 0.6rem; color: var(--dim); text-transform: uppercase; letter-spacing: 0.06em; }
        .cal-leg .bar { width: 14px; height: 3px; border-radius: 2px; }
        .year-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--border); }
        .year-month { background: var(--surface); padding: 14px; }
        .year-month.has-today { background: rgba(92,200,32,0.04); }
        .ym-name { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; display: flex; justify-content: space-between; cursor: pointer; }
        .ym-name:hover { color: var(--green); }
        .ym-name .c { color: var(--green); font-size: 0.6rem; background: rgba(92,200,32,0.12); border-radius: 2px; padding: 1px 6px; }
        .ym-name .c.zero { color: var(--dim); background: rgba(255,255,255,0.04); }
        .ym-mini { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-top: 8px; }
        .ym-dow { font-family: var(--mono); font-size: 0.46rem; color: var(--dim); text-align: center; }
        .ym-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-family: var(--mono); font-size: 0.55rem; color: var(--muted); border-radius: 2px; position: relative; }
        .ym-day.other { color: rgba(255,255,255,0.1); }
        .ym-day.today { background: rgba(92,200,32,0.18); color: var(--green); }
        .ym-day .ym-dots { position: absolute; bottom: 1px; display: flex; gap: 1px; }
        .ym-dot { width: 3px; height: 3px; border-radius: 50%; }
        .dot-Low { background: rgba(255,255,255,0.4); } .dot-Medium { background: var(--amber); } .dot-High { background: var(--orange); } .dot-Urgent { background: var(--red); }
        .hidden-view { display: none; }

        /* ===== CONTACTS + MEETINGS ===== */
        .two-col { display: grid; grid-template-columns: 1.3fr 1fr; gap: 20px; align-items: start; }
        .contacts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .contact-card { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 16px 18px; transition: border-color 0.2s; }
        .contact-card:hover { border-color: rgba(92,200,32,0.3); }
        .contact-top { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .contact-avatar { width: 40px; height: 40px; border-radius: 50%; background: rgba(92,200,32,0.12); border: 1px solid rgba(92,200,32,0.3); display: flex; align-items: center; justify-content: center; font-family: var(--mono); font-size: 0.78rem; color: var(--green); flex-shrink: 0; }
        .contact-name { font-weight: 600; color: var(--white); font-size: 0.9rem; }
        .contact-role { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.06em; color: var(--muted); text-transform: uppercase; margin-top: 2px; }
        .contact-rows { display: flex; flex-direction: column; gap: 7px; }
        .contact-row { display: flex; align-items: center; gap: 9px; font-size: 0.8rem; }
        .contact-row .ic { width: 14px; color: var(--green); opacity: 0.8; flex-shrink: 0; text-align: center; }
        .contact-row a { color: var(--off); text-decoration: none; transition: color 0.2s; word-break: break-all; }
        .contact-row a:hover { color: var(--green); }
        .contact-langs { color: var(--muted); }
        .contact-tag { display: inline-block; font-family: var(--mono); font-size: 0.54rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--blue, #5794f2); background: rgba(87,148,242,0.12); border-radius: 2px; padding: 2px 6px; margin-left: auto; align-self: flex-start; }
        .contact-tag.bdc { color: #f08a3c; background: rgba(240,138,60,0.12); }
        .contact-socials { display: flex; align-items: center; gap: 8px; margin-top: 13px; padding-top: 13px; border-top: 1px solid var(--border); }
        .social-ic { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.12); border-radius: 6px; color: var(--muted); transition: color 0.2s, border-color 0.2s, background 0.2s, transform 0.15s; }
        .social-ic svg { width: 15px; height: 15px; display: block; }
        .social-ic:hover { transform: translateY(-1px); }
        .social-ic.s-telegram:hover { color: #29a9eb; border-color: rgba(41,169,235,0.5); background: rgba(41,169,235,0.1); }
        .social-ic.s-whatsapp:hover { color: #25d366; border-color: rgba(37,211,102,0.5); background: rgba(37,211,102,0.1); }
        .social-ic.s-slack:hover { color: #e01e5a; border-color: rgba(224,30,90,0.45); background: rgba(224,30,90,0.09); }
        .quicklinks { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px; }
        .ql-card { display: flex; flex-direction: column; gap: 6px; background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 18px; text-decoration: none; transition: border-color 0.2s, transform 0.15s; }
        .ql-card:hover { border-color: rgba(92,200,32,0.4); transform: translateY(-2px); }
        .ql-ic { font-size: 1.4rem; }
        .ql-name { font-weight: 600; color: var(--white); font-size: 0.92rem; }
        .ql-desc { font-size: 0.82rem; color: var(--muted); line-height: 1.5; }
        .ql-host { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.08em; color: var(--green); text-transform: uppercase; margin-top: 2px; }
        .docs-table { width: 100%; border-collapse: collapse; min-width: 720px; }
        .docs-table thead th { position: sticky; top: 0; background: #0f0f0f; padding: 11px 14px; text-align: left; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; border-bottom: 1px solid var(--border2); white-space: nowrap; }
        .docs-table tbody td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .docs-table tbody tr:last-child td { border-bottom: none; }
        .docs-table tbody tr:hover { background: rgba(255,255,255,0.018); }
        .doc-name { display: flex; align-items: center; gap: 10px; }
        .doc-ic { font-size: 1.05rem; flex-shrink: 0; }
        .doc-title { font-weight: 600; color: var(--white); font-size: 0.85rem; }
        .doc-type { display: inline-block; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 3px; padding: 4px 9px; white-space: nowrap; }
        .dt-sow { background: rgba(92,200,32,0.14); color: var(--green); }
        .dt-contract { background: rgba(87,148,242,0.14); color: var(--blue); }
        .dt-report { background: rgba(184,119,217,0.14); color: var(--purple); }
        .dt-spec { background: rgba(255,152,48,0.14); color: var(--orange); }
        .dt-other { background: rgba(255,255,255,0.06); color: var(--muted); }
        .doc-owner { font-family: var(--mono); font-size: 0.72rem; color: var(--off); white-space: nowrap; }
        .doc-updated { font-family: var(--mono); font-size: 0.72rem; color: var(--muted); white-space: nowrap; }
        .doc-open-col { width: 90px; text-align: right; }
        .doc-open { display: inline-flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--green); border: 1px solid rgba(92,200,32,0.3); border-radius: 3px; padding: 6px 11px; text-decoration: none; transition: background 0.2s; white-space: nowrap; }
        .doc-open:hover { background: rgba(92,200,32,0.12); }

        .meetings-list { display: flex; flex-direction: column; gap: 12px; }
        .meeting-card { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 15px 17px; }
        .meeting-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 5px; }
        .meeting-name { font-weight: 600; color: var(--white); font-size: 0.88rem; }
        .meeting-cadence { font-family: var(--mono); font-size: 0.56rem; letter-spacing: 0.06em; color: var(--green); text-transform: uppercase; border: 1px solid rgba(92,200,32,0.3); border-radius: 2px; padding: 3px 7px; white-space: nowrap; }
        .meeting-when { font-family: var(--mono); font-size: 0.68rem; color: var(--muted); margin-bottom: 11px; }
        .meeting-join { display: inline-flex; align-items: center; gap: 7px; background: rgba(92,200,32,0.1); border: 1px solid rgba(92,200,32,0.3); color: var(--green); font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.06em; text-transform: uppercase; padding: 7px 13px; border-radius: 3px; text-decoration: none; transition: background 0.2s; }
        .meeting-join:hover { background: rgba(92,200,32,0.18); }

        .footer { text-align: center; padding: 30px 22px; font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; margin-top: 30px; border-top: 1px solid var(--border); }
        .footer span { color: var(--green); }
        .footer img { height: 22px; vertical-align: middle; margin-right: 8px; opacity: 0.7; }

        @media (max-width: 1000px) {
            .summary { grid-template-columns: 1fr 1fr; } .two-col { grid-template-columns: 1fr; }
            .contacts-grid { grid-template-columns: 1fr; } .year-grid { grid-template-columns: repeat(3,1fr); }
        }
        @media (max-width: 640px) { .year-grid { grid-template-columns: repeat(2,1fr); } .contacts-grid { grid-template-columns: 1fr; } }

        }

        /* Task management styles */
        @scope (.task-management) {

        
        
        
        body { background: var(--black); color: var(--off); font-family: var(--sans); min-height: 100vh; font-size: 13px; }
        body::before { content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(92,200,32,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,0.03) 1px, transparent 1px); background-size: 32px 32px; }

        /* HEADER */
        .header { position: sticky; top: 0; z-index: 100; background: rgba(13,13,13,0.92); backdrop-filter: blur(14px); border-bottom: 1px solid var(--border); padding: 0 24px; height: 56px; display: flex; align-items: center; justify-content: space-between; }
        .logo-wrap { display: flex; align-items: center; gap: 14px; }
        .logo-mark { font-weight: 600; font-size: 1.05rem; color: var(--white); letter-spacing: -0.01em; }
        .logo-mark span { color: var(--green); }
        .logo-divider { width: 1px; height: 18px; background: var(--border2); }
        .logo-title { font-family: var(--mono); font-size: 0.65rem; letter-spacing: 0.16em; color: var(--muted); text-transform: uppercase; }
        .header-right { display: flex; align-items: center; gap: 10px; }
        .portal-link, .logout-btn { font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.08em; color: var(--muted); text-transform: uppercase; background: none; border: 1px solid var(--border2); padding: 6px 12px; border-radius: 3px; cursor: pointer; transition: color 0.2s, border-color 0.2s; text-decoration: none; }
        .save-state { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.08em; color: var(--dim); text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
        .save-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); transition: background 0.3s; }
        .save-dot.saving { background: var(--amber); }
        .save-dot.offline { background: var(--red); }

        main { position: relative; z-index: 1; padding: 24px; max-width: 1600px; margin: 0 auto; }

        .page-head { margin-bottom: 22px; }
        .page-eyebrow { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.18em; color: var(--green); text-transform: uppercase; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .page-eyebrow::before { content: ''; width: 3px; height: 3px; background: var(--green); border-radius: 50%; }
        .page-title { font-family: var(--serif); font-size: 2rem; line-height: 1.05; color: var(--white); margin-bottom: 6px; }
        .page-title em { font-style: italic; color: var(--green); }
        .page-sub { font-size: 0.92rem; color: var(--muted); line-height: 1.6; }

        /* SUMMARY STRIP */
        .summary { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; margin-bottom: 20px; }
        .sum-card { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 14px 16px; position: relative; overflow: hidden; }
        .sum-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; opacity: 0.6; }
        .sum-card.total::before { background: var(--green); }
        .sum-card.progress::before { background: var(--blue); }
        .sum-card.review::before { background: var(--purple); }
        .sum-card.blocked::before { background: var(--red); }
        .sum-card.done::before { background: var(--muted); }
        .sum-num { font-family: var(--serif); font-size: 1.8rem; line-height: 1; margin-bottom: 4px; }
        .sum-card.total .sum-num { color: var(--green); }
        .sum-card.progress .sum-num { color: var(--blue); }
        .sum-card.review .sum-num { color: var(--purple); }
        .sum-card.blocked .sum-num { color: var(--red); }
        .sum-card.done .sum-num { color: var(--white); }
        .sum-label { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.12em; color: var(--muted); text-transform: uppercase; }

        /* TOOLBAR */
        .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
        .toolbar .spacer { flex: 1; }
        .filter-group { display: flex; align-items: center; gap: 6px; background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 4px; }
        .filter-btn { font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--muted); background: none; border: none; padding: 5px 11px; border-radius: 2px; cursor: pointer; transition: background 0.2s, color 0.2s; white-space: nowrap; }
        .filter-btn:hover { color: var(--off); }
        .filter-btn.active { background: rgba(92,200,32,0.14); color: var(--green); }
        .search { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 8px 12px; color: var(--off); font-family: var(--mono); font-size: 0.72rem; outline: none; min-width: 200px; transition: border-color 0.2s; }
        .search:focus { border-color: rgba(92,200,32,0.5); }
        .search::placeholder { color: var(--dim); }
        .btn { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.08em; text-transform: uppercase; border-radius: 3px; padding: 9px 16px; cursor: pointer; transition: opacity 0.2s, transform 0.15s, background 0.2s, color 0.2s; border: 1px solid var(--border2); background: none; color: var(--muted); display: inline-flex; align-items: center; gap: 7px; }
        .btn:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .btn.primary { background: var(--green); color: var(--black); border-color: var(--green); font-weight: 500; }
        .btn.primary:hover { opacity: 0.9; transform: translateY(-1px); color: var(--black); }

        /* TABLE */
        .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 1180px; }
        thead th { position: sticky; top: 0; background: #0f0f0f; padding: 11px 14px; text-align: left; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; border-bottom: 1px solid var(--border2); white-space: nowrap; z-index: 2; }
        th.sortable { cursor: pointer; transition: color 0.2s; } th.sortable:hover { color: var(--muted); }
        th .arrow { color: var(--green); margin-left: 4px; }
        tbody td { padding: 4px 8px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: rgba(255,255,255,0.018); }
        tbody tr.dragging { opacity: 0.4; }
        tbody tr.drag-over td { box-shadow: inset 0 2px 0 var(--green); }

        .cell-input, .cell-select, .cell-textarea { width: 100%; background: transparent; border: 1px solid transparent; border-radius: 3px; padding: 7px 9px; color: var(--off); font-family: var(--sans); font-size: 0.82rem; outline: none; transition: background 0.15s, border-color 0.15s; resize: none; }
        .cell-input:hover, .cell-select:hover, .cell-textarea:hover { background: rgba(255,255,255,0.03); }
        .cell-input:focus, .cell-select:focus, .cell-textarea:focus { background: var(--black); border-color: rgba(92,200,32,0.5); }
        .cell-input::placeholder, .cell-textarea::placeholder { color: var(--dim); }
        .cell-select { cursor: pointer; -webkit-appearance: none; appearance: none; }
        .cell-select option { background: #131313; color: var(--off); }
        .cell-textarea { font-size: 0.78rem; line-height: 1.5; min-height: 34px; font-family: var(--sans); }
        .cell-date { font-family: var(--mono); font-size: 0.74rem; color-scheme: dark; }

        td.col-task { min-width: 200px; } td.col-desc { min-width: 260px; } td.col-handle { width: 30px; text-align: center; } td.col-id { width: 56px; }
        td.col-actions { width: 44px; text-align: center; }
        td.col-client { width: 92px; text-align: center; }
        td.col-docs { width: 88px; text-align: center; }
        .doc-btn { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.04em; color: var(--muted); background: none; border: 1px solid var(--border2); border-radius: 3px; padding: 5px 9px; cursor: pointer; transition: color 0.2s, border-color 0.2s, background 0.2s; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
        .doc-btn:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .doc-btn.has { color: var(--blue); border-color: rgba(87,148,242,0.4); }
        .doc-btn.open { background: rgba(87,148,242,0.1); color: var(--blue); border-color: rgba(87,148,242,0.4); }
        .doc-panel { padding: 14px 18px 16px 60px; }
        .doc-title { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.12em; color: var(--blue); text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .doc-title::before { content: ''; width: 3px; height: 3px; background: var(--blue); border-radius: 50%; }
        .doc-list { display: flex; flex-direction: column; gap: 7px; margin-bottom: 12px; max-width: 880px; }
        .doc-item { display: flex; align-items: center; gap: 10px; background: var(--surface); border: 1px solid var(--border); border-left: 2px solid rgba(87,148,242,0.5); border-radius: 3px; padding: 9px 12px; }
        .doc-item .d-type { font-family: var(--mono); font-size: 0.54rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--blue); background: rgba(87,148,242,0.12); border-radius: 2px; padding: 2px 6px; flex-shrink: 0; }
        .doc-item a.d-name { color: var(--off); text-decoration: none; font-size: 0.84rem; flex: 1; word-break: break-word; transition: color 0.2s; }
        .doc-item a.d-name:hover { color: var(--blue); }
        .doc-item .d-open { font-family: var(--mono); font-size: 0.58rem; color: var(--dim); flex-shrink: 0; }
        .doc-del { background: none; border: none; color: var(--dim); cursor: pointer; font-size: 0.8rem; padding: 2px 4px; border-radius: 3px; transition: color 0.2s, background 0.2s; flex-shrink: 0; }
        .doc-del:hover { color: var(--red); background: rgba(242,73,92,0.1); }
        .doc-empty { font-family: var(--mono); font-size: 0.68rem; color: var(--dim); padding: 4px 0 12px; }
        .doc-compose { display: flex; gap: 8px; align-items: flex-start; flex-wrap: wrap; max-width: 880px; }
        .doc-compose select, .doc-compose input { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; color: var(--off); font-family: var(--sans); font-size: 0.82rem; padding: 8px 10px; outline: none; }
        .doc-compose select { font-family: var(--mono); font-size: 0.68rem; cursor: pointer; }
        .doc-compose select option { background: #131313; }
        .doc-compose .d-label { width: 200px; }
        .doc-compose .d-url { flex: 1; min-width: 220px; font-family: var(--mono); font-size: 0.74rem; }
        .doc-compose select:focus, .doc-compose input:focus { border-color: rgba(87,148,242,0.5); }
        .doc-compose input::placeholder { color: var(--dim); }
        .doc-add { background: var(--blue); color: #061427; font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.06em; text-transform: uppercase; font-weight: 500; border: none; border-radius: 3px; padding: 9px 16px; cursor: pointer; transition: opacity 0.2s, transform 0.15s; white-space: nowrap; }
        .doc-add:hover { opacity: 0.9; transform: translateY(-1px); }
        .share-btn { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.04em; color: var(--muted); background: none; border: 1px solid var(--border2); border-radius: 3px; padding: 5px 9px; cursor: pointer; transition: color 0.2s, border-color 0.2s, background 0.2s; white-space: nowrap; }
        .share-btn:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .share-btn.on { color: var(--green); border-color: rgba(92,200,32,0.45); background: rgba(92,200,32,0.08); }
        /* inline latest-update preview */
        .task-latest { display: flex; align-items: center; gap: 6px; margin: 2px 9px 4px; padding-top: 5px; border-top: 1px dashed rgba(255,255,255,0.07); }
        .task-latest .tl-ini { flex-shrink: 0; font-family: var(--mono); font-size: 0.52rem; letter-spacing: 0.03em; color: var(--green); background: rgba(92,200,32,0.12); border: 1px solid rgba(92,200,32,0.3); border-radius: 3px; padding: 1px 4px; }
        .task-latest .tl-txt { font-size: 0.7rem; color: var(--muted); line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        /* UPDATES */
        td.col-updates { width: 92px; text-align: center; }
        .upd-btn { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.04em; color: var(--muted); background: none; border: 1px solid var(--border2); border-radius: 3px; padding: 5px 9px; cursor: pointer; transition: color 0.2s, border-color 0.2s, background 0.2s; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; }
        .upd-btn:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .upd-btn.has { color: var(--green); border-color: rgba(92,200,32,0.4); }
        .upd-count { background: rgba(92,200,32,0.16); color: var(--green); border-radius: 8px; font-size: 0.56rem; padding: 1px 6px; min-width: 16px; }
        .upd-btn.open { background: rgba(92,200,32,0.1); color: var(--green); border-color: rgba(92,200,32,0.4); }

        tr.upd-row td { padding: 0; border-bottom: 1px solid var(--border); background: #0f0f0f; }
        .upd-panel { padding: 14px 18px 16px 60px; }
        .upd-title { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.12em; color: var(--green); text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .upd-title::before { content: ''; width: 3px; height: 3px; background: var(--green); border-radius: 50%; }
        .upd-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px; max-width: 880px; }
        .upd-item { background: var(--surface); border: 1px solid var(--border); border-left: 2px solid rgba(92,200,32,0.5); border-radius: 3px; padding: 9px 12px; position: relative; }
        .upd-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
        .upd-author { font-family: var(--mono); font-size: 0.62rem; color: var(--green); letter-spacing: 0.04em; }
        .upd-time { font-family: var(--mono); font-size: 0.58rem; color: var(--dim); }
        .upd-del { margin-left: auto; background: none; border: none; color: var(--dim); cursor: pointer; font-size: 0.8rem; line-height: 1; padding: 2px 4px; border-radius: 3px; transition: color 0.2s, background 0.2s; }
        .upd-del:hover { color: var(--red); background: rgba(242,73,92,0.1); }
        .upd-text { font-size: 0.82rem; line-height: 1.55; color: var(--off); white-space: pre-wrap; word-break: break-word; }
        .upd-empty { font-family: var(--mono); font-size: 0.68rem; color: var(--dim); padding: 4px 0 12px; }
        .upd-compose { display: flex; gap: 8px; align-items: flex-start; max-width: 880px; }
        .upd-compose select { background: var(--surface); border: 1px solid var(--border); border-radius: 3px; color: var(--off); font-family: var(--mono); font-size: 0.68rem; padding: 8px 9px; outline: none; cursor: pointer; }
        .upd-compose select option { background: #131313; }
        .upd-compose textarea { flex: 1; background: var(--surface); border: 1px solid var(--border); border-radius: 3px; color: var(--off); font-family: var(--sans); font-size: 0.82rem; line-height: 1.5; padding: 8px 11px; outline: none; resize: vertical; min-height: 38px; transition: border-color 0.2s; }
        .upd-compose textarea:focus { border-color: rgba(92,200,32,0.5); }
        .upd-compose textarea::placeholder { color: var(--dim); }
        .upd-post { background: var(--green); color: var(--black); font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.06em; text-transform: uppercase; font-weight: 500; border: none; border-radius: 3px; padding: 9px 16px; cursor: pointer; transition: opacity 0.2s, transform 0.15s; white-space: nowrap; }
        .upd-post:hover { opacity: 0.9; transform: translateY(-1px); }
        .row-id { font-family: var(--mono); font-size: 0.66rem; color: var(--dim); padding-left: 6px; }
        .drag-handle { cursor: grab; color: var(--dim); font-size: 0.9rem; user-select: none; transition: color 0.2s; }
        .drag-handle:hover { color: var(--muted); }

        /* status + priority as styled selects via wrapper "pill" */
        .pill-wrap { position: relative; display: inline-block; width: 100%; }
        .pill-select { width: 100%; -webkit-appearance: none; appearance: none; cursor: pointer; border-radius: 3px; padding: 5px 22px 5px 10px; font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.05em; text-transform: uppercase; border: 1px solid transparent; outline: none; transition: filter 0.15s; }
        .pill-select:hover { filter: brightness(1.15); }
        .pill-wrap::after { content: '▾'; position: absolute; right: 8px; top: 50%; transform: translateY(-50%); font-size: 0.55rem; pointer-events: none; opacity: 0.6; }
        .st-backlog  { background: rgba(255,255,255,0.06); color: var(--muted); }
        .st-progress { background: rgba(87,148,242,0.14); color: var(--blue); }
        .st-review   { background: rgba(184,119,217,0.14); color: var(--purple); }
        .st-blocked  { background: rgba(242,73,92,0.14); color: var(--red); }
        .st-done     { background: rgba(92,200,32,0.14); color: var(--green); }
        .pr-low    { background: rgba(255,255,255,0.06); color: var(--muted); }
        .pr-medium { background: rgba(250,222,42,0.14); color: var(--amber); }
        .pr-high   { background: rgba(255,152,48,0.14); color: var(--orange); }
        .pr-urgent { background: rgba(242,73,92,0.16); color: var(--red); }

        .owner-badge { font-family: var(--mono); font-size: 0.6rem; }

        .del-btn { background: none; border: none; color: var(--dim); cursor: pointer; font-size: 0.9rem; padding: 6px; border-radius: 3px; transition: color 0.2s, background 0.2s; }
        .del-btn:hover { color: var(--red); background: rgba(242,73,92,0.1); }

        .empty { text-align: center; padding: 60px 20px; font-family: var(--mono); font-size: 0.72rem; letter-spacing: 0.1em; color: var(--dim); text-transform: uppercase; }

        .table-foot { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid var(--border); }
        .foot-count { font-family: var(--mono); font-size: 0.64rem; color: var(--dim); letter-spacing: 0.06em; }

        .footer { text-align: center; padding: 22px; font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; margin-top: 18px; }
        .footer span { color: var(--green); }

        .due-soon { color: var(--amber) !important; }
        .due-over { color: var(--red) !important; }

        /* CALENDAR SECTION HEAD + MODE TOGGLE */
        .cal-section-head { display: flex; align-items: center; justify-content: space-between; margin: 30px 0 14px; }
        .cal-mode-toggle { display: flex; background: var(--surface); border: 1px solid var(--border); border-radius: 3px; padding: 4px; }
        .cal-mode-toggle button { font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--muted); background: none; border: none; padding: 5px 15px; border-radius: 2px; cursor: pointer; transition: background 0.2s, color 0.2s; }
        .cal-mode-toggle button:hover { color: var(--off); }
        .cal-mode-toggle button.active { background: rgba(92,200,32,0.14); color: var(--green); }

        /* YEAR VIEW */
        .year-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--border); }
        .year-month { background: var(--surface); padding: 14px 14px 16px; transition: background 0.15s; }
        .year-month.has-today { background: rgba(92,200,32,0.04); }
        .ym-name { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; }
        .ym-name:hover { color: var(--green); }
        .ym-name .ym-count { color: var(--green); font-size: 0.6rem; background: rgba(92,200,32,0.12); border-radius: 2px; padding: 1px 6px; }
        .ym-name .ym-count.zero { color: var(--dim); background: rgba(255,255,255,0.04); }
        .ym-mini { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-top: 8px; }
        .ym-dow { font-family: var(--mono); font-size: 0.46rem; color: var(--dim); text-align: center; padding-bottom: 2px; }
        .ym-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-family: var(--mono); font-size: 0.55rem; color: var(--muted); border-radius: 2px; position: relative; cursor: default; }
        .ym-day.other { color: rgba(255,255,255,0.1); }
        .ym-day.today { background: rgba(92,200,32,0.18); color: var(--green); font-weight: 500; }
        .ym-day.has-task { cursor: pointer; }
        .ym-day .ym-dots { position: absolute; bottom: 1px; left: 0; right: 0; display: flex; gap: 1px; justify-content: center; }
        .ym-day .ym-dot { width: 3px; height: 3px; border-radius: 50%; }
        .ym-day:hover.has-task { background: rgba(255,255,255,0.06); }
        .dot-low { background: rgba(255,255,255,0.4); } .dot-medium { background: var(--amber); } .dot-high { background: var(--orange); } .dot-urgent { background: var(--red); }

        .hidden-view { display: none; }

        @media (max-width: 1100px) { .year-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 760px) { .year-grid { grid-template-columns: repeat(2, 1fr); } }

        /* CALENDAR */
        .cal-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        .cal-top { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border); }
        .cal-month { font-family: var(--serif); font-size: 1.3rem; color: var(--white); }
        .cal-month span { color: var(--green); }
        .cal-nav { display: flex; align-items: center; gap: 8px; }
        .cal-nav button { font-family: var(--mono); font-size: 0.7rem; color: var(--muted); background: none; border: 1px solid var(--border2); border-radius: 3px; padding: 6px 12px; cursor: pointer; transition: color 0.2s, border-color 0.2s; }
        .cal-nav button:hover { color: var(--off); border-color: rgba(255,255,255,0.25); }
        .cal-nav .today-btn { color: var(--green); border-color: rgba(92,200,32,0.4); }

        .cal-dow-row { display: grid; grid-template-columns: repeat(7, 1fr); border-bottom: 1px solid var(--border); }
        .cal-dow { padding: 9px 0; text-align: center; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; }
        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); grid-auto-rows: minmax(108px, auto); }
        .cal-cell { border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 7px 8px; position: relative; overflow: hidden; transition: background 0.15s; }
        .cal-cell:nth-child(7n) { border-right: none; }
        .cal-cell.other { background: rgba(0,0,0,0.25); }
        .cal-cell.other .cal-daynum { color: rgba(255,255,255,0.12); }
        .cal-cell.today { background: rgba(92,200,32,0.06); }
        .cal-cell.drag-over { background: rgba(92,200,32,0.12); box-shadow: inset 0 0 0 1px rgba(92,200,32,0.5); }
        .cal-daynum { font-family: var(--mono); font-size: 0.7rem; color: var(--muted); margin-bottom: 6px; display: flex; align-items: center; justify-content: space-between; }
        .cal-cell.today .cal-daynum { color: var(--green); font-weight: 500; }
        .cal-daynum .add-on-day { opacity: 0; cursor: pointer; color: var(--dim); font-size: 0.85rem; transition: opacity 0.15s, color 0.2s; border: none; background: none; padding: 0 2px; }
        .cal-cell:hover .add-on-day { opacity: 1; }
        .cal-daynum .add-on-day:hover { color: var(--green); }

        .cal-event { display: block; width: 100%; text-align: left; border: none; border-radius: 3px; padding: 4px 7px; margin-bottom: 4px; font-size: 0.68rem; line-height: 1.3; color: var(--off); cursor: pointer; border-left: 2px solid; background: rgba(255,255,255,0.04); transition: background 0.15s, transform 0.1s; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cal-event:hover { background: rgba(255,255,255,0.09); transform: translateX(1px); }
        .cal-event.ev-low { border-left-color: rgba(255,255,255,0.3); }
        .cal-event.ev-medium { border-left-color: var(--amber); }
        .cal-event.ev-high { border-left-color: var(--orange); }
        .cal-event.ev-urgent { border-left-color: var(--red); }
        .cal-event.ev-done { opacity: 0.5; text-decoration: line-through; }
        .cal-event .ev-dot { display: inline-block; width: 5px; height: 5px; border-radius: 50%; margin-right: 5px; vertical-align: middle; }
        .cal-event .ev-ini { display: inline-block; font-family: var(--mono); font-size: 0.52rem; color: var(--green); background: rgba(92,200,32,0.14); border-radius: 2px; padding: 0 3px; margin-right: 5px; vertical-align: middle; }
        .cal-more { font-family: var(--mono); font-size: 0.6rem; color: var(--dim); cursor: pointer; padding: 2px 4px; }
        .cal-more:hover { color: var(--muted); }

        .cal-legend { display: flex; gap: 16px; flex-wrap: wrap; padding: 12px 18px; border-top: 1px solid var(--border); }
        .cal-leg { display: flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 0.6rem; color: var(--dim); text-transform: uppercase; letter-spacing: 0.06em; }
        .cal-leg .bar { width: 14px; height: 3px; border-radius: 2px; }

        .hidden-view { display: none; }

        /* CALENDAR EVENT POPOVER MENU */
        .ev-menu { position: fixed; z-index: 300; background: var(--surface2); border: 1px solid var(--border2); border-radius: 5px; box-shadow: 0 16px 44px rgba(0,0,0,0.6); padding: 5px; min-width: 200px; display: none; }
        .ev-menu.show { display: block; animation: evMenuIn 0.14s ease; }
        @keyframes evMenuIn { from { opacity:0; transform: translateY(-4px);} to { opacity:1; transform: translateY(0);} }
        .ev-menu .em-head { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.06em; color: var(--dim); text-transform: uppercase; padding: 7px 10px 6px; border-bottom: 1px solid var(--border); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 240px; }
        .ev-menu button { display: flex; align-items: center; gap: 9px; width: 100%; text-align: left; background: none; border: none; color: var(--off); font-family: var(--sans); font-size: 0.8rem; padding: 8px 10px; border-radius: 3px; cursor: pointer; transition: background 0.15s; }
        .ev-menu button:hover { background: rgba(92,200,32,0.1); }
        .ev-menu button .ic { width: 16px; text-align: center; opacity: 0.8; }

        @media (max-width: 900px) {
            .cal-grid { grid-auto-rows: minmax(82px, auto); }
            .cal-event { font-size: 0.6rem; padding: 3px 5px; }
        }

        /* toast */
        .toast { position: fixed; bottom: 22px; left: 50%; transform: translateX(-50%) translateY(20px); background: var(--surface2); border: 1px solid var(--border2); border-left: 3px solid var(--green); border-radius: 4px; padding: 11px 18px; font-family: var(--mono); font-size: 0.7rem; color: var(--off); z-index: 200; opacity: 0; pointer-events: none; transition: opacity 0.3s, transform 0.3s; }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        @media (max-width: 900px) {
            .summary { grid-template-columns: 1fr 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .toolbar .spacer { display: none; }
            .search { min-width: 0; }
            .filter-group { overflow-x: auto; }
        }

        /* ===== TEAM HUB SECTIONS ===== */
        .hub-head { display: flex; align-items: center; justify-content: space-between; margin: 42px 0 16px; flex-wrap: wrap; gap: 10px; }
        .docs-table { width: 100%; border-collapse: collapse; min-width: 720px; }
        .docs-table thead th { position: sticky; top: 0; background: #0f0f0f; padding: 11px 14px; text-align: left; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; border-bottom: 1px solid var(--border2); white-space: nowrap; }
        .docs-table tbody td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .docs-table tbody tr:last-child td { border-bottom: none; }
        .docs-table tbody tr:hover { background: rgba(255,255,255,0.018); }
        .doc-name { display: flex; align-items: center; gap: 10px; }
        .doc-ic { font-size: 1.05rem; flex-shrink: 0; }
        .doc-title { font-weight: 600; color: var(--white); font-size: 0.85rem; }
        .doc-type { display: inline-block; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 3px; padding: 4px 9px; white-space: nowrap; }
        .dt-sow { background: rgba(92,200,32,0.14); color: var(--green); }
        .dt-contract { background: rgba(87,148,242,0.14); color: var(--blue); }
        .dt-report { background: rgba(184,119,217,0.14); color: var(--purple); }
        .dt-spec { background: rgba(255,152,48,0.14); color: var(--orange); }
        .dt-other { background: rgba(255,255,255,0.06); color: var(--muted); }
        .doc-owner { font-family: var(--mono); font-size: 0.72rem; color: var(--off); white-space: nowrap; }
        .doc-updated { font-family: var(--mono); font-size: 0.72rem; color: var(--muted); white-space: nowrap; }
        .doc-open-col { width: 90px; text-align: right; }
        .doc-open { display: inline-flex; align-items: center; gap: 6px; font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--green); border: 1px solid rgba(92,200,32,0.3); border-radius: 3px; padding: 6px 11px; text-decoration: none; transition: background 0.2s; white-space: nowrap; }
        .doc-open:hover { background: rgba(92,200,32,0.12); }
        .hub-title { font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.16em; color: var(--green); text-transform: uppercase; display: flex; align-items: center; gap: 8px; }
        .hub-title::before { content: ''; width: 3px; height: 3px; background: var(--green); border-radius: 50%; }
        .hub-note { font-family: var(--mono); font-size: 0.6rem; color: var(--dim); letter-spacing: 0.04em; }

        .two-col { display: grid; grid-template-columns: 1.25fr 1fr; gap: 20px; align-items: start; }

        /* contacts */
        .contacts-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .contact-card { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 16px 18px; transition: border-color 0.2s; }
        .contact-card:hover { border-color: rgba(92,200,32,0.3); }
        .contact-langs { color: var(--muted); font-size: 0.78rem; }
        .contact-top { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
        .contact-avatar { width: 40px; height: 40px; border-radius: 50%; background: rgba(92,200,32,0.12); border: 1px solid rgba(92,200,32,0.3); display: flex; align-items: center; justify-content: center; font-family: var(--mono); font-size: 0.78rem; color: var(--green); flex-shrink: 0; }
        .contact-name { font-weight: 600; color: var(--white); font-size: 0.9rem; }
        .contact-role { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.06em; color: var(--muted); text-transform: uppercase; margin-top: 2px; }
        .contact-rows { display: flex; flex-direction: column; gap: 7px; }
        .contact-row { display: flex; align-items: center; gap: 9px; font-size: 0.8rem; }
        .contact-row .ic { width: 14px; color: var(--green); opacity: 0.8; flex-shrink: 0; text-align: center; }
        .contact-row a, .contact-row span.v { color: var(--off); text-decoration: none; transition: color 0.2s; word-break: break-word; }
        .contact-row a:hover { color: var(--green); }
        .contact-tag { display: inline-block; font-family: var(--mono); font-size: 0.54rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--blue); background: rgba(87,148,242,0.12); border-radius: 2px; padding: 2px 6px; margin-left: auto; }
        .contact-tag.bdc { color: var(--bdc, #f08a3c); background: rgba(240,138,60,0.12); }
        .contact-socials { display: flex; align-items: center; gap: 8px; margin-top: 13px; padding-top: 13px; border-top: 1px solid var(--border); }
        .social-ic { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid var(--border2); border-radius: 6px; color: var(--muted); transition: color 0.2s, border-color 0.2s, background 0.2s, transform 0.15s; }
        .social-ic svg { width: 15px; height: 15px; display: block; }
        .social-ic:hover { transform: translateY(-1px); }
        .social-ic.s-telegram:hover { color: #29a9eb; border-color: rgba(41,169,235,0.5); background: rgba(41,169,235,0.1); }
        .social-ic.s-whatsapp:hover { color: #25d366; border-color: rgba(37,211,102,0.5); background: rgba(37,211,102,0.1); }
        .social-ic.s-slack:hover { color: #e01e5a; border-color: rgba(224,30,90,0.45); background: rgba(224,30,90,0.09); }

        /* meetings */
        .meetings-list { display: flex; flex-direction: column; gap: 12px; }
        .meeting-card { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 15px 17px; }
        .meeting-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 5px; }
        .meeting-name { font-weight: 600; color: var(--white); font-size: 0.86rem; }
        .meeting-cadence { font-family: var(--mono); font-size: 0.54rem; letter-spacing: 0.06em; color: var(--green); text-transform: uppercase; border: 1px solid rgba(92,200,32,0.3); border-radius: 2px; padding: 3px 7px; white-space: nowrap; }
        .meeting-when { font-family: var(--mono); font-size: 0.66rem; color: var(--muted); margin-bottom: 11px; }
        .meeting-join { display: inline-flex; align-items: center; gap: 7px; background: rgba(92,200,32,0.1); border: 1px solid rgba(92,200,32,0.3); color: var(--green); font-family: var(--mono); font-size: 0.64rem; letter-spacing: 0.06em; text-transform: uppercase; padding: 7px 13px; border-radius: 3px; text-decoration: none; transition: background 0.2s; }
        .meeting-join:hover { background: rgba(92,200,32,0.18); }

        /* resource links */
        .res-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .res-card { display: flex; flex-direction: column; gap: 8px; background: var(--surface); border: 1px solid var(--border); border-radius: 4px; padding: 16px; text-decoration: none; transition: border-color 0.2s, transform 0.15s; }
        .res-card:hover { border-color: rgba(92,200,32,0.4); transform: translateY(-2px); }
        .res-ic { font-size: 1.1rem; }
        .res-name { font-weight: 600; color: var(--white); font-size: 0.84rem; }
        .res-desc { font-size: 0.74rem; color: var(--muted); line-height: 1.5; }
        .res-host { font-family: var(--mono); font-size: 0.56rem; letter-spacing: 0.06em; color: var(--green); text-transform: uppercase; margin-top: auto; }

        /* invoicing */
        .invoice-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        .invoice-paper { background: #fbfbf8; color: #1a1a1a; margin: 0; padding: 36px 40px; font-family: var(--sans); }
        .inv-top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #1a1a1a; padding-bottom: 18px; margin-bottom: 22px; }
        .inv-brand { font-family: var(--serif); font-size: 1.5rem; color: #111; }
        .inv-brand span { color: #5cc820; }
        .inv-brand .sub { font-family: var(--mono); font-size: 0.6rem; letter-spacing: 0.1em; color: #666; text-transform: uppercase; margin-top: 4px; }
        .inv-meta { text-align: right; font-size: 0.78rem; color: #333; line-height: 1.7; }
        .inv-meta b { color: #111; }
        .inv-parties { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 22px; }
        .inv-party h5 { font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.1em; color: #888; text-transform: uppercase; margin-bottom: 6px; }
        .inv-party p { font-size: 0.82rem; color: #222; line-height: 1.6; }
        .inv-editable { outline: none; border-radius: 3px; transition: background 0.15s; }
        .inv-editable:hover { background: #eef3e8; }
        .inv-editable:focus { background: #e7f0dd; box-shadow: 0 0 0 2px rgba(92,200,32,0.4); }
        table.inv-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        table.inv-table th { background: #1a1a1a; color: #fff; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.08em; text-transform: uppercase; padding: 9px 12px; text-align: left; }
        table.inv-table th.num, table.inv-table td.num { text-align: right; }
        table.inv-table td { padding: 9px 12px; border-bottom: 1px solid #e2e2dc; font-size: 0.82rem; color: #222; }
        .inv-totals { margin-left: auto; width: 280px; }
        .inv-totals .row { display: flex; justify-content: space-between; padding: 6px 12px; font-size: 0.82rem; color: #333; }
        .inv-totals .row.grand { border-top: 2px solid #1a1a1a; margin-top: 4px; padding-top: 10px; font-family: var(--serif); font-size: 1.1rem; color: #111; }
        .inv-totals .row.grand b { color: #3f8f16; }
        .inv-notes { margin-top: 22px; border-top: 1px solid #ddd; padding-top: 14px; font-size: 0.74rem; color: #555; line-height: 1.6; }
        .invoice-bar { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid var(--border); background: var(--surface); flex-wrap: wrap; gap: 10px; }
        .invoice-bar .hint { font-family: var(--mono); font-size: 0.62rem; color: var(--dim); letter-spacing: 0.04em; }
        .inv-row-add { font-family: var(--mono); font-size: 0.6rem; color: #3f8f16; cursor: pointer; border: 1px dashed #b9d9a0; background: #f0f6ea; border-radius: 3px; padding: 6px 10px; }
        .inv-del { color: #c00; cursor: pointer; background: none; border: none; font-size: 0.85rem; }

        @media print {
            body * { visibility: hidden; }
            #invoice-section, #invoice-section * { visibility: visible; }
            #invoice-section { position: absolute; left: 0; top: 0; width: 100%; }
            .invoice-bar, .hub-head { display: none !important; }
            .invoice-paper { padding: 0; }
        }

        @media (max-width: 1000px) {
            .two-col { grid-template-columns: 1fr; }
            .contacts-grid { grid-template-columns: 1fr; }
            .res-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 640px) {
            .res-grid { grid-template-columns: 1fr; }
            .inv-parties { grid-template-columns: 1fr; }
            .invoice-paper { padding: 22px; }
        }


        }

    </style>
</head>
@if ($portal === 'client')
    @include('client.dashboard')
@elseif ($portal === 'employee')
    @include('employee.dashboard')
@else
<body>
    <header class="portal-header">
        <div class="portal-brand"><div class="portal-logo">onsoft<span>arch</span></div><div class="portal-divider"></div><div class="portal-caption">{{ $portal === 'client' ? 'Banco di Caribe · Client Portal' : 'Banco di Caribe · Team Hub' }}</div></div>
        <div class="portal-user">
            @if (auth()->user()->hasRole('admin'))
                <a class="portal-link" href="{{ route('client.dashboard') }}">Client Portal</a>
                <a class="portal-link" href="{{ route('employee.dashboard') }}">Team Hub</a>
                <a class="portal-link" href="{{ route('admin.users.index') }}">Manage accounts</a>
            @endif
            <span class="portal-user-name">{{ auth()->user()->name }}</span><a class="portal-link" href="{{ route('profile.edit') }}">Profile</a><form method="POST" action="{{ route('logout') }}">@csrf<button class="portal-logout" type="submit">Sign out</button></form>
        </div>
    </header>
    <main class="portal-main">
        <div class="portal-card">This dashboard is not available for your account type.</div>
        <footer class="portal-footer">Banco di Caribe · <span>onsoftarch</span> · Confidential</footer>
    </main>
    @stack('scripts')
</body>
@endif
</html>