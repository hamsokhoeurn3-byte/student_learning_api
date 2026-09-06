@extends('layouts.student')

@section('title', 'Assignments - SLAS')

@section('content')

<div class="container-fluid py-4 px-4">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">Assignments</h1>

            <div class="text-muted">
                <a href="{{ url('/student/dashboard') }}"
                   class="text-decoration-none">
                    Dashboard
                </a>

                <span class="mx-2">/</span>

                <span>Assignments</span>
            </div>
        </div>

    </div>


    {{-- =========================================================
         SUMMARY CARDS
    ========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- Total --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <p class="text-muted mb-2">
                                Total Assignments
                            </p>

                            <h2 class="fw-bold mb-2">
                                12
                            </h2>

                            <small class="text-muted">
                                All assignments
                            </small>
                        </div>

                        <div class="bg-primary bg-opacity-10
                                    text-primary rounded-circle
                                    d-flex align-items-center
                                    justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-journal-text fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Completed --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Completed
                            </p>

                            <h2 class="fw-bold mb-2">
                                8
                            </h2>

                            <small class="text-success fw-semibold">
                                67% completed
                            </small>

                        </div>

                        <div class="bg-success bg-opacity-10
                                    text-success rounded-circle
                                    d-flex align-items-center
                                    justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-check-circle fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Pending --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Pending
                            </p>

                            <h2 class="fw-bold mb-2">
                                3
                            </h2>

                            <small class="text-warning fw-semibold">
                                25% pending
                            </small>

                        </div>

                        <div class="bg-warning bg-opacity-10
                                    text-warning rounded-circle
                                    d-flex align-items-center
                                    justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-clock fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Overdue --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <p class="text-muted mb-2">
                                Overdue
                            </p>

                            <h2 class="fw-bold mb-2">
                                1
                            </h2>

                            <small class="text-danger fw-semibold">
                                8% overdue
                            </small>

                        </div>

                        <div class="bg-danger bg-opacity-10
                                    text-danger rounded-circle
                                    d-flex align-items-center
                                    justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-calendar-x fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         ASSIGNMENT LIST
    ========================================================== --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- FILTER HEADER --}}
        <div class="card-body p-4">

            <div class="row g-3 align-items-center">

                {{-- Tabs --}}
                <div class="col-lg-7">

                    <ul class="nav nav-pills gap-2">

                        <li class="nav-item">

                            <a href="#"
                               class="nav-link active rounded-3 px-4">
                                All Assignments
                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="#"
                               class="nav-link text-dark">
                                Pending
                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="#"
                            class="nav-link text-dark">
                                Submit Now
                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="#"
                               class="nav-link text-dark">
                                Graded
                            </a>

                        </li>

                    </ul>

                </div>


                {{-- Filters --}}
                <div class="col-lg-5">

                    <div class="row g-2">

                        <div class="col-md-6">

                            <select class="form-select rounded-3">

                                <option selected>
                                    All Courses
                                </option>

                                <option>
                                    Data Structures
                                </option>

                                <option>
                                    Database Systems
                                </option>

                                <option>
                                    Web Development
                                </option>

                                <option>
                                    Algorithms
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <select class="form-select rounded-3">

                                <option selected>
                                    Sort by: Due Date
                                </option>

                                <option>
                                    Newest
                                </option>

                                <option>
                                    Oldest
                                </option>

                                <option>
                                    Status
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             TABLE
        ====================================================== --}}
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4 py-3">
                            Assignment
                        </th>

                        <th>
                            Course
                        </th>

                        <th>
                            Due Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Progress
                        </th>

                        <th>
                            Grade
                        </th>

                        <th class="text-end px-4">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                    {{-- =================================================
                         ASSIGNMENT 1
                    ================================================== --}}
                    <tr>

                        <td class="px-4 py-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-primary bg-opacity-10
                                            text-primary
                                            rounded-3
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            me-3"
                                     style="width:45px;height:45px;">

                                    <i class="bi bi-file-earmark-text fs-5"></i>

                                </div>

                                <div>

                                    <h6 class="fw-semibold mb-1">
                                        Data Structures Assignment
                                    </h6>

                                    <small class="text-muted">
                                        Implement linked list operations
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Data Structures
                            </div>

                            <small class="text-muted">
                                CS101
                            </small>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Sep 05, 2026
                            </div>

                            <small class="text-danger">
                                11:59 PM
                            </small>

                        </td>


                        <td>

                            <span class="badge bg-danger-subtle
                                         text-danger
                                         rounded-pill px-3 py-2">

                                Overdue

                            </span>

                        </td>


                        <td>

                            <span class="text-muted">
                                -
                            </span>

                        </td>


                        <td>

                            <span class="text-muted">
                                -
                            </span>

                        </td>


                        <td class="text-end px-4">

                            <a href="{{ url('/student/assignments/1/submit') }}"
                               class="btn btn-primary btn-sm rounded-3 px-3">

                                Submit Now

                            </a>

                            <button type="button"
                                    class="btn btn-link text-secondary">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                        </td>

                    </tr>



                    {{-- =================================================
                         ASSIGNMENT 2
                    ================================================== --}}
                    <tr>

                        <td class="px-4 py-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-warning bg-opacity-10
                                            text-warning
                                            rounded-3
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            me-3"
                                     style="width:45px;height:45px;">

                                    <i class="bi bi-database fs-5"></i>

                                </div>

                                <div>

                                    <h6 class="fw-semibold mb-1">
                                        Database Design Project
                                    </h6>

                                    <small class="text-muted">
                                        Design a university database
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Database Systems
                            </div>

                            <small class="text-muted">
                                CS102
                            </small>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Sep 08, 2026
                            </div>

                            <small class="text-warning">
                                11:59 PM
                            </small>

                        </td>


                        <td>

                            <span class="badge bg-warning-subtle
                                         text-warning
                                         rounded-pill px-3 py-2">

                                Pending

                            </span>

                        </td>


                        <td style="min-width:150px;">

                            <div class="d-flex justify-content-between mb-1">

                                <small class="fw-semibold">
                                    75%
                                </small>

                            </div>

                            <div class="progress"
                                 style="height:6px;">

                                <div class="progress-bar"
                                     style="width:75%;">

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="text-muted">
                                -
                            </span>

                        </td>


                        <td class="text-end px-4">

                            <a href="{{ route('student.assignments.continue', 2) }}"
                            class="btn btn-outline-primary rounded-3 px-4">
                                Continue
                            </a>

                            <button type="button"
                                    class="btn btn-link text-secondary">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                        </td>

                    </tr>



                    {{-- =================================================
                         ASSIGNMENT 3
                    ================================================== --}}
                    <tr>

                        <td class="px-4 py-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-success bg-opacity-10
                                            text-success
                                            rounded-3
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            me-3"
                                     style="width:45px;height:45px;">

                                    <i class="bi bi-code-square fs-5"></i>

                                </div>

                                <div>

                                    <h6 class="fw-semibold mb-1">
                                        Web Development Project
                                    </h6>

                                    <small class="text-muted">
                                        Build a responsive website
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Web Development
                            </div>

                            <small class="text-muted">
                                CS103
                            </small>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Sep 10, 2026
                            </div>

                            <small class="text-warning">
                                11:59 PM
                            </small>

                        </td>


                        <td>

                            <span class="badge bg-warning-subtle
                                         text-warning
                                         rounded-pill px-3 py-2">

                                Pending

                            </span>

                        </td>


                        <td style="min-width:150px;">

                            <div class="d-flex justify-content-between mb-1">

                                <small class="fw-semibold">
                                    50%
                                </small>

                            </div>

                            <div class="progress"
                                 style="height:6px;">

                                <div class="progress-bar"
                                     style="width:50%;">

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="text-muted">
                                -
                            </span>

                        </td>


                        <td class="text-end px-4">

                            <a href="{{ route('student.assignments.continue', 3) }}"
                            class="btn btn-outline-primary rounded-3 px-4">
                                Continue
                            </a>

                            <button type="button"
                                    class="btn btn-link text-secondary">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                        </td>

                    </tr>



                    {{-- =================================================
                         ASSIGNMENT 4
                    ================================================== --}}
                    <tr>

                        <td class="px-4 py-4">

                            <div class="d-flex align-items-center">

                                <div class="bg-info bg-opacity-10
                                            text-info
                                            rounded-3
                                            d-flex
                                            align-items-center
                                            justify-content-center
                                            me-3"
                                     style="width:45px;height:45px;">

                                    <i class="bi bi-calculator fs-5"></i>

                                </div>

                                <div>

                                    <h6 class="fw-semibold mb-1">
                                        Algorithm Analysis
                                    </h6>

                                    <small class="text-muted">
                                        Analyze time complexity
                                    </small>

                                </div>

                            </div>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Algorithms
                            </div>

                            <small class="text-muted">
                                CS201
                            </small>

                        </td>


                        <td>

                            <div class="fw-semibold">
                                Sep 12, 2026
                            </div>

                            <small class="text-muted">
                                11:59 PM
                            </small>

                        </td>


                        <td>

                            <span class="badge bg-success-subtle
                                         text-success
                                         rounded-pill px-3 py-2">

                                Submitted

                            </span>

                        </td>


                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <span class="fw-semibold">
                                    100%
                                </span>

                            </div>

                        </td>


                        <td>

                            <span class="fw-bold">
                                A-
                            </span>

                            <br>

                            <small class="text-muted">
                                85%
                            </small>

                        </td>


                        <td class="text-end px-4">

                            <a href="{{ route('student.assignments.result', 4) }}"
                            class="btn btn-outline-primary rounded-3 px-4">
                                View Result
                            </a>

                            <button type="button"
                                    class="btn btn-link text-secondary">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>


        {{-- =========================================================
             PAGINATION
        ========================================================== --}}
        <div class="card-body border-top">

            <div class="d-flex justify-content-between align-items-center">

                <div class="text-muted small">
                    Showing 1 to 4 of 12 assignments
                </div>

                <nav>

                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item disabled">

                            <a class="page-link">
                                <i class="bi bi-chevron-left"></i>
                            </a>

                        </li>

                        <li class="page-item active">

                            <a class="page-link">
                                1
                            </a>

                        </li>

                        <li class="page-item">

                            <a class="page-link">
                                2
                            </a>

                        </li>

                        <li class="page-item">

                            <a class="page-link">
                                3
                            </a>

                        </li>

                        <li class="page-item">

                            <a class="page-link">
                                <i class="bi bi-chevron-right"></i>
                            </a>

                        </li>

                    </ul>

                </nav>

            </div>

        </div>

    </div>

</div>

@endsection