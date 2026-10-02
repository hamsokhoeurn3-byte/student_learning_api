@extends('layouts.teacher')
@section('title', $assignment->title . ' · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('teacher.assignments') }}" class="text-decoration-none">Assignments</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $assignment->title }}</h1>
        <p class="text-muted mb-0">{{ $assignment->course?->name }} ({{ $assignment->course?->code }})</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ route('teacher.assignments') }}">Back to assignments</a>
        @if((int) $assignment->created_by === (int) auth()->id())<a class="btn btn-primary" href="{{ route('teacher.assignments.edit', $assignment) }}"><i class="bi bi-pencil me-2"></i>Edit assignment</a>@endif
    </div>
</div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card portal-card border-0">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Description</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->description ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Assignment type</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->assignment_type === 'true_false' ? 'True / False questions' : 'File upload' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Available from</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->starts_at?->format('M d, Y H:i') ?? 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Due</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->ends_at?->format('M d, Y H:i') ?? $assignment->due_date?->format('M d, Y') ?? 'No due date' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Retakes</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->allow_retakes ? 'Allowed, up to ' . $assignment->max_attempts . ' attempts' : 'Not allowed' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Status</dt><dd class="col-sm-8 col-lg-9 py-2">{{ ucfirst($assignment->status) }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Created by</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->creator?->name ?? 'Not set' }}</dd>
        </dl>
    </div>
</div>
@if($assignment->assignment_type === 'true_false' && $assignment->questions->isNotEmpty())
    <div class="card portal-card border-0 mt-4"><div class="card-body p-4"><h2 class="h5 fw-bold mb-3">Questions and answer key</h2><ol class="mb-0">@foreach($assignment->questions as $question)<li class="mb-3">{{ $question->prompt }} <span class="badge text-bg-light ms-2">{{ $question->correct_answer ? 'True' : 'False' }}</span></li>@endforeach</ol></div></div>
@endif
<div class="card portal-card border-0 mt-4">
    <div class="card-body p-4 pb-3"><h2 class="h5 fw-bold mb-0">Student attempts</h2></div>
    @if($assignment->attempts->isEmpty())
        <div class="card-body text-center py-4 text-muted">No students have submitted this assignment yet.</div>
    @else
        <div class="table-responsive"><table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Student</th><th>Student ID</th><th>Attempt</th><th>Submitted</th><th>Score</th><th class="text-end pe-4">Submission</th></tr></thead>
            <tbody>
                @foreach($assignment->attempts as $attempt)
                    <tr>
                        <td class="ps-4 fw-semibold">{{ $attempt->student?->user?->name ?? trim(($attempt->student?->first_name ?? '') . ' ' . ($attempt->student?->last_name ?? '')) }}</td>
                        <td>{{ $attempt->student?->student_id }}</td>
                        <td>{{ $attempt->attempt_number }}</td>
                        <td>{{ $attempt->submitted_at?->format('M d, Y H:i') }}</td>
                        <td>{{ $attempt->score !== null ? number_format((float) $attempt->score, 0) . '%' : 'Not graded' }}</td>
                        <td class="text-end pe-4">@if($attempt->file_path)<a class="btn btn-sm btn-outline-primary" href="{{ route('teacher.assignments.attempts.download', [$assignment, $attempt]) }}"><i class="bi bi-download me-1"></i>{{ $attempt->file_name }}</a>@elseif($attempt->answers)<span class="text-muted">Quiz answers recorded</span>@else<span class="text-muted">No file</span>@endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table></div>
    @endif
</div>
@if((int) $assignment->created_by === (int) auth()->id())
    <form class="mt-3" method="POST" action="{{ route('teacher.assignments.destroy', $assignment) }}" onsubmit="return confirm('Delete this assignment?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Delete assignment</button>
    </form>
@endif
@endsection