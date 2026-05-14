{{-- resources/views/auth/verify-otp.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova – Verify OTP</title>
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/forgot-password.css">
</head>
<body>

<header class="header">
    <a href="/" class="logo-link">
        <svg class="CartNova-logo" viewBox="0 0 120 38" xmlns="http://www.w3.org/2000/svg">
            <text x="0" y="28" font-family="Arial Black,sans-serif" font-size="28" font-weight="900" fill="#fff" letter-spacing="-1">CartNova</text>
            <path d="M10 33 Q55 42 105 33" stroke="#FF9900" stroke-width="3" fill="none" stroke-linecap="round"/>
            <polygon points="102,29 110,33 102,37" fill="#FF9900"/>
        </svg>
    </a>
</header>

<main class="main">
    <div class="card">

        {{-- Step indicator --}}
        <div class="steps">
            <div class="step step--done">
                <span class="step__num">✓</span>
                <span class="step__label">Find Account</span>
            </div>
            <div class="step__line step__line--done"></div>
            <div class="step step--active">
                <span class="step__num">2</span>
                <span class="step__label">Verify OTP</span>
            </div>
            <div class="step__line"></div>
            <div class="step">
                <span class="step__num">3</span>
                <span class="step__label">New Password</span>
            </div>
        </div>

        <h1 class="card__title">Verify OTP</h1>

        @if(session('status'))
            <div class="alert alert--success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert--error">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <p class="card__desc">
            A 6-digit One Time Password (OTP) was sent to<br>
            <strong>{{ session('reset_email') }}</strong>
        </p>

        {{-- OTP boxes --}}
        <form action="{{ route('password.verify-otp') }}" method="POST" id="otpForm" novalidate>
            @csrf

            <div class="otp-wrap">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o1" autofocus>
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o2">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o3">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o4">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o5">
                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" id="o6">
                {{-- Hidden combined field --}}
                <input type="hidden" name="otp" id="otpHidden">
            </div>
            <span class="field__error" id="otp-err"></span>

            {{-- Countdown timer --}}
            <div class="otp-timer">
                OTP expires in <span id="countdown">15:00</span>
            </div>

            <button type="submit" class="btn btn--primary" id="verifyBtn">Verify OTP</button>
        </form>

        {{-- Resend --}}
        <form action="{{ route('password.resend-otp') }}" method="POST" style="margin-top:12px">
            @csrf
            <button type="submit" class="btn-resend">Didn't receive it? Resend OTP</button>
        </form>

        <hr class="divider">
        <p class="signin-prompt">
            <a href="{{ route('password.request') }}" class="link link--arrow">← Change email address</a>
        </p>
    </div>
</main>

<footer class="footer">
    <div class="footer__links">
        <a href="#" class="footer__link">Conditions of Use</a>
        <a href="#" class="footer__link">Privacy Notice</a>
        <a href="#" class="footer__link">Help</a>
    </div>
    <p class="footer__copy">© 1996–2025, CartNova.com, Inc. or its affiliates</p>
</footer>

<script>
(function () {
    // ── OTP box auto-advance ────────────────────────────────
    const boxes = [1,2,3,4,5,6].map(i => document.getElementById('o' + i));
    const hidden = document.getElementById('otpHidden');
    const errEl  = document.getElementById('otp-err');

    boxes.forEach((box, idx) => {
        box.addEventListener('input', () => {
            box.value = box.value.replace(/[^0-9]/g, '');
            if (box.value && idx < 5) boxes[idx + 1].focus();
            syncHidden();
        });
        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !box.value && idx > 0) {
                boxes[idx - 1].focus();
            }
        });
        // Allow paste of full OTP
        box.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                            .getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => { if (boxes[i]) boxes[i].value = ch; });
            const lastFilled = Math.min(pasted.length, 5);
            boxes[lastFilled].focus();
            syncHidden();
        });
    });

    function syncHidden() {
        hidden.value = boxes.map(b => b.value).join('');
    }

    // ── Form submit validation ─────────────────────────────
    document.getElementById('otpForm').addEventListener('submit', (e) => {
        syncHidden();
        if (hidden.value.length < 6) {
            e.preventDefault();
            errEl.textContent = 'Please enter the complete 6-digit OTP.';
            boxes[0].focus();
        }
    });

    // ── Countdown timer (15 min) ───────────────────────────
    let total = 15 * 60;
    const cd  = document.getElementById('countdown');
    const timer = setInterval(() => {
        total--;
        if (total <= 0) {
            clearInterval(timer);
            cd.textContent = '00:00';
            cd.style.color = '#CC0C39';
            return;
        }
        const m = String(Math.floor(total / 60)).padStart(2, '0');
        const s = String(total % 60).padStart(2, '0');
        cd.textContent = `${m}:${s}`;
        if (total <= 60) cd.style.color = '#CC0C39';
    }, 1000);
})();
</script>

</body>
</html>