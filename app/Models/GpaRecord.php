<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GpaRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester_id',
        'gpa',
        'total_credits',
        'earned_credits',
        'academic_standing',
    ];

    protected function casts(): array
    {
        return [
            'gpa' => 'float',
            'total_credits' => 'float',
            'earned_credits' => 'float',
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
