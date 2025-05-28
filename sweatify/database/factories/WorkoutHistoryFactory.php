<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use App\Models\WorkoutExerciseHistory;
use App\Models\WorkoutHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkoutHistory>
 */
class WorkoutHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'workout_id' => Workout::inRandomOrder()->first()?->id ?? Workout::factory()->create()->id,
        ];
    }

    public
    function configure()
    {
        return $this->afterCreating(function (WorkoutHistory $workoutHistory) {
            $workout = $workoutHistory->workout;
            $exerciseIds = $workout->exercise_ids ?? [];

            foreach ($exerciseIds as $exerciseId) {
                WorkoutExerciseHistory::create([
                    'workout_history_id' => $workoutHistory->id,
                    'exercise_id' => $exerciseId,
                    'reps' => rand(8, 20),
                    'weight' => rand(10, 50),
                ]);
            }
        });
    }
}
