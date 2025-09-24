<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        return response()->json(Grade::with('subject')->latest()->get());
    }

    public function show($id)
    {
        // We now fetch the grade setup using the subject_id
        $grade = Grade::with('subject')->where('subject_id', $id)->first();

        // If no setup exists for a subject, return null so the frontend can use a default
        if (!$grade) {
            return response()->json(['components' => null]);
        }
        return response()->json($grade);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'components' => 'required|array', // Ensure 'components' is a valid array/object
        ]);

        // This command finds a grade setup for the subject_id or creates a new one.
        // It's a clean way to handle both creating and updating.
        $grade = Grade::updateOrCreate(
            ['subject_id' => $validated['subject_id']],
            ['components' => $validated['components']]
        );

        return response()->json($grade->load('subject'), 201);
    }
}