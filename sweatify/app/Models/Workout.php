<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'exercise_ids',
        'is_custom'
    ];
    protected $casts = [
        'exercise_ids' => 'array',
        ];

    public function exercises()
    {
        return Exercise::whereIn('id', $this->exercise_ids ?? [])->get();
    }
}
