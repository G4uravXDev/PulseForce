@extends('layouts.app')
@section('title', 'PulseForce — Personnel Training Management')
@section('content')

{{-- Cursor dot --}}
<div class="cursor-dot" id="cursor"></div>

{{-- NAV --}}
<nav>
    <a href="{{ route('landing') }}" class="nav-logo">
        <span class="nav-logo-dot"></span>PulseForce
    </a>
    <style>
        .nav-dropdown { position: relative; cursor: pointer; }
        .dropdown-content { 
            visibility: hidden; opacity: 0; transform: translateY(10px);
            position: absolute; background: rgba(20, 20, 22, 0.95); 
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08); padding: 0.5rem; 
            border-radius: 12px; min-width: 250px; z-index: 1000; 
            top: 100%; left: 50%; margin-left: -125px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.1); 
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            display: flex; flex-direction: column; margin-top: 15px;
        }
        .dropdown-content::before {
            content: ''; position: absolute; top: -15px; left: 0; right: 0; height: 15px; background: transparent;
        }
        .nav-dropdown:hover .dropdown-content { 
            visibility: visible; opacity: 1; transform: translateY(0);
        }
        .dropdown-content a { 
            color: rgba(240, 235, 226, 0.8) !important; text-decoration: none; 
            font-size: 0.95rem; font-weight: 500; padding: 0.8rem 1rem; 
            border-radius: 8px; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: space-between;
        }
        .dropdown-content a::after {
            content: '→'; font-size: 1.1em; opacity: 0; transform: translateX(-10px); transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); color: var(--rust, #c94f2c);
        }
        .dropdown-content a:hover { 
            background: rgba(201, 79, 44, 0.1); color: #fff !important; 
        }
        .dropdown-content a:hover::after {
            opacity: 1; transform: translateX(0);
        }
        .nav-dropdown:hover .dropdown-arrow {
            transform: rotate(180deg);
        }
    </style>
    <ul>
        <li><a href="#about">About</a></li>
        <!-- <li><a href="#platform">Platform</a></li> -->
        <li><a href="#membership">Membership</a></li>
        <li class="nav-dropdown">
            <a>Features ▾</a>
            <div class="dropdown-content">
                <a href="{{ route('features.training-programs') }}">Training Programs</a>
                <a href="{{ route('features.diet-plans') }}">Custom Diet Plans</a>
                <a href="{{ route('features.merchandise') }}">Premium Merchandise</a>
            </div>
        </li>
        <!-- <li><a href="#tech">Philosophy</a></li> -->
        @auth
            <li class="nav-dropdown" style="margin-left: 1rem; position: relative;">
                <a style="display:flex; align-items:center; cursor:pointer;">
                    {{ explode(' ', trim(Auth::user()->name))[0] ?? 'User' }} 
                    <span class="dropdown-arrow" style="font-size:0.8em; margin-left:4px; display:inline-block; transition:transform 0.2s ease;">▾</span>
                </a>
                <div class="dropdown-content" style="min-width: 180px; left: auto; right: 0; margin-left: 0; transform-origin: top right; margin-top:15px;">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}" class="nav-btn">Get Started</a></li>
        @endauth
    </ul>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-left">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-line"></span>
            Premium Gym Platform · {{ date('Y') }}
        </div>
        <h1 class="hero-h1">
            Train.<br>
            Track.<br>
            <em>Triumph.</em>
        </h1>
        <p class="hero-p">
            A comprehensive gym management system — with specialized user dashboards, seamless program enrollment, automated renewal alerts, and real-time member progress tracking.
        </p>
        <div class="hero-actions">
            <a href="#platform" class="btn-rust">
                Explore 
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#features" class="btn-outline">Features</a>
        </div>
        <div class="hero-tags">
            <span class="hero-tag">Expert Trainers</span>
            <span class="hero-tag">Merchandise</span>
            <span class="hero-tag">Diet Plan</span>
            <span class="hero-tag">Training Plan</span>
        </div>
    </div>
    <div class="hero-right">
        <img class="hero-img-main" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900&q=80&auto=format&fit=crop" alt="Gym training environment">
        <div class="hero-img-overlay"></div>
        <!-- <div class="hero-badge-top">Laravel 11</div> -->
        <div class="hero-floating-card">
            <div class="hfc-label">Member Progress</div>
            <div class="hfc-name">Strength Program · Wk 8</div>
            <div class="hfc-progress-track">
                <div class="hfc-progress-fill"></div>
            </div>
            <div class="hfc-progress-label">
                <span>68% complete</span>
                <span style="color:var(--rust); font-weight:500;">On Track ✓</span>
            </div>
        </div>
    </div>
