@extends('layouts.student')

@section('title', 'Analytics')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">Analytics</h1>

            <div class="text-muted">
                Dashboard
                <span class="mx-2">/</span>
                Analytics
            </div>
        </div>

        <button class="btn btn-white border rounded-3 px-4 py-2">
            <i class="bi bi-calendar3 text-primary me-2"></i>
            This Semester
            <i class="bi bi-chevron-down ms-2"></i>
        </button>

    </div>


    {{-- ================= SUMMARY CARDS ================= --}}
    <div class="row g-4 mb-4">

        {{-- GPA --}}
        <div class="col-xl col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">

                <div class="d-flex align-items-center">

                    <div class="analytics-icon bg-purple">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <div class="ms-3">
                        <div class="text-muted small">
                            Overall GPA
                        </div>

                        <h3 class="fw-bold mb-1">
                            3.75
                        </h3>

                        <small class="text-success fw-semibold">
                            Good
                        </small>
                    </div>

                </div>

            </div>
        </div>


        {{-- Attendance --}}
        <div class="col-xl col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">

                <div class="d-flex align-items-center">

                    <div class="analytics-icon bg-blue">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <div class="ms-3">

                        <div class="text-muted small">
                            Attendance Rate
                        </div>

                        <h3 class="fw-bold mb-1">
                            92%
                        </h3>

                        <small class="text-success fw-semibold">
                            Excellent
                        </small>

                    </div>

                </div>

            </div>
        </div>


        {{-- Assignments --}}
        <div class="col-xl col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">

                <div class="d-flex align-items-center">

                    <div class="analytics-icon bg-green">
                        <i class="bi bi-book"></i>
                    </div>

                    <div class="ms-3">

                        <div class="text-muted small">
                            Assignments
                        </div>

                        <h3 class="fw-bold mb-1">
                            8/12
                        </h3>

                        <small class="text-success fw-semibold">
                            Completed
                        </small>

                    </div>

                </div>

            </div>
        </div>


        {{-- Quiz --}}
        <div class="col-xl col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">

                <div class="d-flex align-items-center">

                    <div class="analytics-icon bg-orange">
                        <i class="bi bi-question-circle"></i>
                    </div>

                    <div class="ms-3">

                        <div class="text-muted small">
                            Quiz Average
                        </div>

                        <h3 class="fw-bold mb-1">
                            85%
                        </h3>

                        <small class="text-success fw-semibold">
                            Good
                        </small>

                    </div>

                </div>

            </div>
        </div>


        {{-- Total Points --}}
        <div class="col-xl col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">

                <div class="d-flex align-items-center">

                    <div class="analytics-icon bg-red">
                        <i class="bi bi-award"></i>
                    </div>

                    <div class="ms-3">

                        <div class="text-muted small">
                            Total Points
                        </div>

                        <h3 class="fw-bold mb-1">
                            563 / 600
                        </h3>

                        <small class="text-success fw-semibold">
                            93.8%
                        </small>

                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- ================= ROW 2 ================= --}}
    <div class="row g-4 mb-4">

        {{-- GPA TREND --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="fw-bold mb-1">
                            GPA Trend
                        </h5>
                    </div>

                    <button class="btn btn-light border rounded-3 btn-sm px-3">
                        This Semester
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>

                </div>

                <div id="gpaTrendChart" class="mt-3"></div>

            </div>

        </div>


        {{-- PERFORMANCE BY CATEGORY --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <h5 class="fw-bold mb-3">
                    Performance by Category
                </h5>

                <div class="row align-items-center">

                    <div class="col-md-7">

                        <div id="categoryChart"></div>

                    </div>

                    <div class="col-md-5">

                        <div class="analytics-legend">

                            <div class="legend-item">
                                <span class="legend-dot green"></span>
                                <span>Assignments</span>
                                <strong>85%</strong>
                            </div>

                            <div class="legend-item">
                                <span class="legend-dot blue"></span>
                                <span>Quizzes</span>
                                <strong>80%</strong>
                            </div>

                            <div class="legend-item">
                                <span class="legend-dot orange"></span>
                                <span>Attendance</span>
                                <strong>92%</strong>
                            </div>

                            <div class="legend-item">
                                <span class="legend-dot purple"></span>
                                <span>Exams</span>
                                <strong>82%</strong>
                            </div>

                            <div class="legend-item">
                                <span class="legend-dot red"></span>
                                <span>Projects</span>
                                <strong>90%</strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- INSIGHTS --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <h5 class="fw-bold mb-4">
                    Insights
                </h5>

                <div class="insight-item">

                    <div class="insight-icon bg-success-subtle text-success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <div>
                        You are performing better
                        than <strong>85%</strong> of students.
                    </div>

                </div>


                <div class="insight-item">

                    <div class="insight-icon bg-primary-subtle text-primary">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <div>
                        Great job! Your attendance
                        rate is excellent.
                    </div>

                </div>


                <div class="insight-item">

                    <div class="insight-icon bg-warning-subtle text-warning">
                        <i class="bi bi-book"></i>
                    </div>

                    <div>
                        Keep submitting assignments
                        on time.
                    </div>

                </div>


                <div class="insight-item">

                    <div class="insight-icon bg-purple-subtle text-purple">
                        <i class="bi bi-bullseye"></i>
                    </div>

                    <div>
                        Focus more on quizzes to
                        improve your score.
                    </div>

                </div>


                <button class="btn btn-purple w-100 mt-3">
                    View Recommendations
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>

            </div>

        </div>

    </div>


    {{-- ================= ROW 3 ================= --}}
    <div class="row g-4 mb-4">

        {{-- SUBJECT PERFORMANCE --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Subject Performance
                    </h5>

                    <a href="#" class="text-primary fw-semibold text-decoration-none">
                        View All
                    </a>

                </div>

                <div id="subjectPerformanceChart"></div>

            </div>

        </div>


        {{-- STUDY TIME --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="fw-bold mb-0">
                        Study Time (Hours)
                    </h5>

                    <button class="btn btn-light border rounded-3 btn-sm">
                        This Week
                        <i class="bi bi-chevron-down ms-2"></i>
                    </button>

                </div>

                <div id="studyTimeChart" class="mt-3"></div>


                {{-- Study Summary --}}

                <div class="study-summary mt-3">

                    <div>
                        <small class="text-muted">
                            Total Study Time
                        </small>

                        <div class="fw-bold fs-5">
                            <i class="bi bi-stopwatch text-primary me-1"></i>
                            22.0
                            <small>hrs</small>
                        </div>
                    </div>


                    <div>
                        <small class="text-muted">
                            Daily Average
                        </small>

                        <div class="fw-bold fs-5">
                            <i class="bi bi-clock text-primary me-1"></i>
                            3.14
                            <small>hrs</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        {{-- ALERTS --}}
        <div class="col-lg-3">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Alerts
                    </h5>

                    <a href="#" class="text-primary fw-semibold text-decoration-none">
                        View All
                    </a>

                </div>


                {{-- Alert 1 --}}
                <div class="alert-item">

                    <div class="alert-icon bg-warning-subtle text-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold small">
                            Assignment Due Soon
                        </div>

                        <small class="text-muted">
                            Database Design Project due in 2 days
                        </small>

                    </div>

                    <small class="text-muted">
                        2h ago
                    </small>

                </div>


                {{-- Alert 2 --}}
                <div class="alert-item">

                    <div class="alert-icon bg-primary-subtle text-primary">
                        <i class="bi bi-bell"></i>
                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold small">
                            Quiz Tomorrow
                        </div>

                        <small class="text-muted">
                            Physics Quiz 2 is tomorrow
                        </small>

                    </div>

                    <small class="text-muted">
                        5h ago
                    </small>

                </div>


                {{-- Alert 3 --}}
                <div class="alert-item">

                    <div class="alert-icon bg-success-subtle text-success">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold small">
                            Class Reminder
                        </div>

                        <small class="text-muted">
                            Web Development class at 10:00 AM
                        </small>

                    </div>

                    <small class="text-muted">
                        1d ago
                    </small>

                </div>


                {{-- Alert 4 --}}
                <div class="alert-item">

                    <div class="alert-icon bg-danger-subtle text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold small">
                            Attendance Alert
                        </div>

                        <small class="text-muted">
                            You were absent on May 18, 2024
                        </small>

                    </div>

                    <small class="text-muted">
                        2d ago
                    </small>

                </div>


                <a href="#" class="btn btn-light w-100 mt-3 text-primary fw-semibold">
                    View Calendar
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>

            </div>

        </div>

    </div>

</div>


{{-- ================= ANALYTICS CSS ================= --}}
<style>

    .analytics-icon {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .bg-purple {
        background: #eee7ff;
        color: #673ab7;
    }

    .bg-blue {
        background: #e3f2fd;
        color: #2196f3;
    }

    .bg-green {
        background: #e4f8ef;
        color: #20a36a;
    }

    .bg-orange {
        background: #fff1df;
        color: #ff9800;
    }

    .bg-red {
        background: #ffe5e8;
        color: #ef4444;
    }

    .bg-purple-subtle {
        background: #eee7ff;
    }

    .text-purple {
        color: #673ab7;
    }

    .btn-purple {
        background: #673ab7;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px;
    }

    .btn-purple:hover {
        background: #5630a0;
        color: white;
    }

    .analytics-legend {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .legend-item {
        display: grid;
        grid-template-columns: 12px 1fr auto;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .legend-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
    }

    .legend-dot.green {
        background: #20b486;
    }

    .legend-dot.blue {
        background: #2196f3;
    }

    .legend-dot.orange {
        background: #ff9800;
    }

    .legend-dot.purple {
        background: #7c3aed;
    }

    .legend-dot.red {
        background: #ef4444;
    }

    .insight-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.6;
    }

    .insight-icon {
        min-width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .alert-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
    }

    .alert-icon {
        min-width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .study-summary {
        background: #f6f5ff;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
    }

    .card {
        background: #fff;
    }

    #gpaTrendChart,
    #categoryChart,
    #subjectPerformanceChart,
    #studyTimeChart {
        width: 100%;
    }

</style>


{{-- ================= APEXCHARTS ================= --}}
<script>

document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | GPA TREND
    |--------------------------------------------------------------------------
    */

    const gpaTrendOptions = {

        series: [{
            name: 'GPA',
            data: [3.10, 3.20, 3.35, 3.50, 3.60, 3.75]
        }],

        chart: {
            type: 'area',
            height: 280,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },

        colors: ['#673ab7'],

        stroke: {
            curve: 'smooth',
            width: 3
        },

        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.30,
                opacityTo: 0.05
            }
        },

        markers: {
            size: 5,
            strokeWidth: 3,
            hover: {
                size: 7
            }
        },

        dataLabels: {
            enabled: false
        },

        xaxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun'
            ],

            labels: {
                style: {
                    colors: '#64748b'
                }
            }
        },

        yaxis: {
            min: 2,
            max: 4,
            tickAmount: 4,

            labels: {
                formatter: function(value) {
                    return value.toFixed(1);
                },

                style: {
                    colors: '#64748b'
                }
            }
        },

        grid: {
            borderColor: '#eeeeee',
            strokeDashArray: 4
        },

        tooltip: {
            y: {
                formatter: function(value) {
                    return value.toFixed(2);
                }
            }
        }

    };


    const gpaChart = new ApexCharts(
        document.querySelector("#gpaTrendChart"),
        gpaTrendOptions
    );

    gpaChart.render();


    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE BY CATEGORY
    |--------------------------------------------------------------------------
    */

    const categoryOptions = {

        series: [85, 80, 92, 82, 90],

        labels: [
            'Assignments',
            'Quizzes',
            'Attendance',
            'Exams',
            'Projects'
        ],

        chart: {
            type: 'donut',
            height: 280
        },

        colors: [
            '#20b486',
            '#2196f3',
            '#ff9800',
            '#7c3aed',
            '#ef4444'
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
                            fontSize: '13px'
                        },

                        value: {
                            show: true,
                            fontSize: '26px',
                            fontWeight: 700,
                            formatter: function() {
                                return '85%';
                            }
                        },

                        total: {
                            show: true,
                            label: 'Average',
                            formatter: function() {
                                return '85%';
                            }
                        }

                    }

                }

            }

        },

        stroke: {
            width: 3,
            colors: ['#fff']
        }

    };


    const categoryChart = new ApexCharts(
        document.querySelector("#categoryChart"),
        categoryOptions
    );

    categoryChart.render();


    /*
    |--------------------------------------------------------------------------
    | SUBJECT PERFORMANCE
    |--------------------------------------------------------------------------
    */

    const subjectOptions = {

        series: [{
            name: 'Performance',

            data: [
                95,
                88,
                90,
                80,
                85,
                75
            ]
        }],

        chart: {
            type: 'bar',
            height: 280,
            toolbar: {
                show: false
            }
        },

        colors: ['#673ab7'],

        plotOptions: {

            bar: {
                borderRadius: 4,
                columnWidth: '45%',
                distributed: false
            }

        },

        dataLabels: {
            enabled: true,

            formatter: function(value) {
                return value + '%';
            },

            offsetY: -20,

            style: {
                colors: ['#111827'],
                fontSize: '12px'
            }
        },

        xaxis: {

            categories: [
                'Data Structures',
                'Database Systems',
                'Web Development',
                'Discrete Mathematics',
                'Technical Writing',
                'Physics'
            ],

            labels: {
                rotate: -45,
                style: {
                    colors: '#64748b'
                }
            }

        },

        yaxis: {

            min: 0,
            max: 100,

            labels: {
                formatter: function(value) {
                    return value + '%';
                }
            }

        },

        grid: {
            borderColor: '#eeeeee'
        },

        tooltip: {
            y: {
                formatter: function(value) {
                    return value + '%';
                }
            }
        }

    };


    const subjectChart = new ApexCharts(
        document.querySelector("#subjectPerformanceChart"),
        subjectOptions
    );

    subjectChart.render();


    /*
    |--------------------------------------------------------------------------
    | STUDY TIME
    |--------------------------------------------------------------------------
    */

    const studyTimeOptions = {

        series: [{
            name: 'Hours',

            data: [
                2.5,
                3.0,
                4.5,
                5.0,
                3.5,
                2.0,
                1.5
            ]
        }],

        chart: {
            type: 'bar',
            height: 230,
            toolbar: {
                show: false
            }
        },

        colors: ['#673ab7'],

        plotOptions: {

            bar: {
                borderRadius: 5,
                columnWidth: '45%'
            }

        },

        dataLabels: {

            enabled: true,

            formatter: function(value) {
                return value;
            },

            style: {
                colors: ['#111827']
            }

        },

        xaxis: {

            categories: [
                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat',
                'Sun'
            ],

            labels: {
                style: {
                    colors: '#64748b'
                }
            }

        },

        yaxis: {

            min: 0,
            max: 25,

            tickAmount: 5,

            labels: {
                formatter: function(value) {
                    return value;
                }
            }

        },

        grid: {
            borderColor: '#eeeeee',
            strokeDashArray: 4
        }

    };


    const studyChart = new ApexCharts(
        document.querySelector("#studyTimeChart"),
        studyTimeOptions
    );

    studyChart.render();

});

</script>

@endsection