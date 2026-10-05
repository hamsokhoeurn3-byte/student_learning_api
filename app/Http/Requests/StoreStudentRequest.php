<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'student_id' =>
                'required|string|max:50|unique:students,student_code',

            'first_name' =>
                'required|string|max:100',

            'last_name' =>
                'required|string|max:100',

            'gender' =>
                'required|in:Male,Female',

            'date_of_birth' =>
                'nullable|date',

            'nationality' =>
                'nullable|string|max:100',

            'phone' =>
                'nullable|string|max:30',

            'address' =>
                'nullable|string|max:255',

            'email' =>
                'required|email|unique:students,email',

            'department' =>
                'nullable|string|max:255',

            'major' =>
                'nullable|string|max:255',

            'academic_year' =>
                'nullable|string|max:20',

            'year_level' =>
                'nullable|integer|min:1|max:10',

            'semester' =>
                'nullable|string|max:50',

            'advisor' =>
                'nullable|string|max:255',

            'enrollment_date' =>
                'nullable|date',

            'status' =>
                'nullable|string|max:50',
        ];
    }
}