<?php

namespace App\Http\Controllers;


use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class WorkoutController extends Controller
{

    public function index(Request $request): JsonResponse
    {

        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $workouts = Workout::orderBy('id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $total = Workout::count();

        return response()->json([
            'workouts' => $workouts,
            'total' => $total,
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'description' => 'nullable|string',
                'exercise_ids' => 'required|array',
                'exercise_ids.*' => 'exists:exercises,id',
            ]);

            $validated['is_custom'] = true;

            $workout = Workout::create($validated);

            return response()->json($workout, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }


    public function show($id)
    {
        $workout = Workout::findOrFail($id);

        $exercises = Exercise::whereIn('id', $workout->exercise_ids)->get(['id', 'name']);

        return response()->json([
            'id' => $workout->id,
            'name' => $workout->name,
            'type' => $workout->type,
            'description' => $workout->description,
            'exercises' => $exercises,
            'created_at' => $workout->created_at,
            'updated_at' => $workout->updated_at,
            'is_custom' => $workout->is_custom
        ]);
    }

    public function update(Request $request, Workout $workout): JsonResponse
    {
        try {

            \Log::info('Request data:', $request->all());


            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'description' => 'nullable|string',
                'exercise_ids' => 'required|array',
                'exercise_ids.*' => 'exists:exercises,id',
            ]);

            $validated['is_custom'] = true;

            $workout->update($validated);

            // Add updated_at date

            return response()->json($workout);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function showPage($id)
    {
        $workout = Workout::findOrFail($id);

        $exercises = Exercise::whereIn('id', $workout->exercise_ids)->get(['id', 'name']);

        return view('workout.show', [
            'workout' => $workout,
            'exercises' => $exercises
        ]);
    }

    public function destroy($id)
    {
        $workout = Workout::findOrFail($id);

        if ($workout->is_custom != 1) {

            return redirect()->route('home')->with('error', 'Only custom workouts can be deleted!');
        }

        $workout->delete();

        // Flash success üzenet
        return redirect()->route('home')->with('success', 'Workout deleted successfully!');
    }


    public function types(): JsonResponse
    {

        $types = Workout::select('type')->distinct()->get();

        return response()->json([
            'types' => $types->pluck('type')
        ]);
    }

}
