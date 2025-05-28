<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutHistory extends Model
{
use HasFactory;


protected $fillable = [
    'user_id',
    'workout_id',
];
public function user(){
    return $this->belongsTo(User::class);
}
public function exercise(){
    return $this->hasMany(WorkoutExerciseHistory::class);
}
public function workout(){
    return $this->belongsTo(Workout::class);
}
}
