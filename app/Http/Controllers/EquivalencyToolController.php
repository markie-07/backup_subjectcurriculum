<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Equivalency; // Import the new model
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class EquivalencyToolController extends Controller
{
    /**
     * Display the equivalency tool page and provide all subjects and existing equivalencies.
     */
    public function index(): View
    {
        $subjects = Subject::orderBy('subject_code')->get();
        // Fetch equivalencies and eager-load the related subject data to prevent extra queries
        $equivalencies = Equivalency::with('equivalentSubject')->latest()->get();

        return view('equivalency_tool', [
            'subjects' => $subjects,
            'equivalencies' => $equivalencies, // Pass equivalencies to the view
        ]);
    }

    /**
     * Store a new equivalency in the database.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'source_subject_name' => 'required|string|max:255',
            'equivalent_subject_id' => 'required|exists:subjects,id',
        ]);

        $equivalency = Equivalency::create([
            'source_subject_name' => $request->source_subject_name,
            'equivalent_subject_id' => $request->equivalent_subject_id,
        ]);

        // Return the new record with its relationship loaded so the frontend can display it
        return response()->json($equivalency->load('equivalentSubject'));
    }

    /**
     * Remove the specified equivalency from the database.
     */
    public function destroy(Equivalency $equivalency): JsonResponse
    {
        $equivalency->delete();
        return response()->json(['message' => 'Equivalency removed successfully.']);
    }
}