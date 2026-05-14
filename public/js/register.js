/* =========================================
   Amazon Register Page — register.js
   Client-side validation & UX
   ========================================= */

(() => {
    'use strict';

    // ── DOM refs ──────────────────────────────
    const form     = document.getElementById('registerForm');
    const nameEl   = document.getElementById('name');
    const emailEl  = document.getElementById('email');
    const passEl   = document.getElementById('password');
    const confEl   = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const togglePw  = document.getElementById('togglePassword');
    const toggleCf  = document.getElementById('toggleConfirm');

    // Error spans
    const err = (id) => document.getElementById(`${id}-error`);

    // ── Password strength bar (inject after hint) ──
    function buildStrengthBar() {
        const wrap = document.createElement('div');
        wrap.classList.add('strength-bar');
        wrap.id = 'strengthBar';
        wrap.innerHTML = `
            <div class="strength-bar__seg" id="seg1"></div>
            <div class="strength-bar__seg" id="seg2"></div>
            <div class="strength-bar__seg" id="seg3"></div>
            <div class="strength-bar__seg" id="seg4"></div>
        `;
        const label = document.createElement('div');
        label.classList.add('strength-bar__label');
        label.id = 'strengthLabel';
        passEl.closest('.field').appendChild(wrap);
        passEl.closest('.field').appendChild(label);
    }
    buildStrengthBar();

    // ── Show/hide password toggles ─────────────
    function makeToggle(btn, input) {
        btn.addEventListener('click', () => {
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.setAttribute('aria-label', isText ? 'Show password' : 'Hide password');
            // Swap icon
            btn.querySelector('svg').innerHTML = isText
                ? `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`
                : `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>`;
        });
    }
    makeToggle(togglePw, passEl);
    makeToggle(toggleCf, confEl);

    // ── Field validators ──────────────────────
    function validateName() {
        const v = nameEl.value.trim();
        if (!v) {
            setError(nameEl, 'name', 'Enter your name');
            return false;
        }
        if (v.length < 2) {
            setError(nameEl, 'name', 'Name must be at least 2 characters.');
            return false;
        }
        clearError(nameEl, 'name');
        return true;
    }

    function validateEmail() {
        const v = emailEl.value.trim();
        if (!v) {
            setError(emailEl, 'email', 'Enter your email or mobile number');
            return false;
        }
        // Allow mobile (digits, +, spaces, dashes) OR email
        const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const mobileRe = /^[+\d][\d\s\-]{6,}$/;
        if (!emailRe.test(v) && !mobileRe.test(v)) {
            setError(emailEl, 'email', 'Enter a valid email or mobile number.');
            return false;
        }
        clearError(emailEl, 'email');
        return true;
    }

    function validatePassword() {
        const v = passEl.value;
        if (!v) {
            setError(passEl, 'password', 'Enter your password');
            updateStrength('');
            return false;
        }
        if (v.length < 6) {
            setError(passEl, 'password', 'Passwords must be at least 6 characters.');
            updateStrength(v);
            return false;
        }
        clearError(passEl, 'password');
        updateStrength(v);
        return true;
    }

    function validateConfirm() {
        const errEl = document.getElementById('confirm-error');
        if (!confEl.value) {
            setError(confEl, 'confirm', 'Re-enter your password');
            return false;
        }
        if (confEl.value !== passEl.value) {
            setError(confEl, 'confirm', 'Passwords must match.');
            return false;
        }
        clearError(confEl, 'confirm');
        return true;
    }

    // ── Strength meter ────────────────────────
    function updateStrength(pw) {
        const segs  = [1,2,3,4].map(i => document.getElementById(`seg${i}`));
        const label = document.getElementById('strengthLabel');
        const levels = ['weak','fair','fair','good'];
        const texts  = ['Weak','Fair','Good','Strong'];

        segs.forEach(s => {
            s.className = 'strength-bar__seg';
        });
        label.textContent = '';

        if (!pw) return;

        let score = 0;
        if (pw.length >= 8)                 score++;
        if (/[A-Z]/.test(pw))               score++;
        if (/[0-9]/.test(pw))               score++;
        if (/[^A-Za-z0-9]/.test(pw))        score++;
        score = Math.max(score, pw.length >= 6 ? 1 : 0);

        for (let i = 0; i < score; i++) {
            segs[i].classList.add(`strength-bar__seg--${levels[score - 1]}`);
        }
        label.textContent = texts[score - 1] || '';
    }

    // ── Error helpers ─────────────────────────
    function setError(input, id, msg) {
        input.classList.add('field__input--error');
        const el = document.getElementById(`${id}-error`);
        if (el) el.textContent = msg;
    }

    function clearError(input, id) {
        input.classList.remove('field__input--error');
        const el = document.getElementById(`${id}-error`);
        if (el) el.textContent = '';
    }

    // ── Live validation on blur ────────────────
    nameEl.addEventListener('blur', validateName);
    emailEl.addEventListener('blur', validateEmail);
    passEl.addEventListener('input', validatePassword);
    passEl.addEventListener('blur', validatePassword);
    confEl.addEventListener('blur', validateConfirm);
    confEl.addEventListener('input', () => {
        if (confEl.value) validateConfirm();
    });

    // Clear error on focus
    [nameEl, emailEl, passEl, confEl].forEach(inp => {
        inp.addEventListener('focus', () => {
            inp.classList.remove('field__input--error');
        });
    });

    // ── Form submit ───────────────────────────
    form.addEventListener('submit', (e) => {
        const ok = [
            validateName(),
            validateEmail(),
            validatePassword(),
            validateConfirm()
        ].every(Boolean);

        if (!ok) {
            e.preventDefault();
            // Focus first invalid field
            const firstInvalid = form.querySelector('.field__input--error');
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        // Show spinner
        const text    = submitBtn.querySelector('.btn__text');
        const spinner = submitBtn.querySelector('.btn__spinner');
        text.textContent = 'Creating account…';
        spinner.hidden = false;
        submitBtn.disabled = true;
    });

})();