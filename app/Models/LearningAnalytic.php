<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningAnalytic extends Model
{
    use HasFactory;

    // "analytics" is uncountable, so Laravel would guess the wrong table name.
    protected $table = 'learning_analytics';

    protected $fillable = [
        'student_id',
        'semester_id',
        'period_type',
        'period_start',
        'period_end',
        'attendance_rate',
        'assignment_average',
        'quiz_average',
        'exam_average',
        'overall_performance',
        'performance_change',
        'learning_trend',
        'strengths',
        'weaknesses',
        'analytics_summary',
        'calculated_at',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'attendance_rate' => 'float',
            'assignment_average' => 'float',
            'quiz_average' => 'float',
            'exam_average' => 'float',
            'overall_performance' => 'float',
            'performance_change' => 'float',
            'strengths' => 'array',
            'weaknesses' => 'array',
            'calculated_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
