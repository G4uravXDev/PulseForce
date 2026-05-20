@extends('layouts.app')
@section('title', 'Sign Up — PulseForce')

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
                    Join the<br>
                    <em>movement.</em>
                </h1>
                <p class="login-brand-p">
                    Create an account to track your progress, enroll in training programs, and seamlessly manage your gym memberships.
                </p>
            </div>

            <div class="login-brand-tags">
                <span class="login-tag">Personalized Workouts</span>
                <span class="login-tag">Expert Nutrition</span>
                <span class="login-tag">Real-time Tracking</span>
            </div>

            {{-- Floating stat card --}}
            <div class="login-float-card">
                <div class="lfc-icon">📈</div>
                <div>
                    <div class="lfc-num">10k+</div>
                    <div class="lfc-label">Active Members</div>
                </div>
            </div>
        </div>

        {{-- Background image --}}
        <img
            class="login-brand-img"
            src="https://images.unsplash.com/photo-1549476464-37392f717541?w=900&q=80&auto=format&fit=crop"
            alt="Gym environment"
        >
        <div class="login-brand-overlay"></div>
    </div>

    {{-- RIGHT — Form panel --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Get Started</div>
                <h2 class="login-form-title">Create your account</h2>
                <p class="login-form-subtitle">Already have an account? <a href="{{ route('login') }}" class="form-link">Sign in here.</a></p>
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

            <form method="POST" action="{{ route('register.submit') }}" class="login-form" id="register-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input @error('name') is-invalid @enderror"
                        placeholder="John Doe"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <div class="form-error-text">{{ $message }}</div>
                    @enderror
                </div>

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
                    >
                    @error('email')
                        <div class="form-error-text">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
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
                    <p class="form-helper-text" style="font-size: 0.7rem; color: var(--muted); margin-top: 0.3rem;">
                        Must be at least 6 characters, containing an uppercase letter, a lowercase letter, a number, and a symbol.
                    </p>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="password-input-wrap">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="password-toggle" aria-label="Toggle password visibility">
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

                <button type="submit" class="btn-login" id="register-submit-btn">
                    Create Account
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="login-divider" style="margin: 1.5rem 0; display: flex; align-items: center; text-align: center; color: rgba(28,28,30,0.6);">
                <div style="flex: 1; border-bottom: 1px solid rgba(28,28,30,0.1);"></div>
                <span style="padding: 0 10px; font-size: 0.85rem; font-weight: 500;">OR CONTINUE WITH</span>
                <div style="flex: 1; border-bottom: 1px solid rgba(28,28,30,0.1);"></div>
            </div>

            <button type="button" id="google-login-btn" class="btn-back-home" style="margin-bottom: 1.5rem; cursor: pointer;">
                <svg width="18" height="18" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Google
            </button>

            <a href="/" class="btn-back-home" id="back-to-home-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>

            <p class="login-footer-text">
                &copy; PulseForce {{ date('Y') }} · Unleash Your Potential
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Password toggle
document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const passwordInput = toggle.previousElementSibling;
        const eyeOpen = toggle.querySelector('.eye-open');
        const eyeClosed = toggle.querySelector('.eye-closed');
        
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
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

<!-- Firebase SDK Integration -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // Firebase Configuration — loaded via config/firebase.php from .env
    const firebaseConfig = {
        apiKey: "{{ config('firebase.api_key', '') }}",
        authDomain: "{{ config('firebase.auth_domain', '') }}",
        projectId: "{{ config('firebase.project_id', '') }}",
        storageBucket: "{{ config('firebase.storage_bucket', '') }}",
        messagingSenderId: "{{ config('firebase.messaging_sender_id', '') }}",
        appId: "{{ config('firebase.app_id', '') }}"
    };

    // Initialize Firebase only if config is provided
    let app, auth, provider;
    try {
        if(firebaseConfig.apiKey && firebaseConfig.apiKey !== '') {
            app = initializeApp(firebaseConfig);
            auth = getAuth(app);
            provider = new GoogleAuthProvider();
        }
    } catch(e) {
        console.error("Firebase initialization error:", e);
    }

    // Google Login/Signup Logic
    document.getElementById('google-login-btn').addEventListener('click', async () => {
        if(!auth) {
            alert("Firebase is not configured! Please add your Firebase config in register.blade.php.");
            return;
        }

        try {
            const result = await signInWithPopup(auth, provider);
            const user = result.user;
            
            // Send user data to Laravel backend to create session
            fetch("{{ route('auth.firebase.callback') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    email: user.email,
                    displayName: user.displayName,
                    uid: user.uid
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert("Authentication failed on server.");
                }
            })
            .catch(err => {
                console.error("Server callback error:", err);
            });

        } catch (error) {
            console.error("Google Sign-In Error:", error);
            alert("Google Sign-In Failed: " + error.message);
        }
    });
</script>
@endpush

@endsection
