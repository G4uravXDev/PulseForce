@extends('layouts.app')
@section('title', 'Seamless Memberships — PulseForce')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
<div class="login-page">

    <div class="login-brand-panel">
        <div class="login-brand-content">
            <a href="{{ route('landing') }}" class="login-logo">
                <span class="nav-logo-dot"></span>PulseForce
            </a>

            <div class="login-brand-hero">
                <h1 class="login-brand-h1">
                    Seamless<br>
                    <em>Memberships.</em>
                </h1>
                <p class="login-brand-p">
                    Manage your subscription effortlessly. Auto-renewals and clear payment tracking ensure zero interruptions.
                </p>
            </div>
        </div>

        <img class="login-brand-img" src="https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=900&q=80&auto=format&fit=crop" alt="Memberships">
        <div class="login-brand-overlay"></div>
    </div>

    <div class="login-form-panel">
        <div class="login-form-inner" style="justify-content: center; display: flex; flex-direction: column;">
            
            <div class="login-form-header">
                <div class="section-eyebrow" style="margin-bottom:1rem;">Core Feature</div>
                <h2 class="login-form-title">Zero interruptions.</h2>
            </div>
            
            <ul style="list-style: none; padding: 0; margin: 2rem 0; color: rgba(240,235,226,0.8); font-size: 1.1rem; line-height: 2;">
                <li><span style="color:var(--rust); margin-right:10px;">✓</span> Complete control over billing cycles</li>
                <li><span style="color:var(--rust); margin-right:10px;">✓</span> Transparent invoice and payment history</li>
                <li><span style="color:var(--rust); margin-right:10px;">✓</span> Automated renewal reminders</li>
                <li><span style="color:var(--rust); margin-right:10px;">✓</span> Effortless tier upgrades via the app</li>
            </ul>

            <div style="margin-top: 2rem; display: flex; align-items: center; gap: 1.5rem;">
                <a href="{{ route('register') }}" class="btn-rust" style="text-decoration:none;">Upgrade Your Membership &rarr;</a>
                <a href="{{ route('landing') }}#modules" class="form-link">&larr; Back to features</a>
            </div>

        </div>
    </div>
</div>
@endsection
