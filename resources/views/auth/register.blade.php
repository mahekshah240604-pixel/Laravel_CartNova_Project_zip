<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova - Create Account</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
   
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Ember+Display:wght@400;700&family=CartNova+Ember:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/register.css"> --}}
</head>
<body>

    <!-- Header -->
    <header class="header">
    <a href="/" class="logo-link">
        <div class="logo-anim">
            Cart<span>Nova</span>
        </div>
    </a>
</header>

    <!-- Main -->
    <main class="main">
        <div class="card" id="registerCard">

            <h1 class="card__title">Create account</h1>

            <!-- Alerts from server -->
            @if(session('error'))
                <div class="alert alert--error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert--error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST" id="registerForm" novalidate>
                @csrf

                <!-- Your name -->
                <div class="field" id="field-name">
                    <label class="field__label" for="name">Your name</label>
                    <div class="field__input-wrap">
                        <input
                            class="field__input @error('name') field__input--error @enderror"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            placeholder="First and last name"
                        >
                    </div>
                    <span class="field__error" id="name-error">@error('name'){{ $message }}@enderror</span>
                </div>

                <!-- Mobile number or email -->
                <div class="field" id="field-email">
                    <label class="field__label" for="email">Mobile number or email</label>
                    <div class="field__input-wrap">
                        <input
                            class="field__input @error('email') field__input--error @enderror"
                            type="text"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            placeholder=""
                        >
                    </div>
                    <span class="field__error" id="email-error">@error('email'){{ $message }}@enderror</span>
                </div>

                <!-- Password -->
                <div class="field" id="field-password">
                    <label class="field__label" for="password">Password</label>
                    <div class="field__input-wrap">
                        <input
                            class="field__input @error('password') field__input--error @enderror"
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="new-password"
                            placeholder="At least 6 characters"
                        >
                        <button type="button" class="field__toggle" id="togglePassword" aria-label="Show password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <p class="field__hint">
                        <svg viewBox="0 0 16 16" fill="currentColor" width="12"><path d="M8 1a7 7 0 100 14A7 7 0 008 1zm0 3a.75.75 0 110 1.5A.75.75 0 018 4zm0 3.5c.414 0 .75.336.75.75v3a.75.75 0 01-1.5 0v-3c0-.414.336-.75.75-.75z"/></svg>
                        Passwords must be at least 6 characters.
                    </p>
                    <span class="field__error" id="password-error">@error('password'){{ $message }}@enderror</span>
                </div>

                <!-- Re-enter password -->
                <div class="field" id="field-password_confirmation">
                    <label class="field__label" for="password_confirmation">Re-enter password</label>
                    <div class="field__input-wrap">
                        <input
                            class="field__input"
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            autocomplete="new-password"
                            placeholder=""
                        >
                        <button type="button" class="field__toggle" id="toggleConfirm" aria-label="Show password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <span class="field__error" id="confirm-error"></span>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn--primary" id="submitBtn">
                    <span class="btn__text">Continue</span>
                    <span class="btn__spinner" hidden>
                        <svg viewBox="0 0 24 24" width="18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                    </span>
                </button>

                <!-- Legal -->
                <p class="legal">
                    By creating an account, you agree to CartNova's
                  <a href="{{ route('conditions') }}" class="link">Conditions of Use</a>
                  <a href="{{ route('privacy') }}" class="link">Privacy Notice</a>
                </p>
            </form>

            <hr class="divider">

            <!-- Already have account -->
            <p class="signin-prompt">
                Already have an account?
                <a href="/login" class="link link--arrow">Sign in
                    <svg viewBox="0 0 16 16" fill="currentColor" width="10"><path d="M6 3l5 5-5 5"/></svg>
                </a>
            </p>

            <!-- Business account -->
            <hr class="divider">
            {{-- <p class="business-prompt">
                Buying for work?
                <a href="#" class="link">Create a free business account</a>
            </p> --}}
        </div>
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <script src="/js/register.js"></script>
</body>
</html>