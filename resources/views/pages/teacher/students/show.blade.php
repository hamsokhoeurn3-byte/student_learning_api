@extends('layouts.teacher')
@section('title', 'Student Details · Teacher · SLAS')
@section('content')
@php($studentName = $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name))
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('teacher.students') }}" class="text-decoration-none">Students</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $studentName }}</h1>
        <p class="text-muted mb-0">Student information for your assigned classes.</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('teacher.students') }}"><i class="bi bi-arrow-left me-2"></i>Back to students</a>
</div>

<div class="card portal-card border-0 mb-4">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Student information</h2>
        <dl class="row mb-0">
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Student ID</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->student_id }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Email</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->user?->email ?? 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Department</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->department ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Major</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->major ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Academic year</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->academic_year ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Year level</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->year_level ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Semester</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ $student->semester ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Status</dt><dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ ucfirst($student->status) }}</dd>
        </dl>
    </div>
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3"><h2 class="h5 fw-bold mb-0">Your assigned classes</h2></div>
    <div class="table-responsive">
        <table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Course</th><th>Code</th><th>Academic year</th><th class="pe-4">Semester</th></tr></thead>
            <tbody>
                @forelse($student->courses as $course)
                    <tr><td class="ps-4 fw-semibold">{{ $course->name }}</td><td>{{ $course->code }}</td><td>{{ $course->pivot->academic_year ?: 'Not set' }}</td><td class="pe-4">{{ $course->pivot->semester ?: 'Not set' }}</td></tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No assigned classes found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection