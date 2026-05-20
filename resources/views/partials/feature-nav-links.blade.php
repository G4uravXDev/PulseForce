<style>
    .nav-dropdown { position: relative; }
    .nav-dropdown .dropdown-content {
        visibility: hidden; opacity: 0; transform: translateY(10px);
        position: absolute; background: rgba(20, 20, 22, 0.95);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.08); padding: 0.5rem;
        border-radius: 12px; min-width: 250px; z-index: 1000;
        top: 100%; left: 50%; margin-left: -125px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.1);
        transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        display: flex; flex-direction: column; margin-top: 10px;
    }
    .nav-dropdown .dropdown-content::before {
        content: ''; position: absolute; top: -10px; left: 0; right: 0; height: 10px; background: transparent;
    }
    .nav-dropdown:hover .dropdown-content {
        visibility: visible; opacity: 1; transform: translateY(0);
    }
    .nav-dropdown .dropdown-content a {
        color: rgba(240, 235, 226, 0.8) !important; text-decoration: none;
        font-size: 0.95rem; font-weight: 500; padding: 0.8rem 1rem;
        border-radius: 8px; transition: all 0.2s ease;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nav-dropdown .dropdown-content a::after {
        content: '→'; font-size: 1.1em; opacity: 0; transform: translateX(-10px);
        transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1); color: var(--rust, #c94f2c);
    }
    .nav-dropdown .dropdown-content a:hover {
        background: rgba(201, 79, 44, 0.1); color: #fff !important;
    }
    .nav-dropdown .dropdown-content a:hover::after {
        opacity: 1; transform: translateX(0);
    }
    .nav-dropdown:hover .dropdown-arrow {
        transform: rotate(180deg);
    }
</style>
<div class="nav-links">
    <a href="{{ route('landing') }}">Home</a>
    <div class="nav-dropdown">
        <a href="{{ route('landing') }}#features">Features ▾</a>
        <div class="dropdown-content">
            <a href="{{ route('features.training-programs') }}">Training Programs</a>
            <a href="{{ route('features.diet-plans') }}">Custom Diet Plans</a>
            <a href="{{ route('features.merchandise') }}">Premium Merchandise</a>
        </div>
    </div>
    @auth
        <div class="nav-dropdown" style="margin-left: 1rem; position: relative;">
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
        </div>
    @else
        <a href="{{ route('register') }}" class="nav-btn">Get Started</a>
    @endauth
</div>
