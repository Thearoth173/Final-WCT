<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/students', function () {
    
    $students = [
        ['id' => 1, 'name' => 'Yim sokunthearoth', 'email' => 'sokroth@gmail.com'],
        ['id' => 2, 'name' => 'mut bros', 'email' => 'mutbros@gmail.com'],
        ['id' => 3, 'name' => 'yort', 'email' => 'yort@gmail.com']
    ];

    return response()->json([
        'message' => 'Successfully retrieved all students',
        'data' => $students
    ], 200); // 200 OK
});

Route::get('/students/{id}', function ($id) {

    $studentData = [
        1 => ['id' => 1, 'name' => 'Yim sokunthearoth', 'email' => 'sokroth@gmail.com'],
        2 => ['id' => 2, 'name' => 'mut bros', 'email' => 'mutbros@gmail.com'],
        3 => ['id' => 3, 'name' => 'yort', 'email' => 'yort@gmail.com']
    ];

    if (isset($studentData[$id])) {
        return response()->json([
            'message' => "Data recive sucesfully: {$id}",
            'data' => $studentData[$id]
        ], 200); 
    }

    return response()->json([
        'message' => "Student with ID: {$id} not found"
    ], 404); 
});

Route::post('/students', function (Request $request) {
    
    $validatedData = $request->validate([
        'name' => 'required|string|',
        'email' => 'required|email|', 
    ]);

    $newId = rand(100, 999);
    return response()->json([
        'message' => 'New student created successfully!',
        'data' => [
            'id' => $newId,
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]
    ], 200);
});

Route::put('/students/{id}', function (Request $request, $id) {

    $validatedData = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:students,email,' . $id,
    ]);

    // Your simulated student data (this part is fine for simulation)
    $studentData = [
        1 => ['id' => 1, 'name' => 'Yim sokunthearoth', 'email' => 'sokroth@gmail.com'],
        2 => ['id' => 2, 'name' => 'mut bros', 'email' => 'mutbros@gmail.com'],
        3 => ['id' => 3, 'name' => 'yort', 'email' => 'yort@gmail
        
        
        
        
        .com']
    ];

    if (!isset($studentData[$id])) {
        return response()->json(['message' => "Student with ID: {$id} not found for update"], 404);
    }

    // Apply updates based on validated data
    $studentData[$id]['name'] = $validatedData['name'] ?? $studentData[$id]['name'];
    $studentData[$id]['email'] = $validatedData['email'] ?? $studentData[$id]['email'];

    return response()->json([
        'message' => "Student ID: {$id} updated successfully!",
        'data' => $studentData[$id]
    ], 200);
});

Route::delete('/students/{id}', function ($id) {

    if (in_array($id, [1, 2, 3])) {
        return response()->json([
            'message' => "Student ID: {$id} deleted successfully!"
        ], 204); 
    }

    return response()->json([
        'message' => "Student with ID: {$id} not found for deletion"
    ], 404); 
});
