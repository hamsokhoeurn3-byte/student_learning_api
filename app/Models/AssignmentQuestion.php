<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentQuestion extends Model
{
    protected $fillable = [
        'assignment_id',
        'prompt',
        'correct_answer',
        'position',
    ];

    protected function casts(): array
    {
        return ['correct_answer' => 'boolean'];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}