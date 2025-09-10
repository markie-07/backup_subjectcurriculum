<?php

namespace App\Http\Controllers;

use App\Models\Prerequisite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrerequisiteController extends Controller
{
    public function getPrerequisites($curriculumId)
    {
        $prerequisites = Prerequisite::where('curriculum_id', $curriculumId)->get();

        $groupedPrerequisites = [];
        foreach ($prerequisites as $prerequisite) {
            if (!isset($groupedPrerequisites[$prerequisite->subject_code])) {
                $groupedPrerequisites[$prerequisite->subject_code] = [];
            }
            $groupedPrerequisites[$prerequisite->subject_code][] = $prerequisite->prerequisite_subject_code;
        }

        return response()->json($groupedPrerequisites);
    }

    public function savePrerequisites(Request $request)
    {
        $curriculumId = $request->input('curriculum_id');
        $subjectCode = $request->input('subject_code');
        $prerequisites = $request->input('prerequisites');

        // Log the request data for debugging
        Log::info('Saving prerequisites', [
            'curriculum_id' => $curriculumId,
            'subject_code' => $subjectCode,
            'prerequisites' => $prerequisites
        ]);

        if (is_null($prerequisites)) {
            $prerequisites = [];
        }

        // Delete existing prerequisites for this subject and curriculum
        Prerequisite::where('curriculum_id', $curriculumId)
            ->where('subject_code', $subjectCode)
            ->delete();

        // Add the new prerequisites
        foreach ($prerequisites as $prerequisiteCode) {
            Prerequisite::create([
                'curriculum_id' => $curriculumId,
                'subject_code' => $subjectCode,
                'prerequisite_subject_code' => $prerequisiteCode,
            ]);
        }

        return response()->json(['message' => 'Prerequisites saved successfully.']);
    }
}