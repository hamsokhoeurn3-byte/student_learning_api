<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id',
        'teacher_id',
        'teacher_code',
        'department_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'position',
        'specialization',
        'status',
    ];

    /**
     * Keeps the pre-existing API response key `teacher_id` (the teacher code).
     * The database column itself is `teacher_code`.
     */
    protected $appends = ['teacher_id'];

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher) {
            if (empty($teacher->teacher_code) && !empty($teacher->attributes['teacher_id'] ?? null)) {
                $teacher->teacher_code = $teacher->attributes['teacher_id'];
                unset($teacher->attributes['teacher_id']);
            }
            if (empty($teacher->teacher_code)) {
                $nextId = (static::withTrashed()->max('id') ?? 0) + 1;
                $teacher->teacher_code = 'TCH' . str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function setTeacherIdAttribute($value): void
    {
        $this->attributes['teacher_code'] = $value;
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    protected function teacherId(): Attribute
    {
        return Attribute::get(fn () => $this->teacher_code);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}