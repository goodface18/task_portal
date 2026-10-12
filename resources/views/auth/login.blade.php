<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BDC Stratus · Secure Access</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@400;500&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --green: #5cc820; --black: #0d0d0d; --surface: #131313;
    --off: #f0efe9; --white: #fff; --border: rgba(255,255,255,0.08); --border2: rgba(255,255,255,0.12);
    --muted: rgba(255,255,255,0.45); --dim: rgba(255,255,255,0.2); --red: #f2495c;
    --mono: 'DM Mono', monospace; --serif: 'DM Serif Display', serif; --sans: 'Instrument Sans', sans-serif;
  }
  html, body { height: 100%; }
  body { background: var(--black); color: var(--off); font-family: var(--sans); overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 100vh; position: relative; }

  /* Animated grid + drifting glow background */
  .bg-grid { position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(rgba(92,200,32,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(92,200,32,0.04) 1px, transparent 1px); background-size: 40px 40px; mask-image: radial-gradient(ellipse 70% 70% at 50% 45%, black 10%, transparent 80%); }
  .bg-glow { position: fixed; z-index: 0; width: 600px; height: 460px; top: 50%; left: 50%; transform: translate(-50%,-50%); background: radial-gradient(ellipse, rgba(92,200,32,0.09) 0%, transparent 70%); pointer-events: none; animation: pulse-glow 7s ease-in-out infinite; }
  @keyframes pulse-glow { 0%,100%{opacity:0.7; transform:translate(-50%,-50%) scale(1);} 50%{opacity:1; transform:translate(-50%,-50%) scale(1.08);} }

  /* Falling code rain (subtle) */
  .rain { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; opacity: 0.16; }
  .rain span { position: absolute; top: -10%; font-family: var(--mono); font-size: 0.8rem; color: var(--green); white-space: nowrap; writing-mode: vertical-rl; animation: fall linear infinite; }
  @keyframes fall { to { transform: translateY(120vh); } }

  .login-wrap { position: relative; z-index: 2; width: 100%; max-width: 410px; padding: 1.5rem; opacity: 0; transform: translateY(20px); animation: rise 0.7s cubic-bezier(0.22,1,0.36,1) forwards 0.15s; }
  @keyframes rise { to { opacity: 1; transform: translateY(0); } }

  .brand { text-align: center; margin-bottom: 1.75rem; }
  .brand-logo { font-family: var(--sans); font-weight: 600; font-size: 1.35rem; color: var(--white); letter-spacing: -0.01em; }
  .brand-logo span { color: var(--green); }
  .brand-sub { font-family: var(--mono); font-size: 0.62rem; letter-spacing: 0.22em; color: var(--muted); text-transform: uppercase; margin-top: 0.6rem; }

  .terminal { background: rgba(10,10,10,0.92); border: 1px solid var(--border2); border-radius: 8px; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.6); backdrop-filter: blur(6px); }
  .term-bar { background: #131313; border-bottom: 1px solid var(--border); padding: 11px 15px; display: flex; align-items: center; gap: 8px; }
  .tb-dot { width: 11px; height: 11px; border-radius: 50%; }
  .tb-title { font-family: var(--mono); font-size: 0.66rem; color: var(--muted); margin-left: 10px; letter-spacing: 0.05em; }
  .term-body { padding: 1.75rem 1.75rem 2rem; }

  .boot-line { font-family: var(--mono); font-size: 0.72rem; color: var(--muted); line-height: 1.9; opacity: 0; }
  .boot-line.show { opacity: 1; }
  .boot-line .ok { color: var(--green); }
  .boot-line .pr { color: var(--green); }
  .boot-line .err { color: var(--red); }

  .form-area { margin-top: 1.25rem; opacity: 0; max-height: 0; overflow: hidden; transition: opacity 0.5s ease, max-height 0.6s ease; }
  .form-area.show { opacity: 1; max-height: 560px; }

  .field { margin-bottom: 1rem; }
  .field label { display: block; font-family: var(--mono); font-size: 0.66rem; letter-spacing: 0.08em; color: var(--green); text-transform: uppercase; margin-bottom: 0.45rem; }
  .input-wrap { position: relative; display: flex; align-items: center; }
  .input-wrap .prompt { position: absolute; left: 12px; font-family: var(--mono); font-size: 0.82rem; color: var(--green); pointer-events: none; }
  .field input { width: 100%; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 4px; padding: 11px 12px 11px 30px; color: var(--off); font-family: var(--mono); font-size: 0.85rem; outline: none; letter-spacing: 0.05em; transition: border-color 0.2s, box-shadow 0.2s, background 0.2s; }
  .field input::placeholder { color: var(--dim); letter-spacing: 0; }
  .field input:focus { border-color: rgba(92,200,32,0.6); box-shadow: 0 0 0 3px rgba(92,200,32,0.1); background: rgba(92,200,32,0.02); }

  .form-options { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; margin: 0.25rem 0 1rem; font-family: var(--mono); font-size: 0.66rem; }
  .remember-option { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--muted); cursor: pointer; }
  .remember-option input { width: 14px; height: 14px; margin: 0; accent-color: var(--green); cursor: pointer; }
  .forgot-link { color: var(--green); text-decoration: none; }
  .forgot-link:hover { text-decoration: underline; }

  .login-btn { width: 100%; margin-top: 0.5rem; background: var(--green); color: var(--black); font-family: var(--mono); font-size: 0.78rem; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; border: none; border-radius: 4px; padding: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity 0.2s, transform 0.15s; }
  .login-btn:hover { opacity: 0.92; transform: translateY(-1px); }
  .login-btn:disabled { opacity: 0.5; cursor: default; transform: none; }

  .msg { font-family: var(--mono); font-size: 0.7rem; line-height: 1.7; margin-top: 1rem; min-height: 18px; }
  .msg.error { color: var(--red); }
  .msg.success { color: var(--green); }

  .hint { font-family: var(--mono); font-size: 0.62rem; color: var(--dim); text-align: center; margin-top: 1.25rem; letter-spacing: 0.04em; }
  .hint b { color: var(--muted); }

  .cursor { display: inline-block; width: 7px; height: 14px; background: var(--green); margin-left: 1px; vertical-align: text-bottom; animation: blink 1.1s step-end infinite; }
  @keyframes blink { 0%,50%{opacity:1} 51%,100%{opacity:0} }

  /* success overlay */
  .auth-success { display: none; }
  .auth-success.show { display: block; animation: rise 0.4s ease; }
  .auth-success .line { font-family: var(--mono); font-size: 0.74rem; color: var(--green); line-height: 2; }

  .footer-note { position: fixed; bottom: 1.25rem; left: 0; right: 0; text-align: center; z-index: 2; font-family: var(--mono); font-size: 0.58rem; letter-spacing: 0.12em; color: var(--dim); text-transform: uppercase; }
  .footer-note span { color: var(--green); }

  @media (max-width: 480px) {
    .login-wrap { padding: 1rem; }
    .term-body { padding: 1.5rem 1.25rem 1.75rem; }
  }
