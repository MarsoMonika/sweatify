<?php

namespace Database\Seeders;

use App\Models\WorkoutHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkoutHistory::factory(20)->create();
    }
}
