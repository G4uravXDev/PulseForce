<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkoutAssignment;
use App\Models\DietAssignment;
use App\Models\Attendance;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isManager()) {
            // Fetch real data from database
            $totalRevenue = \App\Models\User::where('role', 'customer')
                                ->where('status', 'Active')
                                ->sum('plan_price');
                                
            $activeMembers = \App\Models\User::where('role', 'customer')
                                 ->where('status', 'Active')
                                 ->count();

            // New signups who haven't been activated yet
            $pendingCount = \App\Models\User::where('role', 'customer')
                                ->where(function($q) {
                                    $q->whereNull('status')
                                      ->orWhere('status', '')
                                      ->orWhere('status', 'Pending');
                                })
                                ->where('is_blocked', '!=', true)
                                ->count();
                                 
            $recentEnrollments = \App\Models\User::where('role', 'customer')
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)
                                     ->get();

            // Real attendance rate
            $today = now()->toDateString();
            $todayCheckins = Attendance::where('date', $today)->count();
            $attendanceRate = $activeMembers > 0 
                ? round(($todayCheckins / $activeMembers) * 100) . '%' 
                : '0%';

            return view('admin.dashboard', compact(
                'user',
                'totalRevenue',
                'activeMembers',
                'pendingCount',
                'recentEnrollments',
                'attendanceRate'
            ));
        }

        // --- CUSTOMER DASHBOARD: fetch real assigned data ---
        $userId = (string) $user->_id;

        // Active workout assignment
        $workoutAssignment = WorkoutAssignment::where('user_id', $userId)
                                ->where('status', 'active')
                                ->first();

        // Active diet assignment
        $dietAssignment = DietAssignment::where('user_id', $userId)
                            ->where('status', 'active')
                            ->first();

        // Get workout plan data if assigned
        $workoutData = null;
        if ($workoutAssignment) {
            $trainingController = new \App\Http\Controllers\TrainingProgramController();
            $plans = $trainingController->getAllPlans();
            $workoutData = $plans[$workoutAssignment->goal][$workoutAssignment->level] ?? null;
        }

        // Get diet plan data if assigned
        $dietData = null;
        if ($dietAssignment) {
            $dietController = new \App\Http\Controllers\DietPlanController();
            $plans = $dietController->getAllPlans();
            $dietData = $plans[$dietAssignment->goal][$dietAssignment->type] ?? null;
        }

        // Attendance data
        $startOfMonth = now()->startOfMonth()->toDateString();
        $attendanceDays = Attendance::where('user_id', $userId)
                            ->where('date', '>=', $startOfMonth)
                            ->pluck('date')
                            ->toArray();
        $checkedInToday = in_array(now()->toDateString(), $attendanceDays);

        // Streak
        $streak = 0;
        $checkDate = now()->copy();
        while (true) {
            $hasAttendance = Attendance::where('user_id', $userId)
                                ->where('date', $checkDate->toDateString())
                                ->exists();
            if ($hasAttendance) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        return view('customer.dashboard', compact(
            'user',
            'workoutAssignment',
            'workoutData',
            'dietAssignment',
            'dietData',
            'attendanceDays',
            'checkedInToday',
            'streak'
        ));
    }

    /**
     * Show all members for the admin.
     *
     * @return \Illuminate\View\View
     */
    public function members()
    {
        $user = Auth::user();

        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $members = \App\Models\User::where('role', 'customer')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('admin.members', compact('user', 'members'));
    }

    /**
     * Toggle block status of a member.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleBlockMember($id)
    {
        if (!Auth::user()->isManager()) {
            return redirect()->route('dashboard');
        }

        $member = \App\Models\User::where('role', 'customer')
                    ->where('_id', $id)
                    ->first();

        if ($member) {
            $member->is_blocked = !$member->is_blocked;
            // Also sync the status field so member can't login when blocked
            $member->status = $member->is_blocked ? 'Blocked' : 'Active';
            $member->save();
        }

        $action = $member && $member->is_blocked ? 'blocked' : 'unblocked';
        return redirect()->back()->with('success', "Member {$action} successfully.");
    }

    /**
     * Permanently delete a member (Admin).
     */
    public function deleteMember($id)
    {
        if (!Auth::user()->isManager()) {
            return redirect()->route('dashboard');
        }

        $member = \App\Models\User::where('role', 'customer')
                    ->where('_id', $id)
                    ->first();

        if ($member) {
            // Clean up their assignments and attendance records
            WorkoutAssignment::where('user_id', (string) $member->_id)->delete();
            DietAssignment::where('user_id', (string) $member->_id)->delete();
            Attendance::where('user_id', (string) $member->_id)->delete();
            $member->delete();
        }

        return redirect()->back()->with('success', 'Member deleted successfully.');
    }

    /**
     * Activate a pending member and optionally set their plan (Admin).
     */
    public function activateMember(Request $request, $id)
    {
        if (!Auth::user()->isManager()) {
            return redirect()->route('dashboard');
        }

        $member = \App\Models\User::where('role', 'customer')
                    ->where('_id', $id)
                    ->first();

        if ($member) {
            $plan = $request->input('plan', 'Starter / Basic');
            $planPrices = [
                'Starter / Basic'   => 999,
                'Pro / Performance' => 2499,
                'Elite / Unlimited' => 4999,
            ];
            $member->status     = 'Active';
            $member->is_blocked = false;
            $member->plan       = $plan;
            $member->plan_price = $planPrices[$plan] ?? 999;
            $member->save();
        }

        return redirect()->back()->with('success', "{$member->name} activated successfully.");
    }

    /**
     * Show the form to create a new member (Admin).
     */
    public function createMember()
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }
        return view('admin.members-create', compact('user'));
    }

    /**
     * Store a new member in the database (Admin).
     */
    public function storeMember(Request $request)
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'plan' => 'required|string',
            'plan_price' => 'required|numeric'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
            'plan' => $request->plan,
            'plan_price' => $request->plan_price,
            'status' => 'Active',
            'is_blocked' => false
        ]);

        return redirect()->route('dashboard')->with('success', 'Member added successfully.');
    }

    /**
     * Generate and download a CSV report of members.
     */
    public function downloadReport()
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $members = \App\Models\User::where('role', 'customer')->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=pulseforce_members_report.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($members) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Plan', 'Price (INR)', 'Join Date', 'Status', 'Blocked']);

            foreach ($members as $member) {
                fputcsv($file, [
                    $member->name,
                    $member->email,
                    $member->plan ?? 'N/A',
                    $member->plan_price ?? 0,
                    $member->created_at ? $member->created_at->format('Y-m-d') : 'N/A',
                    $member->status ?? 'Pending',
                    $member->is_blocked ? 'Yes' : 'No'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('profile-images'), $avatarName);
            $user->avatar = $avatarName; 
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update a member's plan and price (Admin).
     */
    public function updateMemberPlan(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'plan' => 'required|string|in:Starter / Basic,Pro / Performance,Elite / Unlimited',
        ]);

        $planPrices = [
            'Starter / Basic' => 999,
            'Pro / Performance' => 2499,
            'Elite / Unlimited' => 4999,
        ];

        $member = \App\Models\User::where('role', 'customer')->find($id);
        if ($member) {
            $member->plan = $request->plan;
            $member->plan_price = $planPrices[$request->plan] ?? 0;
            $member->status = 'Active';
            $member->save();
        }

        return redirect()->back()->with('success', 'Member plan updated successfully.');
    }

    /**
     * Assign a workout program to a member (Admin).
     */
    public function assignWorkout(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'goal' => 'required|string|in:bulk,shredded',
            'level' => 'required|string|in:beginner,intermediate,veteran',
        ]);

        $member = \App\Models\User::where('role', 'customer')->find($id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        // Deactivate any existing active workout
        WorkoutAssignment::where('user_id', (string) $member->_id)
            ->where('status', 'active')
            ->update(['status' => 'completed']);

        // Get program label
        $trainingController = new \App\Http\Controllers\TrainingProgramController();
        $plans = $trainingController->getAllPlans();
        $plan = $plans[$request->goal][$request->level] ?? null;
        $label = $plan ? $plan['label'] : ucfirst($request->goal) . ' — ' . ucfirst($request->level);

        // Create new assignment
        WorkoutAssignment::create([
            'user_id' => (string) $member->_id,
            'assigned_by' => (string) $user->_id,
            'goal' => $request->goal,
            'level' => $request->level,
            'program_label' => $label,
            'completed_exercises' => [],
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', "Workout '{$label}' assigned to {$member->name}.");
    }

    /**
     * Assign a diet plan to a member (Admin).
     */
    public function assignDiet(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isManager()) {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'goal' => 'required|string|in:bulk,slim',
            'type' => 'required|string|in:veg,nonveg,vegan',
        ]);

        $member = \App\Models\User::where('role', 'customer')->find($id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        // Deactivate any existing active diet
        DietAssignment::where('user_id', (string) $member->_id)
            ->where('status', 'active')
            ->update(['status' => 'completed']);

        // Get plan label
        $dietController = new \App\Http\Controllers\DietPlanController();
        $plans = $dietController->getAllPlans();
        $plan = $plans[$request->goal][$request->type] ?? null;
        $label = $plan ? $plan['label'] : ucfirst($request->goal) . ' — ' . ucfirst($request->type);

        // Create new assignment
        DietAssignment::create([
            'user_id' => (string) $member->_id,
            'assigned_by' => (string) $user->_id,
            'goal' => $request->goal,
            'type' => $request->type,
            'plan_label' => $label,
            'completed_meals' => [],
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', "Diet '{$label}' assigned to {$member->name}.");
    }
}
