<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Student::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = Student::create([
        'student_id'    => $request->student_id,
        'first_name'    => $request->first_name,
        'last_name'     => $request->last_name,
        'gender'        => $request->gender,
        'date_of_birth' => $request->date_of_birth,
        'phone'         => $request->phone,
        'email'         => $request->email,
        'faculty'       => $request->faculty,
        'department'    => $request->department,
        'year_level'    => $request->year_level,
        ]);

        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
