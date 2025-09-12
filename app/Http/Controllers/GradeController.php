<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GradeController extends Controller
{
    /**
     * Fetch all existing grades.
     */
    public function index()
    {
        return response()->json(Grade::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a new grade setup.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string',
            'subject_name' => 'required|string',
            'aae' => 'required|integer|min:0',
            'evaluation' => 'required|integer|min:0',
            'assignment' => 'required|integer|min:0',
            'exam' => 'required|integer|min:0',
        ]);

        // Calculate the total of the grade components
        $total = $validated['aae'] + $validated['evaluation'] + $validated['assignment'] + $validated['exam'];

        // Check if the total is exactly 100
        if ($total !== 100) {
            // Return a JSON response with a clear error message
            return response()->json([
                'message' => 'The sum of all grade components must be exactly 100.',
                'errors' => [
                    'components' => ['The sum of all grade components must be exactly 100.']
                ]
            ], 422); // 422 Unprocessable Entity is a standard code for validation errors
        }
        

        // Prevents duplicate entries for the same subject code
        $grade = Grade::updateOrCreate(
            ['subject_code' => $validated['subject_code']],
            $validated
        );

        return response()->json($grade, 201);
    }
}

