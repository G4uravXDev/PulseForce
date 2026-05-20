@extends('layouts.app')
@section('title', 'Reset Password — PulseForce')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')

<div class="login-page">

    {{-- LEFT — Branding panel --}}
    <div class="login-brand-panel">
        <div class="login-brand-content">
            <a href="/" class="login-logo">
                <span class="nav-logo-dot"></span>PulseForce
            </a>

            <div class="login-brand-hero">
                <h1 class="login-brand-h1">
                    New<br>
                    <em>password.</em>
                </h1>
                <p class="login-brand-p">
                    Choose a strong new password for your PulseForce account. Make it secure with a mix of letters, numbers, and symbols.
                </p>
            </div>

            <div class="login-brand-tags">
                <span class="login-tag">Min 6 Characters</span>
                <span class="login-tag">Mixed Case</span>
                <span class="login-tag">Numbers & Symbols</span>
            </div>

            {{-- Floating stat card --}}
            <div class="login-float-card">
                <div class="lfc-icon">✅</div>
                <div>
                    <div class="lfc-num">Secure</div>
                    <div class="lfc-label">Password Update</div>
                </div>
            </div>
        </div>

        {{-- Background image --}}
        <img
            class="login-brand-img"
            src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900&q=80&auto=format&fit=crop"
            alt="Gym environment"
        >
        <div class="login-brand-overlay"></div>
    </div>

    {{-- RIGHT — Reset Password form --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Account Security</div>
                <h2 class="login-form-title">Set your new password</h2>
                <p class="login-form-subtitle">Enter your new password below to regain access to your account.</p>
            </div>

            {{-- Error messages --}}
            @if($errors->any())
                <div class="login-alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="login-form" id="reset-password-form">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        value="{{ old('email', $email) }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="form-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="password-input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="password-toggle" id="password-toggle" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="password-input-wrap">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="password-toggle" id="password-toggle-confirm" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" style="display:none;">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="reset-submit-btn">
                    Reset Password
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <a href="{{ route('login') }}" class="btn-back-home" style="margin-top: 1.5rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Login
            </a>

            <p class="login-footer-text">
                &copy; PulseForce {{ date('Y') }} · Unleash Your Potential
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Password toggle for both fields
document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const wrap = toggle.closest('.password-input-wrap');
        const input = wrap.querySelector('.form-input');
        const eyeOpen = toggle.querySelector('.eye-open');
        const eyeClosed = toggle.querySelector('.eye-closed');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        eyeOpen.style.display = isPassword ? 'none' : 'block';
        eyeClosed.style.display = isPassword ? 'block' : 'none';
    });
});

// Subtle input focus animation
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => input.parentElement.classList.add('focused'));
    input.addEventListener('blur', () => input.parentElement.classList.remove('focused'));
});
</script>
@endpush

@endsection
