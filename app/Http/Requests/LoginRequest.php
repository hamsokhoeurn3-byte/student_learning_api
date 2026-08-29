<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
        return [
            'student_id' => 'required|string|max:50',
            'password' => 'required|string',
        ];
    }
}