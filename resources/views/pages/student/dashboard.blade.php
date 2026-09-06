@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid px-4 py-3">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Welcome back, {{ Auth::user()->name ?? 'Student' }}! 👋
            </h1>

            <p class="text-muted mb-0">
                Here's your learning overview
            </p>
        </div>

        <div>
            <button class="btn btn-white border shadow-sm rounded-3 px-3 py-2">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                {{ now()->format('F d, Y') }}

                <i class="bi bi-chevron-down ms-2"></i>
            </button>
        </div>

    </div>


    {{-- =========================================================
        STAT CARDS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- GPA --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-primary-subtle text-primary
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:64px;height:64px;"
                        >
                            <i class="bi bi-mortarboard-fill fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small mb-1">
                                GPA
                            </div>

                            <h3 class="fw-bold mb-1">
                                3.75
                            </h3>

                            <small class="text-success fw-semibold">
                                ↗ +0.25 this month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Attendance --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-info-subtle text-info
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:64px;height:64px;"
                        >
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small mb-1">
                                Attendance
                            </div>

                            <h3 class="fw-bold mb-1">
                                92%
                            </h3>

                            <small class="text-success fw-semibold">
                                +2% this month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Assignments --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-success-subtle text-success
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:64px;height:64px;"
                        >
                            <i class="bi bi-journal-check fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small mb-1">
                                Assignments
                            </div>

                            <h3 class="fw-bold mb-1">
                                8/12
                            </h3>

                            <small class="text-primary fw-semibold">
                                Completed
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Quizzes --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-warning-subtle text-warning
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:64px;height:64px;"
                        >
                            <i class="bi bi-question-circle-fill fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small mb-1">
                                Quizzes
                            </div>

                            <h3 class="fw-bold mb-1">
                                85%
                            </h3>

                            <small class="text-success fw-semibold">
                                +5% this month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        PERFORMANCE + DEADLINES + ATTENDANCE
    ========================================================== --}}

    <div class="row g-4 mb-4">


        {{-- PERFORMANCE CHART --}}
        <div class="col-xl-7">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Performance Overview
                            </h5>

                            <small class="text-muted">
                                Your academic performance
                            </small>

                        </div>

                        <select class="form-select form-select-sm"
                                style="width:130px;">
                            <option>This Month</option>
                            <option>Last Month</option>
                            <option>Last 6 Months</option>
                        </select>

                    </div>

                    {{-- ApexCharts --}}
                    <div id="performanceChart"></div>

                </div>

            </div>

        </div>


        {{-- UPCOMING DEADLINES --}}
        <div class="col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            Upcoming Deadlines
                        </h5>

                        <a href="#" class="text-primary small text-decoration-none">
                            View all
                        </a>

                    </div>


                    {{-- Math --}}
                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-3 bg-primary-subtle text-primary
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:42px;height:42px;"
                        >
                            <i class="bi bi-book fs-5"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold small">
                                Math Assignment
                            </div>

                            <small class="text-muted">
                                Due: May 22, 2024
                            </small>

                        </div>

                        <span class="badge bg-danger-subtle text-danger">
                            2 days
                        </span>

                    </div>


                    {{-- Chemistry --}}
                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-3 bg-warning-subtle text-warning
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:42px;height:42px;"
                        >
                            <i class="bi bi-flask fs-5"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold small">
                                Chemistry Lab
                            </div>

                            <small class="text-muted">
                                Due: May 25, 2024
                            </small>

                        </div>

                        <span class="badge bg-warning-subtle text-warning">
                            5 days
                        </span>

                    </div>


                    {{-- Physics --}}
                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-3 bg-info-subtle text-info
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:42px;height:42px;"
                        >
                            <i class="bi bi-lightbulb fs-5"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold small">
                                Physics Quiz
                            </div>

                            <small class="text-muted">
                                Due: May 28, 2024
                            </small>

                        </div>

                        <span class="badge bg-info-subtle text-info">
                            8 days
                        </span>

                    </div>


                    {{-- Project --}}
                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-3 bg-success-subtle text-success
                                   d-flex align-items-center justify-content-center me-3"
                            style="width:42px;height:42px;"
                        >
                            <i class="bi bi-easel fs-5"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold small">
                                Project Presentation
                            </div>

                            <small class="text-muted">
                                Due: May 30, 2024
                            </small>

                        </div>

                        <span class="badge bg-success-subtle text-success">
                            10 days
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ATTENDANCE DONUT --}}
        <div class="col-xl-2">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Attendance
                    </h5>

                    <div id="attendanceChart"></div>

                    <div class="text-center">

                        <a href="{{ route('student.attendance') }}"
                           class="btn btn-primary-subtle text-primary w-100 rounded-3">

                            View Attendance
                            <i class="bi bi-arrow-right ms-1"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        BOTTOM SECTION
    ========================================================== --}}

    <div class="row g-4 mb-4">


        {{-- RECENT ACTIVITY --}}
        <div class="col-xl-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-3">

                        <h5 class="fw-bold mb-0">
                            Recent Activity
                        </h5>

                        <a href="#" class="text-primary small">
                            View all
                        </a>

                    </div>


                    <div class="d-flex align-items-center py-3 border-bottom">

                        <div class="rounded-circle bg-success-subtle text-success p-2 me-3">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="small fw-semibold">
                                Assignment submitted
                            </div>

                            <small class="text-muted">
                                Data Structures Assignment
                            </small>

                        </div>

                        <small class="text-muted">
                            2h ago
                        </small>

                    </div>


                    <div class="d-flex align-items-center py-3 border-bottom">

                        <div class="rounded-circle bg-info-subtle text-info p-2 me-3">
                            <i class="bi bi-question"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="small fw-semibold">
                                Quiz completed
                            </div>

                            <small class="text-muted">
                                Math Quiz 1
                            </small>

                        </div>

                        <small class="text-muted">
                            5h ago
                        </small>

                    </div>


                    <div class="d-flex align-items-center py-3 border-bottom">

                        <div class="rounded-circle bg-warning-subtle text-warning p-2 me-3">
                            <i class="bi bi-award"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="small fw-semibold">
                                Grade updated
                            </div>

                            <small class="text-muted">
                                Physics Quiz
                            </small>

                        </div>

                        <small class="text-muted">
                            1d ago
                        </small>

                    </div>


                    <div class="d-flex align-items-center pt-3">

                        <div class="rounded-circle bg-primary-subtle text-primary p-2 me-3">
                            <i class="bi bi-book"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="small fw-semibold">
                                New course material
                            </div>

                            <small class="text-muted">
                                Software Engineering
                            </small>

                        </div>

                        <small class="text-muted">
                            1d ago
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- SUBJECT PERFORMANCE --}}
        <div class="col-xl-5">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold mb-0">
                            Subject Performance
                        </h5>

                        <a href="#" class="text-primary small">
                            View all
                        </a>

                    </div>


                    @foreach([
                        ['Data Structures', 90],
                        ['Database Systems', 85],
                        ['Web Development', 80],
                        ['Computer Networks', 75],
                        ['Software Engineering', 70],
                    ] as $subject)

                        <div class="d-flex align-items-center mb-4">

                            <div style="width:145px;"
                                 class="small fw-semibold">

                                {{ $subject[0] }}

                            </div>

                            <div class="progress flex-grow-1"
                                 style="height:6px;">

                                <div
                                    class="progress-bar bg-primary"
                                    style="width:{{ $subject[1] }}%"
                                ></div>

                            </div>

                            <div class="small ms-3"
                                 style="width:35px;">

                                {{ $subject[1] }}%

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="col-xl-3">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Quick Actions
                    </h5>

                    <div class="row g-3">

                        <div class="col-4">

                            <a href="{{ route('student.courses') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-primary-subtle
                                                text-primary p-3 mb-2">

                                        <i class="bi bi-book fs-4"></i>

                                    </div>

                                    <small>
                                        Courses
                                    </small>

                                </div>

                            </a>

                        </div>


                        <div class="col-4">

                            <a href="{{ route('student.grades') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-success-subtle
                                                text-success p-3 mb-2">

                                        <i class="bi bi-file-earmark-check fs-4"></i>

                                    </div>

                                    <small>
                                        Grades
                                    </small>

                                </div>

                            </a>

                        </div>


                        <div class="col-4">

                            <a href="{{ route('student.calendar') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-warning-subtle
                                                text-warning p-3 mb-2">

                                        <i class="bi bi-calendar-event fs-4"></i>

                                    </div>

                                    <small>
                                        Calendar
                                    </small>

                                </div>

                            </a>

                        </div>


                        <div class="col-4">

                            <a href="{{ route('student.assignments') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-info-subtle
                                                text-info p-3 mb-2">

                                        <i class="bi bi-clipboard-check fs-4"></i>

                                    </div>

                                    <small>
                                        Assignments
                                    </small>

                                </div>

                            </a>

                        </div>


                        <div class="col-4">

                            <a href="{{ route('student.quizzes') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-danger-subtle
                                                text-danger p-3 mb-2">

                                        <i class="bi bi-question-circle fs-4"></i>

                                    </div>

                                    <small>
                                        Quizzes
                                    </small>

                                </div>

                            </a>

                        </div>


                        <div class="col-4">

                            <a href="{{ route('student.reports') }}"
                               class="text-decoration-none text-dark">

                                <div class="text-center">

                                    <div class="rounded-3 bg-primary-subtle
                                                text-primary p-3 mb-2">

                                        <i class="bi bi-bar-chart fs-4"></i>

                                    </div>

                                    <small>
                                        Reports
                                    </small>

                                </div>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Footer --}}
    <div class="border-top pt-3 pb-4 text-muted small">

        © 2024 SLAS. All rights reserved.

    </div>

