<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Salary extends Model
{
    protected $fillable = [
        'user_id',
        'staffable_id',
        'staffable_type',
        'base_salary',
        'currency',
        'payment_method',
        'bank_account',
        'effective_from',
        'effective_to',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'effective_from' => 'date',
            'effective_to' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** The Teacher / Admin / Student record this salary profile points at. */
    public function staffable(): MorphTo
    {
        return $this->morphTo();
    }

    public function allowances(): HasMany
    {
        return $this->hasMany(Allowance::class);
    }

    public function deductions(): HasMany
    {
        return $this->hasMany(Deduction::class);
    }

    public function payslips(): HasMany
    {
        return $this->hasMany(Payslip::class);
    }
}
