{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova – Password Assistance</title>

    <!-- SAME LOGIN STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>

<!-- HEADER -->
<header class="header">
    <a href="/" class="logo-link">
        <div class="logo-anim">
            Cart<span>Nova</span>
        </div>
    </a>
</header>

<!-- MAIN -->
<main class="main">
    <div class="card">

        <!-- Title -->
        <h1 class="card__title">Password assistance</h1>

        <p class="legal" style="margin-top:-5px;">
            Enter the email address associated with your CartNova account.
        </p>

        <!-- ERRORS -->
        @if($errors->any())
            <div class="alert alert--error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('password.send-otp') }}" method="POST" novalidate>
            @csrf

            <div class="field">
                <label class="field__label" for="email">Email address</label>

                <div class="field__input-wrap">
                    <input
                        class="field__input @error('email') field__input--error @enderror"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        placeholder="Enter your email"
                    >
                </div>

                <span class="field__error">
                    @error('email'){{ $message }}@enderror
                </span>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn--primary">
                Continue
            </button>
        </form>

        <!-- BACK TO LOGIN -->
        <hr class="divider">

        <p class="signin-prompt">
            <a href="{{ route('login') }}" class="link link--arrow">
                ← Back to Sign In
            </a>
        </p>

    </div>
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer__links">
        <a href="#" class="footer__link">Conditions of Use</a>
        <a href="#" class="footer__link">Privacy Notice</a>
        <a href="#" class="footer__link">Help</a>
    </div>

    <p class="footer__copy">
        © 1996–2025, CartNova.com, Inc. or its affiliates
    </p>
</footer>

</body>
</html>