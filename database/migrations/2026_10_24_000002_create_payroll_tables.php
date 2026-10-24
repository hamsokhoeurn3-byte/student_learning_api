<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Payroll panel tables: staff salary profiles, one-off allowances and
 * deductions, and the monthly payroll runs that snapshot what each person
 * was paid. Allowance/deduction lines attach to a run so payslips stay
 * immutable after the run is finalized.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            // Points at the login account that owns this salary profile.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('staffable_id');
            $table->string('staffable_type'); // App\Models\Teacher / App\Models\Admin / App\Models\Student
            $table->decimal('base_salary', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method', 30)->default('bank_transfer'); // bank_transfer | cash | cheque
            $table->string('bank_account', 60)->nullable();
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->string('status', 20)->default('active'); // active | inactive
            $table->timestamps();

            $table->index(['staffable_type', 'staffable_id'], 'salaries_staffable_index');
        });

        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120); // e.g. "October 2026 payroll"
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_gross', 14, 2)->default(0);
            $table->decimal('total_deduction', 14, 2)->default(0);
            $table->decimal('total_net', 14, 2)->default(0);
            $table->unsignedInteger('employee_count')->default(0);
            $table->string('status', 20)->default('draft'); // draft | approved | paid
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['period_start', 'period_end'], 'payroll_runs_period_unique');
        });

        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->nullable()->constrained('payroll_runs')->cascadeOnDelete();
            $table->foreignId('salary_id')->constrained('salaries')->cascadeOnDelete();
            $table->string('name', 120); // transport, housing, seniority...
            $table->decimal('amount', 12, 2);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('payroll_run_id', 'allowances_run_index');
        });

        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->nullable()->constrained('payroll_runs')->cascadeOnDelete();
            $table->foreignId('salary_id')->constrained('salaries')->cascadeOnDelete();
            $table->string('name', 120); // tax, social security, advance...
            $table->decimal('amount', 12, 2);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('payroll_run_id', 'deductions_run_index');
        });

        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->constrained('payroll_runs')->cascadeOnDelete();
            $table->foreignId('salary_id')->constrained('salaries')->cascadeOnDelete();
            $table->decimal('base_salary', 12, 2);
            $table->decimal('total_allowance', 12, 2)->default(0);
            $table->decimal('total_deduction', 12, 2)->default(0);
            $table->decimal('net_pay', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status', 20)->default('pending'); // pending | paid
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['payroll_run_id', 'salary_id'], 'payslips_run_salary_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
        Schema::dropIfExists('deductions');
        Schema::dropIfExists('allowances');
        Schema::dropIfExists('payroll_runs');
        Schema::dropIfExists('salaries');
    }
};
