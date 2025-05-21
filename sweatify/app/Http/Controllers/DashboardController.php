<?php

namespace App\Http\Controllers;

use App\Models\WorkoutExerciseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $weightLogs = $user->weightLogs()->orderBy('created_at')->get();

        $topExercises = WorkoutExerciseHistory::with('exercise')
            ->whereHas('workoutHistory', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->selectRaw('exercise_id, COUNT(*) as count')
            ->groupBy('exercise_id')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $exerciseLabels = $topExercises->map(fn($e) => $e->exercise->name);
        $exerciseCounts = $topExercises->map(fn($e) => $e->count);

        return view('dashboard', [
            'weightLogs' => $weightLogs,
            'exerciseLabels' => $exerciseLabels,
            'exerciseCounts' => $exerciseCounts,
        ]);
    }
}
