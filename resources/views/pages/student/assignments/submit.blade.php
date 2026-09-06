@extends('layouts.student')

@section('title', 'Submit Assignment - SLAS')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Assignment Submission
            </h2>

            <div class="text-muted">
                <a href="{{ route('student.assignments') }}"
                   class="text-decoration-none">
                    Assignments
                </a>

                <span class="mx-2">/</span>

                <span>Submit</span>
            </div>
        </div>

        <a href="{{ route('student.assignments') }}"
           class="btn btn-outline-primary rounded-3">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Assignments

        </a>

    </div>


    <div class="row g-4">

        {{-- Main --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h4 class="fw-bold">
                        Data Structures Assignment
                    </h4>

                    <p class="text-muted">
                        Implement linked list operations
                    </p>

                    <hr>

                    <div class="row mb-4">

                        <div class="col-md-4">
                            <small class="text-muted">
                                Course
                            </small>

                            <div class="fw-semibold">
                                Data Structures
                            </div>

                            <small class="text-muted">
                                CS101
                            </small>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">
                                Due Date
                            </small>

                            <div class="fw-semibold text-danger">
                                Sep 05, 2026
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

                    </div>


                    {{-- Instructions --}}
                    <h5 class="fw-bold mb-3">
                        Assignment Instructions
                    </h5>

                    <div class="bg-light rounded-3 p-3 mb-4">

                        Implement linked list operations
                        and explain your solution.

                    </div>


                    {{-- Upload --}}
                    <h5 class="fw-bold mb-3">
                        Your Submission
                    </h5>

                    <div class="border border-2 border-dashed
                                rounded-4 p-5 text-center mb-4">

                        <i class="bi bi-cloud-arrow-up
                                  text-primary fs-1"></i>

                        <h6 class="fw-semibold mt-3">
                            Drag & Drop your file here
                        </h6>

                        <p class="text-muted">
                            or
                        </p>

                        <input type="file"
                               class="form-control">

                        <small class="text-muted d-block mt-2">
                            PDF, DOCX, ZIP (Max 10MB)
                        </small>

                    </div>


                    {{-- Comment --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Comment
                        </label>

                        <textarea class="form-control rounded-3"
                                  rows="4"
                                  placeholder="Add a comment to your teacher..."></textarea>

                    </div>


                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('student.assignments') }}"
                           class="btn btn-light border rounded-3 px-4">

                            Cancel

                        </a>

                        <button type="button"
                                class="btn btn-primary rounded-3 px-4">

                            <i class="bi bi-send me-2"></i>

                            Submit Assignment

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

                    <div class="d-flex mb-3">

                        <i class="bi bi-clock text-warning fs-5 me-3"></i>

                        <div>
                            <small class="text-muted">
                                Status
                            </small>

                            <div class="text-danger fw-semibold">
                                Overdue
                            </div>
                        </div>

                    </div>

                    <div class="d-flex mb-3">

                        <i class="bi bi-file-earmark text-primary
                                  fs-5 me-3"></i>

                        <div>
                            <small class="text-muted">
                                File Type
                            </small>

                            <div>
                                PDF, DOCX, ZIP
                            </div>
                        </div>

                    </div>

                    <div class="d-flex">

                        <i class="bi bi-award text-success
                                  fs-5 me-3"></i>

                        <div>
                            <small class="text-muted">
                                Maximum Marks
                            </small>

                            <div>
                                100
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection