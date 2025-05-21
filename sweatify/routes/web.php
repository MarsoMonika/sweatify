<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// Autentikált, email-ellenőrzött felhasználók
Route::middleware(['auth', 'verified'])->group(function () {

    // Főoldal és dashboard
    Route::get('/home', fn() => view('home'))->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil menü
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Exercise oldalak
    Route::prefix('exercises')->group(function () {
        Route::get('/', fn() => view('exercises'))->name('exercises');
        Route::get('/id/{id}', fn($id) => view('exercise.show', ['id' => $id]))->name('exercise.show');
        Route::get('/name/{name}', fn($name) => view('exercise'))->name('exercises.name');
        Route::get('/bodyPartList', fn() => view('exercise.bodyPartList'))->name('exercises.bodyPartList');
        Route::get('/body-part/{bodyPart}', fn($bodyPart) => view('exercise.bodypart'))->name('exercise.bodypart');
        Route::get('/equipmentList', fn() => view('exercise.equipmentList'))->name('exercises.equipmentList');
        Route::get('/equipment/{equipment}', fn($equipment) => view('exercise.equipment'))->name('exercises.equipment');
        Route::get('/targetList', fn() => view('exercise.targetList'))->name('exercises.targetList');
        Route::get('/target/{target}', fn($target) => view('exercise.target'))->name('exercises.target');
    });

    // Workout oldalak
    Route::prefix('workouts')->group(function () {
        Route::get('/create', fn() => view('workout.create'))->name('workout.create');
        Route::get('/update/id/{id}', fn($id) => view('workout.update', ['id' => $id]))->name('workout.update');
        Route::get('/id/{id}', [WorkoutController::class, 'showPage'])->name('workouts.show');
        Route::delete('/delete/{id}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');
    });
    Route::post('/history', [WorkoutHistoryController::class, 'store'])->middleware('auth')->name('history.store');
});

require __DIR__.'/auth.php';

require __DIR__.'/auth.php';
