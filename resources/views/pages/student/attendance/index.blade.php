@extends('layouts.student')

@section('title', 'Attendance · SLAS')

@section('content')
@php
    $rateLabel = $summary['rate'] !== null ? $summary['rate'] . '%' : '—';
    $statusStyles = [
        'present' => 'bg-success-subtle text-success',
        'late' => 'bg-warning-subtle text-warning',
        'absent' => 'bg-danger-subtle text-danger',
        'excused' => 'bg-secondary-subtle text-secondary',
    ];
    $statusIcons = [
        'present' => 'check-circle',
        'late' => 'clock',
        'absent' => 'x-circle',
        'excused' => 'dash-circle',
    ];
@endphp
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Attendance', 'subtitle' => 'Track your attendance and stay on target this semester.', 'action' => ''])

    <div class="row g-3 mb-4">
        @foreach ([['Attendance rate', $rateLabel, 'calendar-check'], ['Present', $summary['present'] . ' days', 'check2-circle'], ['Late', $summary['late'] . ' days', 'clock'], ['Absent', $summary['absent'] . ' days', 'calendar-x']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div><small class="{{ $label === 'Absent' ? 'text-danger' : 'text-success' }}">{{ $label === 'Attendance rate' ? 'Target 85%' : 'This semester' }}</small></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="student-card overflow-hidden">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div><h5 class="fw-bold mb-1">Attendance records</h5><small class="text-muted">Your latest class attendance.</small></div>
                </div>
                <div class="table-responsive">
                    <table class="table student-table align-middle mb-0">
                        <thead><tr><th class="ps-4">Date</th><th>Course</th><th>Class time</th><th>Status</th><th class="pe-4">Note</th></tr></thead>
                        <tbody>
                            @forelse($records as $record)
                                @php
                                    $status = strtolower($record->status ?? '');
                                    $badge = $statusStyles[$status] ?? 'bg-secondary-subtle text-secondary';
                                    $icon = $statusIcons[$status] ?? 'circle';
                                @endphp
                                <tr>
                                    <td class="ps-4"><strong>{{ $record->attendance_date?->format('M d, Y') ?? '—' }}</strong></td>
                                    <td><span class="small">{{ $record->course?->name ?? 'Course unavailable' }}{{ $record->course?->code ? ' · ' . $record->course->code : '' }}</span></td>
                                    <td>{{ $record->start_time ? substr($record->start_time, 0, 5) : '—' }}</td>
                                    <td><span class="student-status {{ $badge }}"><i class="bi bi-{{ $icon }} me-1"></i>{{ ucfirst($status) }}</span></td>
                                    <td class="pe-4 text-muted small">{{ $record->notes ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-5">No attendance records yet. Your teachers will mark attendance here.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="student-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="fw-bold mb-0">By subject</h5><a href="{{ route('student.reports') }}" class="small">View all</a></div>
                    @forelse($bySubject as $subject)
                        <div class="student-metric">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between small mb-2"><span>{{ $subject['subject'] }}</span><strong>{{ $subject['score'] }}%</strong></div>
                                <div class="student-progress"><span style="width:{{ $subject['score'] }}%"></span></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No subject attendance data yet.</p>
                    @endforelse
                </div>
            </div>
            <div class="student-card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Attendance trend</h5>
                    @if($weeklyTrend->isNotEmpty())
                        <div class="d-flex align-items-end justify-content-between" style="height:100px">
                            @foreach($weeklyTrend as $i => $score)
                                <div class="text-center"><div class="rounded-top" style="height:{{ max(4, (int) $score) }}px;width:34px;background:linear-gradient(#a78bfa,#6d28d9)"></div><small class="d-block text-muted mt-2">W{{ $i + 1 }}</small></div>
                            @endforeach
                        </div>
                        @if($summary['rate'] !== null && $summary['rate'] >= 85)
                            <div class="bg-success-subtle text-success rounded-3 p-2 small mt-4"><i class="bi bi-check-circle me-1"></i> You are above the 85% attendance target.</div>
                        @elseif($summary['rate'] !== null)
                            <div class="bg-warning-subtle text-warning rounded-3 p-2 small mt-4"><i class="bi bi-exclamation-circle me-1"></i> You are below the 85% attendance target.</div>
                        @endif
                    @else
                        <p class="text-muted small mb-0">Attendance trend will appear once records are available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection