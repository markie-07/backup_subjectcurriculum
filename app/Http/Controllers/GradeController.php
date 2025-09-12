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
        return response()->json(Grade::with('subject')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id|unique:grades,subject_id',
            'aae' => 'required|integer|min:0|max:100',
            'evaluation' => 'required|integer|min:0|max:100',
            'assignment' => 'required|integer|min:0|max:100',
            'exam' => 'required|integer|min:0|max:100',
        ]);

        if (array_sum(array_slice($validated, 1)) !== 100) {
            return response()->json(['message' => 'The sum of all grade components must be 100.'], 422);
        }

        $grade = Grade::create($validated);
        
        return response()->json($grade->load('subject'), 201);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        
        $validated = $request->validate([
            'aae' => 'required|integer|min:0|max:100',
            'evaluation' => 'required|integer|min:0|max:100',
            'assignment' => 'required|integer|min:0|max:100',
            'exam' => 'required|integer|min:0|max:100',
        ]);

        if (array_sum($validated) !== 100) {
            return response()->json(['message' => 'The sum of all grade components must be 100.'], 422);
        }

        $grade->update($validated);

        return response()->json($grade->load('subject'));
    }
}