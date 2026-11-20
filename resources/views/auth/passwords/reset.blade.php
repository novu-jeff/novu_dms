
@extends('layouts.guest')

@section('title', __('Reset Password'))

@section('content')
<div class="auth-page">
    <div class="auth-shell">
        {{-- Left branding panel --}}
        <div class="auth-brand-panel">
            <div class="auth-brand">
                <img
                    src="{{ asset('images/logo/novulution_logo.png') }}"
                    alt="Novulutions logo"
                    class="auth-brand-logo"
                >
                <span>Document Management System</span>
            </div>

            <div class="auth-brand-content">
                <span class="auth-eyebrow">ACCOUNT SECURITY</span>
                <h1>Set a new password.</h1>
                <p>
                    Choose a strong password to secure your account
                    and continue accessing your workspace.
                </p>

                <img
                    src="{{ asset('images/auth/signin-image.svg') }}"
                    alt=""
                    class="auth-illustration"
                >
            </div>

            <div class="auth-brand-footer">
                <span>Secure document management</span>
                <span>© {{ date('Y') }} Novulutions Inc.</span>
            </div>
        </div>

        {{-- Right form panel --}}
        <div class="auth-form-panel">
            <div class="auth-form-container">
                <div class="auth-mobile-brand">
                    <img
                        src="{{ asset('images/logo/novulution_logo.png') }}"
                        alt="Novulutions logo"
                    >
                    <span>Document Management System</span>
                </div>

                <div class="auth-form-heading">
                    <div class="auth-heading-icon">
                        <i class="lni lni-lock"></i>
                    </div>

                    <span class="auth-eyebrow">PASSWORD RECOVERY</span>
                    <h2>{{ __('Reset Password') }}</h2>
                    <p>Enter your account email and choose a new password.</p>
                </div>

                @if ($errors->any())
                    <div class="auth-alert" role="alert">
                        <i class="lni lni-warning"></i>
                        <div>
                            <strong>Please check your entries.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    {{-- Required by Laravel's password reset flow --}}
                    <input
                        type="hidden"
                        name="token"
                        value="{{ $token ?? request()->route('token') }}"
                    >

                    <div class="auth-field">
                        <label for="email">{{ __('Email address') }}</label>

                        <div class="auth-input-wrap">
                            <i class="lni lni-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $email ?? request('email')) }}"
                                placeholder="Enter your email address"
                                autocomplete="email"
                                class="@error('email') is-invalid @enderror"
                                required
                                autofocus
                            >
                        </div>

                        @error('email')
                            <span class="auth-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password">{{ __('New password') }}</label>

                        <div class="auth-input-wrap">
                            <i class="lni lni-lock"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Enter your new password"
                                autocomplete="new-password"
                                class="@error('password') is-invalid @enderror"
                                required
                            >

                            <button
                                type="button"
                                class="auth-password-toggle"
                                data-target="password"
                                aria-label="Show password"
                                aria-pressed="false"
                            >
                                <i class="lni lni-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <span class="auth-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auth-field">
                        <label for="password_confirmation">
                            {{ __('Confirm new password') }}
                        </label>

                        <div class="auth-input-wrap">
                            <i class="lni lni-shield"></i>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="Re-enter your new password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="auth-password-toggle"
                                data-target="password_confirmation"
                                aria-label="Show password"
                                aria-pressed="false"
                            >
                                <i class="lni lni-eye"></i>
                            </button>
                        </div>

                        @error('password_confirmation')
                            <span class="auth-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        <span>{{ __('Reset Password') }}</span>
                        <i class="lni lni-arrow-right"></i>
                    </button>

                    @if (Route::has('login'))
                        <p class="auth-back-link">
                            Remember your password?
                            <a href="{{ route('login') }}">Back to login</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .auth-page {
        min-height: 100vh;
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f6fb;
        color: #202c42;
    }

    .auth-shell {
        width: 100%;
        max-width: 1180px;
        min-height: 690px;
        display: grid;
        grid-template-columns: 1fr 0.95fr;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7ecf4;
        border-radius: 24px;
        box-shadow: 0 24px 70px rgba(27, 45, 78, 0.10);
    }

    .auth-brand-panel {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 38px 44px 30px;
        overflow: hidden;
        color: #fff;
        background: linear-gradient(145deg, #14243c 0%, #1d3e65 65%, #176d91 100%);
    }

    .auth-brand {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
    }

    .auth-brand-logo {
        width: 44px;
        height: 44px;
        object-fit: contain;
        padding: 4px;
        border-radius: 10px;
        background: #fff;
    }

    .auth-brand-content {
        position: relative;
        z-index: 1;
        margin: auto 0;
        padding: 45px 0;
    }

    .auth-eyebrow {
        display: block;
        margin-bottom: 12px;
        color: #4ebcdb;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .auth-brand-content h1 {
        max-width: 390px;
        margin: 0 0 18px;
        color: #fff;
        font-size: clamp(30px, 3vw, 42px);
        font-weight: 750;
        line-height: 1.2;
    }

    .auth-brand-content p {
        max-width: 390px;
        margin: 0;
        color: #d0dced;
        font-size: 15px;
        line-height: 1.8;
    }

    .auth-illustration {
        display: block;
        width: 100%;
        max-width: 340px;
        max-height: 205px;
        margin: 34px auto 0;
        object-fit: contain;
    }

    .auth-brand-footer {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 10px;
        color: #bdcde0;
        font-size: 11px;
    }

    .auth-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 55px 48px;
    }

    .auth-form-container {
        width: 100%;
        max-width: 400px;
    }

    .auth-mobile-brand {
        display: none;
    }

    .auth-form-heading {
        margin-bottom: 30px;
    }

    .auth-heading-icon {
        display: flex;
        width: 48px;
        height: 48px;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
        border-radius: 14px;
        background: #edf5ff;
        color: #2865c7;
        font-size: 23px;
    }

    .auth-form-heading .auth-eyebrow {
        margin-bottom: 8px;
        color: #2865c7;
    }

    .auth-form-heading h2 {
        margin: 0 0 10px;
        color: #1e293b;
        font-size: 30px;
        font-weight: 750;
        letter-spacing: -0.8px;
    }

    .auth-form-heading p {
        margin: 0;
        color: #718096;
        font-size: 13px;
        line-height: 1.7;
    }

    .auth-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 22px;
        padding: 13px 15px;
        border: 1px solid #fecaca;
        border-radius: 10px;
        background: #fff5f5;
        color: #b42318;
        font-size: 12px;
    }

    .auth-alert > i {
        margin-top: 2px;
        font-size: 17px;
    }

    .auth-alert strong {
        display: block;
        margin-bottom: 4px;
    }

    .auth-alert ul {
        margin: 0;
        padding-left: 17px;
    }

    .auth-field {
        margin-bottom: 21px;
    }

    .auth-field > label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .auth-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .auth-input-wrap > i:first-child {
        position: absolute;
        left: 15px;
        z-index: 1;
        color: #8996a9;
        font-size: 17px;
        pointer-events: none;
    }

    .auth-input-wrap input {
        width: 100%;
        min-width: 0;
        height: 49px;
        padding: 0 46px;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: #202c42;
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    .auth-input-wrap input::placeholder {
        color: #a0aaba;
    }

    .auth-input-wrap input:focus {
        border-color: #3978d5;
        box-shadow: 0 0 0 3px rgba(57, 120, 213, .12);
    }

    .auth-input-wrap input.is-invalid {
        border-color: #dc3545;
    }

    .auth-password-toggle {
        position: absolute;
        right: 12px;
        display: flex;
        width: 28px;
        height: 32px;
        align-items: center;
        justify-content: center;
        border: 0;
        background: transparent;
        color: #8491a5;
        cursor: pointer;
    }

    .auth-password-toggle i {
        font-size: 17px;
    }

    .auth-field-error {
        display: block;
        margin-top: 7px;
        color: #dc3545;
        font-size: 12px;
    }

    .auth-submit-btn {
        display: flex;
        width: 100%;
        min-height: 49px;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 8px;
        padding: 12px 18px;
        border: 0;
        border-radius: 10px;
        background: linear-gradient(100deg, #2865c7, #247fae);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }

    .auth-submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(40, 101, 199, .22);
        color: #fff;
    }

    .auth-back-link {
        margin: 24px 0 0;
        color: #7b8799;
        font-size: 12px;
        text-align: center;
    }

    .auth-back-link a {
        margin-left: 4px;
        color: #2865c7;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-back-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 850px) {
        .auth-page {
            padding: 18px;
        }

        .auth-shell {
            max-width: 520px;
            min-height: auto;
            grid-template-columns: 1fr;
        }

        .auth-brand-panel {
            display: none;
        }

        .auth-form-panel {
            padding: 42px 30px;
        }

        .auth-mobile-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 38px;
            color: #344054;
            font-size: 12px;
            font-weight: 700;
        }

        .auth-mobile-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }
    }

    @media (max-width: 480px) {
        .auth-page {
            padding: 0;
            background: #fff;
        }

        .auth-shell {
            min-height: 100vh;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .auth-form-panel {
            padding: 30px 23px;
        }

        .auth-form-heading h2 {
            font-size: 27px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.auth-password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.target);

                if (!input) return;

                const showPassword = input.type === 'password';
                input.type = showPassword ? 'text' : 'password';

                button.setAttribute('aria-pressed', String(showPassword));
                button.setAttribute(
                    'aria-label',
                    showPassword ? 'Hide password' : 'Show password'
                );

                const icon = button.querySelector('i');

                if (icon) {
                    icon.classList.toggle('lni-eye', !showPassword);
                    icon.classList.toggle('lni-eye-off', showPassword);
                }
            });
        });
    });
</script>

