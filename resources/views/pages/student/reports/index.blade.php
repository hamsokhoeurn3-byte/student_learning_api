@extends('layouts.student')

@section('title', 'Reports - SLAS')

@section('content')

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Reports
            </h1>

            <p class="text-muted mb-0">
                Dashboard / Reports
            </p>
        </div>

        <div class="d-flex gap-2">

            <button class="btn btn-outline-primary">
                <i class="bi bi-download"></i>
                Export PDF
            </button>

            <button class="btn btn-primary">
                <i class="bi bi-file-earmark-excel"></i>
                Export Excel
            </button>

        </div>

    </div>


    {{-- ================= SUMMARY CARDS ================= --}}

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <small class="text-muted">
                        Total Students
                    </small>

                    <h2 class="fw-bold mt-2">
                        256
                    </h2>

                    <span class="text-success">
                        ↑ 12 this month
                    </span>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <small class="text-muted">
                        Courses
                    </small>

                    <h2 class="fw-bold mt-2">
                        18
                    </h2>

                    <span class="text-success">
                        ↑ 2 this month
                    </span>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <small class="text-muted">
                        Average GPA
                    </small>

                    <h2 class="fw-bold mt-2">
                        3.75
                    </h2>

                    <span class="text-success">
                        Good
                    </span>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <small class="text-muted">
                        Assignments
                    </small>

                    <h2 class="fw-bold mt-2">
                        142
                    </h2>

                    <span class="text-warning">
                        88% submitted
                    </span>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <small class="text-muted">
                        Quizzes Taken
                    </small>

                    <h2 class="fw-bold mt-2">
                        312
                    </h2>

                    <span class="text-danger">
                        85% average
                    </span>

                </div>
            </div>
        </div>

    </div>


    {{-- ================= REPORT FILTER ================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label class="form-label">
                        Report Type
                    </label>

                    <select class="form-select">
                        <option>Overview Report</option>
                        <option>Attendance Report</option>
                        <option>Assignment Report</option>
                        <option>Quiz Performance</option>
                    </select>

                </div>


                <div class="col-md-3">

                    <label class="form-label">
                        Course
                    </label>

                    <select class="form-select">
                        <option>All Courses</option>
                        <option>Data Structures</option>
                        <option>Database Systems</option>
                        <option>Web Development</option>
                    </select>

                </div>


                <div class="col-md-3">

                    <label class="form-label">
                        Date Range
                    </label>

                    <select class="form-select">
                        <option>May 1 – May 31, 2024</option>
                        <option>April 1 – April 30, 2024</option>
                        <option>March 1 – March 31, 2024</option>
                    </select>

                </div>


                <div class="col-md-2">

                    <button class="btn btn-primary w-100">
                        Generate Report
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ================= REPORT CONTENT ================= --}}

    <div class="row g-4">

        {{-- GPA Distribution --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        GPA Distribution
                    </h5>

                    <div class="text-center py-5">

                        <h1 class="fw-bold">
                            256
                        </h1>

                        <p class="text-muted">
                            Students
                        </p>

                        <div class="progress mb-3"
                             style="height: 25px;">

                            <div class="progress-bar bg-success"
                                 style="width: 22%">
                                22%
                            </div>

                            <div class="progress-bar bg-primary"
                                 style="width: 34%">
                                34%
                            </div>

                            <div class="progress-bar bg-warning"
                                 style="width: 24%">
                                24%
                            </div>

                            <div class="progress-bar bg-danger"
                                 style="width: 12%">
                                12%
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Attendance --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Attendance Overview
                    </h5>

                    <div style="height:250px;">

                        <canvas id="attendanceChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================= COURSE PERFORMANCE ================= --}}

    <div class="card border-0 shadow-sm mt-4">

        <div class="card-body">

            <h5 class="fw-bold mb-4">
                Course Performance Report
            </h5>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Students</th>
                        <th>Average GPA</th>
                        <th>Attendance</th>
                        <th>Assignments</th>
                        <th>Quizzes</th>
                    </tr>

                    </thead>

                    <tbody>

                    <tr>
                        <td>1</td>
                        <td>Data Structures (CS101)</td>
                        <td>45</td>
                        <td class="text-success">3.85</td>
                        <td class="text-success">93%</td>
                        <td>92%</td>
                        <td>87%</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Database Systems (CS102)</td>
                        <td>38</td>
                        <td>3.60</td>
                        <td class="text-success">90%</td>
                        <td>88%</td>
                        <td>84%</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Web Development (CS103)</td>
                        <td>42</td>
                        <td>3.70</td>
                        <td class="text-success">91%</td>
                        <td>85%</td>
                        <td>82%</td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Discrete Mathematics</td>
                        <td>30</td>
                        <td>3.30</td>
                        <td class="text-success">88%</td>
                        <td>80%</td>
                        <td>75%</td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Technical Writing</td>
                        <td>25</td>
                        <td>3.75</td>
                        <td class="text-success">95%</td>
                        <td>93%</td>
                        <td>90%</td>
                    </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- Chart Library --}}
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document
    .getElementById('attendanceChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: [
            'Week 1',
            'Week 2',
            'Week 3',
            'Week 4',
            'Week 5'
        ],

        datasets: [

            {
                label: 'This Month',

                data: [
                    85,
                    88,
                    92,
                    90,
                    93
                ],

                tension: 0.4,

                fill: true
            },

            {
                label: 'Last Month',

                data: [
                    78,
                    80,
                    83,
                    82,
                    86
                ],

                tension: 0.4
            }

        ]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false

    }

});

</script>

@endpush

@endsection