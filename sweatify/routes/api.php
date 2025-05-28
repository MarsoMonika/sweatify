<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {


    Route::get('/user', fn(Request $request) => $request->user());

    // Exercises API
    Route::prefix('exercises')->group(function () {
        Route::get('/', [ExerciseController::class, 'index']);
        Route::get('/id/{id}', [ExerciseController::class, 'show']);
        Route::get('/name/{name}', [ExerciseController::class, 'getByName']);
        Route::get('/bodyPartList', [ExerciseController::class, 'getBodyPartList']);
        Route::get('/body-part/{bodyPart}', [ExerciseController::class, 'filterByBodyPart']);
        Route::get('/equipmentList', [ExerciseController::class, 'getEquipmentList']);
        Route::get('/equipment/{equipment}', [ExerciseController::class, 'filterByEquipment']);
        Route::get('/targetList', [ExerciseController::class, 'getTargetList']);
        Route::get('/target/{target}', [ExerciseController::class, 'filterByTarget']);
    });

    // Workouts API
    Route::prefix('workouts')->group(function () {
        Route::get('/', [WorkoutController::class, 'index']);
        Route::post('/create', [WorkoutController::class, 'store']);
        Route::put('/update/{workout}', [WorkoutController::class, 'update']);
        Route::get('/types', [WorkoutController::class, 'types']);
        Route::get('/history/{userId}', [WorkoutHistoryController::class, 'show']);
    });


});