</div>


{{-- =========================================================
    APEXCHARTS
========================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Performance Overview
    |--------------------------------------------------------------------------
    */

    if (document.querySelector("#performanceChart")) {

        const performanceOptions = {

            series: [
                {
                    name: 'Performance',

                    data: [
                        20,
                        42,
                        38,
                        50,
                        60,
                        52,
                        66,
                        62,
                        76,
                        70,
                        63,
                        85
                    ]
                }
            ],

            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },

            dataLabels: {
                enabled: false
            },

            markers: {
                size: 0,
                hover: {
                    size: 7
                }
            },

            xaxis: {
                categories: [
                    'May 1',
                    'May 3',
                    'May 5',
                    'May 7',
                    'May 9',
                    'May 11',
                    'May 13',
                    'May 15',
                    'May 17',
                    'May 18',
                    'May 19',
                    'May 20'
                ],

                labels: {
                    style: {
                        colors: '#64748b'
                    }
                },

                axisBorder: {
                    show: false
                },

                axisTicks: {
                    show: false
                }
            },

            yaxis: {

                min: 0,
                max: 100,

                tickAmount: 4,

                labels: {
                    style: {
                        colors: '#64748b'
                    }
                }

            },

            grid: {

                borderColor: '#e9edf5',

                strokeDashArray: 4

            },

            tooltip: {

                theme: 'light',

                y: {
                    formatter: function (value) {
                        return value + '%';
                    }
                }

            }

        };


        const performanceChart =
            new ApexCharts(
                document.querySelector("#performanceChart"),
                performanceOptions
            );

        performanceChart.render();

    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Overview
    |--------------------------------------------------------------------------
    */

    if (document.querySelector("#attendanceChart")) {

        const attendanceOptions = {

            series: [
                92,
                4,
                4
            ],

            labels: [
                'Present',
                'Late',
                'Absent'
            ],

            chart: {

                type: 'donut',

                height: 220

            },

            plotOptions: {

                pie: {

                    donut: {

                        size: '72%',

                        labels: {

                            show: true,

                            total: {

                                show: true,

                                label: 'Overall',

                                formatter: function () {
                                    return '92%';
                                }

                            }

                        }

                    }

                }

            },

            dataLabels: {
                enabled: false
            },

            legend: {
                show: false
            },

            stroke: {
                width: 0
            },

            tooltip: {

                y: {

                    formatter: function (value) {
                        return value + '%';
                    }

                }

            }

        };


        const attendanceChart =
            new ApexCharts(
                document.querySelector("#attendanceChart"),
                attendanceOptions
            );

        attendanceChart.render();

    }

});

</script>

@endsection