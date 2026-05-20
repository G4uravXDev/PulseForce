<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PulseForce | Admin Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
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
                <a href="{{ route('dashboard') }}" class="nav-item active">
                     Dashboard
                </a>
                
                <a href="{{ route('admin.members') }}" class="nav-item">
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
                <h1 class="page-title">Facility Overview <span>/ Today</span></h1>
                <div class="header-actions">
                    <a href="{{ route('admin.report.download') }}" class="action-btn secondary">Download Report</a>
                    <a href="{{ route('admin.members.create') }}" class="action-btn primary">+ Add Member</a>
                </div>
            </header>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">Total Revenue <div class="stat-icon rust">💰</div></div>
                    <div class="stat-value">&#8377;{{ number_format($totalRevenue) }}</div>
                    <div class="stat-trend up">↑ Based on active plans</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">Active Members <div class="stat-icon teal">👥</div></div>
                    <div class="stat-value">{{ $activeMembers }}</div>
                    <div class="stat-trend up">Total registered</div>
                </div>
                <div class="stat-card" style="{{ $pendingCount > 0 ? 'border:1px solid rgba(217,119,6,0.25);background:rgba(217,119,6,0.03);' : '' }}">
                    <div class="stat-header">Pending Signups <div class="stat-icon" style="background:rgba(217,119,6,0.1);font-size:1rem;">🔔</div></div>
                    <div class="stat-value" style="color:{{ $pendingCount > 0 ? '#d97706' : 'var(--charcoal)' }};">{{ $pendingCount }}</div>
                    <div class="stat-trend" style="color:{{ $pendingCount > 0 ? '#92400e' : '' }};">{{ $pendingCount > 0 ? 'Need activation →' : 'All members active' }}</div>
                </div>
            </div>

            <div class="dashboard-sections">
                {{-- RECENT ENROLLMENTS --}}
                <section class="section-card" id="members">
                    <div class="section-title">
                        Recent Enrollments
                        <a href="{{ route('admin.members') }}" style="text-decoration: none; color: var(--rust); font-size: 0.85rem; font-weight: 600; border: 1px solid var(--rust); padding: 0.3rem 0.8rem; border-radius: 6px; transition: all 0.2s;" onmouseover="this.style.background='var(--rust)'; this.style.color='var(--white)'" onmouseout="this.style.background='transparent'; this.style.color='var(--rust)'">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Plan</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEnrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($enrollment->name) }}&background=random" alt="{{ $enrollment->name }}">
                                            <div>
                                                <div class="u-name">{{ $enrollment->name }}</div>
                                                <div class="u-email">{{ $enrollment->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $enrollment->plan ?? 'N/A' }}</td>
                                    <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(strtolower($enrollment->status) === 'active')
                                            <span class="status-badge active">Active</span>
                                        @else
                                            <span class="status-badge pending">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- QUICK ACTIONS --}}
                <section class="section-card">
                    <div class="section-title">Quick Actions</div>
                    <div class="qa-list">
                        @if($pendingCount > 0)
                        <a href="{{ route('admin.members') }}?filter=pending" class="qa-item" style="background:rgba(217,119,6,0.04);border:1px solid rgba(217,119,6,0.15);border-radius:10px;">
                            <div class="qa-icon" style="background:rgba(217,119,6,0.1);">🔔</div>
                            <div class="qa-text">
                                <span class="qa-title" style="color:#92400e;">{{ $pendingCount }} Pending Member{{ $pendingCount > 1 ? 's' : '' }}</span>
                                <span class="qa-desc">Need activation & plan assignment</span>
                            </div>
                            <span style="font-size:0.75rem;background:#d97706;color:#fff;padding:2px 8px;border-radius:6px;font-weight:700;white-space:nowrap;">Review →</span>
                        </a>
                        @endif
                        <a href="{{ route('features.training-programs') }}" class="qa-item">
                            <div class="qa-icon">🏋️</div>
                            <div class="qa-text">
                                <span class="qa-title">Training Program</span>
                                <span class="qa-desc">Your own training split</span>
                            </div>
                        </a>
                        <a href="{{ route('features.diet-plans') }}" class="qa-item">
                            <div class="qa-icon">🥗</div>
                            <div class="qa-text">
                                <span class="qa-title">Diet Plan</span>
                                <span class="qa-desc">Nutrition guide</span>
                            </div>
                        </a>
                        <a href="{{ route('features.merchandise') }}" class="qa-item">
                            <div class="qa-icon">👕</div>
                            <div class="qa-text">
                                <span class="qa-title">Buy Merchandise</span>
                                <span class="qa-desc">Buy premium Gym Wear</span>
                            </div>
                        </a>
                    </div>
                </section>
            </div>
        </main>
    </div>
    @include('partials.profile-modal')
</body>
</html>