</style>
</head>
<body>

<div class="bg-grid"></div>
<div class="bg-glow"></div>
<div class="rain" id="rain"></div>

<div class="login-wrap">
  <div class="brand">
    <div class="brand-logo">onsoft<span>arch</span></div>
    <div class="brand-sub">BDC Stratus · Secure Access</div>
  </div>

  <div class="terminal">
    <div class="term-bar">
      <span class="tb-dot" style="background:#ff5f57"></span>
      <span class="tb-dot" style="background:#febc2e"></span>
      <span class="tb-dot" style="background:#28c840"></span>
      <span class="tb-title">AUTH.CBL · operator login</span>
    </div>
    <div class="term-body">

      <!-- boot sequence -->
      <div id="boot">
        <div class="boot-line" data-i="0"><span class="pr">&gt;</span> initialising secure channel<span class="cursor" id="boot-cursor"></span></div>
        <div class="boot-line" data-i="1"><span class="ok">&#10003;</span> TLS handshake complete</div>
        <div class="boot-line" data-i="2"><span class="ok">&#10003;</span> BDC Stratus node reached</div>
        <div class="boot-line" data-i="3"><span class="pr">&gt;</span> awaiting operator credentials</div>
        @if ($errors->has('email') || $errors->has('password'))
          <div class="boot-line error" data-i="4"><span class="err">&#10007;</span> ACCESS DENIED · {{ $errors->first('email') ?: $errors->first('password') }}</div>
        @endif
      </div>

      <!-- login form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-area" id="form-area">
            <div class="field">
            <label for="email">{{__('Email')}}</label>
            <div class="input-wrap">
                <span class="prompt">$</span>
                <input id="email" type="email" autocomplete="email" name="email" value="{{ old('email') }}" placeholder="enter email address" spellcheck="false" required autofocus>
            </div>
            </div>
            <div class="field">
            <label for="pass">{{__('Password')}}</label>
            <div class="input-wrap">
                <span class="prompt">$</span>
                <input id="password" type="password" autocomplete="current-password" name="password" placeholder="enter password" spellcheck="false" required>
            </div>
            </div>
            <div class="form-options">
              <label class="remember-option" for="remember">
                <input id="remember" type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <span>{{ __('Remember me') }}</span>
              </label>
              @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
              @endif
            </div>
            <button class="login-btn" id="login-btn" type="submit">&#9654;&nbsp; Authenticate</button>
            <div class="msg{{ $errors->any() ? ' error' : '' }}" id="msg" role="alert">{{ $errors->first('email') ?: $errors->first('password') }}</div>
        </div>
      </form>  

      <!-- success -->
      <div class="auth-success" id="auth-success">
        <div class="line" id="success-lines"></div>
      </div>

    </div>
  </div>

  <!-- <div class="hint">Demo credentials &nbsp;·&nbsp; login <b>BDC</b> &nbsp;·&nbsp; password <b>BDC</b></div> -->
