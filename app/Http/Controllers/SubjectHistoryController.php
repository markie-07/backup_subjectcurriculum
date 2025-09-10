<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Subject;
use App\Models\SubjectHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectHistoryController extends Controller
{
    /**
     * Display the subject history page.
     */
    public function index()
    {
        // This line will now work after you run `php artisan migrate:fresh`
        $history = SubjectHistory::with('curriculum')->latest()->get();
        
        return view('subject_history', ['history' => $history]);
    }

    /**
     * Remove a subject from a curriculum and log this action to the history.
     */
    public function removeSubject(Request $request)
    {
        $validated = $request->validate([
            'curriculumId' => 'required|exists:curriculums,id',
            'subjectCode' => 'required|string|exists:subjects,subject_code',
            'year' => 'required|integer',
            'semester' => 'required|integer',
        ]);

        $curriculum = Curriculum::findOrFail($validated['curriculumId']);
        $subject = Subject::where('subject_code', $validated['subjectCode'])->firstOrFail();

        DB::beginTransaction();
        try {
            // Action 1: Remove the subject from the 'curriculum_subject' pivot table.
            $detached = DB::table('curriculum_subject')
                ->where('curriculum_id', $validated['curriculumId'])
                ->where('subject_id', $subject->id)
                ->where('year', $validated['year'])
                ->where('semester', $validated['semester'])
                ->delete();

            if ($detached === 0) {
                DB::rollBack();
                // This is the error you were seeing. It means the subject was not found with the given details.
                return response()->json(['message' => 'Subject not found in the specified semester.'], 404);
            }

            // Action 2: Create a new record in the 'subject_history' table.
            SubjectHistory::create([
                'curriculum_id' => $curriculum->id,
                'subject_code' => $subject->subject_code,
                'subject_name' => $subject->subject_name,
                'units' => $subject->subject_unit,
                'academic_year_range' => $curriculum->academic_year,
                'semester' => $validated['semester'],
                'action' => 'removed',
            ]);

            DB::commit();

            return response()->json(['message' => 'Subject removed and action logged successfully.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to remove subject: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'An error occurred on the server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}