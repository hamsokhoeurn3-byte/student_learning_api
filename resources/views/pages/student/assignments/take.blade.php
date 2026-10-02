@extends('layouts.student')
@section('title', $assignment->title . ' · SLAS')
@section('content')
<div class="student-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="small text-primary fw-semibold mb-1"><a href="{{ route('student.assignments') }}">Assignments</a> <span class="text-muted mx-1">/</span> Submit</div>
            <h1 class="h2 fw-bold mb-1">{{ $assignment->title }}</h1>
            <p class="text-muted mb-0">{{ $assignment->course?->name }} ({{ $assignment->course?->code }})</p>
        </div>
        <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary">Back to assignments</a>
    </div>

    @if($availabilityMessage)<div class="alert alert-info">{{ $availabilityMessage }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="student-card p-4 mb-4">
        <h2 class="h5 fw-bold">Instructions</h2>
        <p class="mb-3">{{ $assignment->description ?: 'No additional instructions.' }}</p>
        <div class="row g-3 small">
            <div class="col-sm-6"><span class="text-muted">Available from</span><div class="fw-semibold">{{ $assignment->starts_at?->format('M d, Y H:i') ?? 'Now' }}</div></div>
            <div class="col-sm-6"><span class="text-muted">Due</span><div class="fw-semibold">{{ $assignment->ends_at?->format('M d, Y H:i') ?? $assignment->due_date?->format('M d, Y') ?? 'No deadline' }}</div></div>
            <div class="col-sm-6"><span class="text-muted">Attempts</span><div class="fw-semibold">{{ $attempts->count() }} of {{ $assignment->allow_retakes ? $assignment->max_attempts : 1 }} used</div></div>
            <div class="col-sm-6"><span class="text-muted">Assignment type</span><div class="fw-semibold">{{ $assignment->assignment_type === 'true_false' ? 'True / False questions' : 'File upload' }}</div></div>
        </div>
    </div>

    @if($canSubmit)
        <form method="POST" action="{{ route('student.assignments.store', $assignment) }}" @if($assignment->assignment_type === 'file_upload') enctype="multipart/form-data" @endif>
            @csrf
            <div class="student-card p-4">
                @if($assignment->assignment_type === 'file_upload')
                    <label class="form-label fw-semibold" for="submissionFile">Upload your completed assignment</label>
                    <input class="form-control" id="submissionFile" name="submission_file" type="file" accept=".pdf,.doc,.docx,.zip,.txt" required>
                    <small class="form-text">PDF, DOC, DOCX, ZIP, or TXT. Maximum 10 MB.</small>
                @else
                    <h2 class="h5 fw-bold mb-4">Questions</h2>
                    @foreach($questions as $index => $question)
                        <fieldset class="border-bottom pb-3 mb-3">
                            <legend class="h6">{{ $index + 1 }}. {{ $question->prompt }}</legend>
                            <div class="d-flex gap-4">
                                @foreach(['true' => 'True', 'false' => 'False'] as $value => $label)
                                    <label class="form-check"><input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $value }}" @checked(old('answers.' . $question->id) === $value) required><span class="form-check-label">{{ $label }}</span></label>
                                @endforeach
                            </div>
                        </fieldset>
                    @endforeach
                @endif
                <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit">Submit assignment</button></div>
            </div>
        </form>
    @elseif($attempts->isNotEmpty())
        <a class="btn btn-primary" href="{{ route('student.assignments.result', $assignment) }}">View latest result</a>
    @endif
</div>
@endsection