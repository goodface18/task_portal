<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Console') · onsoftarch</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--green:#5cc820;--black:#0d0d0d;--surface:#131313;--surface2:#181818;--off:#f0efe9;--white:#fff;--border:rgba(255,255,255,.08);--border2:rgba(255,255,255,.14);--muted:rgba(255,255,255,.52);--dim:rgba(255,255,255,.28);--red:#f2495c;--blue:#5794f2;--purple:#b877d9;--amber:#fade2a;--mono:'DM Mono',monospace;--serif:'DM Serif Display',serif;--sans:'Instrument Sans',sans-serif}
        *{box-sizing:border-box}body{margin:0;background:var(--black);color:var(--off);font:13px var(--sans);min-height:100vh}body:before{content:'';position:fixed;inset:0;z-index:0;pointer-events:none;background-image:linear-gradient(rgba(92,200,32,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(92,200,32,.025) 1px,transparent 1px);background-size:32px 32px}
        .admin-header{position:sticky;top:0;z-index:10;min-height:60px;padding:10px 24px;display:flex;align-items:center;justify-content:space-between;gap:14px;background:rgba(13,13,13,.94);backdrop-filter:blur(14px);border-bottom:1px solid var(--border)}.admin-brand,.admin-nav,.admin-user{display:flex;align-items:center;gap:11px}.admin-logo{font-size:1.05rem;font-weight:600;color:var(--white);text-decoration:none}.admin-logo span{color:var(--green)}.admin-divider{width:1px;height:22px;background:var(--border2)}.admin-caption{font:.59rem var(--mono);letter-spacing:.11em;text-transform:uppercase;color:var(--muted)}.admin-nav{gap:7px}.admin-user{font:.63rem var(--mono);color:var(--muted)}.admin-header form{margin:0}.admin-link,.admin-logout{padding:7px 10px;border:1px solid var(--border2);border-radius:3px;background:none;color:var(--muted);font:.58rem var(--mono);letter-spacing:.05em;text-transform:uppercase;text-decoration:none;white-space:nowrap;cursor:pointer}.admin-link:hover{color:var(--green);border-color:rgba(92,200,32,.4)}.admin-logout:hover{color:var(--red);border-color:rgba(242,73,92,.4)}
        .admin-main{position:relative;z-index:1;max-width:1420px;margin:0 auto;padding:32px 24px 48px}.admin-hero{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:25px}.admin-eyebrow{font:.6rem var(--mono);letter-spacing:.16em;text-transform:uppercase;color:var(--green);margin-bottom:8px}.admin-hero h1{font:2.15rem/1.08 var(--serif);color:var(--white);margin:0 0 8px}.admin-hero h1 em{font-weight:400;color:var(--green)}.admin-hero p{max-width:700px;margin:0;color:var(--muted);font-size:.9rem;line-height:1.55}.admin-actions{display:flex;gap:8px;flex-wrap:wrap}.admin-button{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:9px 13px;border:1px solid var(--border2);border-radius:3px;background:none;color:var(--muted);font:.6rem var(--mono);letter-spacing:.06em;text-transform:uppercase;text-decoration:none;cursor:pointer;white-space:nowrap}.admin-button:hover{color:var(--off);border-color:rgba(255,255,255,.3)}.admin-button.primary{border-color:var(--green);background:var(--green);color:var(--black);font-weight:500}.admin-button.primary:hover{opacity:.9;color:var(--black)}
        .admin-panel{background:var(--surface);border:1px solid var(--border);border-radius:4px;overflow:hidden}.admin-panel-body{padding:22px}.admin-section-title{font:1.35rem var(--serif);color:var(--white);margin:0}.admin-section-subtitle{margin:5px 0 0;color:var(--muted);font-size:.75rem}.admin-alert{margin-bottom:18px;padding:11px 14px;border:1px solid rgba(92,200,32,.25);border-left:3px solid var(--green);border-radius:3px;background:rgba(92,200,32,.06);color:var(--green);font:.67rem var(--mono)}.admin-footer{text-align:center;margin-top:34px;padding-top:17px;border-top:1px solid var(--border);color:var(--dim);font:.55rem var(--mono);letter-spacing:.1em;text-transform:uppercase}.admin-footer span{color:var(--green)}
    @yield('page-styles')
        @media(max-width:900px){.admin-header{flex-wrap:wrap}.admin-nav{order:3;width:100%;overflow:auto}.admin-hero{align-items:flex-start;flex-direction:column}}
        @media(max-width:600px){.admin-header{padding:10px 14px}.admin-user-name,.admin-caption{display:none}.admin-main{padding:24px 14px 40px}.admin-hero h1{font-size:1.85rem}.admin-nav{gap:5px}.admin-link,.admin-logout{font-size:.53rem;padding:7px 8px}}
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="admin-brand"><a class="admin-logo" href="{{ route('admin.users.index') }}">onsoft<span>arch</span></a><div class="admin-divider"></div><div class="admin-caption">BDC · Admin Console</div></div>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a class="admin-link" href="{{ route('admin.users.index') }}">Manage accounts</a>
            <a class="admin-link" href="{{ route('client.dashboard') }}">Client portal</a>
            <a class="admin-link" href="{{ route('employee.dashboard') }}">Team hub</a>
            <a class="admin-link" href="{{ route('profile.edit') }}">Profile</a>
        </nav>
        <div class="admin-user"><span class="admin-user-name">{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button class="admin-logout" type="submit">Sign out</button></form></div>
    </header>
    <main class="admin-main">
        @yield('content')
        <footer class="admin-footer">Banco di Caribe · <span>onsoftarch</span> · Admin Console</footer>
    </main>
</body>
</html>
