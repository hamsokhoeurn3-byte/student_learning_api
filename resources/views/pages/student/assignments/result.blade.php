@extends('layouts.student')
@section('title', 'Assignment Result - SLAS')
@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Assignment Result 
            </h2>
            <div class="text-muted">
                Dashboard / Assignments / Result
            </div>
        </div>
        <a href="{{ route('student.assignments') }}"
           class="btn btn-outline-primary rounded-3">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Assignments
        </a>
    </div>
    <div class="row g-4">
        {{-- Main Result --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="fw-bold">
                        Algorithm Analysis
                    </h3>
                    <p class="text-muted">
                        Algorithms • CS201
                    </p>
                    <hr>
                    {{-- Score --}}
                    <div class="text-center py-4">
                        <div class="display-4 fw-bold text-primary">
                            85/100
                        </div>
                        <div class="display-6 fw-bold">
                            A-
                        </div>
                        <span class="badge bg-success-subtle
                                     text-success rounded-pill px-3 py-2">
                            Excellent
                        </span>
                    </div>
                    <hr>
                    {{-- Feedback --}}
                    <h5 class="fw-bold mb-3">
                        Teacher Feedback
                    </h5>
                    <div class="bg-light rounded-4 p-4">
                        <i class="bi bi-chat-quote
                                  text-primary fs-4"></i>
                        <p class="mt-2 mb-0 text-muted">
                            Good analysis and explanation.
                            Your complexity calculation is correct.
                        </p>
                    </div>
                    {{-- Submission --}}
                    <h5 class="fw-bold mt-4 mb-3">
                        Your Submission
                    </h5>
                    <div class="border rounded-3 p-3
                                d-flex justify-content-between
                                align-items-center">
                        <div>
                            <i class="bi bi-file-earmark-pdf
                                      text-danger me-2"></i>
                            Algorithm_Analysis.pdf
                        </div>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-eye me-1"></i>
                            View File
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Right --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        Submission Information
                    </h5>
                    <div class="mb-3">
                        <small class="text-muted">
                            Submitted
                        </small>
                        <div class="fw-semibold">
                            Sep 10, 2026
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            Graded
                        </small>
                        <div class="fw-semibold">
                            Sep 11, 2026
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">
                            Graded By
                        </small>
                        <div class="fw-semibold">
                            Dr. Smith
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection