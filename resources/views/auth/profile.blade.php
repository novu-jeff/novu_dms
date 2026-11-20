
@extends('layouts.app')

@section('content')
<div class="fm-page">

    <!-- Page Header -->
    <div class="fm-page-header">
        <div class="fm-breadcrumb">
            <span>Home</span>
            <i class="lni lni-chevron-right"></i>
            <span>My Profile</span>
        </div>

        <div class="fm-heading-content">
            <div class="fm-heading-icon">
                <i class="lni lni-user"></i>
            </div>

            <div>
                <h2 class="fm-heading-title">{{ __('My Profile') }}</h2>
                <p class="fm-heading-subtitle">
                    Manage your account information and password.
                </p>
            </div>
        </div>
    </div>

    <div class="fm-profile-layout">

        <!-- Profile Summary -->
        <div class="fm-card fm-profile-sidebar">
            <div class="fm-profile-avatar">
                <i class="lni lni-user"></i>
            </div>

            <h5 class="fm-profile-name">
                {{ auth()->user()->name }}
            </h5>

            <p class="fm-profile-email">
                {{ auth()->user()->email }}
            </p>

            <div class="fm-profile-divider"></div>

            <div class="fm-profile-info">
                <span class="fm-profile-info-icon">
                    <i class="lni lni-shield"></i>
                </span>
                <div>
                    <span class="fm-profile-info-label">Account Security</span>
                    <p>Keep your account information up to date.</p>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="fm-card fm-profile-main">
            <div class="fm-card-header">
                <div class="fm-card-title-group">
                    <div class="fm-card-title-icon">
                        <i class="lni lni-user"></i>
                    </div>
                    <div>
                        <h5 class="fm-card-title">Personal Information</h5>
                        <p class="fm-card-subtitle">
                            Update your name, email address, or password.
                        </p>
                    </div>
                </div>
            </div>

            <div class="fm-profile-form-body">

                @if ($message = Session::get('success'))
                    <div class="fm-profile-alert fm-profile-alert-success" role="alert">
                        <i class="lni lni-checkmark-circle"></i>
                        <div>
                            <strong>Changes saved successfully</strong>
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information -->
                    <div class="fm-profile-section">
                        <div class="fm-profile-section-heading">
                            <span class="fm-profile-section-icon">
                                <i class="lni lni-user"></i>
                            </span>
                            <div>
                                <h6>Basic Information</h6>
                                <p>Your name and registered email address.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="fm-label">
                                    Name <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    class="form-control fm-input @error('name') is-invalid @enderror"
                                    name="name"
                                    id="name"
                                    placeholder="Enter your full name"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    autocomplete="name"
                                    required
                                >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="email" class="fm-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="email"
                                    class="form-control fm-input @error('email') is-invalid @enderror"
                                    name="email"
                                    id="email"
                                    placeholder="Enter your email address"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    autocomplete="email"
                                    required
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="fm-profile-section">
                        <div class="fm-profile-section-heading">
                            <span class="fm-profile-section-icon">
                                <i class="lni lni-lock"></i>
                            </span>
                            <div>
                                <h6>Change Password</h6>
                                <p>
                                    Leave both password fields blank if you do not
                                    want to change your password.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="password" class="fm-label">
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control fm-input @error('password') is-invalid @enderror"
                                    name="password"
                                    id="password"
                                    placeholder="Enter a new password"
                                    autocomplete="new-password"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="password_confirmation" class="fm-label">
                                    Confirm New Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control fm-input"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Re-enter your new password"
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="fm-profile-actions">
                        <button type="submit" class="fm-btn-primary">
                            <i class="lni lni-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
