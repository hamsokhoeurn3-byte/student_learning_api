<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'assignment_score',
        'quiz_score',
        'attendance_score',
        'midterm_score',
        'final_exam_score',
        'total_score',
        'letter_grade',
        'grade_point',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'assignment_score' => 'float',
            'quiz_score' => 'float',
            'attendance_score' => 'float',
            'midterm_score' => 'float',
            'final_exam_score' => 'float',
            'total_score' => 'float',
            'grade_point' => 'float',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
