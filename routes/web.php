<?php

use App\Http\Controllers\CurriculumController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrerequisiteController;
use App\Http\Controllers\SubjectHistoryController;
use App\Http\Controllers\EquivalencyToolController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/curriculum_builder', function () {
    return view('curriculum_builder');
})->name('curriculum_builder');

// Note: The POST route for curriculum creation was moved to api.php

Route::get('/subject_mapping', function () {
    return view('subject_mapping');
})->name('subject_mapping');

// UPDATED ROUTE: This now calls the controller to fetch the necessary data.
Route::get('/pre_requisite', [PrerequisiteController::class, 'index'])->name('pre_requisite');

Route::get('/grade_setup', function () {
    return view('grade_setup');
})->name('grade_setup');

Route::get('/curriculum_export_tool', function () {
    return view('curriculum_export_tool');
})->name('curriculum_export_tool');

Route::get('/equivalency_tool', function () {
    return view('equivalency_tool');
})->name('equivalency_tool');

Route::get('/subject_history', [SubjectHistoryController::class, 'index'])->name('subject_history');
Route::post('/subject_history/{history}/retrieve', [SubjectHistoryController::class, 'retrieve'])->name('subject_history.retrieve');


// CHED Compliance Validator
Route::get('/compliance-validator', function () {
    $curriculums = [];
    $cmos = [];
    return view('compliance_validator', compact('curriculums', 'cmos'));
})->name('compliance.validator');

Route::post('/compliance-validator/validate', function () {
    // Handle validation logic here
})->name('ched.validator.validate');

// EQUIVALENCY TOOL
Route::get('/equivalency_tool', [EquivalencyToolController::class, 'index'])->name('equivalency_tool');
Route::post('/equivalency_tool', [EquivalencyToolController::class, 'store'])->name('equivalency_tool.store');
Route::delete('/equivalencies/{equivalency}', [EquivalencyToolController::class, 'destroy'])->name('equivalency.destroy');