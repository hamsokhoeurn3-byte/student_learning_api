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

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1">
                {{ __('Welcome back') }}, {{ auth()->user()->name ?? __('Student') }}
            </h1>

            <p class="text-muted mb-0">
                {{ __('Your student profile') }}
            </p>
        </div>

        <div class="small text-muted">
            <i class="bi bi-calendar3 me-2"></i>
            {{ now()->format('F d, Y') }}
        </div>
    </div>


    {{-- PROFILE INFORMATION --}}
    <div class="row g-3 mb-4">

        @foreach($profileFacts as [$label, $value, $icon])

            <div class="col-sm-6 col-xl-3">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-3 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="small text-muted mb-2">
                                {{ __($label) }}
                            </div>

                            <div class="h5 fw-bold mb-0">
                                {{ __($value) }}
                            </div>
                        </div>

                        <span class="portal-stat-icon">
                            <i class="bi bi-{{ $icon }}"></i>
                        </span>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    {{-- ACADEMIC RECORDS --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-6">

            <section class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h2 class="h5 fw-bold mb-3">
                        {{ __('Academic records') }}
                    </h2>

                    <div class="d-flex justify-content-between small mb-2"><span class="text-muted">{{ __('Enrolled courses') }}</span><strong>{{ $enrolledCourseCount }}</strong></div>
                    <div class="d-flex justify-content-between small mb-2"><span class="text-muted">{{ __('Overall GPA') }}</span><strong>{{ $gpaSummary['gpa'] !== null ? number_format($gpaSummary['gpa'], 2) : '—' }}</strong></div>
                    <div class="d-flex justify-content-between small mb-2"><span class="text-muted">{{ __('Credits earned') }}</span><strong>{{ $gpaSummary['credits'] }}</strong></div>
                    <div class="d-flex justify-content-between small mb-2"><span class="text-muted">{{ __('Attendance rate') }}</span><strong>{{ $attendanceSummary['rate'] !== null ? $attendanceSummary['rate'] . '%' : '—' }}</strong></div>
                    <div class="d-flex justify-content-between small"><span class="text-muted">{{ __('Academic standing') }}</span><strong>{{ $gpaSummary['standing'] ? __(ucfirst($gpaSummary['standing'])) : '—' }}</strong></div>

                </div>

            </section>

        </div>


        <div class="col-xl-6">

            <section class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h2 class="h5 fw-bold mb-3">
                        {{ __('Recent activity') }}
                    </h2>

                    @forelse($recentAttempts as $attempt)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <strong class="small d-block">{{ $attempt->assignment?->title ?? 'Deleted assignment' }}</strong>
                                <small class="text-muted">{{ $attempt->assignment?->course?->name ?? 'Course unavailable' }}</small>
                            </div>
                            <div class="text-end">
                                @if($attempt->score !== null)
                                    <span class="badge bg-success-subtle text-success">{{ number_format((float) $attempt->score, 0) }}%</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Awaiting</span>
                                @endif
                                <small class="d-block text-muted">{{ $attempt->submitted_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No activity records are available yet.</p>
                    @endforelse

                </div>

            </section>

        </div>

    </div>


    {{-- ANALYTICS / SUBJECT PERFORMANCE --}}
    <div class="row g-3 mb-4">

        {{-- SUBJECT PERFORMANCE --}}
        <div class="col-xl-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            {{ __('Subject Performance') }}
                        </h5>

                        <a href="{{ route('student.courses') }}"
                           class="text-primary small text-decoration-none">
                            {{ __('View all') }}
                        </a>

                    </div>


                    @forelse($subjectPerformance as $subject)

                        <div class="d-flex align-items-center mb-4">

                            <div
                                style="width: min(140px, 35%);"
                                class="small fw-semibold text-truncate pe-2"
                                title="{{ $subject['name'] }}"
                            >
                                {{ $subject['name'] }}
                            </div>

                            <div
                                class="progress flex-grow-1"
                                style="height:6px;"
                            >
                                <div
                                    class="progress-bar bg-primary"
                                    style="width:{{ $subject['score'] }}%"
                                ></div>
                            </div>

                            <div
                                class="small ms-3 text-end"
                                style="width:35px;"
                            >
                                {{ $subject['score'] }}%
                            </div>

                        </div>

                    @empty

                        <p class="text-muted small mb-0">
                            No graded subjects yet. Your subject performance will appear here once grades are recorded.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="col-xl-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        {{ __('Quick Actions') }}
                    </h5>

                    <div class="row g-3">

                        {{-- Courses --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.courses') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-primary-subtle text-primary p-3 mb-2">

                                        <i class="bi bi-book fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Courses') }}
                                    </small>

                                </div>

                            </a>

                        </div>


                        {{-- Grades --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.grades') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-success-subtle text-success p-3 mb-2">

                                        <i class="bi bi-file-earmark-check fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Grades') }}
                                    </small>

                                </div>

                            </a>

                        </div>


                        {{-- Calendar --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.calendar') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-warning-subtle text-warning p-3 mb-2">

                                        <i class="bi bi-calendar-event fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Calendar') }}
                                    </small>

                                </div>

                            </a>

                        </div>


                        {{-- Assignments --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.assignments') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-info-subtle text-info p-3 mb-2">

                                        <i class="bi bi-clipboard-check fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Assignments') }}
                                    </small>

                                </div>

                            </a>

                        </div>


                        {{-- Quizzes --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.quizzes') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-danger-subtle text-danger p-3 mb-2">

                                        <i class="bi bi-question-circle fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Quizzes') }}
                                    </small>

                                </div>

                            </a>

                        </div>


                        {{-- Reports --}}
                        <div class="col-4">

                            <a
                                href="{{ route('student.reports') }}"
                                class="text-decoration-none text-dark"
                            >

                                <div class="text-center">

                                    <div class="rounded-3 bg-primary-subtle text-primary p-3 mb-2">

                                        <i class="bi bi-bar-chart fs-4"></i>

                                    </div>

                                    <small>
                                        {{ __('Reports') }}
                                    </small>

                                </div>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- QUICK ACTION BUTTONS --}}
    <section class="border-top pt-4 pb-4">

        <h2 class="h5 fw-bold mb-3">
            Quick actions
        </h2>

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route('student.courses') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-book me-2"></i>
                Courses
            </a>

            <a
                href="{{ route('student.grades') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-file-earmark-check me-2"></i>
                Grades
            </a>

            <a
                href="{{ route('student.attendance') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-calendar-check me-2"></i>
                Attendance
            </a>

            <a
                href="{{ route('student.assignments') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-clipboard-check me-2"></i>
                Assignments
            </a>

            <a
                href="{{ route('student.quizzes') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-question-circle me-2"></i>
                Quizzes
            </a>

            <a
                href="{{ route('student.reports') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-bar-chart me-2"></i>
                Reports
            </a>

        </div>

    </section>

</div>

@endsection