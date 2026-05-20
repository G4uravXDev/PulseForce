@extends('layouts.app')
@section('title', 'Forgot Password — PulseForce')

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
                    Reset your<br>
                    <em>password.</em>
                </h1>
                <p class="login-brand-p">
                    Enter the email address associated with your account and we'll send you a link to reset your password.
                </p>
            </div>

            <div class="login-brand-tags">
                <span class="login-tag">Secure Reset</span>
                <span class="login-tag">Quick Recovery</span>
                <span class="login-tag">Email Verification</span>
            </div>

            {{-- Floating stat card --}}
            <div class="login-float-card">
                <div class="lfc-icon">🔒</div>
                <div>
                    <div class="lfc-num">256-bit</div>
                    <div class="lfc-label">Encryption</div>
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

    {{-- RIGHT — Forgot Password form --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Password Recovery</div>
                <h2 class="login-form-title">Forgot your password?</h2>
                <p class="login-form-subtitle">Remember your password? <a href="{{ route('login') }}" class="form-link">Sign in here.</a></p>
            </div>

            {{-- Success message --}}
            @if(session('status'))
                <div class="login-alert" style="background: rgba(34, 197, 94, 0.08); border-color: rgba(34, 197, 94, 0.2); color: #16a34a;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Error messages --}}
            @if($errors->any())
                <div class="login-alert">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="login-form" id="forgot-password-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="form-error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login" id="forgot-submit-btn">
                    Send Reset Link
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
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
// Subtle input focus animation
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => input.parentElement.classList.add('focused'));
    input.addEventListener('blur', () => input.parentElement.classList.remove('focused'));
});
</script>
@endpush

@endsection
