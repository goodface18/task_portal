<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Settings · onsoftarch</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--green:#5cc820;--black:#0d0d0d;--surface:#131313;--surface2:#181818;--off:#f0efe9;--white:#fff;--border:rgba(255,255,255,.08);--border2:rgba(255,255,255,.14);--muted:rgba(255,255,255,.52);--dim:rgba(255,255,255,.28);--red:#f2495c;--blue:#5794f2;--mono:'DM Mono',monospace;--serif:'DM Serif Display',serif;--sans:'Instrument Sans',sans-serif}
        *{box-sizing:border-box}body{margin:0;background:var(--black);color:var(--off);font:13px var(--sans);min-height:100vh}body:before{content:'';position:fixed;inset:0;z-index:0;pointer-events:none;background-image:linear-gradient(rgba(92,200,32,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(92,200,32,.025) 1px,transparent 1px);background-size:32px 32px}
        .profile-header{position:sticky;top:0;z-index:10;min-height:60px;padding:10px 24px;display:flex;align-items:center;justify-content:space-between;gap:14px;background:rgba(13,13,13,.94);backdrop-filter:blur(14px);border-bottom:1px solid var(--border)}.brand,.header-nav,.header-user{display:flex;align-items:center;gap:10px}.logo{font-size:1.05rem;font-weight:600;color:var(--white);text-decoration:none}.logo span{color:var(--green)}.divider{width:1px;height:22px;background:var(--border2)}.caption{font:.59rem var(--mono);letter-spacing:.11em;text-transform:uppercase;color:var(--muted)}.header-user{font:.63rem var(--mono);color:var(--muted)}.header-user form{margin:0}.nav-link,.logout{padding:7px 10px;border:1px solid var(--border2);border-radius:3px;background:none;color:var(--muted);font:.58rem var(--mono);letter-spacing:.05em;text-transform:uppercase;text-decoration:none;white-space:nowrap;cursor:pointer}.nav-link:hover{color:var(--green);border-color:rgba(92,200,32,.4)}.logout:hover{color:var(--red);border-color:rgba(242,73,92,.4)}
        .main{position:relative;z-index:1;max-width:1100px;margin:0 auto;padding:34px 24px 50px}.hero{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:25px}.eyebrow{font:.6rem var(--mono);letter-spacing:.16em;text-transform:uppercase;color:var(--green);margin-bottom:8px}.hero h1{font:2.15rem/1.08 var(--serif);color:var(--white);margin:0 0 8px}.hero h1 em{font-weight:400;color:var(--green)}.hero p{margin:0;color:var(--muted);font-size:.9rem;line-height:1.55}.button{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:9px 13px;border:1px solid var(--border2);border-radius:3px;background:none;color:var(--muted);font:.6rem var(--mono);letter-spacing:.06em;text-transform:uppercase;text-decoration:none;cursor:pointer;white-space:nowrap}.button:hover{color:var(--off);border-color:rgba(255,255,255,.3)}.button.primary{border-color:var(--green);background:var(--green);color:var(--black);font-weight:500}.button.primary:hover{opacity:.9}.button.danger{border-color:rgba(242,73,92,.38);color:var(--red)}.button.danger:hover{background:rgba(242,73,92,.1)}
        .notice{margin:0 0 18px;padding:11px 14px;border:1px solid rgba(92,200,32,.25);border-left:3px solid var(--green);border-radius:3px;background:rgba(92,200,32,.06);color:var(--green);font:.67rem var(--mono)}.profile-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}.panel{background:var(--surface);border:1px solid var(--border);border-radius:4px;overflow:hidden}.panel.full{grid-column:1/-1}.panel-head{padding:18px 20px 0}.panel-eyebrow{font:.57rem var(--mono);letter-spacing:.14em;text-transform:uppercase;color:var(--green);margin-bottom:6px}.panel-title{font:1.25rem var(--serif);color:var(--white);margin:0}.panel-description{margin:5px 0 0;color:var(--muted);font-size:.76rem;line-height:1.5}.panel-body{padding:18px 20px 20px}.field{display:flex;flex-direction:column;gap:7px;margin-bottom:15px}.field:last-of-type{margin-bottom:0}.label{font:.58rem var(--mono);letter-spacing:.08em;text-transform:uppercase;color:var(--green)}.control{width:100%;padding:11px 12px;border:1px solid var(--border2);border-radius:3px;background:#0d0d0d;color:var(--off);font:.78rem var(--sans);outline:none}.control:focus{border-color:rgba(92,200,32,.65);box-shadow:0 0 0 3px rgba(92,200,32,.08)}.control::placeholder{color:var(--dim)}.error{color:var(--red);font:.63rem var(--mono)}.field-note{color:var(--dim);font-size:.68rem;line-height:1.45}.field-actions{display:flex;align-items:center;gap:12px;margin-top:17px}.saved{color:var(--green);font:.63rem var(--mono)}.verification{margin-top:12px;color:var(--muted);font-size:.75rem;line-height:1.5}.verification button{display:block;margin-top:8px;padding:0;border:0;background:none;color:var(--green);font:.65rem var(--mono);text-decoration:underline;cursor:pointer}.danger-panel{border-color:rgba(242,73,92,.22)}.danger-panel .panel-eyebrow{color:var(--red)}.danger-panel .panel-description{max-width:680px}.danger-content{display:flex;align-items:center;justify-content:space-between;gap:15px}.footer{text-align:center;margin-top:35px;padding-top:17px;border-top:1px solid var(--border);color:var(--dim);font:.55rem var(--mono);letter-spacing:.1em;text-transform:uppercase}.footer span{color:var(--green)}
        dialog{width:min(460px,calc(100% - 30px));padding:0;border:1px solid var(--border2);border-radius:5px;background:var(--surface2);color:var(--off);box-shadow:0 24px 70px rgba(0,0,0,.7)}dialog::backdrop{background:rgba(0,0,0,.75);backdrop-filter:blur(3px)}.dialog-body{padding:22px}.dialog-body h2{margin:0 0 8px;color:var(--white);font:1.4rem var(--serif)}.dialog-body p{margin:0 0 16px;color:var(--muted);font-size:.78rem;line-height:1.55}.dialog-actions{display:flex;justify-content:flex-end;gap:9px;margin-top:18px}
        @media(max-width:760px){.profile-header{flex-wrap:wrap}.header-nav{order:3;width:100%;overflow:auto}.main{padding:25px 14px 40px}.hero{align-items:flex-start;flex-direction:column}.profile-grid{grid-template-columns:1fr}.panel.full{grid-column:auto}}
        @media(max-width:560px){.profile-header{padding:10px 14px}.caption,.header-user-name{display:none}.header-nav{gap:5px}.nav-link,.logout{font-size:.53rem;padding:7px 8px}.hero h1{font-size:1.85rem}.panel-head{padding:16px 16px 0}.panel-body{padding:16px}.danger-content{align-items:flex-start;flex-direction:column}.field-actions{flex-wrap:wrap}}
    </style>
</head>
<body>
    @php($user = $user ?? auth()->user())
    <header class="profile-header">
        <div class="brand"><a class="logo" href="{{ $user->hasRole('admin') ? route('admin.users.index') : route($user->dashboardRoute()) }}">onsoft<span>arch</span></a><div class="divider"></div><div class="caption">Account settings</div></div>
        <nav class="header-nav" aria-label="Main navigation">
            @if ($user->hasRole('admin'))
                <a class="nav-link" href="{{ route('admin.users.index') }}">Manage accounts</a>
                <a class="nav-link" href="{{ route('client.dashboard') }}">Client portal</a>
                <a class="nav-link" href="{{ route('employee.dashboard') }}">Team hub</a>
            @else
                <a class="nav-link" href="{{ route($user->dashboardRoute()) }}">← Back to dashboard</a>
            @endif
        </nav>
        <div class="header-user"><span class="header-user-name">{{ $user->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button class="logout" type="submit">Sign out</button></form></div>
    </header>

    <main class="main">
        <section class="hero">
            <div><div class="eyebrow">Task Portal · Account</div><h1>Profile <em>settings</em></h1><p>Manage your personal information, password and account security.</p></div>
            <a class="button" href="{{ $user->hasRole('admin') ? route('admin.users.index') : route($user->dashboardRoute()) }}">← Back</a>
        </section>

        @if (session('status') === 'profile-updated')<div class="notice" role="status">Profile information saved.</div>@elseif (session('status') === 'password-updated')<div class="notice" role="status">Password updated successfully.</div>@elseif (session('status') === 'verification-link-sent')<div class="notice" role="status">A new verification link has been sent to your email.</div>@endif

        <div class="profile-grid">
            <section class="panel">
                <div class="panel-head"><div class="panel-eyebrow">Personal details</div><h2 class="panel-title">Profile information</h2><p class="panel-description">Update your account name and email address.</p></div>
                <div class="panel-body">
                    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="field"><label class="label" for="name">Name</label><input class="control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name">@error('name')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label class="label" for="email">Email address</label><input class="control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">@error('email')<span class="error">{{ $message }}</span>@enderror</div>
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="verification">Your email address is unverified.<button form="send-verification" type="submit">Resend verification email</button></div>
                        @endif
                        <div class="field-actions"><button class="button primary" type="submit">Save profile</button></div>
                    </form>
                </div>
            </section>

            <section class="panel">
                <div class="panel-head"><div class="panel-eyebrow">Security</div><h2 class="panel-title">Update password</h2><p class="panel-description">Use a long, unique password to keep your account secure.</p></div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="field"><label class="label" for="current_password">Current password</label><input class="control" id="current_password" name="current_password" type="password" autocomplete="current-password">@error('current_password', 'updatePassword')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label class="label" for="new_password">New password</label><input class="control" id="new_password" name="password" type="password" autocomplete="new-password">@error('password', 'updatePassword')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field"><label class="label" for="password_confirmation">Confirm new password</label><input class="control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">@error('password_confirmation', 'updatePassword')<span class="error">{{ $message }}</span>@enderror</div>
                        <div class="field-actions"><button class="button primary" type="submit">Update password</button></div>
                    </form>
                </div>
            </section>

            <section class="panel danger-panel full">
                <div class="panel-head"><div class="panel-eyebrow">Danger zone</div><h2 class="panel-title">Delete account</h2><p class="panel-description">Permanently delete your account and associated data. This action cannot be undone.</p></div>
                <div class="panel-body danger-content">
                    <span class="field-note">You will need to confirm your password before deletion.</span>
                    <button class="button danger" id="open-delete-dialog" type="button">Delete my account</button>
                </div>
            </section>
        </div>

        <dialog id="delete-dialog">
            <form class="dialog-body" method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <h2>Delete your account?</h2>
                <p>This permanently removes your account and its data. Enter your password to confirm this action.</p>
                <div class="field"><label class="label" for="delete_password">Password</label><input class="control" id="delete_password" name="password" type="password" required autocomplete="current-password">@error('password', 'userDeletion')<span class="error">{{ $message }}</span>@enderror</div>
                <div class="dialog-actions"><button class="button" id="cancel-delete-dialog" type="button">Cancel</button><button class="button danger" type="submit">Permanently delete</button></div>
            </form>
        </dialog>
        <footer class="footer">Banco di Caribe · <span>onsoftarch</span> · Account settings</footer>
    </main>
    <script>
        const deleteDialog = document.getElementById('delete-dialog');
        document.getElementById('open-delete-dialog').addEventListener('click', () => deleteDialog.showModal());
        document.getElementById('cancel-delete-dialog').addEventListener('click', () => deleteDialog.close());
        deleteDialog.addEventListener('click', event => { if (event.target === deleteDialog) deleteDialog.close(); });
        @if ($errors->userDeletion->isNotEmpty())
            deleteDialog.showModal();
        @endif
    </script>
</body>
</html>