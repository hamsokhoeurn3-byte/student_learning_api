@extends('layouts.teacher')
@section('title', 'Teacher Dashboard · SLAS')
@section('content')
@php
    $weekStart = now()->startOfWeek();
    $activity = collect(range(0, 6))->map(function ($offset) use ($weekStart, $submissionsByDay) {
        $day = $weekStart->copy()->addDays($offset);

        return [
            'label' => $day->format('D'),
            'count' => (int) ($submissionsByDay[$day->toDateString()] ?? 0),
        ];
    });
    $maxActivity = max($activity->pluck('count')->all() ?: [0]);
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Overview</div>
        <h1 class="h2 fw-bold mb-1">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-muted mb-0">Your classes, student submissions, and upcoming deadlines.</p>
    </div>
    <a class="btn btn-primary rounded-3 px-3" href="{{ route('teacher.courses') }}"><i class="bi bi-book me-2"></i>View my courses</a>
</div>

<div class="row g-3 mb-4">
    @foreach($dashboardStats as [$label, $value, $icon])
        <div class="col-sm-6 col-xl-3"><div class="card portal-card border-0 h-100"><div class="card-body p-3 d-flex justify-content-between align-items-start"><div><div class="small text-muted mb-2">{{ $label }}</div><div class="h3 fw-bold mb-1">{{ $value }}</div><small class="text-success">Assigned to you</small></div><div class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></div></div></div></div>
    @endforeach
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-7">
        <div class="card portal-card border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-4">
                    <div><h2 class="h5 fw-bold mb-1">Submissions this week</h2><small class="text-muted">Student work submitted to your courses</small></div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('teacher.grades') }}">Review grades</a>
                </div>
                @if($activity->sum('count') > 0)
                    <div class="d-flex justify-content-between gap-2" style="height:190px">
                        @foreach($activity as $day)
                            <div class="d-flex flex-column align-items-center flex-fill">
                                <div class="d-flex align-items-end justify-content-center w-100" style="height:150px">
                                    <div class="rounded-top bg-primary" style="height: {{ max(4, round($day['count'] / $maxActivity * 140)) }}px; width:20px" title="{{ $day['count'] }} submissions"></div>
                                </div>
                                <small class="text-muted d-block mt-2">{{ $day['label'] }}</small>
                                <small class="text-muted">{{ $day['count'] }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center text-muted text-center" style="height:190px">No submissions this week.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card portal-card border-0 h-100">
            <div class="card-body p-4 pb-3 d-flex justify-content-between align-items-start">
                <div><h2 class="h5 fw-bold mb-1">Needs grading</h2><p class="small text-muted mb-0">Submissions without a score</p></div>
                <a href="{{ route('teacher.grades') }}" class="small text-decoration-none">All grades</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($pendingAttempts as $attempt)
                    <a class="list-group-item list-group-item-action border-0 px-4 py-3" href="{{ route('teacher.assignments.show', $attempt->assignment) }}">
                        <div class="d-flex justify-content-between gap-3">
                            <div class="min-w-0"><strong class="d-block text-truncate">{{ $attempt->assignment?->title }}</strong><small class="text-muted">{{ $attempt->student?->user?->name ?? 'Student' }} · {{ $attempt->assignment?->course?->code }}</small></div>
                            <small class="text-muted text-nowrap">{{ $attempt->submitted_at?->diffForHumans() }}</small>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5">Nothing needs grading.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3 d-flex justify-content-between align-items-center gap-3">
        <div><h2 class="h5 fw-bold mb-1">Upcoming deadlines</h2><p class="small text-muted mb-0">Published assignments in your classes</p></div>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('teacher.assignments') }}">All assignments</a>
    </div>
    <div class="table-responsive">
        <table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Assignment</th><th>Course</th><th>Due</th><th class="pe-4">Status</th></tr></thead>
            <tbody>
                @forelse($upcomingAssignments as $assignment)
                    <tr><td class="ps-4 fw-semibold">{{ $assignment->title }}</td><td>{{ $assignment->course?->name }} <span class="text-muted">({{ $assignment->course?->code }})</span></td><td>{{ $assignment->ends_at?->format('M d, Y H:i') ?? $assignment->due_date?->format('M d, Y') }}</td><td class="pe-4"><span class="badge portal-badge rounded-pill">{{ ucfirst($assignment->status) }}</span></td></tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No upcoming deadlines.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
