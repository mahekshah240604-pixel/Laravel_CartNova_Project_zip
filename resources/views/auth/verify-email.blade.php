{{-- resources/views/auth/verify-email.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova – Verify Your Email</title>
    <link rel="stylesheet" href="/css/register.css">
    <style>
        .verify-icon {
            width: 60px; height: 60px;
            background: #f0fff4;
            border: 2px solid #007600;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .verify-icon svg { width: 30px; height: 30px; color: #007600; }
        .card { text-align: center; }
        .card__title { font-size: 1.5rem; }
        .email-badge {
            display: inline-block;
            background: #f7f7f7;
            border: 1px solid #d5d9d9;
            border-radius: 4px;
            padding: 6px 14px;
            font-size: .9rem;
            font-weight: 700;
            color: #0F1111;
            margin: 10px 0 16px;
            word-break: break-all;
        }
        .desc {
            font-size: .875rem;
            color: #565959;
            line-height: 1.6;
            margin-bottom: 18px;
            text-align: left;
        }
        .alert-success {
            background: #f0fff4;
            border: 1px solid #007600;
            color: #007600;
            border-radius: 4px;
            padding: 9px 13px;
            font-size: .84rem;
            margin-bottom: 14px;
            text-align: left;
        }
        .btn-resend {
            width: 100%;
            background: linear-gradient(to bottom,#f7dfa5,#f0c14b);
            border: 1px solid #a88734;
            border-radius: 4px;
            box-shadow: 0 1px 0 #9c7e31;
            padding: 8px 10px;
            font-family: inherit;
            font-size: .9375rem;
            cursor: pointer;
            color: #0F1111;
            margin-bottom: 10px;
        }
        .btn-resend:hover { filter: brightness(1.04); }
        .steps-note {
            font-size: .78rem;
            color: #888;
            margin-top: 14px;
            line-height: 1.5;
            text-align: left;
        }
        .steps-note li { margin-bottom: 4px; }
    </style>
</head>
<body>

<header class="header">
    <a href="/" class="logo-link">
        <svg class="CartNova-logo" viewBox="0 0 120 38" xmlns="http://www.w3.org/2000/svg">
            <text x="0" y="28" font-family="Arial Black,sans-serif" font-size="28"
                  font-weight="900" fill="#fff" letter-spacing="-1">CartNova</text>
            <path d="M10 33 Q55 42 105 33" stroke="#FF9900" stroke-width="3"
                  fill="none" stroke-linecap="round"/>
            <polygon points="102,29 110,33 102,37" fill="#FF9900"/>
        </svg>
    </a>
</header>

<main class="main">
    <div class="card">

        {{-- Success icon --}}
        <div class="verify-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1
                         0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
        </div>

        <h1 class="card__title">Verify your email address</h1>

        {{-- Flash: resent status --}}
        @if(session('status'))
            <div class="alert-success">
                ✓ {{ session('status') }}
            </div>
        @endif

        <p class="desc">
            To complete your CartNova account setup, please verify your email address.
            We sent a verification link to:
        </p>

        <span class="email-badge">{{ auth()->user()->email ?? session('email', 'your email address') }}</span>

        <p class="desc">
            Click the link in that email to activate your account.
            If you don't see it, check your <strong>Spam</strong> or
            <strong>Junk</strong> folder.
        </p>

        {{-- Resend button --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-resend">
                Resend verification email
            </button>
        </form>

        <ul class="steps-note">
            <li>• The link expires after <strong>60 minutes</strong>.</li>
            <li>• You can resend up to 6 times per minute.</li>
            <li>• Make sure to check your spam/junk folder.</li>
        </ul>

        <hr class="divider">

        {{-- Already verified / wrong account --}}
        <p style="font-size:.875rem; color:#0F1111;">
            Wrong email?
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="link">Sign out</a>
            and register again.
        </p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
            @csrf
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

</body>
</html>