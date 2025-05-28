<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutExerciseHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'workout_history_id',
        'exercise_id',
        'reps',
        'weight',
    ];
    public function workoutHistory(){
        return $this->belongsTo(WorkoutHistory::class);
    }
    public function exercise(){
        return $this->belongsTo(Exercise::class);
    }
}