</section>

{{-- MARQUEE --}}
<div class="marquee-section">
    <div class="marquee-track">
        @for($i = 0; $i < 2; $i++)
            @foreach($marqueeItems as $item)
                <span>{{ $item }}</span><span class="accent">◆</span>
            @endforeach
        @endfor
    </div>
</div>

{{-- INTRO / ABOUT --}}
<section class="intro-section" id="about">
    <div class="intro-left reveal">
        <div class="section-eyebrow">About the System</div>
        <h2 class="intro-h2">Gym management, <span>reimagined</span> for performance</h2>
        <p class="intro-p">
            PulseForce is an elite fitness management platform designed for modern gyms. It brings together tailored workout programs, seamless membership tracking, automated renewals, and an integrated merchandise store into one cohesive, elegant experience.
        </p>
        <br>
        <p class="intro-p">
            Built to elevate your facility's operations — equipping your trainers with powerful oversight and empowering your members with an intuitive portal to track their fitness journey.
        </p>
    </div>
    <div class="intro-right">
        <div class="intro-stat-card reveal d1">
            <div class="isc-icon rust">🏋</div>
            <div>
                <div class="isc-num">50+</div>
                <div class="isc-label">Curated training programs available</div>
            </div>
        </div>
        <div class="intro-stat-card reveal d2">
            <div class="isc-icon teal">🏆</div>
            <div>
                <div class="isc-num">24/7</div>
                <div class="isc-label">Member portal access & tracking</div>
            </div>
        </div>
        <div class="intro-stat-card reveal d3">
            <div class="isc-icon sand">📲</div>
            <div>
                <div class="isc-num">3&times;</div>
                <div class="isc-label">Faster renewal rates with auto-alerts</div>
            </div>
        </div>
    </div>
</section>

{{-- ROLES --}}
<section class="roles-section" id="platform">
    <div class="section-eyebrow reveal">What We Offer</div>
    <h2 class="intro-h2 reveal" style="max-width:600px;">Everything under<br>one roof.</h2>

    <div class="roles-grid">
        <div class="role-card reveal d1">
            <div class="role-card-img-wrap">
                <img class="role-card-img" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80&auto=format&fit=crop" alt="Modern gym equipment">
            </div>
            <div class="role-card-body">
                <span class="role-pill rust">Training &amp; Equipment</span>
                <div class="role-title">World-Class Training Floor</div>
                <p class="role-desc">State-of-the-art equipment, structured workout programs, and expert guidance to help you reach your peak performance.</p>
                <div class="role-features">
                    <div class="role-feature"><div class="rf-dot rust"></div>Fully equipped strength &amp; cardio zones</div>
                    <div class="role-feature"><div class="rf-dot rust"></div>Structured programs for bulk &amp; shredded goals</div>
                    <div class="role-feature"><div class="rf-dot rust"></div>Beginner to veteran difficulty levels</div>
                    <div class="role-feature"><div class="rf-dot rust"></div>Weekly training splits with guided exercises</div>
                    <div class="role-feature"><div class="rf-dot rust"></div>Dedicated free weights &amp; functional area</div>
                    <div class="role-feature"><div class="rf-dot rust"></div>Progress tracking &amp; performance metrics</div>
                </div>
            </div>
        </div>
        <div class="role-card reveal d2">
            <div class="role-card-img-wrap">
                <img class="role-card-img" src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&q=80&auto=format&fit=crop" alt="Healthy meal prep">
            </div>
            <div class="role-card-body">
                <span class="role-pill teal">Nutrition &amp; Lifestyle</span>
                <div class="role-title">Fuel Your Transformation</div>
                <p class="role-desc">Custom diet plans, premium supplements, and lifestyle gear — because real results happen both inside and outside the gym.</p>
                <div class="role-features">
                    <div class="role-feature"><div class="rf-dot teal"></div>Veg, non-veg &amp; vegan meal plans</div>
                    <div class="role-feature"><div class="rf-dot teal"></div>Calorie &amp; macro breakdowns for every meal</div>
                    <div class="role-feature"><div class="rf-dot teal"></div>Premium whey, creatine &amp; supplements</div>
                    <div class="role-feature"><div class="rf-dot teal"></div>Exclusive gym apparel &amp; training gear</div>
                    <div class="role-feature"><div class="rf-dot teal"></div>Recovery accessories &amp; essentials</div>
                    <div class="role-feature"><div class="rf-dot teal"></div>Plans for bulking, cutting &amp; maintenance</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MODULES --}}
