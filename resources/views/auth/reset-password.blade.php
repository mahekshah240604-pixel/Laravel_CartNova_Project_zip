{{-- resources/views/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova – Create New Password</title>
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
            <div class="step step--done">
                <span class="step__num">✓</span>
                <span class="step__label">Verify OTP</span>
            </div>
            <div class="step__line step__line--done"></div>
            <div class="step step--active">
                <span class="step__num">3</span>
                <span class="step__label">New Password</span>
            </div>
        </div>

        <h1 class="card__title">Create new password</h1>
        <p class="card__desc">Your new password must be different from your previous password.</p>

        @if($errors->any())
            <div class="alert alert--error">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form action="{{ route('password.reset') }}" method="POST" id="resetForm" novalidate>
            @csrf

            {{-- New Password --}}
            <div class="field">
                <label class="field__label" for="password">New password</label>
                <div class="field__input-wrap">
                    <input class="field__input @error('password') field__input--error @enderror"
                           type="password" id="password" name="password"
                           placeholder="At least 6 characters"
                           autocomplete="new-password">
                    <button type="button" class="field__toggle" id="eyePw" aria-label="Show password">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <p class="field__hint">
                    <svg viewBox="0 0 16 16" fill="currentColor" width="12"><path d="M8 1a7 7 0 100 14A7 7 0 008 1zm0 3a.75.75 0 110 1.5A.75.75 0 018 4zm0 3.5c.414 0 .75.336.75.75v3a.75.75 0 01-1.5 0v-3c0-.414.336-.75.75-.75z"/></svg>
                    Passwords must be at least 6 characters.
                </p>
                {{-- Strength bar --}}
                <div class="sbar"><div class="seg" id="s1"></div><div class="seg" id="s2"></div><div class="seg" id="s3"></div><div class="seg" id="s4"></div></div>
                <div class="slabel" id="slabel"></div>
                <span class="field__error" id="pw-err">@error('password'){{ $message }}@enderror</span>
            </div>

            {{-- Confirm Password --}}
            <div class="field">
                <label class="field__label" for="password_confirmation">Re-enter new password</label>
                <div class="field__input-wrap">
                    <input class="field__input"
                           type="password" id="password_confirmation"
                           name="password_confirmation"
                           autocomplete="new-password">
                    <button type="button" class="field__toggle" id="eyeCf" aria-label="Show password">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <span class="field__error" id="cf-err"></span>
            </div>

            <button type="submit" class="btn btn--primary">Save changes</button>
        </form>
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
(function(){
    // Eye toggle
    function mkEye(btnId, inputId){
        document.getElementById(btnId).addEventListener('click', function(){
            var inp = document.getElementById(inputId);
            inp.type = inp.type === 'password' ? 'text' : 'password';
        });
    }
    mkEye('eyePw','password'); mkEye('eyeCf','password_confirmation');

    // Strength bar
    var pw = document.getElementById('password');
    pw.addEventListener('input', function(){
        var v = pw.value;
        var segs = [1,2,3,4].map(function(i){ return document.getElementById('s'+i); });
        var lbl  = document.getElementById('slabel');
        segs.forEach(function(s){ s.className='seg'; }); lbl.textContent='';
        if(!v) return;
        var sc=0;
        if(v.length>=8) sc++;
        if(/[A-Z]/.test(v)) sc++;
        if(/[0-9]/.test(v)) sc++;
        if(/[^A-Za-z0-9]/.test(v)) sc++;
        sc = Math.max(sc, v.length>=6?1:0);
        var cls=['weak','fair','fair','good'], lbs=['Weak','Fair','Good','Strong'];
        for(var i=0;i<sc;i++) segs[i].classList.add('seg--'+cls[sc-1]);
        lbl.textContent = lbs[sc-1]||'';
    });

    // Confirm match
    var cf = document.getElementById('password_confirmation');
    cf.addEventListener('blur', function(){
        var errEl = document.getElementById('cf-err');
        if(cf.value && cf.value !== pw.value){
            cf.classList.add('field__input--error');
            errEl.textContent = 'Passwords must match.';
        } else {
            cf.classList.remove('field__input--error');
            errEl.textContent = '';
        }
    });

    // Submit guard
    document.getElementById('resetForm').addEventListener('submit', function(e){
        var ok = true;
        if(pw.value.length < 6){
            document.getElementById('pw-err').textContent = 'Password must be at least 6 characters.';
            pw.classList.add('field__input--error');
            ok = false;
        }
        if(cf.value !== pw.value){
            document.getElementById('cf-err').textContent = 'Passwords must match.';
            cf.classList.add('field__input--error');
            ok = false;
        }
        if(!ok) e.preventDefault();
    });
})();
</script>

</body>
</html>