</div>

<div class="footer-note">onsoft<span>arch</span> &nbsp;·&nbsp; Authorised Operators Only</div>

<script>
  // ---- code rain ----
  (function(){
    var rain = document.getElementById('rain');
    var snippets = ['PIC 9(9)','PERFORM','COMP-3','GOBACK','01 WS-AUTH','MOVE','EVALUATE','END-IF','CALL','STOP RUN','9(11)V99','WORKING-STORAGE'];
    var cols = Math.floor(window.innerWidth / 38);
    for (var i=0;i<cols;i++){
      var s = document.createElement('span');
      s.textContent = snippets[Math.floor(Math.random()*snippets.length)] + ' ' + snippets[Math.floor(Math.random()*snippets.length)];
      s.style.left = (i*38 + Math.random()*10) + 'px';
      s.style.animationDuration = (6 + Math.random()*8) + 's';
      s.style.animationDelay = (-Math.random()*10) + 's';
      rain.appendChild(s);
    }
  })();

  // ---- boot sequence ----
  var bootLines = document.querySelectorAll('.boot-line');
  var delays = [300, 900, 1350, 1800, 2250];
  bootLines.forEach(function(line, index){
    setTimeout(function(){
      line.classList.add('show');
      if (index === 0) {
        setTimeout(function(){
          var cursor = document.getElementById('boot-cursor');
          if (cursor) cursor.style.display = 'none';
        }, 550);
      }
      if (index === bootLines.length - 1) {
        setTimeout(function(){
          document.getElementById('form-area').classList.add('show');
          var email = document.getElementById('email');
          var password = document.getElementById('password');
          (password && document.querySelector('.boot-line.error') ? password : email).focus();
        }, 350);
      }
    }, delays[index] || delays[delays.length - 1]);
  });
</script>
</body>
</html>
