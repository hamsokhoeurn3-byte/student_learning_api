@extends('layouts.student')

@section('title', 'Assignment Details - SLAS')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Assignment Details
            </h2>

            <div class="text-muted">
                Dashboard / Assignments / Details
            </div>
        </div>

        <a href="{{ route('student.assignments') }}"
           class="btn btn-outline-primary rounded-3">

            <i class="bi bi-arrow-left me-2"></i>
            Back

        </a>

    </div>


    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between
                        align-items-start">

                <div>

                    <h3 class="fw-bold">
                        Database Design Project
                    </h3>

                    <p class="text-muted">
                        Database Systems • CS102
                    </p>

                </div>

                <span class="badge bg-warning-subtle
                             text-warning rounded-pill px-3 py-2">

                    Pending

                </span>

            </div>

            <hr>


            {{-- Information --}}
            <div class="row g-4 mb-4">

                <div class="col-md-4">

                    <small class="text-muted">
                        Due Date
                    </small>

                    <div class="fw-semibold">
                        Sep 08, 2026
                    </div>

                </div>

                <div class="col-md-4">

                    <small class="text-muted">
                        Total Marks
                    </small>

                    <div class="fw-semibold">
                        100
                    </div>

                </div>

                <div class="col-md-4">

                    <small class="text-muted">
                        Progress
                    </small>

                    <div class="fw-semibold">
                        75%
                    </div>

                </div>

            </div>


            {{-- Description --}}
            <h5 class="fw-bold">
                Description
            </h5>

            <p class="text-muted mb-4">

                Design a university database using
                ERD and SQL.

            </p>


            {{-- Instructions --}}
            <h5 class="fw-bold">
                Instructions
            </h5>

            <ul class="text-muted">

                <li>Create ERD</li>

                <li>Create database tables</li>

                <li>Write SQL queries</li>

            </ul>


            {{-- Attachment --}}
            <h5 class="fw-bold mt-4">
                Attached Files
            </h5>

            <div class="border rounded-3 p-3
                        d-flex justify-content-between
                        align-items-center">

                <div>

                    <i class="bi bi-file-earmark-pdf
                              text-danger me-2"></i>

                    Database_Project_Guide.pdf

                </div>

                <button class="btn btn-outline-primary btn-sm">

                    <i class="bi bi-download me-1"></i>
                    Download

                </button>

            </div>


            {{-- Progress --}}
            <h5 class="fw-bold mt-4">
                Your Progress
            </h5>

            <div class="progress mb-2"
                 style="height:10px;">

                <div class="progress-bar"
                     style="width:75%;">

                </div>

            </div>

            <div class="text-muted small">
                75% completed
            </div>


            <div class="text-end mt-4">

                <div class="text-end mt-4">
                <a href="{{ route('student.assignments.continue', $assignment) }}"
                class="btn btn-primary rounded-3 px-4">

                    <i class="bi bi-arrow-right-circle me-2"></i>

                    Continue Working

                </a>
            </div>

            </div>

        </div>

    </div>

</div>

@endsection