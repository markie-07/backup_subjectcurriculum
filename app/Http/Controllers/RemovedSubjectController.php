<?php

namespace App\Http\Controllers;

use App\Models\RemovedSubject;
use Illuminate\Http\Request;

class RemovedSubjectController extends Controller
{
    public function index($curriculumId)
    {
        $removedSubjects = RemovedSubject::where('curriculum_id', $curriculumId)
            ->with('curriculum')
            ->with('subject')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($removedSubjects);
    }
}