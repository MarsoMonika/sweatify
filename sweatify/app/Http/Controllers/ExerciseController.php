<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Get all exercises
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $exercises = Exercise::offset($offset)->limit($limit)->get();
        $total = Exercise::count(); // Get total number of exercises

        return response()->json([
            'exercises' => $exercises,
            'total' => $total,
            'limit' => (int) $limit,
            'offset' => (int) $offset
        ]);
    }

    // Get a single exercise by ID
    public function show($id)
    {
        return Exercise::findOrFail($id);
    }

    // Get exercise by name
    public function getByName($name)
    {
        return Exercise::where('name', 'like', "%$name%")->get();
    }



    // Get list of all unique body parts
    public function getBodyPartList()
    {
        return Exercise::select('bodyPart')->distinct()->pluck('bodyPart');
    }

    // Get exercises filtered by bodyPart
    public function filterByBodyPart(Request $request, $bodyPart)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        // Get exercises for the specific body part with pagination
        $exercises = Exercise::where('bodyPart', $bodyPart)
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Get the total number of exercises for the body part (to calculate total pages)
        $total = Exercise::where('bodyPart', $bodyPart)->count();

        return response()->json([
            'exercises' => $exercises,
            'total' => $total,
            'limit' => (int) $limit,
            'offset' => (int) $offset
        ]);
    }



    // Get list of all unique equipment
    public function getEquipmentList()
    {
        return Exercise::select('equipment')->distinct()->pluck('equipment');
    }

    // Get exercises filtered by equipment
    public function filterByEquipment(Request $request, $equipment)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $exercises = Exercise::where('equipment', $equipment)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $total = Exercise::where('equipment', $equipment)->count();

        return response()->json([
            'exercises' => $exercises,
            'total' => $total,
            'limit' => (int) $limit,
            'offset' => (int) $offset
        ]);
    }



    // Get list of all unique target muscles
    public function getTargetList()
    {
        return Exercise::select('target')->distinct()->pluck('target');
    }

    // Get exercises filtered by target muscle
    public function filterByTarget(Request $request, $target)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $exercises = Exercise::where('target', $target)
            ->offset($offset)
            ->limit($limit)
            ->get();

        $total = Exercise::where('target', $target)->count();

        return response()->json([
            'exercises' => $exercises,
            'total' => $total,
            'limit' => (int) $limit,
            'offset' => (int) $offset
        ]);
    }




}
