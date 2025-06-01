<?php
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::apiResource('teachers', TeacherController::class);
Route::apiResource('students', StudentController::class);
