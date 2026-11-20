
@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="dms-login-page">
    {{-- Left: Branding panel --}}
    <div class="dms-login-brand-panel">
        <div class="dms-login-brand-content">
            <a href="{{ url('/') }}" class="dms-login-brand" aria-label="Home">
                <img
                    src="{{ asset('images/logo/novulution_logo.png') }}"
                    alt="Novulutions logo"
                    class="dms-login-logo"
                >
                <span class="dms-login-brand-divider"></span>
                <span class="dms-login-brand-name">Document Management System</span>
            </a>

            <div class="dms-login-intro">
                <span class="dms-login-eyebrow">DIGITAL WORKSPACE</span>
                <h1>Manage documents.<br>Move work forward.</h1>
                <p>
                    Access your documents, organize records, and support
                    efficient document management in one secure workspace.
                </p>
            </div>

            <div class="dms-login-illustration">
                <img
                    src="{{ asset('images/auth/signin-image.svg') }}"
                    alt="Document management illustration"
                >
            </div>

            <div class="dms-login-brand-footer">
                <span class="dms-login-status-dot"></span>
                <span>Document Management System</span>
            </div>
        </div>
    </div>

    {{-- Right: Login form --}}
    <div class="dms-login-form-panel">
        <div class="dms-login-form-container">
            <div class="dms-login-mobile-brand">
                <img
                    src="{{ asset('images/logo/novulution_logo.png') }}"
                    alt="Novulutions logo"
                >
            </div>

            <div class="dms-login-heading">
                <span class="dms-login-form-eyebrow">WELCOME BACK</span>
                <h2>{{ __('Sign in to your account') }}</h2>
                <p>Enter your credentials to access your workspace.</p>
            </div>

            @if ($errors->any())
                <div class="dms-login-alert" role="alert">
                    <i class="lni lni-warning" aria-hidden="true"></i>
                    <div>
                        <strong>Unable to sign in</strong>
                        <p>
                            {{ $errors->first('email') ?: $errors->first('password') ?: $errors->first() }}
                        </p>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="dms-login-form">
                @csrf

                <div class="dms-login-field">
                    <label for="email">{{ __('Email address') }}</label>
                    <div class="dms-login-input-wrap">
                        <i class="lni lni-envelope" aria-hidden="true"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email address"
                            class="@error('email') is-invalid @enderror"
                            autocomplete="email"
                            autofocus
                            required
                            aria-describedby="email-error"
                        >
                    </div>
                    @error('email')
                        <span id="email-error" class="dms-login-field-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="dms-login-field">
                    <div class="dms-login-label-row">
                        <label for="password">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="dms-login-forgot">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="dms-login-input-wrap">
                        <i class="lni lni-lock" aria-hidden="true"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Enter your password"
                            class="@error('password') is-invalid @enderror"
                            autocomplete="current-password"
                            required
                            aria-describedby="password-error"
                        >
                        <button
                            type="button"
                            class="dms-login-password-toggle"
                            id="toggle-password"
                            aria-label="Show password"
                            aria-pressed="false"
                        >
                            <i class="lni lni-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <span id="password-error" class="dms-login-field-error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="dms-login-options">
                    <label class="dms-login-remember" for="remember">
                        <input
                            type="checkbox"
                            name="remember"
                            id="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span class="dms-login-custom-checkbox"></span>
                        <span>{{ __('Remember me') }}</span>
                    </label>
                </div>

                <button type="submit" class="dms-login-submit">
                    <span>{{ __('Sign in') }}</span>
                    <i class="lni lni-arrow-right" aria-hidden="true"></i>
                </button>
            </form>

            <div class="dms-login-divider">
                <span>DOCUMENT MANAGEMENT SYSTEM</span>
            </div>

            <div class="dms-login-bottom-links">
                <a href="{{ route('whitepaper') }}">
                    <i class="lni lni-files" aria-hidden="true"></i>
                    Read the White Paper
                </a>
            </div>

            <p class="dms-login-copyright">
                &copy; {{ date('Y') }} Novulutions Inc. All rights reserved.
            </p>
        </div>
    </div>
