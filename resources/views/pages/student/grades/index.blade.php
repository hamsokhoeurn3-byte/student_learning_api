@extends('layouts.student')

@section('title', 'Grades')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">Grades</h1>

            <div class="text-muted">
                Dashboard
                <span class="mx-2">/</span>
                <span>Grades</span>
            </div>
        </div>

        <div class="d-flex gap-3 mt-3 mt-md-0">

            {{-- Semester --}}
            <button class="btn btn-white border rounded-3 px-4 py-2">
                <i class="bi bi-calendar3 text-primary me-2"></i>
                This Semester
                <i class="bi bi-chevron-down ms-3"></i>
            </button>

            {{-- Export --}}
            <button class="btn btn-white border rounded-3 px-4 py-2">
                <i class="bi bi-download me-2"></i>
                Export Report
            </button>

        </div>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- GPA --}}
        <div class="col-xl-2 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="grade-icon bg-primary-subtle text-primary">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div>
                            <small class="text-muted">GPA</small>

                            <h3 class="fw-bold mb-1">
                                3.72
                                <small class="fs-6 fw-normal text-muted">
                                    / 4.00
                                </small>
                            </h3>

                            <small class="text-success">
                                Good
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- Total Courses --}}
        <div class="col-xl-2 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="grade-icon bg-info-subtle text-info">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>

                        <div>
                            <small class="text-muted">
                                Total Courses
                            </small>

                            <h3 class="fw-bold mb-1">
                                7
                            </h3>

                            <small class="text-success">
                                Enrolled
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- Credits --}}
        <div class="col-xl-2 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="grade-icon bg-success-subtle text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>
                            <small class="text-muted">
                                Credits Earned
                            </small>

                            <h3 class="fw-bold mb-1">
                                18 / 21
                            </h3>

                            <small class="text-success">
                                86% Completed
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- Average Score --}}
        <div class="col-xl-2 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="grade-icon bg-warning-subtle text-warning">
                            <i class="bi bi-award-fill"></i>
                        </div>

                        <div>
                            <small class="text-muted">
                                Average Score
                            </small>

                            <h3 class="fw-bold mb-1">
                                87.4%
                            </h3>

                            <small class="text-muted">
                                This Semester
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>


        {{-- Grade Trend --}}
        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="grade-icon bg-danger-subtle text-danger">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>

                        <div>
                            <small class="text-muted">
                                Grade Trend
                            </small>

                            <h3 class="fw-bold mb-1">
                                +8.6%
                            </h3>

                            <small class="text-success">
                                vs Last Semester
                            </small>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <div class="row g-4">

        {{-- =====================================================
            LEFT COLUMN
        ====================================================== --}}
        <div class="col-xl-8">

            {{-- Grade Overview --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Grade Overview
                        </h5>

                        <button class="btn btn-sm border rounded-3 px-3">
                            By Course
                            <i class="bi bi-chevron-down ms-2"></i>
                        </button>

                    </div>


                    {{-- Table --}}
                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>
                                <tr class="text-muted small">
                                    <th>Course</th>
                                    <th>Credit</th>
                                    <th>Grade</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                {{-- Course 1 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-primary text-white">
                                                <i class="bi bi-code-slash"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Data Structures (CS101)
                                                </div>

                                                <small class="text-muted">
                                                    Dr. Robert Smith
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>3</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            A-
                                        </span>
                                    </td>

                                    <td class="fw-semibold">92%</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Excellent
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 2 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-info text-white">
                                                <i class="bi bi-database-fill"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Database Systems (CS102)
                                                </div>

                                                <small class="text-muted">
                                                    Prof. Linda Brown
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>3</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            A
                                        </span>
                                    </td>

                                    <td class="fw-semibold">90%</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Excellent
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 3 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-success text-white">
                                                <i class="bi bi-globe"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Web Development (CS103)
                                                </div>

                                                <small class="text-muted">
                                                    Mr. Michael Lee
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>3</td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            B+
                                        </span>
                                    </td>

                                    <td class="fw-semibold">84%</td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            Good
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 4 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-warning text-white">
                                                <i class="bi bi-pi"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Discrete Mathematics (MATH201)
                                                </div>

                                                <small class="text-muted">
                                                    Dr. Emily Davis
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>3</td>

                                    <td>
                                        <span class="badge bg-warning-subtle text-warning">
                                            B
                                        </span>
                                    </td>

                                    <td class="fw-semibold">78%</td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            Good
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 5 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-info text-white">
                                                <i class="bi bi-pencil"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Technical Writing (ENG101)
                                                </div>

                                                <small class="text-muted">
                                                    Ms. Sarah Wilson
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>2</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            A-
                                        </span>
                                    </td>

                                    <td class="fw-semibold">91%</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Excellent
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 6 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-danger text-white">
                                                <i class="bi bi-flask"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Physics (PHY101)
                                                </div>

                                                <small class="text-muted">
                                                    Dr. James Taylor
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>3</td>

                                    <td>
                                        <span class="badge bg-warning-subtle text-warning">
                                            C+
                                        </span>
                                    </td>

                                    <td class="fw-semibold">72%</td>

                                    <td>
                                        <span class="badge bg-warning-subtle text-warning">
                                            Average
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>


                                {{-- Course 7 --}}
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div class="course-icon bg-primary text-white">
                                                <i class="bi bi-code-square"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    Intro to Programming (CS100)
                                                </div>

                                                <small class="text-muted">
                                                    Mr. David Kim
                                                </small>
                                            </div>

                                        </div>
                                    </td>

                                    <td>2</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            A
                                        </span>
                                    </td>

                                    <td class="fw-semibold">95%</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Excellent
                                        </span>
                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- GPA Calculation --}}
                    <div class="mt-3 p-3 rounded-3 bg-light">

                        <div class="small fw-semibold">
                            GPA Calculation
                        </div>

                        <small class="text-muted">
                            (92×3 + 90×3 + 84×3 + 78×3 +
                            91×2 + 72×3 + 95×2) / 21
                            = <strong>3.72</strong>
                        </small>

                    </div>

                </div>

            </div>


            {{-- Grade Trend --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="fw-bold mb-1">
                                Grade Trend
                            </h5>
                        </div>

                        <button class="btn btn-sm border rounded-3">
                            This Semester
                            <i class="bi bi-chevron-down ms-2"></i>
                        </button>

                    </div>

                    <div id="gradeTrendChart" class="mt-3"></div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            MIDDLE COLUMN
        ====================================================== --}}
        <div class="col-xl-4">

            {{-- Grade Distribution --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Grade Distribution
                    </h5>

                    <div id="gradeDistributionChart"></div>

                    <div class="mt-3">

                        <div class="d-flex justify-content-between mb-3">
                            <span>
                                <i class="bi bi-circle-fill text-success me-2"></i>
                                A (90-100)
                            </span>
                            <strong>35%</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>
                                <i class="bi bi-circle-fill text-primary me-2"></i>
                                B (80-89)
                            </span>
                            <strong>40%</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>
                                <i class="bi bi-circle-fill text-warning me-2"></i>
                                C (70-79)
                            </span>
                            <strong>15%</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>
                                <i class="bi bi-circle-fill text-danger me-2"></i>
                                D (60-69)
                            </span>
                            <strong>7%</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>
                                <i class="bi bi-circle-fill text-purple me-2"></i>
                                F (Below 60)
                            </span>
                            <strong>3%</strong>
                        </div>

                    </div>


                    <div class="alert alert-success border-0 rounded-4 mt-4 mb-0">

                        <i class="bi bi-star-fill me-2"></i>

                        You are performing better than
                        <strong>78%</strong>
                        of students in your program.

                    </div>

                </div>

            </div>


            {{-- GPA By Semester --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">
                            GPA by Semester
                        </h5>

                        <button class="btn btn-sm border rounded-3">
                            All
                            <i class="bi bi-chevron-down ms-2"></i>
                        </button>

                    </div>

                    <div id="gpaSemesterChart"></div>


                    <div class="alert alert-primary border-0 rounded-4 mb-0 mt-3">

                        <i class="bi bi-bar-chart-fill me-2"></i>

                        Your GPA has improved by
                        <strong>0.62</strong>
                        points since Fall 2022.

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT COLUMN
        ====================================================== --}}
        <div class="col-xl-4">

            {{-- Recent Grades --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Recent Grades
                        </h5>

                        <a href="#" class="text-primary text-decoration-none">
                            View All
                        </a>

                    </div>


                    @php
                        $recentGrades = [
                            [
                                'icon' => 'bi-patch-question',
                                'color' => 'primary',
                                'title' => 'Data Structures Quiz 2',
                                'date' => 'May 20, 2024',
                                'score' => '19 / 20',
                                'percent' => '95%',
                            ],
                            [
                                'icon' => 'bi-file-earmark-text',
                                'color' => 'info',
                                'title' => 'Database Assignment 3',
                                'date' => 'May 18, 2024',
                                'score' => '16 / 20',
                                'percent' => '80%',
                            ],
                            [
                                'icon' => 'bi-code-slash',
                                'color' => 'success',
                                'title' => 'Web Dev Project',
                                'date' => 'May 15, 2024',
                                'score' => '92 / 100',
                                'percent' => '92%',
                            ],
                            [
                                'icon' => 'bi-pi',
                                'color' => 'warning',
                                'title' => 'Math Test 2',
                                'date' => 'May 12, 2024',
                                'score' => '31 / 40',
                                'percent' => '77.5%',
                            ],
                            [
                                'icon' => 'bi-flask',
                                'color' => 'danger',
                                'title' => 'Physics Lab Report',
                                'date' => 'May 10, 2024',
                                'score' => '28 / 40',
                                'percent' => '70%',
                            ],
                        ];
                    @endphp


                    @foreach($recentGrades as $grade)

                        <div class="d-flex align-items-center gap-3 py-3 border-bottom">

                            <div class="recent-grade-icon
                                bg-{{ $grade['color'] }}-subtle
                                text-{{ $grade['color'] }}">

                                <i class="bi {{ $grade['icon'] }}"></i>

                            </div>

                            <div class="flex-grow-1">

                                <div class="fw-semibold small">
                                    {{ $grade['title'] }}
                                </div>

                                <small class="text-muted">
                                    {{ $grade['date'] }}
                                </small>

                            </div>

                            <div class="text-end">

                                <div class="fw-semibold small">
                                    {{ $grade['score'] }}
                                </div>

                                <small class="text-success">
                                    {{ $grade['percent'] }}
                                </small>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- Tips --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Tips to Improve Your Grades
                        </h5>

                    </div>


                    @php
                        $tips = [
                            [
                                'icon' => 'bi-person-check',
                                'color' => 'primary',
                                'title' => 'Attend classes regularly',
                                'text' => 'Consistent attendance helps you understand better.',
                            ],
                            [
                                'icon' => 'bi-clock',
                                'color' => 'warning',
                                'title' => 'Manage your time',
                                'text' => 'Create a study schedule and stick to it.',
                            ],
                            [
                                'icon' => 'bi-clipboard-check',
                                'color' => 'primary',
                                'title' => 'Practice more',
                                'text' => 'Do extra practice and solve past papers.',
                            ],
                            [
                                'icon' => 'bi-search',
                                'color' => 'primary',
                                'title' => 'Ask for help',
                                'text' => "Don't hesitate to ask your instructors or classmates.",
                            ],
                        ];
                    @endphp


                    @foreach($tips as $tip)

                        <div class="d-flex gap-3 mb-4">

                            <div class="tip-icon
                                bg-{{ $tip['color'] }}-subtle
                                text-{{ $tip['color'] }}">

                                <i class="bi {{ $tip['icon'] }}"></i>

                            </div>

                            <div>

                                <div class="fw-semibold small">
                                    {{ $tip['title'] }}
                                </div>

                                <small class="text-muted">
                                    {{ $tip['text'] }}
                                </small>

                            </div>

                        </div>

                    @endforeach


                    <div class="text-center border-top pt-3">

                        <a href="#" class="text-primary text-decoration-none fw-semibold">
                            View All Tips
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    PAGE STYLE
============================================================= --}}
<style>

    .card {
        border: 1px solid rgba(0,0,0,.04);
    }

    .grade-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 21px;
    }

    .course-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;

        border-radius: 9px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .recent-grade-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 18px;
    }

    .tip-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-purple {
        color: #6f42c1 !important;
    }

    table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    table tbody tr:last-child {
        border-bottom: none;
    }

    table td {
        padding-top: 13px;
        padding-bottom: 13px;
    }

    .btn-white {
        background: #fff;
    }

    .btn-white:hover {
        background: #f8f9fa;
    }

</style>


{{-- =============================================================
    APEXCHARTS
============================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =========================================================
       1. GRADE TREND
    ========================================================= */

    var gradeTrendOptions = {

        series: [{
            name: 'GPA',
            data: [3.10, 3.28, 3.45, 3.60, 3.72, 3.72, 3.72, 3.72]
        }],

        chart: {
            type: 'area',
            height: 280,
            toolbar: {
                show: false
            }
        },

        stroke: {
            curve: 'smooth',
            width: 3
        },

        markers: {
            size: 4
        },

        dataLabels: {
            enabled: true,
            formatter: function (value) {
                return value.toFixed(2);
            }
        },

        xaxis: {
            categories: [
                'Week 1',
                'Week 2',
                'Week 3',
                'Week 4',
                'Week 5',
                'Week 6',
                'Week 7',
                'Week 8'
            ]
        },

        yaxis: {
            min: 2,
            max: 4,
            tickAmount: 4
        },

        grid: {
            borderColor: '#eeeeee'
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return value.toFixed(2) + ' GPA';
                }
            }
        },

        colors: ['#6c3df5'],

        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.35,
                opacityTo: 0.05
            }
        }

    };

    var gradeTrendChart =
        new ApexCharts(
            document.querySelector("#gradeTrendChart"),
            gradeTrendOptions
        );

    gradeTrendChart.render();



    /* =========================================================
       2. GRADE DISTRIBUTION
    ========================================================= */

    var distributionOptions = {

        series: [35, 40, 15, 7, 3],

        labels: [
            'A (90-100)',
            'B (80-89)',
            'C (70-79)',
            'D (60-69)',
            'F (Below 60)'
        ],

        chart: {
            type: 'donut',
            height: 300
        },

        colors: [
            '#20a878',
            '#238be6',
            '#ff9f1c',
            '#ff3b4e',
            '#7b42f6'
        ],

        plotOptions: {

            pie: {

                donut: {

                    size: '68%',

                    labels: {

                        show: true,

                        total: {

                            show: true,

                            label: 'Average',

                            formatter: function () {
                                return '87.4%';
                            }
                        }

                    }

                }

            }

        },

        legend: {
            show: false
        },

        dataLabels: {
            enabled: false
        },

        stroke: {
            width: 3,
            colors: ['#fff']
        }

    };

    var distributionChart =
        new ApexCharts(
            document.querySelector("#gradeDistributionChart"),
            distributionOptions
        );

    distributionChart.render();



    /* =========================================================
       3. GPA BY SEMESTER
    ========================================================= */

    var gpaSemesterOptions = {

        series: [{
            name: 'GPA',
            data: [3.10, 3.42, 3.68, 3.72]
        }],

        chart: {
            type: 'bar',
            height: 250,
            toolbar: {
                show: false
            }
        },

        plotOptions: {

            bar: {

                borderRadius: 5,

                columnWidth: '42%',

                distributed: true

            }

        },

        colors: [
            '#9b7bea',
            '#438fe8',
            '#43c69c',
            '#6537e9'
        ],

        dataLabels: {

            enabled: true,

            formatter: function (value) {
                return value.toFixed(2);
            }

        },

        xaxis: {

            categories: [
                'Fall 2022',
                'Spring 2023',
                'Fall 2023',
                'Spring 2024'
            ]

        },

        yaxis: {

            min: 0,
            max: 4,
            tickAmount: 4

        },

        grid: {
            borderColor: '#eeeeee'
        },

        legend: {
            show: false
        }

    };

    var gpaSemesterChart =
        new ApexCharts(
            document.querySelector("#gpaSemesterChart"),
            gpaSemesterOptions
        );

    gpaSemesterChart.render();

});

</script>

@endsection