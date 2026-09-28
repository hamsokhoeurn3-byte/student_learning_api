@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
@php
    $profileFacts = [
        ['Student ID', $studentProfile?->student_id ?? 'Not set', 'person-vcard'],
        ['Enrollment status', ucfirst($studentProfile?->status ?? 'not set'), 'check2-circle'],
        ['Academic year', $studentProfile?->academic_year ?? 'Not set', 'calendar3'],
        ['Year level', $studentProfile?->year_level ?? 'Not set', 'mortarboard'],
    ];
@endphp
<div class="container-fluid px-4 py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">Welcome back, {{ auth()->user()->name ?? 'Student' }}</h1>
            <p class="text-muted mb-0">Your student profile</p>
        </div>
        <div class="small text-muted"><i class="bi bi-calendar3 me-2"></i>{{ now()->format('F d, Y') }}</div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($profileFacts as [$label, $value, $icon])
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="small text-muted mb-2">{{ $label }}</div>
                            <div class="h5 fw-bold mb-0">{{ $value }}</div>
                        </div>
                        <span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-1">Academic records</h2>
                    <p class="text-muted small mb-0">No grade, attendance, course, or assignment records are available yet.</p>
                </div>
            </section>
        </div>
        <div class="col-xl-6">
            <section class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-1">Recent activity</h2>
                    <p class="text-muted small mb-0">No activity records are available yet.</p>
                </div>
            </section>
        </div>
    </div>

    <section class="border-top pt-4">
        <h2 class="h5 fw-bold mb-3">Quick actions</h2>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('student.courses') }}" class="btn btn-outline-primary"><i class="bi bi-book me-2"></i>Courses</a>
            <a href="{{ route('student.grades') }}" class="btn btn-outline-primary"><i class="bi bi-file-earmark-check me-2"></i>Grades</a>
            <a href="{{ route('student.attendance') }}" class="btn btn-outline-primary"><i class="bi bi-calendar-check me-2"></i>Attendance</a>
            <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary"><i class="bi bi-clipboard-check me-2"></i>Assignments</a>
            <a href="{{ route('student.quizzes') }}" class="btn btn-outline-primary"><i class="bi bi-question-circle me-2"></i>Quizzes</a>
            <a href="{{ route('student.reports') }}" class="btn btn-outline-primary"><i class="bi bi-bar-chart me-2"></i>Reports</a>
        </div>
    </section>
</div>
@endsection