</div>
@endsection


<style>
    .dms-login-page {
        --login-primary: #315cce;
        --login-primary-dark: #2448ad;
        --login-ink: #17253d;
        --login-muted: #78869c;
        --login-border: #e2e8f0;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        min-height: 100vh;
        margin: -1px;
        background: #fff;
        color: var(--login-ink);
        font-family: inherit;
    }

    .dms-login-page *,
    .dms-login-page *::before,
    .dms-login-page *::after {
        box-sizing: border-box;
    }

    .dms-login-brand-panel {
        position: relative;
        display: flex;
        min-height: 100vh;
        overflow: hidden;
        padding: 48px clamp(32px, 6vw, 96px);
        background:
            radial-gradient(ellipse at 85% 85%, rgba(72, 119, 220, .24), transparent 40%),
            linear-gradient(145deg, #14243c 0%, #192f50 58%, #203e68 100%);
        color: #fff;
    }

    .dms-login-brand-panel::before,
    .dms-login-brand-panel::after {
        position: absolute;
        content: "";
        pointer-events: none;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 50%;
    }

    .dms-login-brand-panel::before {
        width: 480px;
        height: 480px;
        right: -210px;
        bottom: -180px;
    }

    .dms-login-brand-panel::after {
        width: 340px;
        height: 340px;
        right: -140px;
        bottom: -110px;
    }

    .dms-login-brand-content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 560px;
        margin: 0 auto;
    }

    .dms-login-brand {
        display: inline-flex;
        align-items: center;
        align-self: flex-start;
        gap: 16px;
        color: #fff;
        text-decoration: none;
    }

    .dms-login-logo {
        display: block;
        width: 58px;
        height: 58px;
        object-fit: contain;
        padding: 5px;
        border-radius: 12px;
        background: #fff;
    }

    .dms-login-brand-divider {
        width: 1px;
        height: 38px;
        background: rgba(255, 255, 255, .25);
    }

    .dms-login-brand-name {
        max-width: 145px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.6;
        letter-spacing: .09em;
        text-transform: uppercase;
    }

    .dms-login-intro {
        margin-top: clamp(64px, 11vh, 120px);
    }

    .dms-login-eyebrow,
    .dms-login-form-eyebrow {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .16em;
    }

    .dms-login-eyebrow {
        margin-bottom: 20px;
        color: #9cbaff;
    }

    .dms-login-intro h1 {
        margin: 0 0 20px;
        color: #fff;
        font-size: clamp(30px, 3.1vw, 46px);
        font-weight: 750;
        line-height: 1.2;
        letter-spacing: -.035em;
    }

    .dms-login-intro p {
        max-width: 430px;
        margin: 0;
        color: #c0cce0;
        font-size: 15px;
        line-height: 1.9;
    }

    .dms-login-illustration {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: center;
        min-height: 180px;
        padding: 28px 0;
    }

    .dms-login-illustration img {
        display: block;
        width: 100%;
        max-width: 410px;
        max-height: 300px;
        object-fit: contain;
    }

    .dms-login-brand-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        padding-top: 24px;
        color: #c0cce0;
        font-size: 12px;
    }

    .dms-login-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #70d6ae;
        box-shadow: 0 0 0 4px rgba(112, 214, 174, .12);
    }

    .dms-login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
        padding: 56px clamp(28px, 6vw, 96px);
        background: #fff;
    }

    .dms-login-form-container {
        width: 100%;
        max-width: 420px;
        margin: auto;
    }

    .dms-login-mobile-brand {
        display: none;
    }

    .dms-login-heading {
        margin-bottom: 36px;
    }

    .dms-login-form-eyebrow {
        margin-bottom: 13px;
        color: var(--login-primary);
    }

    .dms-login-heading h2 {
        margin: 0 0 12px;
        color: var(--login-ink);
        font-size: clamp(25px, 2.4vw, 32px);
        font-weight: 750;
        line-height: 1.3;
        letter-spacing: -.035em;
    }

    .dms-login-heading p {
        margin: 0;
        color: var(--login-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .dms-login-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 24px;
        padding: 14px 16px;
        border: 1px solid #fecaca;
        border-radius: 12px;
        background: #fff7f7;
        color: #b42318;
        font-size: 13px;
    }

    .dms-login-alert > i {
        margin-top: 2px;
        font-size: 18px;
    }

    .dms-login-alert strong {
        display: block;
        margin-bottom: 4px;
    }

    .dms-login-alert p {
        margin: 0;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .dms-login-field {
        margin-bottom: 23px;
    }

    .dms-login-field > label,
    .dms-login-label-row > label {
        display: block;
        margin-bottom: 10px;
        color: #344158;
        font-size: 13px;
        font-weight: 700;
    }

    .dms-login-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dms-login-label-row > label {
        margin-bottom: 10px;
    }

    .dms-login-forgot {
        margin-bottom: 10px;
        color: var(--login-primary);
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .dms-login-forgot:hover,
    .dms-login-bottom-links a:hover {
        color: var(--login-primary-dark);
        text-decoration: underline;
    }

    .dms-login-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
        min-height: 54px;
        border: 1px solid var(--login-border);
        border-radius: 12px;
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .dms-login-input-wrap:focus-within {
        border-color: var(--login-primary);
        box-shadow: 0 0 0 4px rgba(49, 92, 206, .10);
    }

    .dms-login-input-wrap > i:first-child {
        flex: 0 0 auto;
        margin-left: 16px;
        color: #8b98ac;
        font-size: 18px;
    }

    .dms-login-input-wrap input {
        width: 100%;
        min-width: 0;
        height: 52px;
        padding: 0 14px;
        border: 0 !important;
        outline: none;
        background: transparent !important;
        box-shadow: none !important;
        color: var(--login-ink);
        font: inherit;
        font-size: 13px;
    }

    .dms-login-input-wrap input::placeholder {
        color: #a0aabc;
    }

    .dms-login-input-wrap input.is-invalid {
        color: #b42318;
    }

    .dms-login-input-wrap:has(input.is-invalid) {
        border-color: #dc3545;
    }

    .dms-login-password-toggle {
        display: inline-flex;
        flex: 0 0 44px;
        align-items: center;
        justify-content: center;
        height: 48px;
        margin-right: 3px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: #8b98ac;
        cursor: pointer;
    }

    .dms-login-password-toggle:hover {
        color: var(--login-primary);
    }

    .dms-login-password-toggle:focus-visible {
        outline: 2px solid var(--login-primary);
        outline-offset: -4px;
    }

    .dms-login-field-error {
        display: block;
        margin-top: 8px;
        color: #dc3545;
        font-size: 12px;
        line-height: 1.5;
    }

    .dms-login-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 2px 0 27px;
    }

    .dms-login-remember {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        color: #65738a;
        font-size: 13px;
        cursor: pointer;
    }

    .dms-login-remember input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .dms-login-custom-checkbox {
        position: relative;
        display: inline-block;
        flex: 0 0 18px;
        width: 18px;
        height: 18px;
        border: 1px solid #cbd5e1;
        border-radius: 5px;
        background: #fff;
    }

    .dms-login-remember input:checked + .dms-login-custom-checkbox {
        border-color: var(--login-primary);
        background: var(--login-primary);
    }

    .dms-login-remember input:checked + .dms-login-custom-checkbox::after {
        position: absolute;
        top: 1px;
        left: 5px;
        width: 5px;
        height: 10px;
        transform: rotate(45deg);
        border: solid #fff;
        border-width: 0 2px 2px 0;
        content: "";
    }

    .dms-login-remember input:focus-visible + .dms-login-custom-checkbox {
        outline: 3px solid rgba(49, 92, 206, .2);
        outline-offset: 2px;
    }

    .dms-login-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        min-height: 54px;
        padding: 14px 20px;
        border: 0;
        border-radius: 12px;
        background: var(--login-primary);
        color: #fff;
        font: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 7px 16px rgba(49, 92, 206, .18);
        transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .dms-login-submit:hover {
        transform: translateY(-1px);
        background: var(--login-primary-dark);
        box-shadow: 0 10px 22px rgba(49, 92, 206, .24);
    }

    .dms-login-submit:focus-visible {
        outline: 3px solid rgba(49, 92, 206, .3);
        outline-offset: 3px;
    }

    .dms-login-submit i {
        font-size: 17px;
    }

    .dms-login-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 35px 0 24px;
        color: #a0aabc;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .13em;
        white-space: nowrap;
    }

    .dms-login-divider::before,
    .dms-login-divider::after {
        flex: 1;
        height: 1px;
        background: #edf0f5;
        content: "";
    }

    .dms-login-bottom-links {
        text-align: center;
    }

    .dms-login-bottom-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #53647d;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .dms-login-bottom-links i {
        color: var(--login-primary);
        font-size: 17px;
    }

    .dms-login-copyright {
        margin: 35px 0 0;
        color: #a0aabc;
        font-size: 11px;
        line-height: 1.7;
        text-align: center;
    }

    @media (min-width: 1500px) {
        .dms-login-brand-panel {
            padding-right: 9%;
            padding-left: 9%;
        }
    }

    @media (max-width: 991.98px) {
        .dms-login-page {
            grid-template-columns: minmax(0, 0.85fr) minmax(0, 1.15fr);
        }

        .dms-login-brand-panel {
            padding: 36px 30px;
        }

        .dms-login-form-panel {
            padding: 48px 32px;
        }

        .dms-login-intro h1 {
            font-size: 32px;
        }

        .dms-login-brand-name {
            font-size: 10px;
        }
    }

    @media (max-width: 767.98px) {
        .dms-login-page {
            display: block;
            min-height: 100vh;
            margin: 0;
            background: #f6f8fc;
        }

        .dms-login-brand-panel {
            display: none;
        }

        .dms-login-form-panel {
            min-height: 100vh;
            padding: 36px 22px;
            background:
                radial-gradient(ellipse at top right, rgba(49, 92, 206, .07), transparent 45%),
                #f6f8fc;
        }

        .dms-login-form-container {
            max-width: 440px;
            padding: 30px 24px;
            border: 1px solid #edf0f5;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 15px 45px rgba(23, 37, 61, .06);
        }

        .dms-login-mobile-brand {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
        }

        .dms-login-mobile-brand img {
            width: 64px;
            height: 64px;
            object-fit: contain;
        }

        .dms-login-heading {
            margin-bottom: 28px;
            text-align: center;
        }

        .dms-login-heading h2 {
            font-size: 26px;
        }

        .dms-login-divider {
            margin-top: 28px;
        }

        .dms-login-copyright {
            margin-top: 26px;
        }
    }

    @media (max-width: 380px) {
        .dms-login-form-panel {
            padding: 20px 12px;
        }

        .dms-login-form-container {
            padding: 26px 18px;
        }

        .dms-login-heading h2 {
            font-size: 23px;
        }

        .dms-login-label-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .dms-login-page *,
        .dms-login-page *::before,
        .dms-login-page *::after {
            transition: none !important;
            animation: none !important;
            scroll-behavior: auto !important;
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        if (!toggleButton || !passwordInput) {
            return;
        }

        toggleButton.addEventListener('click', function () {
            const isPasswordHidden = passwordInput.type === 'password';

            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            toggleButton.setAttribute('aria-pressed', String(isPasswordHidden));
            toggleButton.setAttribute(
                'aria-label',
                isPasswordHidden ? 'Hide password' : 'Show password'
            );

            const icon = toggleButton.querySelector('i');

            if (icon) {
                icon.classList.toggle('lni-eye', !isPasswordHidden);
                icon.classList.toggle('lni-eye-off', isPasswordHidden);
            }
        });
    });
</script>


