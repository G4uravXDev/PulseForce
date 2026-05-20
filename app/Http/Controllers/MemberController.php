<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkoutAssignment;
use App\Models\DietAssignment;
use App\Models\Attendance;

class MemberController extends Controller
{
    /**
     * Toggle an exercise as completed/uncompleted for a workout day.
     */
    public function toggleExercise(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'exercise' => 'required|string',
        ]);

        $user = Auth::user();
        $assignment = WorkoutAssignment::where('user_id', (string) $user->_id)
                        ->where('status', 'active')
                        ->first();

        if (!$assignment) {
            return response()->json(['error' => 'No active workout assigned'], 404);
        }

        $completed = $assignment->completed_exercises ?? [];
        $day = $request->day;
        $exercise = $request->exercise;

        if (!isset($completed[$day])) {
            $completed[$day] = [];
        }

        // Toggle
        if (in_array($exercise, $completed[$day])) {
            $completed[$day] = array_values(array_diff($completed[$day], [$exercise]));
        } else {
            $completed[$day][] = $exercise;
        }

        $assignment->completed_exercises = $completed;
        $assignment->save();

        return response()->json([
            'success' => true,
            'completed' => $completed[$day],
            'day' => $day,
        ]);
    }

    /**
     * Toggle a meal as eaten/not eaten for today.
     */
    public function toggleMeal(Request $request)
    {
        $request->validate([
            'meal_key' => 'required|string', // e.g. "Breakfast:Paneer Paratha (3 pcs)"
        ]);

        $user = Auth::user();
        $assignment = DietAssignment::where('user_id', (string) $user->_id)
                        ->where('status', 'active')
                        ->first();

        if (!$assignment) {
            return response()->json(['error' => 'No active diet plan assigned'], 404);
        }

        $completed = $assignment->completed_meals ?? [];
        $today = now()->toDateString();
        $mealKey = $request->meal_key;

        if (!isset($completed[$today])) {
            $completed[$today] = [];
        }

        // Toggle
        if (in_array($mealKey, $completed[$today])) {
            $completed[$today] = array_values(array_diff($completed[$today], [$mealKey]));
        } else {
            $completed[$today][] = $mealKey;
        }

        $assignment->completed_meals = $completed;
        $assignment->save();

        return response()->json([
            'success' => true,
            'completed_today' => $completed[$today],
        ]);
    }

    /**
     * Check in for today (attendance).
     */
    public function checkIn()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        // Prevent double check-in
        $existing = Attendance::where('user_id', (string) $user->_id)
                        ->where('date', $today)
                        ->first();

        if ($existing) {
            return response()->json(['success' => true, 'already' => true, 'message' => 'Already checked in today!']);
        }

        Attendance::create([
            'user_id' => (string) $user->_id,
            'date' => $today,
        ]);

        return response()->json(['success' => true, 'already' => false, 'message' => 'Checked in successfully!']);
    }

    /**
     * Get member's workout and diet data for the dashboard (AJAX).
     */
    public function myData()
    {
        $user = Auth::user();
        $userId = (string) $user->_id;

        // Active workout
        $workout = WorkoutAssignment::where('user_id', $userId)
                        ->where('status', 'active')
                        ->first();

        // Active diet
        $diet = DietAssignment::where('user_id', $userId)
                    ->where('status', 'active')
                    ->first();

        // Attendance this month
        $startOfMonth = now()->startOfMonth()->toDateString();
        $attendanceDays = Attendance::where('user_id', $userId)
                            ->where('date', '>=', $startOfMonth)
                            ->pluck('date')
                            ->toArray();

        // Today's check-in status
        $checkedInToday = in_array(now()->toDateString(), $attendanceDays);

        // Calculate streak
        $streak = 0;
        $checkDate = now();
        while (true) {
            $dateStr = $checkDate->toDateString();
            $hasAttendance = Attendance::where('user_id', $userId)
                                ->where('date', $dateStr)
                                ->exists();
            if ($hasAttendance) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        return response()->json([
            'workout' => $workout,
            'diet' => $diet,
            'attendance_days' => $attendanceDays,
            'checked_in_today' => $checkedInToday,
            'streak' => $streak,
        ]);
    }
}
