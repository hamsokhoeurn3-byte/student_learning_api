<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'student_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'phone',
        'address',
        'department',
        'major',
        'academic_year',
        'year_level',
        'semester',
        'advisor',
        'enrollment_date',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}