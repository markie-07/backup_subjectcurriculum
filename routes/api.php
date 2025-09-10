<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\PrerequisiteController;

// --- Curriculum Routes ---
// Handles all actions related to curriculum management.
Route::get('/curriculums', [CurriculumController::class, 'index']);
Route::post('/curriculums', [CurriculumController::class, 'store']);
Route::get('/curriculums/{id}', [CurriculumController::class, 'getCurriculumData']);
Route::put('/curriculums/{id}', [CurriculumController::class, 'update']);
Route::delete('/curriculums/{id}', [CurriculumController::class, 'destroy']);
Route::post('/curriculums/save', [CurriculumController::class, 'saveSubjects']);

// Add this line with your other curriculum routes
Route::post('/curriculum/remove-subject', [CurriculumController::class, 'removeSubject']);

// --- Subject Routes ---
// Handles creation and retrieval of subjects.
Route::get('/subjects', [SubjectController::class, 'index']);
Route::post('/subjects', [SubjectController::class, 'store']);

// --- AI Generation Routes ---
// Manages interactions with the Google AI for content generation.
Route::post('/generate-lesson-topics', [AiController::class, 'generateLessonTopics']);
Route::post('/generate-lesson-plan', [AiController::class, 'generateLessonPlan']);

// --- Prerequisite Routes ---
// Manages subject prerequisites within a curriculum.
Route::get('/prerequisites/{curriculumId}', [PrerequisiteController::class, 'getPrerequisites']);
Route::post('/prerequisites', [PrerequisiteController::class, 'savePrerequisites']);

// --- Default User Route ---
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/subject_history', function () {
    return view('subject_history');
})->name('subject_history');