<section class="modules-section" id="features">
    <div class="section-eyebrow reveal">Core Features</div>
    <h2 class="modules-h2 reveal">Everything you need. Built in.</h2>
    <p class="modules-sub reveal">Three essential modules, fully integrated, designed to streamline your gym operations.</p>

    <div class="modules-grid-6">
        @foreach($modules as $i => $mod)
            <a href="{{ route('features.' . $mod['slug']) }}" class="mod-card reveal{{ $i % 3 > 0 ? ' d'.($i % 3) : '' }}" data-num="{{ $mod['num'] }}" style="text-decoration: none; color: inherit; display: block;">
                <div class="mod-icon-wrap">{{ $mod['icon'] }}</div>
                <div class="mod-name">{{ $mod['name'] }} <span style="font-size:0.8em; margin-left:5px;">&rarr;</span></div>
                <p class="mod-desc">{{ $mod['desc'] }}</p>
            </a>
        @endforeach
    </div>
</section>

{{-- FEATURE SPLIT 1 — Fee Reminders --}}
<div class="feature-split">
    <div class="feature-img-side">
        <img src="https://images.unsplash.com/photo-1576678927484-cc907957088c?w=900&q=80&auto=format&fit=crop" alt="Person checking phone at gym">
        <div class="feature-img-overlay"></div>
    </div>
    <div class="feature-content-side" style="border-left:1px solid var(--border);">
        <div class="section-eyebrow reveal">Smart Communications</div>
        <h3 class="feat-h3 reveal">Stay connected.<br>Boost retention.</h3>
        <p class="feat-p reveal">Keep your members engaged and your business thriving with an intelligent communication system that reaches clients exactly when they need it.</p>
        <div class="feat-checklist reveal">
            <div class="feat-check"><div class="check-icon rust">✓</div>Automated membership renewal alerts</div>
            <div class="feat-check"><div class="check-icon rust">✓</div>Personalized class and training reminders</div>
            <div class="feat-check"><div class="check-icon rust">✓</div>Targeted promotional offers and news</div>
            <div class="feat-check"><div class="check-icon rust">✓</div>Beautiful, responsive email campaigns</div>
            <div class="feat-check"><div class="check-icon rust">✓</div>Instant alerts delivered straight to members' phones</div>
        </div>
    </div>
</div>

{{-- FEATURE SPLIT 2 — Progress --}}
<div class="feature-split">
    <div class="feature-content-side dark" style="border-right:1px solid rgba(255,255,255,0.06);">
        <div class="section-eyebrow reveal" style="color:rgba(201,79,44,0.8);">Performance Analytics</div>
        <h3 class="feat-h3 reveal" style="color:var(--cream);">Visualize the<br>fitness journey.</h3>
        <p class="feat-p reveal">Give your members the tools they need to stay motivated. Watch numbers turn into results with interactive charts and milestone tracking.</p>
        <div class="feat-checklist reveal">
            <div class="feat-check"><div class="check-icon cream">✓</div>Log weekly strength and cardio gains</div>
            <div class="feat-check"><div class="check-icon cream">✓</div>Monitor custom diet and nutrition plans</div>
            <div class="feat-check"><div class="check-icon cream">✓</div>Interactive charts for body metric tracking</div>
            <div class="feat-check"><div class="check-icon cream">✓</div>Private feedback loop with expert trainers</div>
        </div>
    </div>
    <div class="feature-img-side">
        <img src="https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=900&q=80&auto=format&fit=crop" alt="Fitness progress tracking">
        <div class="feature-img-overlay" style="background:linear-gradient(135deg,rgba(28,28,30,0.5) 0%,rgba(26,107,107,0.1) 100%);"></div>
    </div>
</div>

