@extends('layouts.app')
@section('title', 'Training Programs — PulseForce')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/training-programs.css') }}">
<style>
    .member-banner { padding: 1rem 1.5rem; border-radius: 12px; margin: 0 auto 1.5rem; max-width: 1100px; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
    .member-banner.assigned { background: linear-gradient(135deg, rgba(30,142,62,0.1) 0%, rgba(26,107,107,0.08) 100%); border: 1px solid rgba(30,142,62,0.2); }
    .member-banner.other { background: rgba(201,79,44,0.06); border: 1px solid rgba(201,79,44,0.15); }
    .member-banner.none { background: rgba(28,28,30,0.04); border: 1px solid rgba(28,28,30,0.1); }
    .mb-text { font-family: 'Epilogue', sans-serif; font-size: 0.9rem; font-weight: 600; }
    .mb-text span { font-weight: 400; opacity: 0.7; }
    .mb-link { font-family: 'Epilogue', sans-serif; font-size: 0.85rem; font-weight: 600; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; transition: all 0.2s; white-space: nowrap; }
    .mb-link.dash { background: var(--charcoal, #1c1c1e); color: #fff; }
    .mb-link.dash:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
    .mb-link.view-assigned { background: rgba(30,142,62,0.1); color: #1e8e3e; }
    .mb-link.view-assigned:hover { background: rgba(30,142,62,0.2); }
</style>
@endpush

@section('content')
<div class="training-page">

    <div class="training-nav">
        <div class="nav-logo"><a href="{{ route('landing') }}"><span class="nav-logo-dot"></span>PulseForce</a></div>
        @include('partials.feature-nav-links')
    </div>

    <div class="training-hero">
        <img class="training-hero-bg" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80&auto=format&fit=crop" alt="Training">
        <div class="training-hero-overlay"></div>
        <div class="training-hero-content">
            <div class="section-eyebrow">Training Hub</div>
            <h1 class="training-hero-h1">Lift Heavy.<br><em>Get Results.</em></h1>
            <p class="training-hero-p">Choose your fitness goal and experience level to get a complete weekly training split with exercises, sets, reps, and rest periods.</p>
        </div>
    </div>

    <div class="training-filters">
        <div class="filter-group">
            <span class="filter-group-label">Goal</span>
            <a href="{{ route('features.training-programs', ['goal' => 'bulk', 'level' => $level]) }}" class="filter-btn {{ $goal === 'bulk' ? 'active' : '' }}"> Bulk</a>
            <a href="{{ route('features.training-programs', ['goal' => 'shredded', 'level' => $level]) }}" class="filter-btn {{ $goal === 'shredded' ? 'active' : '' }}"> Shredded</a>
        </div>
        <div class="filter-group">
            <span class="filter-group-label">Level</span>
            <a href="{{ route('features.training-programs', ['goal' => $goal, 'level' => 'beginner']) }}" class="filter-btn {{ $level === 'beginner' ? 'active' : '' }}"> Beginner</a>
            <a href="{{ route('features.training-programs', ['goal' => $goal, 'level' => 'intermediate']) }}" class="filter-btn {{ $level === 'intermediate' ? 'active' : '' }}"> Intermediate</a>
            <a href="{{ route('features.training-programs', ['goal' => $goal, 'level' => 'veteran']) }}" class="filter-btn {{ $level === 'veteran' ? 'active' : '' }}"> Veteran</a>
        </div>
    </div>

    {{-- MEMBER PERSONALIZATION BANNER --}}
    @auth
        @if(Auth::user()->isCustomer())
            @if(isset($activeAssignment) && $activeAssignment)
                @php $isViewingAssigned = ($goal === $activeAssignment->goal && $level === $activeAssignment->level); @endphp
                @if($isViewingAssigned)
                    <div class="member-banner assigned">
                        <div class="mb-text">✅ This is your assigned program — <strong>{{ $activeAssignment->program_label }}</strong> <span>· Track progress on dashboard</span></div>
                        <a href="{{ route('dashboard') }}" class="mb-link dash">← My Dashboard</a>
                    </div>
                @else
                    <div class="member-banner other">
                        <div class="mb-text">👀 Browsing — Your trainer assigned: <strong>{{ $activeAssignment->program_label }}</strong></div>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="{{ route('features.training-programs', ['goal' => $activeAssignment->goal, 'level' => $activeAssignment->level]) }}" class="mb-link view-assigned">View My Program</a>
                            <a href="{{ route('dashboard') }}" class="mb-link dash">← Dashboard</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="member-banner none">
                    <div class="mb-text">💡 No workout assigned yet — <span>Your trainer will assign a program for you to track</span></div>
                    <a href="{{ route('dashboard') }}" class="mb-link dash">← My Dashboard</a>
                </div>
            @endif
        @endif
    @endauth

    <div class="plan-header">
        <h2>{{ $current['label'] }}</h2>
        <div class="plan-meta">
            <span>📅 {{ $current['weeks'] }} Weeks</span>
            <span>🗓️ {{ $current['days_per_week'] }} Days/Week</span>
            <span>⏱️ Rest: {{ $current['rest_between'] }}</span>
            <span>🎯 {{ $current['focus'] }}</span>
        </div>
    </div>

    <div class="days-container">
        <div class="program-summary">
            <div class="summary-stat">
                <div class="stat-num rust">{{ $current['weeks'] }}</div>
                <div class="stat-label">Weeks</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num teal">{{ $current['days_per_week'] }}</div>
                <div class="stat-label">Days / Week</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num rust">{{ count(array_filter($current['days'], fn($d) => !isset($d['rest']))) }}</div>
                <div class="stat-label">Training Days</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num teal">{{ $current['rest_between'] }}</div>
                <div class="stat-label">Avg Rest</div>
            </div>
        </div>

        @foreach($current['days'] as $day)
            <h3 class="day-heading">
                <span class="day-badge">{{ $day['day'] }}</span>
                {{ $day['muscle'] }}
                @if(!isset($day['rest']))
                    <span class="day-muscle">{{ count($day['exercises']) }} exercises</span>
                @endif
            </h3>

            @if(isset($day['rest']) && $day['rest'])
                <div class="rest-day-card">
                    <div class="rest-icon">😴</div>
                    <div class="rest-title">Rest & Recovery</div>
                    <div class="rest-desc">Focus on sleep, hydration, stretching, and light mobility work. Your muscles grow during rest.</div>
                </div>
            @else
                <div class="exercise-grid">
                    @foreach($day['exercises'] as $ex)
                    <div class="exercise-card">
                        <div class="exercise-name">{{ $ex['name'] }}</div>
                        <div class="exercise-target">{{ $ex['target'] }}</div>
                        <div class="exercise-desc">{{ $ex['desc'] }}</div>
                        <div class="exercise-stats">
                            <span class="ex-stat sets">{{ $ex['sets'] }} sets</span>
                            <span class="ex-stat reps">{{ $ex['reps'] }} reps</span>
                            <span class="ex-stat rest">{{ $ex['rest'] }} rest</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <div class="training-back">
        @auth
            @if(Auth::user()->isCustomer())
                <a href="{{ route('dashboard') }}">&larr; Back to My Dashboard</a>
            @else
                <a href="{{ route('landing') }}#modules">&larr; Back to all features</a>
            @endif
        @else
            <a href="{{ route('landing') }}#modules">&larr; Back to all features</a>
        @endauth
    </div>
</div>
@endsection
