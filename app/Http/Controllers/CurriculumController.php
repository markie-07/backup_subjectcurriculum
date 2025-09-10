<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Subject;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Retrieves all curriculums formatted for a dropdown selector.
     */
    public function index()
    {
        $curriculums = Curriculum::orderBy('year_level')->orderBy('curriculum')->get()->map(function ($curriculum) {
            return [
                'id' => $curriculum->id,
                'curriculum_name' => $curriculum->curriculum,
                'program_code' => $curriculum->program_code,
                'academic_year' => $curriculum->academic_year,
                'year_level' => $curriculum->year_level,
                'created_at' => $curriculum->created_at
            ];
        });
        return response()->json($curriculums);
    }

    /**
     * Stores a new curriculum.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curriculum' => 'required|string|max:255',
            'programCode' => 'required|string|max:255|unique:curriculums,program_code',
            'academicYear' => 'required|string|max:255',
            'yearLevel' => 'required|in:Senior High,College',
        ]);

        $curriculum = Curriculum::create($validated);

        return response()->json(['message' => 'Curriculum created successfully!', 'curriculum' => $curriculum], 201);
    }

    /**
     * Updates an existing curriculum.
     */
    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $validated = $request->validate([
            'curriculum' => 'required|string|max:255',
            'programCode' => 'required|string|max:255|unique:curriculums,program_code,' . $curriculum->id,
            'academicYear' => 'required|string|max:255',
            'yearLevel' => 'required|in:Senior High,College',
        ]);
        $curriculum->update($validated);
        return response()->json(['message' => 'Curriculum updated successfully!', 'curriculum' => $curriculum]);
    }

    /**
     * Deletes a curriculum.
     */
    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();
        return response()->json(['message' => 'Curriculum deleted successfully!']);
    }

    /**
     * Retrieves data for a specific curriculum, including all available subjects for mapping.
     */
    public function getCurriculumData($id)
    {
        try {
            $curriculum = Curriculum::with('subjects')->findOrFail($id);
            $allSubjects = Subject::all(); // Always fetch all subjects

            return response()->json([
                'curriculum' => $curriculum,
                'allSubjects' => $allSubjects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'A database error occurred while fetching curriculum data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Saves the subject mapping for a curriculum.
     */
    public function saveSubjects(Request $request)
    {
        $validated = $request->validate([
            'curriculumId' => 'required|exists:curriculums,id',
            'curriculumData' => 'required|array',
        ]);

        $curriculum = Curriculum::findOrFail($validated['curriculumId']);
        $curriculum->subjects()->detach();

        foreach ($validated['curriculumData'] as $data) {
            foreach ($data['subjects'] as $subject) {
                $dbSubject = Subject::firstOrCreate(
                    ['subject_code' => $subject['subjectCode']],
                    [
                        'subject_name' => $subject['subjectName'],
                        'subject_type' => $subject['subjectType'],
                        'subject_unit' => $subject['subjectUnit'],
                        'lessons' => $subject['lessons'] ?? [],
                    ]
                );

                $curriculum->subjects()->attach($dbSubject->id, [
                    'year' => $data['year'],
                    'semester' => $data['semester'],
                ]);
            }
        }
        return response()->json(['message' => 'Curriculum saved successfully!', 'curriculumId' => $curriculum->id]);
    }
}