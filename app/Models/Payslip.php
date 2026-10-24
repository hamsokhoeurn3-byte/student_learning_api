<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payslip extends Model
{
    protected $fillable = [
        'payroll_run_id',
        'salary_id',
        'base_salary',
        'total_allowance',
        'total_deduction',
        'net_pay',
        'currency',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'base_salary' => 'decimal:2',
            'total_allowance' => 'decimal:2',
            'total_deduction' => 'decimal:2',
            'net_pay' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function payrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }
}
