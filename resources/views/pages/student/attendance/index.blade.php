@extends('layouts.student')

@section('title', 'Attendance')

@section('content')

<div class="container-fluid px-4 py-3">

    {{-- =========================
        PAGE HEADER
    ========================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">

        <div>
            <h1 class="fw-bold mb-1 text-dark">
                Attendance
            </h1>

            <p class="text-secondary mb-0">
                Dashboard
                <span class="mx-2">/</span>
                Attendance
            </p>
        </div>

        {{-- Month Filter --}}
        <div class="dropdown">
            <button
                class="btn btn-white border rounded-3 px-4 py-2 d-flex align-items-center gap-2"
                type="button"
                data-bs-toggle="dropdown"
            >
                <i class="bi bi-calendar3 text-primary"></i>
                <span>This Month</span>
                <i class="bi bi-chevron-down small"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                <li>
                    <a class="dropdown-item" href="#">This Month</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Last Month</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">This Semester</a>
                </li>
            </ul>
        </div>

    </div>


    {{-- =========================
        STATISTICS CARDS
    ========================== --}}
    <div class="row g-4 mb-4">

        {{-- Attendance Rate --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div class="d-flex align-items-center gap-3">

                            <div class="rounded-circle bg-success-subtle
                                        d-flex align-items-center justify-content-center"
                                 style="width:52px;height:52px;">

                                <i class="bi bi-calendar-check-fill
                                          text-success fs-4"></i>

                            </div>

                            <div>
                                <div class="text-secondary small fw-semibold">
                                    Attendance Rate
                                </div>

                                <div class="fs-2 fw-bold text-dark">
                                    92%
                                </div>
                            </div>

                        </div>

                        <i class="bi bi-graph-up-arrow text-success"></i>

                    </div>

                    <div class="text-success fw-semibold mt-2">
                        Excellent
                    </div>

                </div>

            </div>

        </div>


        {{-- Present --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-circle bg-success-subtle
                                    d-flex align-items-center justify-content-center"
                             style="width:52px;height:52px;">

                            <i class="bi bi-check-lg text-success fs-4"></i>

                        </div>

                        <div>

                            <div class="text-secondary small fw-semibold">
                                Present
                            </div>

                            <div class="fs-2 fw-bold">
                                46
                            </div>

                            <div class="text-success fw-semibold small">
                                (92%)
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Late --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-circle bg-warning-subtle
                                    d-flex align-items-center justify-content-center"
                             style="width:52px;height:52px;">

                            <i class="bi bi-clock-fill text-warning fs-4"></i>

                        </div>

                        <div>

                            <div class="text-secondary small fw-semibold">
                                Late
                            </div>

                            <div class="fs-2 fw-bold">
                                2
                            </div>

                            <div class="text-warning fw-semibold small">
                                (4%)
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Absent --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-circle bg-danger-subtle
                                    d-flex align-items-center justify-content-center"
                             style="width:52px;height:52px;">

                            <i class="bi bi-x-lg text-danger fs-4"></i>

                        </div>

                        <div>

                            <div class="text-secondary small fw-semibold">
                                Absent
                            </div>

                            <div class="fs-2 fw-bold">
                                2
                            </div>

                            <div class="text-danger fw-semibold small">
                                (4%)
                            </div>

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

        {{-- LEFT SIDE --}}
        <div class="col-12 col-xl-8">

            {{-- Calendar + Records --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-0">

                    <div class="row g-0">

                        {{-- =====================
                            CALENDAR
                        ====================== --}}
                        <div class="col-12 col-lg-5 border-end">

                            <div class="p-4">

                                <div class="d-flex align-items-center gap-2 mb-4">

                                    <i class="bi bi-calendar3 text-primary fs-5"></i>

                                    <h5 class="fw-bold mb-0">
                                        Attendance Calendar
                                    </h5>

                                </div>


                                <div class="d-flex justify-content-between
                                            align-items-center mb-4">

                                    <button class="btn btn-sm text-primary">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>

                                    <h6 class="fw-bold mb-0">
                                        May 2024
                                    </h6>

                                    <button class="btn btn-sm text-primary">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>

                                </div>


                                {{-- Week --}}
                                <div class="row text-center small
                                            text-secondary fw-semibold mb-3">

                                    <div class="col">Mon</div>
                                    <div class="col">Tue</div>
                                    <div class="col">Wed</div>
                                    <div class="col">Thu</div>
                                    <div class="col">Fri</div>
                                    <div class="col">Sat</div>
                                    <div class="col">Sun</div>

                                </div>


                                {{-- Calendar Days --}}
                                <div class="row row-cols-7 g-2 text-center">

                                    @foreach([
                                        ['29',''],
                                        ['30',''],
                                        ['1','present'],
                                        ['2','present'],
                                        ['3','present'],
                                        ['4',''],
                                        ['5',''],

                                        ['6','present'],
                                        ['7','present'],
                                        ['8','present'],
                                        ['9','present'],
                                        ['10','present'],
                                        ['11','late'],
                                        ['12',''],

                                        ['13','present'],
                                        ['14','present'],
                                        ['15','present'],
                                        ['16','present'],
                                        ['17','present'],
                                        ['18','absent'],
                                        ['19',''],

                                        ['20','present'],
                                        ['21','present'],
                                        ['22','present'],
                                        ['23','late'],
                                        ['24','late'],
                                        ['25',''],
                                        ['26',''],

                                        ['27','present'],
                                        ['28','present'],
                                        ['29','present'],
                                        ['30','absent'],
                                        ['31','present'],
                                        ['1',''],
                                        ['2','']
                                    ] as $day)

                                        <div class="col">

                                            <div class="small mb-2 text-secondary">
                                                {{ $day[0] }}
                                            </div>

                                            @if($day[1] === 'present')

                                                <span class="badge rounded-circle
                                                             bg-success p-1"
                                                      style="width:18px;height:18px;">
                                                    <i class="bi bi-check"
                                                       style="font-size:10px;">
                                                    </i>
                                                </span>

                                            @elseif($day[1] === 'late')

                                                <span class="badge rounded-circle
                                                             bg-warning p-1"
                                                      style="width:18px;height:18px;">
                                                    <i class="bi bi-clock"
                                                       style="font-size:10px;">
                                                    </i>
                                                </span>

                                            @elseif($day[1] === 'absent')

                                                <span class="badge rounded-circle
                                                             bg-danger p-1"
                                                      style="width:18px;height:18px;">
                                                    <i class="bi bi-x"
                                                       style="font-size:10px;">
                                                    </i>
                                                </span>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>


                                {{-- Legend --}}
                                <div class="d-flex flex-wrap gap-3 mt-4 small">

                                    <span>
                                        <i class="bi bi-circle-fill text-success me-1"></i>
                                        Present
                                    </span>

                                    <span>
                                        <i class="bi bi-circle-fill text-warning me-1"></i>
                                        Late
                                    </span>

                                    <span>
                                        <i class="bi bi-circle-fill text-danger me-1"></i>
                                        Absent
                                    </span>

                                    <span>
                                        <i class="bi bi-circle-fill text-secondary me-1"></i>
                                        No Class
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- =====================
                            ATTENDANCE RECORDS
                        ====================== --}}
                        <div class="col-12 col-lg-7">

                            <div class="p-4">

                                <div class="d-flex justify-content-between
                                            align-items-center mb-4">

                                    <div class="d-flex align-items-center gap-2">

                                        <i class="bi bi-person-check text-primary fs-5"></i>

                                        <h5 class="fw-bold mb-0">
                                            Attendance Records
                                        </h5>

                                    </div>

                                </div>


                                <div class="table-responsive">

                                    <table class="table align-middle mb-0">

                                        <thead>

                                            <tr class="small text-secondary">

                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                                <th>Subject</th>
                                                <th>Class</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td>May 20, 2024</td>
                                                <td>Mon</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:00 AM</td>
                                                <td>Data Structures</td>
                                                <td>CS101</td>

                                            </tr>


                                            <tr>

                                                <td>May 17, 2024</td>
                                                <td>Fri</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:05 AM</td>
                                                <td>Database Systems</td>
                                                <td>CS102</td>

                                            </tr>


                                            <tr>

                                                <td>May 16, 2024</td>
                                                <td>Thu</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:00 AM</td>
                                                <td>Web Development</td>
                                                <td>CS103</td>

                                            </tr>


                                            <tr>

                                                <td>May 15, 2024</td>
                                                <td>Wed</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:00 AM</td>
                                                <td>Discrete Math</td>
                                                <td>MATH201</td>

                                            </tr>


                                            <tr>

                                                <td>May 14, 2024</td>
                                                <td>Tue</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:02 AM</td>
                                                <td>Technical Writing</td>
                                                <td>ENG101</td>

                                            </tr>


                                            <tr>

                                                <td>May 11, 2024</td>
                                                <td>Sat</td>

                                                <td>
                                                    <span class="text-warning fw-semibold">
                                                        <i class="bi bi-clock-fill me-1"></i>
                                                        Late
                                                    </span>
                                                </td>

                                                <td>08:20 AM</td>
                                                <td>Database Systems</td>
                                                <td>CS102</td>

                                            </tr>


                                            <tr>

                                                <td>May 10, 2024</td>
                                                <td>Fri</td>

                                                <td>
                                                    <span class="text-success fw-semibold">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Present
                                                    </span>
                                                </td>

                                                <td>08:00 AM</td>
                                                <td>Web Development</td>
                                                <td>CS103</td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>


                                <div class="text-center mt-4">

                                    <a href="#"
                                       class="text-primary text-decoration-none fw-semibold">

                                        View All Records
                                        <i class="bi bi-arrow-right ms-1"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
            RIGHT SIDE
        ========================== --}}
        <div class="col-12 col-xl-4">

            {{-- Attendance Overview --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-1">
                        Attendance Overview
                    </h5>

                    <p class="text-secondary small mb-3">
                        Overall attendance rate
                    </p>

                    <div id="attendance-overview-chart"></div>

                </div>

            </div>


            {{-- Attendance By Subject --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between
                                align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            Attendance by Subject
                        </h5>

                        <a href="#"
                           class="text-primary text-decoration-none
                                  fw-semibold small">
                            View All
                        </a>

                    </div>


                    @foreach([
                        ['Data Structures',95],
                        ['Database Systems',90],
                        ['Web Development',92],
                        ['Discrete Math',85],
                        ['Technical Writing',90]
                    ] as $subject)

                        <div class="mb-3">

                            <div class="d-flex justify-content-between
                                        small fw-semibold mb-2">

                                <span>
                                    {{ $subject[0] }}
                                </span>

                                <span>
                                    {{ $subject[1] }}%
                                </span>

                            </div>

                            <div class="progress"
                                 style="height:7px;">

                                <div
                                    class="progress-bar bg-success rounded-pill"
                                    style="width: {{ $subject[1] }}%;">
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- Attendance Trend --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-1">
                        Attendance Trend
                    </h5>

                    <div id="attendance-trend-chart"></div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- =========================================================
    ATTENDANCE PAGE JAVASCRIPT
========================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       DONUT CHART
    ========================== */

    const overviewElement =
        document.querySelector('#attendance-overview-chart');

    if (overviewElement && typeof ApexCharts !== 'undefined') {

        const overviewOptions = {

            chart: {
                type: 'donut',
                height: 280
            },

            series: [46, 2, 2],

            labels: [
                'Present',
                'Late',
                'Absent'
            ],

            legend: {
                position: 'bottom'
            },

            dataLabels: {
                enabled: false
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

            }

        };

        new ApexCharts(
            overviewElement,
            overviewOptions
        ).render();

    }


    /* =========================
       TREND CHART
    ========================== */

    const trendElement =
        document.querySelector('#attendance-trend-chart');

    if (trendElement && typeof ApexCharts !== 'undefined') {

        const trendOptions = {

            chart: {

                type: 'area',

                height: 220,

                toolbar: {
                    show: false
                }
            },

            series: [

                {
                    name: 'Attendance',

                    data: [
                        88,
                        90,
                        92,
                        92
                    ]
                }

            ],

            xaxis: {

                categories: [
                    'Week 1',
                    'Week 2',
                    'Week 3',
                    'Week 4'
                ]

            },

            yaxis: {

                min: 0,

                max: 100,

                labels: {

                    formatter: function (value) {
                        return value + '%';
                    }

                }

            },

            stroke: {

                curve: 'smooth',

                width: 3

            },

            dataLabels: {

                enabled: false

            },

            fill: {

                type: 'gradient',

                gradient: {

                    opacityFrom: 0.35,

                    opacityTo: 0.05

                }

            },

            tooltip: {

                y: {

                    formatter: function (value) {
                        return value + '%';
                    }

                }

            }

        };

        new ApexCharts(
            trendElement,
            trendOptions
        ).render();

    }

});

</script>

@endpush