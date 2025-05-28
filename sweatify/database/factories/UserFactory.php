<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>$this->faker->name(),
            'email' =>$this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'age' => $this->faker->numberBetween(18, 60),
            'weight' => $this->faker->randomFloat(1, 50, 120), // 50kg-120kg
            'height' => $this->faker->numberBetween(150, 200), // 150cm-200cm
            'gender' => $this->faker->randomElement(['male', 'female']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
