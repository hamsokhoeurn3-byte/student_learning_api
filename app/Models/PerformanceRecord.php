<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'semester_id',
        'period_type',
        'period_start',
        'period_end',
        'attendance_percentage',
        'assignment_percentage',
        'quiz_percentage',
        'exam_percentage',
        'overall_score',
        'performance_level',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'attendance_percentage' => 'float',
            'assignment_percentage' => 'float',
            'quiz_percentage' => 'float',
            'exam_percentage' => 'float',
            'overall_score' => 'float',
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