{{-- MEMBERSHIP PRICING --}}
<section class="membership-section" id="membership">
    <div class="section-eyebrow reveal">Membership Plans</div>
    <h2 class="intro-h2 reveal" style="max-width:500px;">Choose your<br><em>path.</em></h2>
    <p class="membership-sub reveal">Flexible plans designed for every fitness level. No hidden fees, cancel anytime.</p>

    <div class="membership-grid">

        {{-- STARTER --}}
        <div class="membership-card reveal">
            <div class="mem-tier">Starter</div>
            <div class="mem-name">Basic</div>
            <div class="mem-desc">Perfect for beginners looking to build a consistent gym habit.</div>
            <div class="mem-price">&#8377;999 <span>/mo</span></div>
            <div class="mem-billing">Billed monthly</div>
            <ul class="mem-features">
                <li><span class="mem-check">&#10003;</span> Access to gym floor &amp; cardio zone</li>
                <li><span class="mem-check">&#10003;</span> 1 group class per week</li>
                <li><span class="mem-check">&#10003;</span> Basic diet plan template</li>
                <li><span class="mem-check">&#10003;</span> Locker room access</li>
            </ul>
            <button type="button" class="mem-btn outline mem-enquire-btn" data-plan="Starter / Basic" data-price="₹999/mo">Enquire Now</button>
        </div>

        {{-- PRO --}}
        <div class="membership-card popular reveal d1">
            <div class="mem-tier">Pro</div>
            <div class="mem-name">Performance</div>
            <div class="mem-desc">For dedicated athletes who want personalized guidance and results.</div>
            <div class="mem-price">&#8377;2,499 <span>/mo</span></div>
            <div class="mem-billing">Billed monthly &middot; Save 20% annually</div>
            <ul class="mem-features">
                <li><span class="mem-check teal">&#10003;</span> Everything in Basic</li>
                <li><span class="mem-check teal">&#10003;</span> Unlimited group classes</li>
                <li><span class="mem-check teal">&#10003;</span> Custom training program</li>
                <li><span class="mem-check teal">&#10003;</span> Personalized diet plan</li>
                <li><span class="mem-check teal">&#10003;</span> Monthly body composition analysis</li>
                <li><span class="mem-check teal">&#10003;</span> 10% off merchandise</li>
                <li><span class="mem-check teal">&#10003;</span> Priority class booking</li>
            </ul>
            <button type="button" class="mem-btn filled mem-enquire-btn" data-plan="Pro / Performance" data-price="₹2,499/mo">Enquire Now</button>
        </div>

        {{-- ELITE --}}
        <div class="membership-card reveal d2">
            <div class="mem-tier">Elite</div>
            <div class="mem-name">Unlimited</div>
            <div class="mem-desc">The ultimate fitness experience with 1-on-1 coaching and VIP perks.</div>
            <div class="mem-price">&#8377;4,999 <span>/mo</span></div>
            <div class="mem-billing">Billed monthly &middot; Save 25% annually</div>
            <ul class="mem-features">
                <li><span class="mem-check">&#10003;</span> Everything in Pro</li>
                <li><span class="mem-check">&#10003;</span> 1-on-1 personal training (4x/mo)</li>
                <li><span class="mem-check">&#10003;</span> Weekly diet consultations</li>
                <li><span class="mem-check">&#10003;</span> Spa &amp; recovery zone access</li>
                <li><span class="mem-check">&#10003;</span> 25% off all merchandise</li>
                <li><span class="mem-check">&#10003;</span> Guest passes (2/month)</li>
                <li><span class="mem-check">&#10003;</span> VIP locker &amp; towel service</li>
                <li><span class="mem-check">&#10003;</span> Dedicated account manager</li>
            </ul>
            <button type="button" class="mem-btn outline mem-enquire-btn" data-plan="Elite / Unlimited" data-price="₹4,999/mo">Enquire Now</button>
        </div>

    </div>

    {{-- ENQUIRY POPUP --}}
    <div class="mem-popup-overlay" id="memPopupOverlay">
        <div class="mem-popup">
            <button type="button" class="mem-popup-close" id="memPopupClose">&times;</button>
            <div class="mem-popup-header">
                <!-- <div class="mem-popup-icon">💬</div> -->
                <h3 class="mem-popup-title">Interested in <span id="popupPlanName">this plan</span>?</h3>
                <p class="mem-popup-price" id="popupPlanPrice"></p>
            </div>
            <p class="mem-popup-desc">Enquire about the membership, ask questions, or proceed with payment — reach us instantly on WhatsApp.</p>
            
            <a href="#" id="popupWhatsappBtn" class="mem-popup-wa-btn" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat on WhatsApp
            </a>
            
            @auth
                <a href="{{ route('dashboard') }}" class="mem-popup-secondary">Or go to your Dashboard →</a>
            @else
                <a href="{{ route('register') }}" class="mem-popup-secondary">Or create an account first →</a>
            @endauth
        </div>
    </div>

    <style>
        .mem-enquire-btn { cursor: pointer; border: none; font-family: inherit; }
        
        /* Popup Overlay */
        .mem-popup-overlay {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .mem-popup-overlay.active { opacity: 1; visibility: visible; }

        /* Popup Card */
        .mem-popup {
            background: var(--cream, #f0ebe2); border-radius: 20px; padding: 2.5rem;
            max-width: 420px; width: 90%; position: relative;
            transform: translateY(30px) scale(0.95); transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
            box-shadow: 0 30px 60px rgba(0,0,0,0.3), 0 0 0 1px rgba(0,0,0,0.05);
            text-align: center;
        }
        .mem-popup-overlay.active .mem-popup { transform: translateY(0) scale(1); }

        /* Close Button */
        .mem-popup-close {
            position: absolute; top: 1rem; right: 1.2rem;
            background: none; border: none; font-size: 1.8rem;
            color: rgba(28,28,30,0.4); cursor: pointer; line-height: 1;
            transition: color 0.2s, transform 0.2s;
        }
        .mem-popup-close:hover { color: var(--rust, #c94f2c); transform: scale(1.1); }

        /* Header */
        .mem-popup-header { margin-bottom: 1.25rem; }
        .mem-popup-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
        .mem-popup-title {
            font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 700;
            color: var(--charcoal, #1c1c1e); margin: 0 0 0.3rem;
        }
        .mem-popup-title span { color: var(--rust, #c94f2c); }
        .mem-popup-price {
            font-family: 'Epilogue', sans-serif; font-size: 1.1rem; font-weight: 600;
            color: var(--teal, #1a6b6b); margin: 0;
        }

        /* Description */
        .mem-popup-desc {
            font-family: 'Epilogue', sans-serif; font-size: 0.95rem;
            color: rgba(28,28,30,0.65); line-height: 1.6; margin-bottom: 1.75rem;
        }

        /* WhatsApp Button */
        .mem-popup-wa-btn {
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
            width: 100%; padding: 0.9rem 1.5rem;
            background: #25D366; color: #fff; border-radius: 12px;
            font-family: 'Epilogue', sans-serif; font-size: 1rem; font-weight: 600;
            text-decoration: none; transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
        }
        .mem-popup-wa-btn:hover { background: #1ebe5d; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4); }

        /* Secondary link */
        .mem-popup-secondary {
            display: inline-block; margin-top: 1rem;
            font-family: 'Epilogue', sans-serif; font-size: 0.85rem; font-weight: 500;
            color: rgba(28,28,30,0.5); text-decoration: none; transition: color 0.2s;
        }
        .mem-popup-secondary:hover { color: var(--rust, #c94f2c); }
    </style>
</section>

{{-- QUOTE --}}
<div class="quote-section">
    <p class="quote-text reveal">
        "True strength isn't built in a day.
        <em>It's built every time you decide to show up.</em>"
    </p>
    <p class="quote-credit reveal">PulseForce Training Philosophy</p>
</div>

{{-- CTA --}}
<section class="cta-section" id="cta">
    <div>
        <h2 class="cta-h2 reveal">Ready to transform your <span>physique</span>?</h2>
        <p class="cta-p reveal">Join a community dedicated to real results. With elite training programs, personalized meal plans, and a premium pro shop, everything you need to reach your peak is right here.</p>
    </div>
    <div class="cta-actions reveal">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-rust" style="font-size:1rem; padding:1rem 2.25rem;">
                Go to Dashboard
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-rust" style="font-size:1rem; padding:1rem 2.25rem;">
                Get Started
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        @endauth
        <a href="#modules" class="btn-outline">See Features</a>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-logo">Pulse<span>Force</span></div>
    <div class="footer-note">Premium Gym Management Platform · {{ date('Y') }}</div>
    <div class="footer-note">Strength · Endurance · Discipline · Growth</div>
</footer>

@push('scripts')
<script>
/* cursor */
const cursor = document.getElementById('cursor');
document.addEventListener('mousemove', e => {
    cursor.style.left = e.clientX - 4 + 'px';
    cursor.style.top  = e.clientY - 4 + 'px';
});

/* scroll reveal */
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('up'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

/* ── Membership Enquiry Popup ── */
(function() {
    const WHATSAPP_NUMBER = '916287231231'; // ← Replace with your actual WhatsApp number (with country code, no +)

    const overlay = document.getElementById('memPopupOverlay');
    const closeBtn = document.getElementById('memPopupClose');
    const planNameEl = document.getElementById('popupPlanName');
    const planPriceEl = document.getElementById('popupPlanPrice');
    const waBtn = document.getElementById('popupWhatsappBtn');

    document.querySelectorAll('.mem-enquire-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const plan = btn.getAttribute('data-plan');
            const price = btn.getAttribute('data-price');

            planNameEl.textContent = plan;
            planPriceEl.textContent = price;

            const message = encodeURIComponent(
                `Hi PulseForce! 👋\n\nI'm interested in the *${plan}* membership plan (${price}).\n\nCould you share more details about enrollment and payment options?`
            );
            waBtn.href = `https://wa.me/${WHATSAPP_NUMBER}?text=${message}`;

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    function closePopup() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closePopup();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('active')) closePopup();
    });
})();
</script>
@endpush

@endsection
