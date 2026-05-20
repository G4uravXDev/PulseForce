<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PulseForce | Members</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .plan-select { padding: 0.4rem 2rem 0.4rem 0.6rem; border: 1px solid var(--border,#e0dcd4); border-radius: 8px; background: #fff; font-family: 'Epilogue', sans-serif; font-size: 0.82rem; font-weight: 600; color: var(--charcoal,#1c1c1e); cursor: pointer; appearance: none; -webkit-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%231c1c1e' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.5rem center; transition: border-color 0.2s; }
        .plan-select:hover, .plan-select:focus { border-color: var(--rust,#c94f2c); outline: none; }

        /* SEARCH */
        .search-bar { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem; }
        .search-input { flex: 1; padding: 0.6rem 1rem; border: 1px solid var(--border,#e0dcd4); border-radius: 10px; font-family: 'Epilogue', sans-serif; font-size: 0.88rem; color: var(--charcoal); background: #fff; transition: border-color 0.2s; }
        .search-input:focus { outline: none; border-color: var(--rust); }
        .filter-btn { padding: 0.5rem 0.9rem; border-radius: 8px; border: 1px solid var(--border); background: #fff; font-family: 'Epilogue'; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s; color: rgba(28,28,30,0.5); }
        .filter-btn.active, .filter-btn:hover { background: var(--charcoal); color: #fff; border-color: var(--charcoal); }
        .filter-btn.pending-filter.active { background: #d97706; border-color: #d97706; }

        /* PENDING ALERT BANNER */
        .pending-banner { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.9rem 1.2rem; background: linear-gradient(135deg, rgba(217,119,6,0.08) 0%, rgba(201,79,44,0.05) 100%); border: 1px solid rgba(217,119,6,0.2); border-radius: 12px; margin-bottom: 1.25rem; }
        .pending-banner-text { font-family: 'Epilogue'; font-size: 0.88rem; font-weight: 600; color: #92400e; }
        .pending-banner-text span { font-weight: 400; opacity: 0.8; }
        .pending-badge { display: inline-flex; align-items: center; justify-content: center; min-width: 22px; height: 22px; padding: 0 6px; background: #d97706; color: #fff; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }

        /* TABLE ACTIONS */
        .action-icon-btn { background: transparent; border: none; cursor: pointer; padding: 0.4rem; font-size: 1.1rem; border-radius: 6px; transition: background 0.15s; line-height: 1; }
        .action-icon-btn:hover { background: rgba(0,0,0,0.06); }
        .action-icon-btn.danger:hover { background: rgba(201,79,44,0.1); }

        /* PENDING ROW HIGHLIGHT */
        tr.pending-row td { background: rgba(217,119,6,0.03); }

        /* ACTIVATE INLINE FORM */
        .activate-form { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
        .activate-btn { background: #d97706; color: #fff; border: none; border-radius: 6px; padding: 0.3rem 0.65rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; white-space: nowrap; transition: background 0.2s; }
        .activate-btn:hover { background: #b45309; }

        /* CONFIRM MODAL */
        .confirm-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 9990; display: none; align-items: center; justify-content: center; }
        .confirm-overlay.show { display: flex; }
        .confirm-box { background: #fff; border-radius: 16px; padding: 2rem; max-width: 400px; width: 90%; box-shadow: 0 24px 60px rgba(0,0,0,0.2); font-family: 'Epilogue'; }
        .confirm-box h3 { font-family: 'Syne'; font-size: 1.2rem; margin: 0 0 0.5rem; }
        .confirm-box p { font-size: 0.88rem; color: rgba(28,28,30,0.6); margin: 0 0 1.5rem; }
        .confirm-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
        .confirm-cancel { padding: 0.6rem 1.2rem; border: 1px solid var(--border); border-radius: 8px; background: #fff; cursor: pointer; font-family: 'Epilogue'; font-weight: 600; font-size: 0.85rem; }
        .confirm-delete { padding: 0.6rem 1.2rem; border: none; border-radius: 8px; background: var(--rust); color: #fff; cursor: pointer; font-family: 'Epilogue'; font-weight: 700; font-size: 0.85rem; }
    </style>
</head>
<body>
    @include('partials.loader')
    <div class="admin-layout">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <a href="{{ route('landing') }}" class="sidebar-logo">PulseForce<span class="sidebar-logo-dot"></span></a>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item"> Dashboard</a>
                <a href="{{ route('admin.members') }}" class="nav-item active"> Members</a>
                <a href="{{ route('features.training-programs') }}" class="nav-item"> Training Plans</a>
                <a href="{{ route('features.diet-plans') }}" class="nav-item"> Diet Plans</a>
                <a href="/" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to Home
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="user-profile" onclick="openProfileModal()" style="cursor:pointer;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('profile-images/'.Auth::user()->avatar) }}" class="user-avatar" style="object-fit:cover;">
                    @else
                        <div class="user-avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</div>
                    @endif
                    <div class="user-info">
                        <span class="user-name">{{ $user->name ?? 'Admin' }}</span>
                        <span class="user-role">Facility Manager</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:1rem;">
                    @csrf
                    <button type="submit" style="width:100%;padding:0.8rem;background:rgba(201,79,44,0.1);border:1px solid rgba(201,79,44,0.2);border-radius:8px;color:#c94f2c;font-family:'Epilogue';font-weight:600;font-size:0.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;">Log Out</button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Member Directory <span>/ All Members</span></h1>
                <div class="header-actions">
                    <a href="{{ route('admin.report.download') }}" class="action-btn secondary">Export CSV</a>
                    <a href="{{ route('admin.members.create') }}" class="action-btn primary">+ Add Member</a>
                </div>
            </header>

            @php
                $pendingMembers = $members->filter(fn($m) =>
                    !$m->is_blocked && (empty($m->status) || $m->status === 'Pending')
                );
                $pendingCount = $pendingMembers->count();
            @endphp

            <div class="dashboard-sections" style="grid-template-columns:1fr;">
                @if(session('success'))
                    <div style="padding:0.8rem 1.2rem;background:rgba(30,142,62,0.1);border:1px solid rgba(30,142,62,0.2);border-radius:10px;color:#1e8e3e;font-weight:600;font-size:0.9rem;margin-bottom:0.5rem;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="padding:0.8rem 1.2rem;background:rgba(201,79,44,0.08);border:1px solid rgba(201,79,44,0.2);border-radius:10px;color:var(--rust);font-weight:600;font-size:0.9rem;margin-bottom:0.5rem;">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                {{-- PENDING ALERT --}}
                @if($pendingCount > 0)
                    <div class="pending-banner">
                        <div class="pending-banner-text">
                            🔔 <span class="pending-badge">{{ $pendingCount }}</span>
                            new member{{ $pendingCount > 1 ? 's' : '' }} signed up and need{{ $pendingCount > 1 ? '' : 's' }} activation.
                            <span>Assign a plan and activate them so they can access their dashboard.</span>
                        </div>
                        <button class="filter-btn pending-filter active" onclick="filterTable('pending')">View Pending</button>
                    </div>
                @endif

                <section class="section-card">
                    {{-- SEARCH + FILTERS --}}
                    <div class="search-bar">
                        <input type="text" class="search-input" id="memberSearch" placeholder="🔍  Search by name or email…" oninput="filterSearch(this.value)">
                        <button class="filter-btn active" onclick="filterTable('all', this)">All ({{ count($members) }})</button>
                        <button class="filter-btn" onclick="filterTable('active', this)">Active</button>
                        <button class="filter-btn pending-filter" onclick="filterTable('pending', this)">Pending @if($pendingCount > 0)<span class="pending-badge" style="margin-left:4px;">{{ $pendingCount }}</span>@endif</button>
                        <button class="filter-btn" onclick="filterTable('blocked', this)">Blocked</button>
                    </div>

                    <div class="section-title" style="margin-bottom:0.75rem;">All Members ({{ count($members) }})</div>
                    <div class="table-responsive">
                        <table class="admin-table" id="membersTable">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Plan</th>
                                    <th>Assign Workout</th>
                                    <th>Assign Diet</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                @php
                                    $isPending = !$member->is_blocked && (empty($member->status) || $member->status === 'Pending');
                                    $isBlocked = $member->is_blocked;
                                    $statusClass = $isPending ? 'pending' : ($isBlocked ? 'blocked' : 'active');
                                    $activeWorkout = \App\Models\WorkoutAssignment::where('user_id', (string)$member->_id)->where('status','active')->first();
                                    $activeDiet    = \App\Models\DietAssignment::where('user_id', (string)$member->_id)->where('status','active')->first();
                                @endphp
                                <tr class="{{ $isPending ? 'pending-row' : '' }}" data-status="{{ $statusClass }}" data-name="{{ strtolower($member->name) }}" data-email="{{ strtolower($member->email) }}">
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" alt="{{ $member->name }}">
                                            <div>
                                                <div class="u-name">{{ $member->name }} @if($isPending)<span style="font-size:0.65rem;background:#d97706;color:#fff;padding:1px 5px;border-radius:4px;margin-left:4px;font-weight:700;">NEW</span>@endif</div>
                                                <div class="u-email">{{ $member->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- PLAN COLUMN --}}
                                    <td>
                                        @if($isPending)
                                            {{-- PENDING: Activate with plan picker --}}
                                            <form action="{{ route('admin.members.activate', $member->_id) }}" method="POST" class="activate-form">
                                                @csrf
                                                <select name="plan" class="plan-select" style="min-width:120px;">
                                                    <option value="Starter / Basic">Starter</option>
                                                    <option value="Pro / Performance">Pro</option>
                                                    <option value="Elite / Unlimited">Elite</option>
                                                </select>
                                                <button type="submit" class="activate-btn">✓ Activate</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.members.updatePlan', $member->_id) }}" method="POST">
                                                @csrf
                                                <select name="plan" class="plan-select" onchange="this.form.submit()" style="min-width:120px;">
                                                    <option value="Starter / Basic" {{ ($member->plan ?? '') == 'Starter / Basic' ? 'selected' : '' }}>Starter</option>
                                                    <option value="Pro / Performance" {{ ($member->plan ?? '') == 'Pro / Performance' ? 'selected' : '' }}>Pro</option>
                                                    <option value="Elite / Unlimited" {{ ($member->plan ?? '') == 'Elite / Unlimited' ? 'selected' : '' }}>Elite</option>
                                                    @if(!$member->plan)<option value="" disabled selected>N/A</option>@endif
                                                </select>
                                            </form>
                                        @endif
                                    </td>

                                    {{-- ASSIGN WORKOUT --}}
                                    <td>
                                        <form action="{{ route('admin.members.assignWorkout', $member->_id) }}" method="POST" style="display:flex;gap:3px;flex-wrap:wrap;">
                                            @csrf
                                            <select name="goal" class="plan-select" style="min-width:75px;">
                                                <option value="bulk"     {{ ($activeWorkout && $activeWorkout->goal=='bulk')     ? 'selected' : '' }}>Bulk</option>
                                                <option value="shredded" {{ ($activeWorkout && $activeWorkout->goal=='shredded') ? 'selected' : '' }}>Shredded</option>
                                            </select>
                                            <select name="level" class="plan-select" style="min-width:85px;">
                                                <option value="beginner"     {{ ($activeWorkout && $activeWorkout->level=='beginner')     ? 'selected' : '' }}>Beginner</option>
                                                <option value="intermediate" {{ ($activeWorkout && $activeWorkout->level=='intermediate') ? 'selected' : '' }}>Inter.</option>
                                                <option value="veteran"      {{ ($activeWorkout && $activeWorkout->level=='veteran')      ? 'selected' : '' }}>Veteran</option>
                                            </select>
                                            <button type="submit" style="background:var(--rust);color:#fff;border:none;border-radius:6px;padding:0.3rem 0.55rem;cursor:pointer;font-size:0.75rem;font-weight:700;">{{ $activeWorkout ? '↻' : '→' }}</button>
                                        </form>
                                        @if($activeWorkout)<div style="font-size:0.7rem;color:var(--teal);margin-top:2px;font-weight:600;">✓ {{ $activeWorkout->program_label }}</div>@endif
                                    </td>

                                    {{-- ASSIGN DIET --}}
                                    <td>
                                        <form action="{{ route('admin.members.assignDiet', $member->_id) }}" method="POST" style="display:flex;gap:3px;flex-wrap:wrap;">
                                            @csrf
                                            <select name="goal" class="plan-select" style="min-width:65px;">
                                                <option value="bulk" {{ ($activeDiet && $activeDiet->goal=='bulk') ? 'selected' : '' }}>Bulk</option>
                                                <option value="slim" {{ ($activeDiet && $activeDiet->goal=='slim') ? 'selected' : '' }}>Slim</option>
                                            </select>
                                            <select name="type" class="plan-select" style="min-width:75px;">
                                                <option value="veg"    {{ ($activeDiet && $activeDiet->type=='veg')    ? 'selected' : '' }}>Veg</option>
                                                <option value="nonveg" {{ ($activeDiet && $activeDiet->type=='nonveg') ? 'selected' : '' }}>Non-Veg</option>
                                                <option value="vegan"  {{ ($activeDiet && $activeDiet->type=='vegan')  ? 'selected' : '' }}>Vegan</option>
                                            </select>
                                            <button type="submit" style="background:var(--teal);color:#fff;border:none;border-radius:6px;padding:0.3rem 0.55rem;cursor:pointer;font-size:0.75rem;font-weight:700;">{{ $activeDiet ? '↻' : '→' }}</button>
                                        </form>
                                        @if($activeDiet)<div style="font-size:0.7rem;color:var(--teal);margin-top:2px;font-weight:600;">✓ {{ $activeDiet->plan_label }}</div>@endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if($isBlocked)
                                            <span class="status-badge pending" style="background:rgba(28,28,30,0.08);color:var(--charcoal);">Blocked</span>
                                        @elseif($isPending)
                                            <span class="status-badge pending" style="background:rgba(217,119,6,0.1);color:#92400e;border:1px solid rgba(217,119,6,0.2);">Pending</span>
                                        @else
                                            <span class="status-badge active">Active</span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td style="text-align:right;">
                                        <div style="display:flex;gap:4px;justify-content:flex-end;align-items:center;">
                                            {{-- Block / Unblock --}}
                                            <form action="{{ route('admin.members.toggleBlock', $member->_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="action-icon-btn" title="{{ $isBlocked ? 'Unblock Member' : 'Block Member' }}">{{ $isBlocked ? '🔓' : '🔒' }}</button>
                                            </form>
                                            {{-- Delete --}}
                                            <button type="button" class="action-icon-btn danger" title="Delete Member" onclick="confirmDelete('{{ $member->_id }}', '{{ addslashes($member->name) }}')">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- DELETE CONFIRM MODAL --}}
    <div class="confirm-overlay" id="deleteModal">
        <div class="confirm-box">
            <h3>Delete Member?</h3>
            <p id="deleteModalText">This will permanently remove the member and all their data (assignments, attendance). This cannot be undone.</p>
            <div class="confirm-actions">
                <button class="confirm-cancel" onclick="closeDeleteModal()">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    <button type="submit" class="confirm-delete">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.profile-modal')

    <script>
        // Search
        function filterSearch(q) {
            q = q.toLowerCase();
            document.querySelectorAll('#membersTable tbody tr').forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                row.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
            });
        }

        // Filter by status tab
        let activeFilter = 'all';
        function filterTable(status, btn) {
            activeFilter = status;
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');
            document.querySelectorAll('#membersTable tbody tr').forEach(row => {
                if (status === 'all') { row.style.display = ''; return; }
                row.style.display = row.dataset.status === status ? '' : 'none';
            });
        }

        // Delete confirm
        function confirmDelete(memberId, memberName) {
            document.getElementById('deleteModalText').textContent =
                `This will permanently remove "${memberName}" and all their workout, diet, and attendance data. This cannot be undone.`;
            document.getElementById('deleteForm').action = `/admin/members/${memberId}/delete`;
            document.getElementById('deleteModal').classList.add('show');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
</body>
</html>
