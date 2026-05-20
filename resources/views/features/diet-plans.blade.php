@extends('layouts.app')
@section('title', 'Custom Diet Plans — PulseForce')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/diet-plans.css') }}">
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
<div class="diet-page">

    {{-- NAV --}}
    <div class="diet-nav">
        <div class="nav-logo"><a href="{{ route('landing') }}"><span class="nav-logo-dot"></span>PulseForce</a></div>
        @include('partials.feature-nav-links')
    </div>

    {{-- HERO --}}
    <div class="diet-hero">
        <img class="diet-hero-bg" src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=1200&q=80&auto=format&fit=crop" alt="Healthy food">
        <div class="diet-hero-overlay"></div>
        <div class="diet-hero-content">
            <div class="section-eyebrow">Nutrition Hub</div>
            <h1 class="diet-hero-h1">Eat Smart.<br><em>Train Hard.</em></h1>
            <p class="diet-hero-p">Choose your fitness goal and dietary preference to get a fully detailed daily meal plan with calorie and macro breakdowns for every meal.</p>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="diet-filters">
        <div class="filter-group">
            <span class="filter-group-label">Goal</span>
            <a href="{{ route('features.diet-plans', ['goal' => 'bulk', 'type' => $type]) }}" class="filter-btn {{ $goal === 'bulk' ? 'active' : '' }}"> Bulk</a>
            <a href="{{ route('features.diet-plans', ['goal' => 'slim', 'type' => $type]) }}" class="filter-btn {{ $goal === 'slim' ? 'active' : '' }}"> Slim</a>
        </div>
        <div class="filter-group">
            <span class="filter-group-label">Diet</span>
            <a href="{{ route('features.diet-plans', ['goal' => $goal, 'type' => 'veg']) }}" class="filter-btn {{ $type === 'veg' ? 'active' : '' }}"> Vegetarian</a>
            <a href="{{ route('features.diet-plans', ['goal' => $goal, 'type' => 'nonveg']) }}" class="filter-btn {{ $type === 'nonveg' ? 'active' : '' }}"> Non-Veg</a>
            <a href="{{ route('features.diet-plans', ['goal' => $goal, 'type' => 'vegan']) }}" class="filter-btn {{ $type === 'vegan' ? 'active' : '' }}"> Vegan</a>
        </div>
    </div>

    {{-- MEMBER PERSONALIZATION BANNER --}}
    @auth
        @if(Auth::user()->isCustomer())
            @if(isset($activeAssignment) && $activeAssignment)
                @php $isViewingAssigned = ($goal === $activeAssignment->goal && $type === $activeAssignment->type); @endphp
                @if($isViewingAssigned)
                    <div class="member-banner assigned">
                        <div class="mb-text">✅ This is your assigned diet — <strong>{{ $activeAssignment->plan_label }}</strong> <span>· Log meals on dashboard</span></div>
                        <a href="{{ route('dashboard') }}" class="mb-link dash">← My Dashboard</a>
                    </div>
                @else
                    <div class="member-banner other">
                        <div class="mb-text">👀 Browsing — Your trainer assigned: <strong>{{ $activeAssignment->plan_label }}</strong></div>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="{{ route('features.diet-plans', ['goal' => $activeAssignment->goal, 'type' => $activeAssignment->type]) }}" class="mb-link view-assigned">View My Plan</a>
                            <a href="{{ route('dashboard') }}" class="mb-link dash">← Dashboard</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="member-banner none">
                    <div class="mb-text">💡 No diet plan assigned yet — <span>Your trainer will assign a meal plan for you</span></div>
                    <a href="{{ route('dashboard') }}" class="mb-link dash">← My Dashboard</a>
                </div>
            @endif
        @endif
    @endauth

    {{-- PLAN HEADER --}}
    <div class="plan-header">
        <h2>{{ $current['label'] }}</h2>
        <div class="plan-meta">
            <span>🔥 {{ $current['calories'] }} kcal/day</span>
            <span>💪 {{ $current['protein'] }} protein</span>
            <span>🍞 {{ $current['carbs'] }} carbs</span>
            <span>🫒 {{ $current['fat'] }} fat</span>
        </div>
    </div>

    {{-- DAILY SUMMARY --}}
    <div class="meals-container">
        <div class="daily-summary">
            <div class="summary-stat">
                <div class="stat-num rust">{{ $current['calories'] }}</div>
                <div class="stat-label">Total Calories</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num teal">{{ $current['protein'] }}</div>
                <div class="stat-label">Protein</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num rust">{{ $current['carbs'] }}</div>
                <div class="stat-label">Carbohydrates</div>
            </div>
            <div class="summary-stat">
                <div class="stat-num teal">{{ $current['fat'] }}</div>
                <div class="stat-label">Fats</div>
            </div>
        </div>

        {{-- MEAL CARDS --}}
        @foreach($current['meals'] as $meal)
        <h3 style="font-family:'Syne',sans-serif; font-size:1.3rem; font-weight:700; color:var(--charcoal); margin: 2rem 0 1rem; display:flex; align-items:center; gap:0.5rem;">
            <span>{{ $meal['icon'] }}</span> {{ $meal['slot'] }}
            <span style="font-size:0.8rem; font-weight:400; color:var(--muted); margin-left:auto;">{{ $meal['time'] }}</span>
        </h3>
        <div class="meals-grid">
            @foreach($meal['items'] as $item)
            <div class="meal-card">
                <div class="meal-card-header">
                    <span class="meal-icon">{{ $meal['icon'] }}</span>
                    <span class="meal-label">{{ $meal['slot'] }}</span>
                    <span class="meal-time">{{ $meal['time'] }}</span>
                </div>
                <div class="meal-card-body">
                    <div class="meal-item">
                        <div class="meal-item-name">{{ $item['name'] }}</div>
                        <div class="meal-item-desc">{{ $item['desc'] }}</div>
                        <div class="meal-item-macros">
                            <span class="macro-tag protein">P: {{ $item['p'] }}</span>
                            <span class="macro-tag carbs">C: {{ $item['c'] }}</span>
                            <span class="macro-tag fat">F: {{ $item['f'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- BACK --}}
    <div class="diet-back">
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
