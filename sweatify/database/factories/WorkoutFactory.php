<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workout>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $exerciseIds = Exercise::inRandomOrder()->limit(rand(3, 5))->pluck('id')->toArray();
        return [
            'name' => $this->faker->randomElement(['Cardio Blast',
                'Strength Training',
                'HIIT',
                'Full Body Workout',
                'Leg Day',
                'Push/Pull Workout',
                'Endurance Training',
                'Powerlifting',
                'Yoga Flow',
                'Circuit Training',
                'Boxing Training',
                'CrossFit WOD',
                'Pilates Routine',
                'Dance Aerobics']),
            'type' => $this->faker->randomElement(['cardio', 'strength', 'endurance', 'flexibility', 'swimming', 'dance']),
             'description' => $this->faker->text(),
            'exercise_ids' => $exerciseIds,
        ];
    }
}
