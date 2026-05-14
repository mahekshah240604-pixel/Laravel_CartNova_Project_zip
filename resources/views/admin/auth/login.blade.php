{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova Admin — Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange:   #FF6B00;
            --orange-lt:#FF8C33;
            --dark:     #0A0A0F;
            --dark2:    #12121A;
            --dark3:    #1C1C28;
            --border:   rgba(255,255,255,.08);
            --text:     #F0F0F5;
            --muted:    rgba(240,240,245,.45);
            --error:    #FF4D6A;
            --success:  #3DDC97;
        }

        html { font-size: 16px; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── BIG BACKGROUND TEXT ─────────────────── */
        .bg-word {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .bg-word span {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: clamp(120px, 22vw, 320px);
            color: transparent;
            -webkit-text-stroke: 1px rgba(255,107,0,.08);
            white-space: nowrap;
            user-select: none;
            letter-spacing: -4px;
            animation: bgFloat 8s ease-in-out infinite;
        }
        @keyframes bgFloat {
            0%,100% { transform: translateY(0) rotate(-2deg); }
            50%      { transform: translateY(-20px) rotate(-2deg); }
        }

        /* ── GRID OVERLAY ────────────────────────── */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,107,0,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,107,0,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        /* ── GLOW ORBS ───────────────────────────── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,107,0,.18), transparent 70%);
            top: -100px; left: -100px;
            animation: orb1 12s ease-in-out infinite;
        }
        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,107,0,.10), transparent 70%);
            bottom: -100px; right: -80px;
            animation: orb1 15s ease-in-out infinite reverse;
        }
        @keyframes orb1 {
            0%,100% { transform: translate(0,0); }
            50%      { transform: translate(40px, 30px); }
        }

        /* ── LAYOUT ──────────────────────────────── */
        .page {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            min-height: 100vh;
        }

        /* ── CARD ────────────────────────────────── */
        .card {
            width: 100%;
            max-width: 440px;
            background: rgba(18,18,26,.85);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 44px 40px 40px;
            backdrop-filter: blur(24px);
            box-shadow:
                0 0 0 1px rgba(255,107,0,.08),
                0 40px 80px rgba(0,0,0,.5),
                inset 0 1px 0 rgba(255,255,255,.06);
            animation: cardIn .5s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform: translateY(24px) scale(.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* ── LOGO ────────────────────────────────── */
        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--orange), var(--orange-lt));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 16px rgba(255,107,0,.35);
        }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .logo-text .cart { color: var(--text); }
        .logo-text .nova { color: var(--orange); }
        .logo-badge {
            font-size: .65rem;
            font-weight: 500;
            background: rgba(255,107,0,.15);
            border: 1px solid rgba(255,107,0,.25);
            color: var(--orange);
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 4px;
            letter-spacing: .5px;
        }

        /* ── HEADING ─────────────────────────────── */
        .heading {
            margin-bottom: 28px;
        }
        .heading h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -.3px;
        }
        .heading p {
            font-size: .875rem;
            color: var(--muted);
            line-height: 1.5;
        }

        /* ── ALERT ───────────────────────────────── */
        .alert {
            background: rgba(255,77,106,.1);
            border: 1px solid rgba(255,77,106,.25);
            color: #FF8098;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .84rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── FIELDS ──────────────────────────────── */
        .field {
            margin-bottom: 18px;
        }
        .field label {
            display: block;
            font-size: .8rem;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 7px;
            letter-spacing: .3px;
            text-transform: uppercase;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 1rem;
            pointer-events: none;
        }
        .field input {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 14px 12px 40px;
            font-size: .9375rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .field input::placeholder { color: rgba(240,240,245,.25); }
        .field input:focus {
            border-color: var(--orange);
            background: rgba(255,107,0,.06);
            box-shadow: 0 0 0 3px rgba(255,107,0,.12);
        }
        .field input.err {
            border-color: var(--error);
            box-shadow: 0 0 0 3px rgba(255,77,106,.1);
        }
        .ferr {
            font-size: .78rem;
            color: #FF8098;
            margin-top: 5px;
            display: block;
        }

        /* Eye toggle */
        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 2px;
            display: flex;
            align-items: center;
            transition: color .15s;
        }
        .eye-btn:hover { color: var(--text); }
        .eye-btn svg { width: 17px; height: 17px; }

        /* ── REMEMBER ROW ────────────────────────── */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .84rem;
            color: var(--muted);
            cursor: pointer;
        }
        .remember-label input[type=checkbox] {
            accent-color: var(--orange);
            width: 15px;
            height: 15px;
        }
        .forgot-link {
            font-size: .82rem;
            color: var(--orange);
            text-decoration: none;
            opacity: .8;
            transition: opacity .15s;
        }
        .forgot-link:hover { opacity: 1; }

        /* ── SUBMIT BUTTON ───────────────────────── */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--orange), var(--orange-lt));
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            letter-spacing: .3px;
            position: relative;
            overflow: hidden;
            transition: filter .2s, transform .15s;
            box-shadow: 0 4px 20px rgba(255,107,0,.35);
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,.15));
            opacity: 0;
            transition: opacity .2s;
        }
        .btn-submit:hover { filter: brightness(1.08); transform: translateY(-1px); }
        .btn-submit:hover::before { opacity: 1; }
        .btn-submit:active { transform: translateY(0); filter: brightness(.98); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* Spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── DIVIDER ─────────────────────────────── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: var(--muted);
            font-size: .78rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── BACK TO STORE ───────────────────────── */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: var(--muted);
            font-size: .84rem;
            text-decoration: none;
            transition: color .15s;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }
        .back-link:hover {
            color: var(--text);
            border-color: rgba(255,255,255,.15);
            background: rgba(255,255,255,.04);
        }

        /* ── FOOTER ──────────────────────────────── */
        .card-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: .75rem;
            color: var(--muted);
        }

        @media (max-width: 480px) {
            .card { padding: 32px 24px 28px; }
        }
    </style>
