@extends('layouts.student')

@section('title', 'Quizzes · SLAS')

@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Quizzes', 'subtitle' => 'Practice, track your attempts, and improve one quiz at a time.'])

    <div class="row g-3 mb-4">
        @foreach ([['Available quizzes', '6', 'patch-question'], ['Completed', '14', 'check2-circle'], ['Average score', '86%', 'graph-up-arrow'], ['Due this week', '2', 'calendar-event']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="student-card overflow-hidden">
                <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center"><div><h5 class="fw-bold mb-1">Your quizzes</h5><small class="text-muted">Choose a quiz to continue learning.</small></div><div class="d-flex gap-2"><select class="form-select form-select-sm"><option>All courses</option><option>CS101</option><option>CS102</option></select><button class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel"></i></button></div></div>
                <div class="table-responsive"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Quiz</th><th>Course</th><th>Questions</th><th>Due date</th><th>Status</th><th class="pe-4 text-end">Action</th></tr></thead><tbody>
                    @foreach ([['Arrays Practice Quiz', 'CS101', '10', 'Sep 08', 'Ready', 'Start quiz'], ['Database Fundamentals', 'CS102', '15', 'Sep 10', 'In progress', 'Continue'], ['Graph Algorithms', 'CS101', '20', 'Sep 12', 'Ready', 'Start quiz'], ['Web Accessibility', 'WD201', '12', 'Sep 15', 'Completed', 'View result']] as $quiz)
                    <tr><td class="ps-4"><div class="d-flex align-items-center gap-3"><span class="student-icon" style="width:36px;height:36px;flex-basis:36px;border-radius:10px"><i class="bi bi-patch-question"></i></span><div><strong class="d-block">{{ $quiz[0] }}</strong><small class="text-muted">15–30 minutes</small></div></div></td><td><span class="badge portal-badge">{{ $quiz[1] }}</span></td><td>{{ $quiz[2] }}</td><td>{{ $quiz[3] }}</td><td><span class="student-status {{ $quiz[4] === 'Completed' ? 'bg-success-subtle text-success' : ($quiz[4] === 'In progress' ? 'bg-warning-subtle text-warning' : 'portal-badge') }}">{{ $quiz[4] }}</span></td><td class="pe-4 text-end"><button class="btn btn-sm {{ $quiz[4] === 'Completed' ? 'btn-outline-primary' : 'btn-primary' }}">{{ $quiz[5] }}</button></td></tr>
                    @endforeach
                </tbody></table></div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="student-card mb-4"><div class="card-body"><div class="d-flex justify-content-between align-items-center mb-3"><h5 class="fw-bold mb-0">Performance</h5><span class="badge portal-badge">This semester</span></div>@foreach ([['Graded quizzes', '86%', 86], ['Practice quizzes', '82%', 82], ['Timed quizzes', '88%', 88]] as [$label, $value, $percent])<div class="student-metric"><div class="flex-grow-1"><div class="d-flex justify-content-between small mb-2"><span>{{ $label }}</span><strong>{{ $value }}</strong></div><div class="student-progress"><span style="width:{{ $percent }}%"></span></div></div></div>@endforeach</div></div>
            <div class="student-card"><div class="card-body"><h5 class="fw-bold mb-3">Study tip</h5><div class="d-flex gap-3"><span class="student-icon"><i class="bi bi-lightbulb"></i></span><p class="small text-muted mb-0">Review incorrect answers after each attempt. It is the fastest way to lift your next score.</p></div></div></div>
        </div>
    </div>
</div>
@endsection
