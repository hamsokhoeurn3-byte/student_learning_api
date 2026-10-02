<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Assignment extends Model
{
    protected $fillable = [
        'course_id',
        'created_by',
        'title',
        'description',
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
            'due_date' => 'date',
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

    public function questions(): HasMany
    {
        return $this->hasMany(AssignmentQuestion::class)->orderBy('position');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(AssignmentAttempt::class);
    }
}