@extends('layouts.student')

@section('title', 'Grades · SLAS')

@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Grades', 'subtitle' => 'Scores and feedback from your submitted assignments and quizzes.'])
    <div class="row g-3 mb-4">
        @foreach ([['Submitted', $gradeAttempts->count(), 'journal-text'], ['Graded', $gradedCount, 'check2-circle'], ['Awaiting score', $pendingCount, 'clock'], ['Average score', $averageScore !== null ? number_format((float) $averageScore, 2) . '%' : '—', 'graph-up-arrow']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>
    <div class="student-card overflow-hidden">
        <div class="card-header"><h2 class="h5 fw-bold mb-0">Submitted work</h2></div>
        <div class="table-responsive">
            <table class="table student-table align-middle mb-0">
                <thead><tr><th class="ps-4">Assignment / quiz</th><th>Course</th><th>Attempt</th><th>Submitted</th><th class="pe-4">Score</th></tr></thead>
                <tbody>
                    @forelse($gradeAttempts as $attempt)
                        <tr>
                            <td class="ps-4"><strong>{{ $attempt->assignment?->title ?? 'Deleted assignment' }}</strong><small class="d-block text-muted">{{ $attempt->assignment?->assignment_type === 'true_false' ? 'Quiz' : 'Assignment' }}</small></td>
                            <td>{{ $attempt->assignment?->course?->name ?? 'Course unavailable' }}</td>
                            <td>{{ $attempt->attempt_number }}</td>
                            <td>{{ $attempt->submitted_at?->format('M d, Y H:i') ?? '—' }}</td>
                            <td class="pe-4">@if($attempt->score !== null)<strong class="text-primary">{{ number_format((float) $attempt->score, 2) }}%</strong>@else<span class="text-muted">Awaiting score</span>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-5">Your submitted work and grades will appear here.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
