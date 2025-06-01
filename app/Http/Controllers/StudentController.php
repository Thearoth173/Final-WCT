<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index()
    {
        return Student::with('teacher')->get();
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'nullable|email|unique:Student,email',
                'grade_level' => 'nullable|string',
                'teacher_id' => 'nullable|exists:Teacher,teacher_id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }

        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    public function show(Student $student)
    {
        return $student->load('teacher');
    }

    public function update(Request $request, Student $student)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'nullable|email|unique:Student,email,' . $student->student_id . ',student_id',
                'grade_level' => 'nullable|string',
                'teacher_id' => 'nullable|exists:Teacher,teacher_id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }

        $student->update($validatedData);
        return response()->json($student->load('teacher'));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted']);
    }
}
