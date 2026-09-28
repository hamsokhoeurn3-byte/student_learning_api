@extends('layouts.admin')
@section('title', $assignment->title . ' · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('admin.assignments') }}" class="text-decoration-none">Assignments</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $assignment->title }}</h1>
        <p class="text-muted mb-0">{{ $assignment->course?->name ?? 'Course unavailable' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.assignments') }}" class="btn btn-outline-primary">Back to assignments</a>
        <a href="{{ route('admin.assignments.edit', $assignment) }}" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Edit assignment</a>
    </div>
</div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card portal-card border-0">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Title</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->title }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Course</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->course?->name ?? 'Course unavailable' }} ({{ $assignment->course?->code ?? 'N/A' }})</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Description</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->description ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Due date</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->due_date?->format('M d, Y') ?? 'No due date' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Status</dt><dd class="col-sm-8 col-lg-9 py-2">{{ ucfirst($assignment->status) }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Created by</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $assignment->creator?->name ?? 'Not set' }}</dd>
        </dl>
    </div>
</div>
<form class="mt-3" method="POST" action="{{ route('admin.assignments.destroy', $assignment) }}" onsubmit="return confirm('Delete this assignment?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Delete assignment</button>
</form>
@endsection
