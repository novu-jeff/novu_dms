
@extends('layouts.guest')

@section('title', __('Forgot Password'))

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
                <span class="auth-eyebrow">ACCOUNT RECOVERY</span>
                <h1>Let's get you back in.</h1>
                <p>
                    Forgot your password? No problem. Enter the email
                    address associated with your account and we'll help
                    you get back to your workspace.
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
                        <i class="lni lni-envelope"></i>
                    </div>

                    <span class="auth-eyebrow">PASSWORD RECOVERY</span>
                    <h2>{{ __('Forgot Password?') }}</h2>
                    <p>
                        Enter your registered email address and we'll
                        send you a password reset link.
                    </p>
                </div>

                @if (session('status'))
                    <div class="auth-status-alert" role="status">
                        <i class="lni lni-checkmark-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="auth-error-alert" role="alert">
                        <i class="lni lni-warning"></i>
                        <div>
                            <strong>Please check your email address.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="auth-field">
                        <label for="email">{{ __('Email address') }}</label>

                        <div class="auth-input-wrap">
                            <i class="lni lni-envelope"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
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

                    <button type="submit" class="auth-submit-btn">
                        <span>{{ __('Send Password Reset Link') }}</span>
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
        min-height: 650px;
        display: grid;
        grid-template-columns: 1fr 0.95fr;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7ecf4;
        border-radius: 24px;
        box-shadow: 0 24px 70px rgba(27, 45, 78, 0.10);
    }

    .auth-brand-panel {
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        padding: 38px 44px 30px;
        color: #fff;
        background: linear-gradient(145deg, #14243c 0%, #1d3e65 65%, #176d91 100%);
    }

    .auth-brand {
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
        padding: 4px;
        object-fit: contain;
        border-radius: 10px;
        background: #fff;
    }

    .auth-brand-content {
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

    .auth-status-alert,
    .auth-error-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 22px;
        padding: 13px 15px;
        border-radius: 10px;
        font-size: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .auth-status-alert {
        border: 1px solid #bbf0d0;
        background: #f0fdf4;
        color: #166534;
    }

    .auth-error-alert {
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #b42318;
    }

    .auth-status-alert > i,
    .auth-error-alert > i {
        margin-top: 2px;
        font-size: 17px;
    }

    .auth-error-alert strong {
        display: block;
        margin-bottom: 4px;
    }

    .auth-error-alert ul {
        margin: 0;
        padding-left: 17px;
    }

    .auth-field {
        margin-bottom: 23px;
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

    .auth-input-wrap > i {
        position: absolute;
        left: 15px;
        color: #8996a9;
        font-size: 17px;
        pointer-events: none;
    }

    .auth-input-wrap input {
        width: 100%;
        min-width: 0;
        height: 49px;
        padding: 0 15px 0 46px;
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

