@extends('layouts.app')
@section('title', 'Login — PulseForce')

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
                    Welcome<br>
                    <em>back.</em>
                </h1>
                <p class="login-brand-p">
                    Log in to access your dashboard — manage programs, track progress, and stay on top of your gym operations.
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
            src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900&q=80&auto=format&fit=crop"
            alt="Gym environment"
        >
        <div class="login-brand-overlay"></div>
    </div>

    {{-- RIGHT — Login form --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Account Access</div>
                <h2 class="login-form-title">Sign in to your account</h2>
                <p class="login-form-subtitle">Don't have an account? <a href="{{ route('register') }}" class="form-link">Sign up here.</a></p>
            </div>

            {{-- Success message (e.g. after password reset) --}}
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

            <form method="POST" action="{{ route('login.submit') }}" class="login-form" id="login-form">
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

                <div class="form-group">
                    <div class="form-label-row">
                        <label for="password" class="form-label">Password</label>
                        <a href="#" class="form-link" id="forgot-password-link">Forgot password?</a>
                    </div>
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

                <div class="form-group-inline">
                    <label class="checkbox-wrap" for="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-label">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-login" id="login-submit-btn">
                    Sign In
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
const toggle = document.getElementById('password-toggle');
const passwordInput = document.getElementById('password');
const eyeOpen = toggle.querySelector('.eye-open');
const eyeClosed = toggle.querySelector('.eye-closed');

toggle.addEventListener('click', () => {
    const isPassword = passwordInput.type === 'password';
    passwordInput.type = isPassword ? 'text' : 'password';
    eyeOpen.style.display = isPassword ? 'none' : 'block';
    eyeClosed.style.display = isPassword ? 'block' : 'none';
});

// Subtle input focus animation
document.querySelectorAll('.form-input').forEach(input => {
    input.addEventListener('focus', () => input.parentElement.classList.add('focused'));
    input.addEventListener('blur', () => input.parentElement.classList.remove('focused'));
});

// ─── Forgot Password: inline DOM swap ───
(function() {
    const formInner = document.querySelector('.login-form-inner');
    const forgotLink = document.getElementById('forgot-password-link');

    // Save original HTML so we can swap back
    const originalHTML = formInner.innerHTML;

    forgotLink.addEventListener('click', (e) => {
        e.preventDefault();

        // Grab email value if user already typed it
        const existingEmail = document.getElementById('email')?.value || '';

        formInner.innerHTML = `
            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Password Recovery</div>
                <h2 class="login-form-title">Forgot your password?</h2>
                <p class="login-form-subtitle">Enter your email and we'll send you a reset link.</p>
            </div>

            <div id="forgot-alert-box"></div>

            <form class="login-form" id="forgot-password-form">
                <div class="form-group">
                    <label for="forgot-email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="forgot-email"
                        name="email"
                        class="form-input"
                        placeholder="you@example.com"
                        value="${existingEmail}"
                        required
                        autofocus
                    >
                </div>

                <button type="submit" class="btn-login" id="forgot-submit-btn">
                    Send Reset Link
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </form>

            <a href="#" class="btn-back-home" id="back-to-login-link" style="margin-top: 1.5rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Login
            </a>

            <p class="login-footer-text">
                &copy; PulseForce ${new Date().getFullYear()} · Unleash Your Potential
            </p>
        `;

        // Animate in
        formInner.style.opacity = '0';
        formInner.style.transform = 'translateY(12px)';
        requestAnimationFrame(() => {
            formInner.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            formInner.style.opacity = '1';
            formInner.style.transform = 'translateY(0)';
        });

        // Back to login handler
        document.getElementById('back-to-login-link').addEventListener('click', (ev) => {
            ev.preventDefault();
            formInner.style.opacity = '0';
            formInner.style.transform = 'translateY(12px)';
            setTimeout(() => {
                formInner.innerHTML = originalHTML;
                formInner.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                formInner.style.opacity = '1';
                formInner.style.transform = 'translateY(0)';
                // Re-bind password toggle and forgot link
                rebindLoginHandlers();
            }, 200);
        });

        // Forgot form submit — AJAX to Laravel
        document.getElementById('forgot-password-form').addEventListener('submit', async (ev) => {
            ev.preventDefault();
            const btn = document.getElementById('forgot-submit-btn');
            const alertBox = document.getElementById('forgot-alert-box');
            const email = document.getElementById('forgot-email').value.trim();

            if (!email) {
                showForgotAlert(alertBox, 'Please enter your email address.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = `
                <svg class="spin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16" style="animation:spin .8s linear infinite;">
                    <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                </svg>
                Sending...
            `;

            try {
                const res = await fetch("{{ route('password.email') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email })
                });

                const data = await res.json();

                if (res.ok) {
                    showForgotAlert(alertBox, data.message || 'Password reset link sent! Check your email.', 'success');
                    btn.innerHTML = `
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Link Sent!
                    `;
                } else {
                    const errMsg = data.errors?.email?.[0] || data.message || 'Something went wrong.';
                    showForgotAlert(alertBox, errMsg, 'error');
                    btn.disabled = false;
                    btn.innerHTML = `
                        Send Reset Link
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                        </svg>
                    `;
                }
            } catch (err) {
                console.error('Forgot password error:', err);
                showForgotAlert(alertBox, 'Network error. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = `
                    Send Reset Link
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                `;
            }
        });
    });

    function showForgotAlert(container, msg, type) {
        const isSuccess = type === 'success';
        container.innerHTML = `
            <div class="login-alert" style="
                background: ${isSuccess ? 'rgba(34,197,94,0.08)' : 'rgba(201,79,44,0.08)'};
                border-color: ${isSuccess ? 'rgba(34,197,94,0.2)' : 'rgba(201,79,44,0.2)'};
                color: ${isSuccess ? '#16a34a' : 'var(--rust)'};
                margin-bottom: 1rem;
            ">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                    ${isSuccess
                        ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
                        : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'
                    }
                </svg>
                ${msg}
            </div>
        `;
    }

    function rebindLoginHandlers() {
        const t = document.getElementById('password-toggle');
        const p = document.getElementById('password');
        if (t && p) {
            const eo = t.querySelector('.eye-open');
            const ec = t.querySelector('.eye-closed');
            t.addEventListener('click', () => {
                const isPw = p.type === 'password';
                p.type = isPw ? 'text' : 'password';
                eo.style.display = isPw ? 'none' : 'block';
                ec.style.display = isPw ? 'block' : 'none';
            });
        }
        const fl = document.getElementById('forgot-password-link');
        if (fl) {
            fl.addEventListener('click', (e2) => {
                e2.preventDefault();
                forgotLink.click(); // re-trigger the main handler
            });
        }
        document.querySelectorAll('.form-input').forEach(inp => {
            inp.addEventListener('focus', () => inp.parentElement.classList.add('focused'));
            inp.addEventListener('blur', () => inp.parentElement.classList.remove('focused'));
        });
    }
})();
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

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

    // Google Login Logic
    document.getElementById('google-login-btn').addEventListener('click', async () => {
        if(!auth) {
            alert("Firebase is not configured! Please add your Firebase config in login.blade.php.");
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
