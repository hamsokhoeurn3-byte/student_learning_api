<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'teacher_id',
        'name',
        'code',
        'course_code',
        'course_name',
        'department',
        'description',
        'credit',
        'credits',
        'academic_year',
        'semester',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'status',
    ];

    protected $appends = ['course_code', 'course_name', 'code', 'name', 'credits'];

    protected function casts(): array
    {
        return [
            'credit' => 'float',
            'credits' => 'float',
        ];
    }

    protected function courseCode(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['course_code'] ?? $this->attributes['code'] ?? null,
            set: fn ($value) => [
                'course_code' => $value,
                'code' => $value,
            ]
        );
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['code'] ?? $this->attributes['course_code'] ?? null,
            set: fn ($value) => [
                'code' => $value,
                'course_code' => $value,
            ]
        );
    }

    protected function courseName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['course_name'] ?? $this->attributes['name'] ?? null,
            set: fn ($value) => [
                'course_name' => $value,
                'name' => $value,
            ]
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['name'] ?? $this->attributes['course_name'] ?? null,
            set: fn ($value) => [
                'name' => $value,
                'course_name' => $value,
            ]
        );
    }

    protected function credits(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['credit'] ?? $this->attributes['credits'] ?? null,
            set: fn ($value) => [
                'credit' => $value,
                'credits' => $value,
            ]
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_enrollments')
            ->withPivot([
                'semester_id',
                'enrollment_date',
                'status',
                'final_score',
                'grade',
            ])
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
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

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function performanceRecords(): HasMany
    {
        return $this->hasMany(PerformanceRecord::class);
    }
}