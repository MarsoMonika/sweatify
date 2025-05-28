<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
use HasFactory;
protected $fillable = [
    'name',
    'gifUrl',
    'instructions',
    'target',
    'bodyPart',
    'equipment',
    'secondaryMuscles'
];
    protected $casts = [
        'instructions' => 'array',
        'secondaryMuscles' => 'array',
    ];
    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises');
    }
}
