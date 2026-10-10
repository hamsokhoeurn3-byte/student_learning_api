@extends('layouts.student')

@section('title', 'Reports · SLAS')

@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Reports', 'subtitle' => 'Your personal academic performance summary.', 'action' => ''])

    <div class="row g-3 mb-4">
        @foreach($summary as $card)
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $card['label'] }}</div><div class="stat-value mt-1">{{ $card['value'] }}</div></div><span class="student-icon"><i class="bi bi-{{ $card['icon'] }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="student-card h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Attendance overview</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div><div class="stat-label">Attendance rate</div><div class="stat-value">{{ $attendanceSummary['rate'] !== null ? $attendanceSummary['rate'] . '%' : '—' }}</div></div>
                        <span class="student-icon"><i class="bi bi-calendar-check"></i></span>
                    </div>
                    <div class="student-metric"><span class="small">Present</span><strong>{{ $attendanceSummary['present'] }}</strong></div>
                    <div class="student-metric"><span class="small">Late</span><strong>{{ $attendanceSummary['late'] }}</strong></div>
                    <div class="student-metric"><span class="small">Absent</span><strong>{{ $attendanceSummary['absent'] }}</strong></div>
                    <div class="student-metric"><span class="small">Excused</span><strong>{{ $attendanceSummary['excused'] }}</strong></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="student-card h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">GPA by semester</h5>
                    @forelse($gpaRecords as $record)
                        <div class="student-metric">
                            <span class="small">{{ $record->semester?->name ?? ('Semester ' . $record->semester_id) }}</span>
                            <div class="d-flex align-items-center gap-2" style="width:60%">
                                <div class="student-progress flex-grow-1"><span style="width:{{ min(100, (float) $record->gpa / 4 * 100) }}%"></span></div>
                                <strong class="small">{{ number_format((float) $record->gpa, 2) }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No GPA records yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="student-card">
        <div class="card-header"><h5 class="fw-bold mb-0">Course performance</h5></div>
        <div class="table-responsive">
            <table class="table student-table align-middle mb-0">
                <thead><tr><th class="ps-4">Course</th><th>Total score</th><th>Letter</th><th>Grade point</th><th>Attendance</th><th class="pe-4">Status</th></tr></thead>
                <tbody>
                    @forelse($courseRows as $row)
                        <tr>
                            <td class="ps-4"><strong>{{ $row['name'] }}</strong><small class="d-block text-muted">{{ $row['code'] }}</small></td>
                            <td>@if($row['total_score'] !== null)<strong class="text-primary">{{ $row['total_score'] }}%</strong>@else<span class="text-muted">—</span>@endif</td>
                            <td>{{ $row['letter_grade'] }}</td>
                            <td>{{ $row['grade_point'] }}</td>
                            <td>@if($row['attendance'] !== null){{ $row['attendance'] }}%@else<span class="text-muted">—</span>@endif</td>
                            <td class="pe-4"><span class="student-status bg-secondary-subtle text-secondary">{{ ucfirst($row['status'] ?? 'n/a') }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">No course performance records yet. Grades will appear here once recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection