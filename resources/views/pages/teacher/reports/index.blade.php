@extends('layouts.teacher')
@section('title', 'Reports · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Reports</div>
        <h1 class="h2 fw-bold mb-1">Class reports</h1>
        <p class="text-muted mb-0">Enrollment, attendance, and assignment summaries for your assigned classes.</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('teacher.reports.export') }}"><i class="bi bi-filetype-csv me-2"></i>Export CSV</a>
        <a class="btn btn-primary" href="{{ route('teacher.reports.export-pdf') }}"><i class="bi bi-file-earmark-pdf me-2"></i>Export PDF</a>
    </div>
</div>

<div class="row g-3 mb-4">
    @foreach($reportStats as [$label, $value, $icon])
        <div class="col-sm-6 col-xl-3">
            <div class="card portal-card border-0 h-100">
                <div class="card-body p-3 d-flex justify-content-between align-items-start">
                    <div><div class="small text-muted">{{ $label }}</div><div class="h3 fw-bold mb-0 mt-1">{{ $value }}</div></div>
                    <span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3">
        <h2 class="h5 fw-bold mb-1">Assigned class summary</h2>
        <p class="small text-muted mb-0">Attendance rate counts present and late marks; excused marks are excluded.</p>
    </div>
    @if($reportRows->isEmpty())
        <div class="card-body text-center py-5 text-muted">No classes have been assigned to you yet.</div>
    @else
        <div class="table-responsive">
            <table class="table portal-table align-middle mb-0">
                <thead><tr><th class="ps-4">Class</th><th>Code</th><th>Enrolled</th><th>Attendance</th><th>Present or late</th><th>Absent</th><th class="pe-4">Assignments</th></tr></thead>
                <tbody>
                    @foreach($reportRows as $row)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $row['name'] }}</td>
                            <td>{{ $row['code'] }}</td>
                            <td>{{ $row['enrolled'] }} enrolled</td>
                            <td>{{ $row['attendance_rate'] }}</td>
                            <td>{{ $row['attended'] }}</td>
                            <td>{{ $row['absent'] }}</td>
                            <td class="pe-4">{{ $row['assignments'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
