@extends('layouts.teacher')
@section('title', 'Grades · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Grades</div>
        <h1 class="h2 fw-bold mb-1">Grades</h1>
        <p class="text-muted mb-0">Review student submissions and enter scores for your assigned courses.</p>
    </div>
</div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<div class="row g-3 mb-4">
    @foreach([['Submissions', $submittedCount, 'journal-text'], ['Graded', $gradedCount, 'check2-circle'], ['Awaiting score', $pendingCount, 'clock']] as [$label, $value, $icon])
        <div class="col-md-4"><div class="card portal-card border-0 h-100"><div class="card-body p-3 d-flex justify-content-between align-items-center"><div><div class="small text-muted">{{ $label }}</div><div class="h3 fw-bold mb-0 mt-1">{{ number_format($value) }}</div></div><span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div></div>
    @endforeach
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3"><h2 class="h5 fw-bold mb-0">Student submissions</h2></div>
    <div class="table-responsive">
        <table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Student</th><th>Assignment / quiz</th><th>Course</th><th>Submitted</th><th>Current score</th><th class="pe-4">Enter score</th></tr></thead>
            <tbody>
                @forelse($attempts as $attempt)
                    <tr>
                        <td class="ps-4"><strong>{{ $attempt->student?->user?->name ?? trim(($attempt->student?->first_name ?? '') . ' ' . ($attempt->student?->last_name ?? '')) }}</strong><small class="d-block text-muted">{{ $attempt->student?->student_id }}</small></td>
                        <td><a href="{{ route('teacher.assignments.show', $attempt->assignment) }}" class="text-decoration-none fw-semibold">{{ $attempt->assignment?->title }}</a><small class="d-block text-muted">{{ $attempt->assignment?->assignment_type === 'true_false' ? 'Quiz' : 'Assignment' }} · Attempt {{ $attempt->attempt_number }}</small></td>
                        <td>{{ $attempt->assignment?->course?->code }}</td>
                        <td>{{ $attempt->submitted_at?->format('M d, Y H:i') }}</td>
                        <td>
                            @if($attempt->score !== null)
                                <strong>{{ number_format((float) $attempt->score, 2) }}%</strong>
                                <small class="d-block text-muted">{{ $attempt->graded_at ? 'Updated ' . $attempt->graded_at->format('M d, Y') : 'Auto-scored' }}</small>
                            @else
                                <span class="text-muted">Pending</span>
                            @endif
                        </td>
                        <td class="pe-4">
                            <form method="POST" action="{{ route('teacher.grades.update', $attempt) }}" class="d-flex gap-2 align-items-center">
                                @csrf
                                @method('PUT')
                                <input class="form-control form-control-sm" style="width: 105px" type="number" name="score" min="0" max="100" step="0.01" value="{{ old('score', $attempt->score) }}" placeholder="0-100" aria-label="Score for {{ $attempt->student?->user?->name }}" required>
                                <button class="btn btn-sm btn-primary" type="submit">{{ $attempt->score === null ? 'Save' : 'Update' }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No student submissions to grade yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($attempts->hasPages())<div class="px-4 pb-3">{{ $attempts->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
