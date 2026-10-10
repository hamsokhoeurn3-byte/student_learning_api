@extends('layouts.student')

@section('title', 'Analytics · SLAS')

@section('content')
@php
    $gpaLabel = $overallGpa !== null ? number_format($overallGpa, 2) : '—';
    $attendanceLabel = $attendanceRate !== null ? $attendanceRate . '%' : '—';
    $assignmentsLabel = $assignmentsDone . ' / ' . $assignmentsTotal;
    $quizLabel = $quizAverage !== null ? round($quizAverage) . '%' : '—';
    $maxGpa = $gpaProgression->max('gpa') ?: 4.0;
@endphp
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Academic Analytics', 'subtitle' => 'Understand your learning progress and focus your next study session.', 'action' => ''])

    <div class="row g-3 mb-4">
        @foreach ([['Overall GPA', $gpaLabel, 'graph-up-arrow'], ['Attendance rate', $attendanceLabel, 'calendar-check'], ['Assignments', $assignmentsLabel, 'journal-check'], ['Quiz average', $quizLabel, 'patch-question']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div><small class="text-success">Live data</small></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="student-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><h5 class="fw-bold mb-1">GPA progression</h5><small class="text-muted">Semester trend</small></div>
                    <span class="badge portal-badge">Scale 4.00</span>
                </div>
                <div class="card-body">
                    @if($gpaProgression->isNotEmpty())
                        <div class="d-flex align-items-end justify-content-between gap-2" style="height:195px">
                            @foreach($gpaProgression as $point)
                                @php $height = $maxGpa > 0 ? max(6, (int) round($point['gpa'] / $maxGpa * 100)) : 6; @endphp
                                <div class="text-center flex-fill h-100 d-flex flex-column justify-content-end">
                                    <small class="fw-bold text-primary mb-2">{{ number_format($point['gpa'], 2) }}</small>
                                    <div class="mx-auto rounded-top" style="height:{{ $height }}%;max-height:145px;width:26px;background:linear-gradient(180deg,#a78bfa,#6d28d9)"></div>
                                    <small class="text-muted mt-2">{{ $point['label'] }}</small>
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-primary-subtle rounded-3 p-3 mt-4 d-flex align-items-center gap-2 small"><i class="bi bi-stars text-primary fs-5"></i><span><strong>Current GPA {{ $gpaLabel }}.</strong> Based on your recorded semester results.</span></div>
                    @else
                        <p class="text-muted small mb-0">GPA progression will appear once your semester results are recorded.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="student-card h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-1">Performance breakdown</h5>
                    <p class="small text-muted mb-3">Your weighted categories</p>
                    @foreach($breakdown as $row)
                        <div class="student-metric">
                            <span class="small">{{ $row['label'] }}</span>
                            <div class="d-flex align-items-center gap-2" style="width:58%">
                                <div class="student-progress flex-grow-1"><span style="width:{{ $row['value'] ?? 0 }}%"></span></div>
                                <strong class="small">{{ $row['value'] !== null ? $row['value'] . '%' : '—' }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="student-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3"><h5 class="fw-bold mb-0">Subject performance</h5><a href="{{ route('student.grades') }}" class="small">View all</a></div>
                    @forelse($subjectPerformance as $subject)
                        <div class="student-metric">
                            <span class="small fw-semibold">{{ $subject['name'] }}</span>
                            <div class="d-flex align-items-center gap-2" style="width:55%">
                                <div class="student-progress flex-grow-1"><span style="width:{{ $subject['score'] }}%"></span></div>
                                <strong class="small">{{ $subject['score'] }}%</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No graded subjects yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="student-card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Personal insights</h5>
                    <div class="student-timeline">
                        @foreach($insights as $insight)
                            <div class="student-timeline-item"><div class="small">{{ $insight }}</div></div>
                        @endforeach
                    </div>
                    <a href="{{ route('student.reports') }}" class="btn btn-primary w-100 mt-3">View full report <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection