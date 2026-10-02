@extends('layouts.student')
@section('title', 'Assignment Result · SLAS')
@section('content')
<div class="student-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><div class="small text-primary fw-semibold mb-1"><a href="{{ route('student.assignments') }}">Assignments</a> <span class="text-muted mx-1">/</span> Result</div><h1 class="h2 fw-bold mb-1">{{ $assignment->title }}</h1><p class="text-muted mb-0">{{ $assignment->course?->name }} · Attempt {{ $attempt->attempt_number }}</p></div>
        <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary">Back to assignments</a>
    </div>
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    <div class="student-card p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div><div class="small text-muted">Submitted</div><strong>{{ $attempt->submitted_at?->format('M d, Y H:i') }}</strong></div>
            @if($assignment->assignment_type === 'true_false')<div class="text-end"><div class="small text-muted">Score</div><div class="h2 fw-bold mb-0">{{ number_format((float) $attempt->score, 0) }}%</div></div>
            @else<div class="text-end"><div class="small text-muted">File submitted</div><strong>{{ $attempt->file_name }}</strong></div>@endif
        </div>
        @if($attempt->answers)
            @foreach($attempt->answers as $answer)
                <div class="border-top py-3">
                    <div class="fw-semibold">{{ $answer['prompt'] }}</div>
                    <div>Your answer: {{ ucfirst($answer['answer']) }} <span class="{{ $answer['is_correct'] ? 'text-success' : 'text-danger' }}">{{ $answer['is_correct'] ? 'Correct' : 'Incorrect' }}</span></div>
                </div>
            @endforeach
        @endif
        @if($assignment->allow_retakes && $attempt->attempt_number < $assignment->max_attempts && (!$assignment->ends_at || now()->lte($assignment->ends_at)))
            <a class="btn btn-primary mt-3" href="{{ route('student.assignments.submit', $assignment) }}">Retake assignment</a>
        @endif
    </div>
</div>
@endsection