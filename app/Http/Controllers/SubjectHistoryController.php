<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\SubjectHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectHistoryController extends Controller
{
    /**
     * Display a listing of the subject history.
     */
    public function index()
    {
        $history = SubjectHistory::with('curriculum')->orderBy('created_at', 'desc')->get();
        return view('subject_history', compact('history'));
    }

    /**
     * Retrieve a subject from history and add it back to the curriculum.
     */
    public function retrieve($historyId)
    {
        try {
            DB::transaction(function () use ($historyId) {
                $historyRecord = SubjectHistory::findOrFail($historyId);

                $curriculum = Curriculum::find($historyRecord->curriculum_id);
                $subject = Subject::find($historyRecord->subject_id);

                if (!$curriculum || !$subject) {
                    throw new \Exception("Original Curriculum or Subject no longer exists.");
                }

                // Re-attach the subject to the curriculum_subject pivot table
                $curriculum->subjects()->attach($subject->id, [
                    'year'       => $historyRecord->year,
                    'semester'   => $historyRecord->semester,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Delete the history record since it has been retrieved
                $historyRecord->delete();
            });

            return response()->json(['message' => 'Subject retrieved successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve subject: ' . $e->getMessage()], 500);
        }
    }
}