@extends('layouts.payroll')
@section('title', 'Payroll Run · Payroll · SLAS')
@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="small text-primary fw-semibold mb-1">Payroll Runs <span class="text-muted mx-1">/</span> {{ $run->name }}</div>
            <h1 class="h2 fw-bold mb-1">{{ $run->name }}</h1>
            <p class="text-muted mb-0">{{ $run->period_start->format('M d, Y') }} – {{ $run->period_end->format('M d, Y') }} · {{ ucfirst($run->status) }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @if ($run->status === 'draft')
                <form method="POST" action="{{ route('payroll.runs.approve', $run) }}">
                    @csrf
                    <button class="btn btn-primary rounded-3 px-3"><i class="bi bi-check2-circle me-2"></i>Approve run</button>
                </form>
            @elseif ($run->status === 'approved')
                <form method="POST" action="{{ route('payroll.runs.mark-paid', $run) }}">
                    @csrf
                    <button class="btn btn-success rounded-3 px-3"><i class="bi bi-cash-coin me-2"></i>Mark as paid</button>
                </form>
            @endif
            <a href="{{ route('payroll.runs') }}" class="btn btn-outline-primary rounded-3 px-3"><i class="bi bi-arrow-left me-2"></i>Back</a>
        </div>
    </div>

    @if (session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card portal-card border-0"><div class="card-body p-3 d-flex justify-content-between"><div><div class="small text-muted">Total gross</div><div class="h3 fw-bold mb-0 mt-1">${{ number_format($run->total_gross, 2) }}</div></div><div class="portal-stat-icon"><i class="bi bi-cash-stack"></i></div></div></div></div>
        <div class="col-md-4"><div class="card portal-card border-0"><div class="card-body p-3 d-flex justify-content-between"><div><div class="small text-muted">Total deductions</div><div class="h3 fw-bold mb-0 mt-1">${{ number_format($run->total_deduction, 2) }}</div></div><div class="portal-stat-icon"><i class="bi bi-dash-square"></i></div></div></div></div>
        <div class="col-md-4"><div class="card portal-card border-0"><div class="card-body p-3 d-flex justify-content-between"><div><div class="small text-muted">Total net</div><div class="h3 fw-bold mb-0 mt-1">${{ number_format($run->total_net, 2) }}</div></div><div class="portal-stat-icon"><i class="bi bi-cash-coin"></i></div></div></div></div>
    </div>

    <div class="card portal-card border-0">
        <div class="card-body p-4 pb-3">
            <h5 class="fw-bold mb-0">Payslips in this run ({{ number_format($run->employee_count) }})</h5>
        </div>
        <div class="table-responsive">
            <table class="table portal-table align-middle mb-0">
                <thead><tr><th class="ps-4">Employee</th><th>Base salary</th><th>Allowances</th><th>Deductions</th><th>Net pay</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($run->payslips as $payslip)
                        <tr>
                            <td class="ps-4 py-3"><strong>{{ $payslip->salary?->user?->name ?? 'Unknown' }}</strong></td>
                            <td>${{ number_format($payslip->base_salary, 2) }}</td>
                            <td>${{ number_format($payslip->total_allowance, 2) }}</td>
                            <td>${{ number_format($payslip->total_deduction, 2) }}</td>
                            <td><strong>${{ number_format($payslip->net_pay, 2) }}</strong></td>
                            <td><span class="badge portal-badge rounded-pill">{{ ucfirst($payslip->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">No payslips yet. Approve the run to generate them.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
