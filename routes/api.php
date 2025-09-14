<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\PrerequisiteController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\EquivalencyToolController; 

// --- Curriculum Routes ---
Route::get('/curriculums', [CurriculumController::class, 'index']);
Route::post('/curriculums', [CurriculumController::class, 'store']);
Route::get('/curriculums/{id}', [CurriculumController::class, 'getCurriculumData']);
Route::put('/curriculums/{id}', [CurriculumController::class, 'update']);
Route::delete('/curriculums/{id}', [CurriculumController::class, 'destroy']);
Route::post('/curriculums/save', [CurriculumController::class, 'saveSubjects']);
Route::post('/curriculum/remove-subject', [CurriculumController::class, 'removeSubject']);

// --- Subject Routes ---
Route::get('/subjects', [SubjectController::class, 'index']);
Route::post('/subjects', [SubjectController::class, 'store']);
Route::get('/subjects/{id}', [SubjectController::class, 'show']);
Route::put('/subjects/{id}', [SubjectController::class, 'update']);

// --- AI Generation Routes ---
Route::post('/generate-lesson-topics', [AiController::class, 'generateLessonTopics']);
Route::post('/generate-lesson-plan', [AiController::class, 'generateLessonPlan']);

// --- Prerequisite Routes ---
Route::get('/prerequisites/{curriculum}', [PrerequisiteController::class, 'fetchData']);
Route::post('/prerequisites', [PrerequisiteController::class, 'store']);

// --- Grade Routes ---
Route::get('/grades', [GradeController::class, 'index']);
Route::post('/grades', [GradeController::class, 'store']);
Route::get('/grades/{id}', [GradeController::class, 'show']);
Route::put('/grades/{id}', [GradeController::class, 'update']);
Route::delete('/grades/{id}', [GradeController::class, 'destroy']);

// --- Equivalency Tool Routes ---
Route::post('/equivalencies', [EquivalencyToolController::class, 'store']);
Route::patch('/equivalencies/{equivalency}', [EquivalencyToolController::class, 'update']);
Route::delete('/equivalencies/{equivalency}', [EquivalencyToolController::class, 'destroy']);

// --- Default User Route ---
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});