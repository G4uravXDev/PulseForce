<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PulseForce | Add Member</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--charcoal); font-size: 0.9rem; }
        .form-input { 
            width: 100%; padding: 0.8rem 1rem; border: 1px solid var(--border); border-radius: 8px; 
            font-family: 'Epilogue', sans-serif; font-size: 1rem; background: #fff; transition: border-color 0.2s;
        }
        .form-input:focus { outline: none; border-color: var(--rust); }
        .error-msg { color: var(--rust); font-size: 0.8rem; margin-top: 0.25rem; display: block; }
    </style>
</head>
<body>
    @include('partials.loader')
    <div class="admin-layout">
        
        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <a href="{{ route('landing') }}" class="sidebar-logo">
                PulseForce<span class="sidebar-logo-dot"></span>
            </a>
            
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item">
                     Dashboard
                </a>
                <a href="{{ route('admin.members') }}" class="nav-item active">
                     Members
                </a>
                <a href="{{ route('features.training-programs') }}" class="nav-item">
                     Training Plans
                </a>
                <a href="{{ route('features.diet-plans') }}" class="nav-item">
                     Diet Plans
                </a>
                <a href="/" class="nav-item" id="back-to-home-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-profile" onclick="openProfileModal()" style="cursor:pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('profile-images/'.Auth::user()->avatar) }}" class="user-avatar" style="object-fit:cover;">
                    @else
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <div class="user-info">
                        <span class="user-name">{{ $user->name ?? 'Admin User' }}</span>
                        <span class="user-role">Facility Manager</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 0.8rem; background: rgba(201, 79, 44, 0.1); border: 1px solid rgba(201, 79, 44, 0.2); border-radius: 8px; color: #c94f2c; font-family: 'Epilogue', sans-serif; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(201, 79, 44, 0.2)'" onmouseout="this.style.background='rgba(201, 79, 44, 0.1)'">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Add Member <span>/ Registration</span></h1>
                <div class="header-actions">
                    <a href="{{ route('admin.members') }}" class="action-btn secondary">Cancel</a>
                </div>
            </header>

            <div class="dashboard-sections" style="grid-template-columns: 1fr;">
                <section class="section-card" style="max-width: 600px;">
                    <div class="section-title">Member Details</div>
                    
                    <form method="POST" action="{{ route('admin.members.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
                            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Temporary Password</label>
                            <input type="password" id="password" name="password" class="form-input" required>
                            @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="plan">Membership Plan</label>
                            <select id="plan" name="plan" class="form-input" required>
                                <option value="Starter / Basic">Starter / Basic (₹999)</option>
                                <option value="Pro / Performance" selected>Pro / Performance (₹2,499)</option>
                                <option value="Elite / Unlimited">Elite / Unlimited (₹4,999)</option>
                            </select>
                            @error('plan') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Hidden price mapping - normally handled in JS or backend mapping, but keeping simple here -->
                        <input type="hidden" name="plan_price" id="plan_price" value="2499">
                        
                        <script>
                            document.getElementById('plan').addEventListener('change', function(e) {
                                let price = 2499;
                                if (e.target.value.includes('Starter')) price = 999;
                                if (e.target.value.includes('Elite')) price = 4999;
                                document.getElementById('plan_price').value = price;
                            });
                        </script>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="action-btn primary" style="width: 100%; justify-content: center; font-size: 1rem; padding: 0.8rem;">
                                Register Member
                            </button>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
    @include('partials.profile-modal')
</body>
</html>
