<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\PayrollRun;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function dashboard()
    {
        $salaryQuery = Salary::where('status', 'active');

        return view('pages.payroll.dashboard', [
            'dashboardStats' => [
                ['Employees on payroll', number_format($salaryQuery->count()), 'people'],
                ['Monthly payroll', '$' . number_format((float) $salaryQuery->sum('base_salary'), 2), 'cash-coin'],
                ['Payroll runs', number_format(PayrollRun::count()), 'calculator'],
                ['Pending payslips', number_format(
                    \App\Models\Payslip::where('status', 'pending')->count()
                ), 'receipt'],
            ],
            'activityByDay' => [],
            'latestRuns' => PayrollRun::with('createdBy')->latest('period_end')->take(5)->get(),
        ]);
    }

    public function employees(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string|max:255',
        ]);
        $term = trim($validated['term'] ?? '');

        $query = Salary::with(['user', 'staffable']);

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->whereHas('user', fn($user) => $user->where('name', 'like', "%{$term}%"))
                    ->orWhere('bank_account', 'like', "%{$term}%");
            });
        }

        $salaries = $query->latest()->paginate(10);
        $managementRows = $salaries->through(fn(Salary $salary) => [
            $salary->user?->name ?? 'Unknown',
            $salary->staffable_type ? class_basename($salary->staffable_type) : '—',
            '$' . number_format((float) $salary->base_salary, 2),
            ucfirst($salary->status),
            $salary->id,
        ]);

        return view('pages.payroll.employees.index', [
            'managementStats' => [
                ['Salary profiles', number_format(Salary::count()), 'collection'],
                ['Active', number_format(Salary::where('status', 'active')->count()), 'graph-up-arrow'],
                ['Inactive', number_format(Salary::where('status', 'inactive')->count()), 'clock'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $salaries->total(),
            'term' => $term,
        ]);
    }

    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'staffable_type' => 'required|in:App\Models\Teacher,App\Models\Admin,App\Models\Student',
            'staffable_id' => 'required|integer|min:1',
            'base_salary' => 'required|numeric|min:0|max:999999999',
            'currency' => 'required|in:USD,KHR',
            'payment_method' => 'required|in:bank_transfer,cash,cheque',
            'bank_account' => 'nullable|string|max:60',
            'effective_from' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $staffable = $validated['staffable_type']::findOrFail($validated['staffable_id']);
        $user = $staffable->user ?? null;
        abort_if(!$user, 422, 'The selected record has no linked login account.');

        Salary::create($validated + ['user_id' => $user->id]);

        return redirect()->route('payroll.employees')->with('status', 'Salary profile created successfully.');
    }

    public function destroyEmployee(Salary $salary)
    {
        $salary->delete();

        return redirect()->route('payroll.employees')->with('status', 'Salary profile deleted successfully.');
    }

    public function salaries(Request $request)
    {
        $salaries = Salary::with(['user', 'allowances', 'deductions'])
            ->where('status', 'active')
            ->latest('effective_from')
            ->paginate(10);

        $managementRows = $salaries->through(fn(Salary $salary) => [
            $salary->user?->name ?? 'Unknown',
            '$' . number_format((float) $salary->base_salary, 2),
            '$' . number_format((float) $salary->allowances->sum('amount'), 2),
            '$' . number_format((float) $salary->deductions->sum('amount'), 2),
            $salary->id,
        ]);

        return view('pages.payroll.salaries.index', [
            'managementStats' => [
                ['Active salaries', number_format($salaries->total()), 'cash-coin'],
                ['Base total', '$' . number_format((float) Salary::where('status', 'active')->sum('base_salary'), 2), 'calculator'],
                ['Allowance lines', number_format(Allowance::count()), 'plus-square'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $salaries->total(),
        ]);
    }

    public function runs()
    {
        $runs = PayrollRun::with('createdBy')->latest('period_end')->paginate(10);
        $managementRows = $runs->through(fn(PayrollRun $run) => [
            $run->name,
            $run->period_start->format('M d, Y') . ' – ' . $run->period_end->format('M d, Y'),
            number_format((int) $run->employee_count) . ' employees',
            ucfirst($run->status),
            $run->id,
        ]);

        return view('pages.payroll.runs.index', [
            'managementStats' => [
                ['Total runs', number_format(PayrollRun::count()), 'calculator'],
                ['Draft runs', number_format(PayrollRun::where('status', 'draft')->count()), 'pencil-square'],
                ['Paid runs', number_format(PayrollRun::where('status', 'paid')->count()), 'check2-circle'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $runs->total(),
            'latestRuns' => $runs,
        ]);
    }

    public function storeRun(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        $run = PayrollRun::create($validated + [
            'created_by' => Auth::id(),
            'status' => 'draft',
        ]);

        $this->recalculateRun($run);

        return redirect()->route('payroll.runs')->with('status', 'Payroll run created successfully.');
    }

    public function showRun(PayrollRun $run)
    {
        $run->load(['payslips.salary.user']);

        return view('pages.payroll.runs.show', ['run' => $run]);
    }

    public function approveRun(PayrollRun $run)
    {
        $this->recalculateRun($run);
        $run->update(['status' => 'approved']);

        return redirect()->route('payroll.runs.show', $run)->with('status', 'Payroll run approved.');
    }

    public function markRunPaid(PayrollRun $run)
    {
        $run->payslips()->update(['status' => 'paid', 'paid_at' => now()]);
        $run->update(['status' => 'paid']);

        return redirect()->route('payroll.runs.show', $run)->with('status', 'Payroll run marked as paid.');
    }

    public function allowances(Request $request)
    {
        $allowances = Allowance::with(['salary.user', 'payrollRun'])->latest()->paginate(10);
        $managementRows = $allowances->through(fn(Allowance $allowance) => [
            $allowance->name,
            $allowance->salary?->user?->name ?? 'Unknown',
            '$' . number_format((float) $allowance->amount, 2),
            $allowance->payrollRun?->name ?? 'One-off',
            $allowance->id,
        ]);

        return view('pages.payroll.allowances.index', [
            'managementStats' => [
                ['Allowance lines', number_format(Allowance::count()), 'plus-square'],
                ['Attached to runs', number_format(Allowance::whereNotNull('payroll_run_id')->count()), 'link-45deg'],
                ['Total amount', '$' . number_format((float) Allowance::sum('amount'), 2), 'cash-coin'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $allowances->total(),
            'salaries' => Salary::with('user')->where('status', 'active')->orderBy('id')->get(),
        ]);
    }

    public function storeAllowance(Request $request)
    {
        $validated = $request->validate([
            'salary_id' => 'required|exists:salaries,id',
            'name' => 'required|string|max:120',
            'amount' => 'required|numeric|min:0|max:999999999',
            'note' => 'nullable|string|max:2000',
        ]);

        Allowance::create($validated + ['payroll_run_id' => null]);

        return redirect()->route('payroll.allowances')->with('status', 'Allowance added successfully.');
    }

    public function destroyAllowance(Allowance $allowance)
    {
        $allowance->delete();

        return redirect()->route('payroll.allowances')->with('status', 'Allowance deleted successfully.');
    }

    public function deductions(Request $request)
    {
        $deductions = Deduction::with(['salary.user', 'payrollRun'])->latest()->paginate(10);
        $managementRows = $deductions->through(fn(Deduction $deduction) => [
            $deduction->name,
            $deduction->salary?->user?->name ?? 'Unknown',
            '$' . number_format((float) $deduction->amount, 2),
            $deduction->payrollRun?->name ?? 'One-off',
            $deduction->id,
        ]);

        return view('pages.payroll.deductions.index', [
            'managementStats' => [
                ['Deduction lines', number_format(Deduction::count()), 'dash-square'],
                ['Attached to runs', number_format(Deduction::whereNotNull('payroll_run_id')->count()), 'link-45deg'],
                ['Total amount', '$' . number_format((float) Deduction::sum('amount'), 2), 'cash-coin'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $deductions->total(),
            'salaries' => Salary::with('user')->where('status', 'active')->orderBy('id')->get(),
        ]);
    }

    public function storeDeduction(Request $request)
    {
        $validated = $request->validate([
            'salary_id' => 'required|exists:salaries,id',
            'name' => 'required|string|max:120',
            'amount' => 'required|numeric|min:0|max:999999999',
            'note' => 'nullable|string|max:2000',
        ]);

        Deduction::create($validated + ['payroll_run_id' => null]);

        return redirect()->route('payroll.deductions')->with('status', 'Deduction added successfully.');
    }

    public function destroyDeduction(Deduction $deduction)
    {
        $deduction->delete();

        return redirect()->route('payroll.deductions')->with('status', 'Deduction deleted successfully.');
    }

    public function payslips()
    {
        $payslips = \App\Models\Payslip::with(['salary.user', 'payrollRun'])
            ->latest('id')
            ->paginate(10);
        $managementRows = $payslips->through(fn($payslip) => [
            $payslip->salary?->user?->name ?? 'Unknown',
            $payslip->payrollRun?->name ?? '—',
            '$' . number_format((float) $payslip->net_pay, 2),
            ucfirst($payslip->status),
            $payslip->id,
        ]);

        return view('pages.payroll.payslips.index', [
            'managementStats' => [
                ['Payslips', number_format($payslips->total()), 'receipt'],
                ['Paid', number_format(\App\Models\Payslip::where('status', 'paid')->count()), 'check2-circle'],
                ['Pending', number_format(\App\Models\Payslip::where('status', 'pending')->count()), 'clock'],
            ],
            'managementRows' => $managementRows,
            'managementCount' => $payslips->total(),
        ]);
    }

    public function reports()
    {
        $salaryByRole = Salary::query()
            ->where('status', 'active')
            ->get()
            ->groupBy(fn(Salary $salary) => $salary->staffable_type ? class_basename($salary->staffable_type) : 'Other')
            ->map(fn($group) => [
                'count' => $group->count(),
                'total' => (float) $group->sum('base_salary'),
            ]);

        return view('pages.payroll.reports.index', [
            'managementStats' => [
                ['Employees', number_format(Salary::where('status', 'active')->count()), 'people'],
                ['Monthly base', '$' . number_format((float) Salary::where('status', 'active')->sum('base_salary'), 2), 'cash-coin'],
                ['Runs paid', number_format(PayrollRun::where('status', 'paid')->count()), 'check2-circle'],
            ],
            'managementRows' => $salaryByRole,
        ]);
    }

    protected function recalculateRun(PayrollRun $run): void
    {
        DB::transaction(function () use ($run) {
            $salaries = Salary::with(['allowances', 'deductions'])->where('status', 'active')->get();
            $gross = 0;
            $net = 0;
            $deducted = 0;

            foreach ($salaries as $salary) {
                $allowanceTotal = (float) $salary->allowances->sum('amount');
                $deductionTotal = (float) $salary->deductions->sum('amount');
                $base = (float) $salary->base_salary;
                $netPay = $base + $allowanceTotal - $deductionTotal;

                $run->payslips()->updateOrCreate(
                    ['salary_id' => $salary->id],
                    [
                        'base_salary' => $base,
                        'total_allowance' => $allowanceTotal,
                        'total_deduction' => $deductionTotal,
                        'net_pay' => $netPay,
                        'currency' => $salary->currency,
                    ]
                );

                $gross += $base + $allowanceTotal;
                $deducted += $deductionTotal;
                $net += $netPay;
            }

            $run->update([
                'total_gross' => $gross,
                'total_deduction' => $deducted,
                'total_net' => $net,
                'employee_count' => $salaries->count(),
            ]);
        });
    }
}
