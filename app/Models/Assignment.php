<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'created_by',
        'teacher_id',
        'semester_id',
        'title',
        'description',
        'total_score',
        'due_date',
        'starts_at',
        'ends_at',
        'assignment_type',
        'allow_retakes',
        'max_attempts',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_score' => 'float',
            'due_date' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'allow_retakes' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (Assignment $assignment) {
            $attempts = $assignment->attempts()->get(['file_path']);

            foreach ($attempts as $attempt) {
                if ($attempt->file_path) {
                    Storage::disk('local')->delete($attempt->file_path);
                }
            }

            $assignment->attempts()->delete();
            $assignment->questions()->delete();
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssignmentQuestion::class)
            ->orderBy('position');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(AssignmentAttempt::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}