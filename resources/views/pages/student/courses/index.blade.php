@extends('layouts.student')

@section('title', 'Data Structures')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- =========================
        PAGE HEADER
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Data Structures (CS101)
            </h1>

            <div class="text-muted">
                Dashboard
                <span class="mx-2">/</span>
                Courses
                <span class="mx-2">/</span>
                Data Structures
            </div>
        </div>

        <a href="{{ url('/student/courses') }}"
           class="btn btn-light border rounded-3 px-4 py-2">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Courses
        </a>

    </div>


    {{-- =========================
        COURSE INFORMATION
    ========================== --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row align-items-center">

                {{-- Course Info --}}
                <div class="col-lg-6">

                    <div class="d-flex align-items-center">

                        <div
                            class="d-flex align-items-center justify-content-center rounded-4 me-4"
                            style="
                                width:80px;
                                height:80px;
                                background:linear-gradient(135deg,#8b5cf6,#4f46e5);
                            "
                        >
                            <i class="bi bi-code-slash text-white fs-1"></i>
                        </div>

                        <div>

                            <div class="d-flex align-items-center gap-3 mb-2">

                                <h3 class="fw-bold mb-0">
                                    Data Structures
                                </h3>

                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    Active
                                </span>

                            </div>

                            <div class="text-muted mb-2">
                                Course Code:
                                <strong class="text-dark">CS101</strong>

                                <span class="mx-3">|</span>

                                Credits:
                                <strong class="text-dark">3</strong>
                            </div>

                            <div class="text-muted">
                                Instructor:
                                <strong class="text-dark">
                                    Dr. Robert Smith
                                </strong>

                                <i class="bi bi-envelope ms-2 text-primary"></i>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Progress --}}
                <div class="col-lg-3 border-start">

                    <div class="px-4">

                        <small class="fw-semibold text-muted">
                            Your Progress
                        </small>

                        <div class="d-flex align-items-center mt-2">

                            <div
                                class="progress rounded-circle me-3"
                                style="
                                    width:82px;
                                    height:82px;
                                    background:#eee;
                                    padding:7px;
                                "
                            >
                                <div
                                    class="d-flex align-items-center justify-content-center rounded-circle bg-white w-100 h-100"
                                >
                                    <strong class="fs-5">
                                        75%
                                    </strong>
                                </div>
                            </div>

                            <div>
                                <div class="text-success fw-semibold">
                                    9 / 12 Completed
                                </div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Schedule --}}
                <div class="col-lg-3 border-start">

                    <div class="px-4">

                        <div class="fw-semibold mb-3">
                            <i class="bi bi-calendar3 text-primary me-2"></i>
                            Class Schedule
                        </div>

                        <div class="text-muted mb-2">
                            Mon, Wed, Fri
                        </div>

                        <div class="text-muted mb-2">
                            10:00 AM – 11:30 AM
                        </div>

                        <div class="text-muted">
                            Room: IT-305
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        MAIN CONTENT
    ========================== --}}
    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-xl-9">

            {{-- Tabs --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-0">

                    <ul class="nav nav-tabs border-0 px-3 pt-2">

                        <li class="nav-item">
                            <a class="nav-link active px-4 py-3 fw-semibold"
                               href="#">
                                <i class="bi bi-grid me-2"></i>
                                Overview
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4 py-3"
                               href="#">
                                <i class="bi bi-clipboard-check me-2"></i>
                                Assignments
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4 py-3"
                               href="#">
                                <i class="bi bi-question-circle me-2"></i>
                                Quizzes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4 py-3"
                               href="#">
                                <i class="bi bi-book me-2"></i>
                                Materials
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link px-4 py-3"
                               href="#">
                                <i class="bi bi-megaphone me-2"></i>
                                Announcements
                            </a>
                        </li>

                    </ul>


                    {{-- Course Description --}}
                    <div class="p-4">

                        <div class="row">

                            <div class="col-lg-7 border-end">

                                <h5 class="fw-bold mb-3">
                                    Course Description
                                </h5>

                                <p class="text-muted lh-lg mb-2">
                                    This course introduces fundamental data
                                    structures including arrays, linked lists,
                                    stacks, queues, trees, graphs, and their
                                    applications.
                                </p>

                                <p class="text-muted lh-lg mb-3">
                                    Students will learn to analyze and implement
                                    efficient algorithms using these structures.
                                </p>

                                <a href="#"
                                   class="text-primary text-decoration-none fw-semibold">
                                    Show more
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </a>

                            </div>


                            {{-- What You Learn --}}
                            <div class="col-lg-5 ps-lg-4">

                                <h5 class="fw-bold mb-3">
                                    What You'll Learn
                                </h5>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Understand basic and advanced data structures
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Implement algorithms using data structures
                                </div>

                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Analyze time and space complexity
                                </div>

                                <div>
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Apply data structures in real-world problems
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                ASSIGNMENTS
            ========================== --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Assignments
                        </h5>

                        <a href="#"
                           class="text-primary text-decoration-none fw-semibold">
                            View All
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>

                    </div>


                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>
                                <tr class="text-muted small">

                                    <th>Title</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <th></th>

                                </tr>
                            </thead>

                            <tbody>

                                {{-- Assignment 1 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-3 d-flex align-items-center justify-content-center me-3"
                                                style="
                                                    width:38px;
                                                    height:38px;
                                                    background:#e8f3ff;
                                                "
                                            >
                                                <i class="bi bi-file-code text-primary"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Array Implementation
                                                </div>

                                                <small class="text-muted">
                                                    Implement basic array operations
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <div>May 10, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            Completed
                                        </span>
                                    </td>

                                    <td class="text-success fw-semibold">
                                        18 / 20
                                    </td>

                                    <td>
                                        <i class="bi bi-chevron-right text-primary"></i>
                                    </td>

                                </tr>


                                {{-- Assignment 2 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-3 d-flex align-items-center justify-content-center me-3"
                                                style="
                                                    width:38px;
                                                    height:38px;
                                                    background:#e8fff5;
                                                "
                                            >
                                                <i class="bi bi-diagram-3 text-success"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Linked List Program
                                                </div>

                                                <small class="text-muted">
                                                    Singly linked list implementation
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <div>May 17, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            Completed
                                        </span>
                                    </td>

                                    <td class="text-success fw-semibold">
                                        16 / 20
                                    </td>

                                    <td>
                                        <i class="bi bi-chevron-right text-primary"></i>
                                    </td>

                                </tr>


                                {{-- Assignment 3 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-3 d-flex align-items-center justify-content-center me-3"
                                                style="
                                                    width:38px;
                                                    height:38px;
                                                    background:#fff4df;
                                                "
                                            >
                                                <i class="bi bi-layers text-warning"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Stack and Queue
                                                </div>

                                                <small class="text-muted">
                                                    Implement stack and queue
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <div>May 24, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                            Submitted
                                        </span>
                                    </td>

                                    <td>
                                        -
                                    </td>

                                    <td>
                                        <i class="bi bi-chevron-right text-primary"></i>
                                    </td>

                                </tr>


                                {{-- Assignment 4 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center">

                                            <div
                                                class="rounded-3 d-flex align-items-center justify-content-center me-3"
                                                style="
                                                    width:38px;
                                                    height:38px;
                                                    background:#f1eaff;
                                                "
                                            >
                                                <i class="bi bi-diagram-2 text-primary"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Binary Tree Traversal
                                                </div>

                                                <small class="text-muted">
                                                    Implement tree traversal algorithms
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <div>May 31, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                            Pending
                                        </span>
                                    </td>

                                    <td>
                                        -
                                    </td>

                                    <td>
                                        <i class="bi bi-chevron-right text-primary"></i>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
            RIGHT SIDEBAR
        ========================== --}}
        <div class="col-xl-3">


            {{-- Grade Summary --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Grade Summary
                    </h5>

                    <div id="gradeSummaryChart"></div>

                    <div class="mt-3">

                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                <i class="bi bi-circle-fill text-success me-2 small"></i>
                                A (90-100)
                            </span>

                            <strong>45%</strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                <i class="bi bi-circle-fill text-primary me-2 small"></i>
                                B (80-89)
                            </span>

                            <strong>30%</strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                <i class="bi bi-circle-fill text-warning me-2 small"></i>
                                C (70-79)
                            </span>

                            <strong>15%</strong>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>
                                <i class="bi bi-circle-fill text-danger me-2 small"></i>
                                D (60-69)
                            </span>

                            <strong>7%</strong>

                        </div>

                        <div class="d-flex justify-content-between">

                            <span>
                                <i class="bi bi-circle-fill text-secondary me-2 small"></i>
                                F (Below 60)
                            </span>

                            <strong>3%</strong>

                        </div>

                    </div>


                    <div class="alert alert-success border-0 rounded-3 mt-4 mb-0">

                        <i class="bi bi-trophy-fill me-2"></i>

                        <small>
                            Great job! You are in the top
                            <strong>20%</strong>
                            of the class.
                        </small>

                    </div>

                </div>

            </div>


            {{-- Course Performance --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            Course Performance
                        </h5>

                        <a href="#"
                           class="text-primary text-decoration-none small">
                            View Details
                        </a>

                    </div>


                    <div class="d-flex justify-content-between mb-4">

                        <div>
                            <i class="bi bi-star-fill text-primary me-2"></i>
                            Average GPA
                        </div>

                        <strong>
                            3.70 / 4.00
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-4">

                        <div>
                            <i class="bi bi-calendar-check text-success me-2"></i>
                            Attendance Rate
                        </div>

                        <strong>
                            92%
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-4">

                        <div>
                            <i class="bi bi-file-earmark-text text-warning me-2"></i>
                            Assignments
                        </div>

                        <strong>
                            89%
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <div>
                            <i class="bi bi-question-circle text-info me-2"></i>
                            Quiz Average
                        </div>

                        <strong>
                            85%
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Resources --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Resources
                    </h5>


                    <a href="#"
                       class="d-flex justify-content-between align-items-center text-decoration-none text-dark mb-4">

                        <span>
                            <i class="bi bi-file-earmark-text text-primary me-3"></i>
                            Course Syllabus
                        </span>

                        <i class="bi bi-chevron-right"></i>

                    </a>


                    <a href="#"
                       class="d-flex justify-content-between align-items-center text-decoration-none text-dark mb-4">

                        <span>
                            <i class="bi bi-book text-primary me-3"></i>
                            Lecture Notes
                        </span>

                        <i class="bi bi-chevron-right"></i>

                    </a>


                    <a href="#"
                       class="d-flex justify-content-between align-items-center text-decoration-none text-dark mb-4">

                        <span>
                            <i class="bi bi-stack text-primary me-3"></i>
                            Recommended Books
                        </span>

                        <i class="bi bi-chevron-right"></i>

                    </a>


                    <a href="#"
                       class="d-flex justify-content-between align-items-center text-decoration-none text-dark">

                        <span>
                            <i class="bi bi-link-45deg text-primary me-3"></i>
                            Useful Links
                        </span>

                        <i class="bi bi-chevron-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================
     APEXCHARTS
========================== --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const options = {

        series: [45, 30, 15, 7, 3],

        chart: {
            type: 'donut',
            height: 260
        },

        labels: [
            'A (90-100)',
            'B (80-89)',
            'C (70-79)',
            'D (60-69)',
            'F (Below 60)'
        ],

        colors: [
            '#22c55e',
            '#2196f3',
            '#f59e0b',
            '#ef4444',
            '#8b5cf6'
        ],

        legend: {
            show: false
        },

        dataLabels: {
            enabled: false
        },

        plotOptions: {

            pie: {

                donut: {

                    size: '68%',

                    labels: {

                        show: true,

                        name: {
                            show: true,
                            offsetY: -5,
                            color: '#64748b'
                        },

                        value: {
                            show: true,
                            fontSize: '24px',
                            fontWeight: 700,
                            offsetY: 10,
                            color: '#0f172a',
                            formatter: function () {
                                return 'A-';
                            }
                        },

                        total: {
                            show: true,
                            label: '3.70 / 4.00',
                            color: '#64748b',
                            formatter: function () {
                                return 'A-';
                            }
                        }

                    }

                }

            }

        },

        stroke: {
            width: 2,
            colors: ['#fff']
        },

        tooltip: {
            y: {
                formatter: function(value) {
                    return value + '%';
                }
            }
        }

    };


    if (typeof ApexCharts !== 'undefined') {

        const chart = new ApexCharts(
            document.querySelector("#gradeSummaryChart"),
            options
        );

        chart.render();

    }

});
</script>


{{-- =========================
     PAGE STYLE
========================== --}}
<style>

    .nav-tabs .nav-link {
        color: #334155;
        border: none;
        border-bottom: 3px solid transparent;
    }

    .nav-tabs .nav-link:hover {
        color: #4f46e5;
        border-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #4f46e5;
        background: transparent;
        border-bottom: 3px solid #4f46e5;
    }

    .table > :not(caption) > * > * {
        padding: 18px 10px;
        border-bottom-color: #eef0f4;
    }

    .table thead th {
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }

    .card {
        transition: all .2s ease;
    }

    .card:hover {
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.06) !important;
    }

    .progress {
        overflow: hidden;
    }

</style>

@endsection