</head>
<body>

{{-- Background Elements --}}
<div class="bg-grid"></div>
<div class="bg-word"><span>CartNova</span></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="page">
    <div class="card">

        {{-- Logo --}}
        <div class="logo-wrap">
            <div class="logo-icon">🛒</div>
            <div class="logo-text">
                <span class="cart">Cart</span><span class="nova">Nova</span>
            </div>
            <span class="logo-badge">ADMIN</span>
        </div>

        {{-- Heading --}}
        <div class="heading">
            <h1>Welcome back 👋</h1>
            <p>Sign in to your admin panel to manage your store.</p>
        </div>

        {{-- Error Alert --}}
        @if($errors->any())
            <div class="alert">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert">⚠️ {{ session('error') }}</div>
        @endif

        {{-- Login Form --}}
        <form action="{{ route('admin.login.submit') }}" method="POST" id="loginForm" novalidate>
            @csrf

            {{-- Email --}}
            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <span class="icon">✉️</span>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@cartnova.com"
                           autocomplete="email" autofocus
                           class="{{ $errors->has('email') ? 'err' : '' }}">
                </div>
                @error('email')<span class="ferr">{{ $message }}</span>@enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="icon">🔒</span>
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password"
                           autocomplete="current-password"
                           class="{{ $errors->has('password') ? 'err' : '' }}">
                    <button type="button" class="eye-btn" id="eyeBtn" aria-label="Show password">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')<span class="ferr">{{ $message }}</span>@enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="remember-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Keep me signed in
                </label>
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit" id="submitBtn">
                <span id="btnText">Sign In to Admin Panel</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>

        <div class="divider">or</div>

        {{-- Back to Store --}}
        <a href="{{ route('home') }}" class="back-link">
            🏪 Back to CartNova Store
        </a>

        <div class="card-footer">
            © 2025 CartNova · Admin Panel · Secure Login
        </div>
    </div>
</div>

<script>
// Eye toggle
document.getElementById('eyeBtn').addEventListener('click', function() {
    const inp = document.getElementById('password');
    const isPass = inp.type === 'password';
    inp.type = isPass ? 'text' : 'password';
    this.innerHTML = isPass
        ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
            <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
            <line x1="1" y1="1" x2="23" y2="23"/>
           </svg>`
        : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
           </svg>`;
});

// Submit spinner
document.getElementById('loginForm').addEventListener('submit', function() {
    document.getElementById('btnText').style.display = 'none';
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('submitBtn').disabled = true;
});

// Input focus animation
document.querySelectorAll('input').forEach(inp => {
    inp.addEventListener('focus', () => inp.classList.remove('err'));
});
</script>

</body>
</html>