@extends('layouts.teacher')
@section('title', $course->name . ' · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('teacher.courses') }}" class="text-decoration-none">Courses</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $course->name }}</h1>
        <p class="text-muted mb-0">Course {{ $course->code }}</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('teacher.courses') }}"><i class="bi bi-arrow-left me-2"></i>Back to courses</a>
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Course information</h2>
        <dl class="row mb-0">
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Course name</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->name }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Course code</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->code }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Description</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->description ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Department</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->department ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Credits</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->credits ?? 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Teacher</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->teacher?->user?->name ?? 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Academic year</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->academic_year ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Semester</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->semester ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Class schedule</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->day_of_week ? $course->day_of_week . ' · ' : '' }}{{ $course->start_time ? \Carbon\Carbon::parse($course->start_time)->format('H:i') : 'Not set' }}{{ $course->end_time ? ' - ' . \Carbon\Carbon::parse($course->end_time)->format('H:i') : '' }}{{ $course->room ? ' · ' . $course->room : '' }}{{ !$course->day_of_week && !$course->start_time && !$course->end_time && !$course->room ? '' : '' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Status</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ ucfirst($course->status) }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Assignments</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $course->assignments->count() }}</dd>
        </dl>
    </div>
</div>
@endsection