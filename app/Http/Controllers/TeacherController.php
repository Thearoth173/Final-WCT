<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeacherController extends Controller
{
    public function index()
    {
        return Teacher::with('students')->get();
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:Teacher,email',
                'subject' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }

        $teacher = Teacher::create($validatedData);
        return response()->json($teacher, 201);
    }

    public function show(Teacher $teacher)
    {
        return $teacher->load('students');
    }

    public function update(Request $request, Teacher $teacher)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:Teacher,email,' . $teacher->teacher_id . ',teacher_id',
                'subject' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors()
            ], 422);
        }

        $teacher->update($validatedData);
        return response()->json($teacher);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(['message' => 'Teacher deleted']);
    }
}
