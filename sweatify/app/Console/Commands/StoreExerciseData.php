<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StoreExerciseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-exercise-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing exercise data from data json file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = storage_path('data/data.json');
        if (!File::exists($filePath)) {
            $this->error('File not found');
            return 1;
        }
        $jsonData = File::get($filePath);
        $exercisesData = json_decode($jsonData, true);
        if (!$exercisesData) {
            $this->error('JSON data is invalid');
            return 1;
        }
        DB::beginTransaction();

        try {
            foreach ($exercisesData as $data) {
                // Ellenőrizzük, hogy minden kulcs létezik-e a JSON-ben
                if (!isset($data['name'], $data['gifUrl'], $data['instructions'], $data['target'], $data['bodyPart'], $data['equipment'], $data['secondaryMuscles'])) {
                    $this->warn("Skipping exercise due to missing fields: " . json_encode($data));
                    continue;
                }

                // Mentsük az adatokat az adatbázisba
                Exercise::create([
                    'name' => $data['name'],
                    'gifUrl' => $data['gifUrl'],
                    'instructions' => $data['instructions'], // Laravel automatikusan JSON-ként kezeli
                    'target' => $data['target'],
                    'bodyPart' => $data['bodyPart'],
                    'equipment' => $data['equipment'],
                    'secondaryMuscles' => $data['secondaryMuscles'], // Laravel automatikusan JSON-ként kezeli
                ]);
            }

            DB::commit(); // Ha minden sikeres, véglegesítjük az adatokat
            $this->info('✅ Exercises successfully stored in the database.');
            return 0;

        } catch (\Exception $e) {
            DB::rollBack(); // Ha hiba van, visszaállítjuk az adatbázis állapotát
            $this->error('❌ Error inserting data: ' . $e->getMessage());
            return 1;
        }
    }
}
