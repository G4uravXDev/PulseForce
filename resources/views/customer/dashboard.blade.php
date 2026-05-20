<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PulseForce | Member Hub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;500;600;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        /* CHECK-IN */
        .checkin-btn { padding: 0.6rem 1.3rem; border-radius: 10px; font-family: 'Epilogue'; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; border: none; }
        .checkin-btn.available { background: var(--rust); color: #fff; }
        .checkin-btn.available:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(201,79,44,0.3); }
        .checkin-btn.done { background: rgba(30,142,62,0.1); color: #1e8e3e; cursor: default; }

        /* MAIN TABS */
        .hub-tabs { display: flex; gap: 0; border-bottom: 2px solid rgba(0,0,0,0.06); margin-bottom: 1.5rem; }
        .hub-tab { padding: 0.75rem 1.5rem; font-family: 'Epilogue'; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; background: none; color: rgba(28,28,30,0.4); position: relative; transition: color 0.2s; }
        .hub-tab:hover { color: rgba(28,28,30,0.7); }
        .hub-tab.active { color: var(--charcoal); }
        .hub-tab.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 2px; background: var(--rust); border-radius: 2px 2px 0 0; }
        .hub-tab .tab-badge { font-size: 0.65rem; background: var(--rust); color: #fff; padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.4rem; vertical-align: middle; }
        .hub-panel { display: none; }
        .hub-panel.active { display: block; }

        /* EXERCISE ROWS */
        .exercise-row { display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid rgba(0,0,0,0.05); transition: opacity 0.3s; }
        .exercise-row:last-child { border-bottom: none; }
        .exercise-row.completed { opacity: 0.45; }
        .exercise-row.completed .ex-name { text-decoration: line-through; }
        .ex-check { width: 22px; height: 22px; border-radius: 6px; border: 2px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.2s; background: #fff; font-size: 0.75rem; }
        .ex-check.checked { background: var(--rust); border-color: var(--rust); color: #fff; }
        .ex-check:hover { border-color: var(--rust); }
        .ex-name { font-weight: 600; font-size: 0.9rem; color: var(--charcoal); }
        .ex-detail { font-size: 0.78rem; color: rgba(28,28,30,0.45); }
        .ex-meta { margin-left: auto; display: flex; gap: 0.4rem; flex-shrink: 0; }
        .ex-meta span { font-size: 0.72rem; padding: 0.15rem 0.45rem; border-radius: 4px; background: rgba(0,0,0,0.04); font-weight: 600; }

        /* DAY TABS */
        .day-tabs { display: flex; gap: 0.4rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .day-tab { padding: 0.45rem 0.9rem; border-radius: 8px; border: 1px solid var(--border); background: #fff; cursor: pointer; font-family: 'Epilogue'; font-weight: 600; font-size: 0.78rem; transition: all 0.2s; }
        .day-tab.active { background: var(--charcoal); color: #fff; border-color: var(--charcoal); }

        /* PROGRESS BAR */
        .progress-bar-wrap { width: 100%; height: 8px; background: rgba(0,0,0,0.06); border-radius: 4px; overflow: hidden; }
        .progress-bar-fill { height: 100%; background: var(--rust); border-radius: 4px; transition: width 0.5s ease; }

        /* MEAL ROWS */
        .meal-row { display: flex; align-items: center; gap: 0.8rem; padding: 0.6rem 0; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .meal-row:last-child { border-bottom: none; }
        .meal-row.eaten { opacity: 0.45; }
        .meal-row.eaten .meal-name { text-decoration: line-through; }
        .meal-name { font-weight: 600; font-size: 0.88rem; }
        .meal-desc-small { font-size: 0.75rem; color: rgba(28,28,30,0.45); }
        .macro-pills { display: flex; gap: 0.3rem; margin-left: auto; flex-shrink: 0; }
        .macro-pills span { font-size: 0.68rem; padding: 0.12rem 0.35rem; border-radius: 4px; font-weight: 600; }
        .macro-pills .mp { background: rgba(201,79,44,0.1); color: var(--rust); }
        .macro-pills .mc { background: rgba(26,107,107,0.1); color: var(--teal); }
        .macro-pills .mf { background: rgba(28,28,30,0.06); color: var(--charcoal); }
        .meal-slot-label { font-weight: 700; font-size: 0.78rem; color: var(--rust); margin: 0.8rem 0 0.2rem; text-transform: uppercase; letter-spacing: 0.5px; }

        /* MEALS GRID */
        .meals-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 900px) { .meals-2col { grid-template-columns: 1fr; } }

        /* ATTENDANCE */
        .att-section { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; align-items: start; }
        @media (max-width: 900px) { .att-section { grid-template-columns: 1fr; } }
        .attendance-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .att-day { aspect-ratio: 1; border-radius: 6px; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 600; color: rgba(28,28,30,0.3); }
        .att-day.present { background: rgba(30,142,62,0.15); color: #1e8e3e; }
        .att-day.today { border: 2px solid var(--rust); }
        .att-stats { display: flex; flex-direction: column; gap: 1rem; }
        .att-stat-card { padding: 1.2rem; border-radius: 12px; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); }
        .att-stat-card .label { font-size: 0.78rem; color: rgba(28,28,30,0.5); font-weight: 500; margin-bottom: 0.3rem; }
        .att-stat-card .val { font-family: 'Syne'; font-size: 1.8rem; font-weight: 700; }

        /* EMPTY */
        .empty-state { text-align: center; padding: 2rem 1rem; color: rgba(28,28,30,0.4); }
        .empty-state .empty-icon { font-size: 2.2rem; margin-bottom: 0.5rem; }
        .empty-state p { font-size: 0.85rem; line-height: 1.5; }

        /* TOAST */
        .toast { position: fixed; bottom: 2rem; right: 2rem; padding: 0.8rem 1.5rem; border-radius: 10px; background: var(--charcoal); color: #fff; font-family: 'Epilogue'; font-weight: 600; font-size: 0.85rem; z-index: 9999; transform: translateY(100px); opacity: 0; transition: all 0.3s; }
        .toast.show { transform: translateY(0); opacity: 1; }
    </style>
</head>
<body>
    @include('partials.loader')
    <div class="admin-layout">
        {{-- SIDEBAR --}}
        <aside class="sidebar" style="background: linear-gradient(180deg, var(--charcoal) 0%, #111 100%);">
            <a href="{{ route('landing') }}" class="sidebar-logo">PulseForce<span class="sidebar-logo-dot"></span></a>
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item active"> My Hub</a>
                <a href="{{ route('features.training-programs') }}" class="nav-item"> Browse Workouts</a>
                <a href="{{ route('features.diet-plans') }}" class="nav-item"> Browse Diets</a>
                <a href="{{ route('features.merchandise') }}" class="nav-item"> Shop Gear</a>
                <br>
                <a href="{{ route('landing') }}" class="nav-item" style="color: rgba(240,235,226,0.6);"><span style="margin-right:8px;">&larr;</span> Back to Home</a>
            </nav>
            <div class="sidebar-footer">
                <div class="user-profile" onclick="openProfileModal()" style="cursor:pointer;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('profile-images/'.Auth::user()->avatar) }}" class="user-avatar" style="object-fit:cover;">
                    @else
                        <div class="user-avatar" style="background:var(--rust);">{{ strtoupper(substr($user->name ?? 'M', 0, 1)) }}</div>
                    @endif
                    <div class="user-info">
                        <span class="user-name">{{ $user->name ?? 'Member' }}</span>
                        <span class="user-role">{{ $user->plan ?? 'Member' }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:1rem;">
                    @csrf
                    <button type="submit" style="width:100%;padding:0.7rem;background:rgba(201,79,44,0.1);border:1px solid rgba(201,79,44,0.2);border-radius:8px;color:#c94f2c;font-family:'Epilogue';font-weight:600;font-size:0.85rem;cursor:pointer;transition:all 0.2s;">Log Out</button>
                </form>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Welcome back, {{ explode(' ', $user->name ?? 'Member')[0] }}! <span>Let's crush it.</span></h1>
                <div class="header-actions">
                    @if($checkedInToday)
                        <button class="checkin-btn done" disabled>✅ Checked In</button>
                    @else
                        <button class="checkin-btn available" onclick="doCheckIn()">🏋️ Check In</button>
                    @endif
                </div>
            </header>

            {{-- STAT CARDS --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">Current Streak <div class="stat-icon rust">🔥</div></div>
                    <div class="stat-value">{{ $streak }} Day{{ $streak !== 1 ? 's' : '' }}</div>
                    <div class="stat-trend {{ $streak > 0 ? 'up' : '' }}">{{ $streak > 0 ? 'Keep it up!' : 'Check in to start!' }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">My Workout <div class="stat-icon teal">🏋️</div></div>
                    <div class="stat-value" style="font-size:1.2rem;margin-top:0.4rem;">{{ $workoutAssignment ? $workoutAssignment->program_label : 'Not Assigned' }}</div>
                    <div class="stat-trend">{{ $workoutAssignment ? 'Assigned by trainer' : 'Ask your trainer' }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">My Diet <div class="stat-icon charcoal">🥗</div></div>
                    <div class="stat-value" style="font-size:1.2rem;margin-top:0.4rem;">{{ $dietAssignment ? $dietAssignment->plan_label : 'Not Assigned' }}</div>
                    <div class="stat-trend">{{ $dietAssignment ? ($dietData ? $dietData['calories'].' kcal/day' : '') : 'Ask your trainer' }}</div>
                </div>
            </div>

            {{-- TABBED SECTIONS --}}
            <div class="hub-tabs">
                <button class="hub-tab active" onclick="switchPanel('workout', this)">🏋️ Workout @if($workoutData)<span class="tab-badge">{{ $workoutData['days_per_week'] }}d/wk</span>@endif</button>
                <button class="hub-tab" onclick="switchPanel('meals', this)">🍽️ Today's Meals @if($dietData)@php $todayKey = now()->toDateString(); $completedMeals = $dietAssignment->completed_meals ?? []; $todayMeals = $completedMeals[$todayKey] ?? []; $totalMI = 0; $doneMI = 0; foreach($dietData['meals'] as $ml) { foreach($ml['items'] as $it) { $totalMI++; $mk = $ml['slot'].':'.$it['name']; if(in_array($mk, $todayMeals)) $doneMI++; } } @endphp<span class="tab-badge">{{ $doneMI }}/{{ $totalMI }}</span>@endif</button>
                <button class="hub-tab" onclick="switchPanel('attendance', this)">📅 Attendance <span class="tab-badge">{{ count($attendanceDays) }}d</span></button>
            </div>

            {{-- PANEL: WORKOUT --}}
            <div class="hub-panel active" id="panel-workout">
                <section class="section-card">
                    <div class="section-title">My Assigned Workout @if($workoutData)<span style="font-size:0.8rem;color:rgba(28,28,30,0.4);font-weight:400;">{{ $workoutData['weeks'] }} weeks · {{ $workoutData['days_per_week'] }} days/week</span>@endif</div>
                    @if($workoutData)
                        <div class="day-tabs">
                            @foreach($workoutData['days'] as $i => $day)
                                <button class="day-tab {{ $i === 0 ? 'active' : '' }}" onclick="switchDay({{ $i }})">{{ $day['day'] }}: {{ Str::limit($day['muscle'], 18) }}</button>
                            @endforeach
                        </div>
                        @php $completedExercises = $workoutAssignment->completed_exercises ?? []; @endphp
                        @foreach($workoutData['days'] as $i => $day)
                            <div class="day-content" id="day-{{ $i }}" style="{{ $i !== 0 ? 'display:none;' : '' }}">
                                @if(isset($day['rest']) && $day['rest'])
                                    <div class="empty-state"><div class="empty-icon">😴</div><p><strong>Rest & Recovery</strong><br>Focus on sleep, hydration, and stretching.</p></div>
                                @else
                                    @php $dayKey = $day['day']; $dayCompleted = $completedExercises[$dayKey] ?? []; $totalEx = count($day['exercises']); $doneEx = count($dayCompleted); $pct = $totalEx > 0 ? round(($doneEx / $totalEx) * 100) : 0; @endphp
                                    <div style="margin-bottom:1rem;">
                                        <div style="display:flex;justify-content:space-between;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;"><span>{{ $doneEx }}/{{ $totalEx }} completed</span><span>{{ $pct }}%</span></div>
                                        <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:{{ $pct }}%"></div></div>
                                    </div>
                                    @foreach($day['exercises'] as $ex)
                                        @php $isDone = in_array($ex['name'], $dayCompleted); @endphp
                                        <div class="exercise-row {{ $isDone ? 'completed' : '' }}">
                                            <div class="ex-check {{ $isDone ? 'checked' : '' }}" onclick="toggleExercise('{{ $dayKey }}', '{{ addslashes($ex['name']) }}', this)">{{ $isDone ? '✓' : '' }}</div>
                                            <div><div class="ex-name">{{ $ex['name'] }}</div><div class="ex-detail">{{ $ex['target'] }} · {{ $ex['desc'] }}</div></div>
                                            <div class="ex-meta"><span>{{ $ex['sets'] }}s</span><span>{{ $ex['reps'] }}r</span></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state"><div class="empty-icon">🏋️</div><p><strong>No workout assigned yet</strong><br>Your trainer will assign a program — it will show up here.</p></div>
                    @endif
                </section>
            </div>

            {{-- PANEL: MEALS --}}
            <div class="hub-panel" id="panel-meals">
                <section class="section-card">
                    <div class="section-title">Today's Meals @if($dietData)<span style="font-size:0.8rem;color:rgba(28,28,30,0.4);font-weight:400;">{{ $dietData['calories'] }} kcal target</span>@endif</div>
                    @if($dietData)
                        <div class="meals-2col">
                            @foreach($dietData['meals'] as $meal)
                                <div>
                                    <div class="meal-slot-label">{{ $meal['icon'] }} {{ $meal['slot'] }} · {{ $meal['time'] }}</div>
                                    @foreach($meal['items'] as $item)
                                        @php $mealKey = $meal['slot'] . ':' . $item['name']; $isEaten = in_array($mealKey, $todayMeals ?? []); @endphp
                                        <div class="meal-row {{ $isEaten ? 'eaten' : '' }}">
                                            <div class="ex-check {{ $isEaten ? 'checked' : '' }}" onclick="toggleMeal('{{ addslashes($mealKey) }}', this)">{{ $isEaten ? '✓' : '' }}</div>
                                            <div><div class="meal-name">{{ $item['name'] }}</div><div class="meal-desc-small">{{ Str::limit($item['desc'], 50) }}</div></div>
                                            <div class="macro-pills"><span class="mp">P:{{ $item['p'] }}</span><span class="mc">C:{{ $item['c'] }}</span><span class="mf">F:{{ $item['f'] }}</span></div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state"><div class="empty-icon">🥗</div><p><strong>No diet plan assigned yet</strong><br>Your trainer will assign a meal plan you can track daily.</p></div>
                    @endif
                </section>
            </div>

            {{-- PANEL: ATTENDANCE --}}
            <div class="hub-panel" id="panel-attendance">
                <section class="section-card">
                    <div class="section-title">Attendance — {{ now()->format('F Y') }}</div>
                    <div class="att-section">
                        <div>
                            <div class="attendance-grid">
                                @php $daysInMonth = now()->daysInMonth; $todayDate = now()->day; @endphp
                                @for($d = 1; $d <= $daysInMonth; $d++)
                                    @php $dateStr = now()->startOfMonth()->addDays($d - 1)->toDateString(); $isPresent = in_array($dateStr, $attendanceDays); $isToday = $d === $todayDate; @endphp
                                    <div class="att-day {{ $isPresent ? 'present' : '' }} {{ $isToday ? 'today' : '' }}">{{ $d }}</div>
                                @endfor
                            </div>
                            <div style="margin-top:0.75rem;font-size:0.78rem;color:rgba(28,28,30,0.5);display:flex;gap:0.5rem;flex-wrap:wrap;">
                                <span style="display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:3px;background:rgba(30,142,62,0.15);display:inline-block;"></span> Present</span>
                                <span style="display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:3px;border:2px solid var(--rust);display:inline-block;"></span> Today</span>
                            </div>
                        </div>
                        <div class="att-stats">
                            <div class="att-stat-card"><div class="label">Days This Month</div><div class="val" style="color:var(--teal);">{{ count($attendanceDays) }} <span style="font-size:0.9rem;font-weight:400;">/ {{ $daysInMonth }}</span></div></div>
                            <div class="att-stat-card"><div class="label">Current Streak</div><div class="val" style="color:var(--rust);">🔥 {{ $streak }}</div></div>
                            <div class="att-stat-card"><div class="label">Attendance Rate</div><div class="val">{{ $daysInMonth > 0 ? round((count($attendanceDays) / now()->day) * 100) : 0 }}%</div></div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div class="toast" id="toast"></div>
    @include('partials.profile-modal')

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        function showToast(msg) { const t = document.getElementById('toast'); t.textContent = msg; t.classList.add('show'); setTimeout(() => t.classList.remove('show'), 2500); }

        function switchPanel(name, btn) {
            document.querySelectorAll('.hub-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.hub-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('panel-' + name).classList.add('active');
            btn.classList.add('active');
        }

        function switchDay(idx) {
            document.querySelectorAll('.day-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.day-tab').forEach(el => el.classList.remove('active'));
            document.getElementById('day-' + idx).style.display = 'block';
            document.querySelectorAll('.day-tab')[idx].classList.add('active');
        }

        function toggleExercise(day, exercise, el) {
            fetch('{{ route("member.toggleExercise") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({ day, exercise }) })
            .then(r => r.json()).then(data => {
                if (data.success) {
                    const done = data.completed.includes(exercise);
                    el.classList.toggle('checked', done); el.textContent = done ? '✓' : '';
                    el.closest('.exercise-row').classList.toggle('completed', done);
                    showToast(done ? '💪 Exercise completed!' : 'Exercise unmarked');
                    const dc = el.closest('.day-content'), total = dc.querySelectorAll('.exercise-row').length, doneC = dc.querySelectorAll('.exercise-row.completed').length, pct = Math.round((doneC/total)*100);
                    const pb = dc.querySelector('.progress-bar-fill'); if(pb) pb.style.width = pct+'%';
                }
            });
        }

        function toggleMeal(mealKey, el) {
            fetch('{{ route("member.toggleMeal") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({ meal_key: mealKey }) })
            .then(r => r.json()).then(data => {
                if (data.success) {
                    const eaten = data.completed_today.includes(mealKey);
                    el.classList.toggle('checked', eaten); el.textContent = eaten ? '✓' : '';
                    el.closest('.meal-row').classList.toggle('eaten', eaten);
                    showToast(eaten ? '🍽️ Meal logged!' : 'Meal unlogged');
                }
            });
        }

        function doCheckIn() {
            fetch('{{ route("member.checkIn") }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({}) })
            .then(r => r.json()).then(data => { if (data.success) { showToast('✅ ' + data.message); setTimeout(() => location.reload(), 1000); } });
        }
    </script>
</body>
</html>
