@extends('layouts.student')

@section('title', 'Profile')

@section('content')

<div class="container-fluid px-lg-4 px-4 py-3">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="d-flex flex-column flex-md-row
                align-items-md-center
                justify-content-between
                gap-3 mb-4">

        <div>
            <div class="text-primary small fw-semibold mb-1">
                Dashboard / Profile
            </div>

            <h1 class="h3 fw-bold text-dark mb-1">
                Student Profile
            </h1>

            <p class="text-secondary mb-0">
                Manage your personal and academic information.
            </p>
        </div>

        <!-- <button type="button"
                class="btn btn-outline-primary rounded-3 px-4">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Profile
        </button> -->
        <a href="{{ route('student.profile.edit') }}"
        class="btn btn-outline-primary rounded-3 px-4">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Profile
        </a>

    </div>


    {{-- =========================================================
         TOP PROFILE INFORMATION
    ========================================================== --}}
    <div class="row g-4 mb-4">

        {{-- PROFILE CARD --}}
        <div class="col-12 col-lg-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body text-center p-4">

                    {{-- Avatar --}}
                    <div class="rounded-circle
                                bg-primary-subtle
                                text-primary
                                d-flex
                                align-items-center
                                justify-content-center
                                mx-auto
                                mb-3"
                         style="width: 100px; height: 100px;">

                        <span class="display-6 fw-bold">
                            JD
                        </span>

                    </div>

                    <h4 class="fw-bold text-dark mb-1">
                        John Doe
                    </h4>

                    <div class="mb-2">
                        <span class="badge
                                     bg-primary-subtle
                                     text-primary
                                     rounded-pill
                                     px-3 py-2">
                            BSR181174
                        </span>
                    </div>

                    <p class="text-secondary mb-2">
                        Computer Science Student
                    </p>

                    <p class="small text-secondary mb-3">
                        3rd Year
                        <span class="mx-1">•</span>
                        Semester 6
                    </p>

                    <span class="badge
                                 bg-success-subtle
                                 text-success
                                 rounded-pill
                                 px-3 py-2">

                        <i class="bi bi-check-circle-fill me-1"></i>
                        Active

                    </span>

                </div>

            </div>

        </div>


        {{-- PERSONAL INFORMATION --}}
        <div class="col-12 col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold text-dark mb-4">

                        <i class="bi bi-person-circle text-primary me-2"></i>

                        Personal Information

                    </h5>


                    <div class="row g-3">

                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-person"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Full Name
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        John Doe
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-card-text"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Student ID
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        BSR181174
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-envelope"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Email
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        john.doe@student.com
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-telephone"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Phone
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        +855 12 345 678
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-calendar3"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Date of Birth
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        May 15, 2002
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-gender-ambiguous"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Gender
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        Male
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <div class="d-flex">

                                <div class="text-primary me-3">
                                    <i class="bi bi-geo-alt"></i>
                                </div>

                                <div class="flex-grow-1">

                                    <div class="small text-secondary">
                                        Address
                                    </div>

                                    <div class="fw-semibold text-dark">
                                        Phnom Penh, Cambodia
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ACADEMIC INFORMATION --}}
        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold text-dark mb-4">

                        <i class="bi bi-mortarboard-fill text-primary me-2"></i>

                        Academic Information

                    </h5>


                    <div class="row g-3">

                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-building text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Department
                                    </div>

                                    <div class="fw-semibold">
                                        Computer Science
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-code-square text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Major
                                    </div>

                                    <div class="fw-semibold">
                                        Software Engineering
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-calendar3 text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Academic Year
                                    </div>

                                    <div class="fw-semibold">
                                        2023 - 2024
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-layers text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Year Level
                                    </div>

                                    <div class="fw-semibold">
                                        3rd Year
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-book text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Semester
                                    </div>

                                    <div class="fw-semibold">
                                        Semester 6
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-person-badge text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Advisor
                                    </div>

                                    <div class="fw-semibold">
                                        Dr. Emily Johnson
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex">

                                <i class="bi bi-calendar-check text-primary me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Enrollment Date
                                    </div>

                                    <div class="fw-semibold">
                                        Sep 1, 2021
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-check-circle text-success me-3"></i>

                                <div>
                                    <div class="small text-secondary">
                                        Status
                                    </div>

                                    <span class="badge
                                                 bg-success-subtle
                                                 text-success
                                                 rounded-pill">

                                        Enrolled

                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         BOTTOM SECTION
    ========================================================== --}}
    <div class="row g-4">

        {{-- ACADEMIC SUMMARY --}}
        <div class="col-12 col-lg-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-bar-chart-fill text-primary me-2"></i>
                        Academic Summary
                    </h5>


                    <div class="row g-3">

                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    GPA
                                </small>

                                <div class="fs-4 fw-bold">
                                    3.75
                                </div>

                                <small class="text-success fw-semibold">
                                    Good
                                </small>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    Attendance
                                </small>

                                <div class="fs-4 fw-bold">
                                    92%
                                </div>

                                <small class="text-success fw-semibold">
                                    Excellent
                                </small>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    Assignments
                                </small>

                                <div class="fs-4 fw-bold">
                                    8/12
                                </div>

                                <small class="text-secondary">
                                    Completed
                                </small>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    Quizzes
                                </small>

                                <div class="fs-4 fw-bold">
                                    85%
                                </div>

                                <small class="text-success fw-semibold">
                                    Good
                                </small>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    Credits
                                </small>

                                <div class="fs-4 fw-bold">
                                    75/120
                                </div>

                                <small class="text-secondary">
                                    Credits
                                </small>
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="border rounded-3 text-center p-3">
                                <small class="text-secondary">
                                    Rank
                                </small>

                                <div class="fs-4 fw-bold">
                                    5/50
                                </div>

                                <small class="text-secondary">
                                    Top 10%
                                </small>
                            </div>
                        </div>

                    </div>


                    <a href="{{ route('student.analytics') }}"
                    class="btn btn-light w-100 text-primary">
                        View All analytics
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>

                </div>

            </div>

        </div>


        {{-- CURRENT SUBJECTS --}}
        <div class="col-12 col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex
                                justify-content-between
                                align-items-center
                                mb-4">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-book text-primary me-2"></i>

                            Current Subjects

                        </h5>

                        <a href="{{ route('student.courses') }}"
                        class="text-primary
                                  text-decoration-none
                                  small
                                  fw-semibold">
                            View All
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                        </a>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-borderless align-middle mb-0">

                            <thead>

                                <tr class="text-secondary small">

                                    <th>Code</th>
                                    <th>Subject</th>
                                    <th>Teacher</th>
                                    <th>Progress</th>
                                    <th>Grade</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td class="fw-semibold">
                                        CS101
                                    </td>

                                    <td>
                                        Data Structures
                                    </td>

                                    <td>
                                        Dr. Smith
                                    </td>

                                    <td style="min-width: 100px;">

                                        <div class="progress"
                                             role="progressbar"
                                             aria-label="Data Structures progress"
                                             aria-valuenow="90"
                                             aria-valuemin="0"
                                             aria-valuemax="100">

                                            <div class="progress-bar bg-primary"
                                                 style="width: 90%">
                                            </div>

                                        </div>

                                        <small class="text-secondary">
                                            90%
                                        </small>

                                    </td>

                                    <td class="fw-bold">
                                        A
                                    </td>

                                </tr>


                                <tr>

                                    <td class="fw-semibold">
                                        CS102
                                    </td>

                                    <td>
                                        Database Systems
                                    </td>

                                    <td>
                                        Mr. Johnson
                                    </td>

                                    <td>

                                        <div class="progress"
                                             role="progressbar"
                                             aria-label="Database progress"
                                             aria-valuenow="85"
                                             aria-valuemin="0"
                                             aria-valuemax="100">

                                            <div class="progress-bar bg-primary"
                                                 style="width: 85%">
                                            </div>

                                        </div>

                                        <small class="text-secondary">
                                            85%
                                        </small>

                                    </td>

                                    <td class="fw-bold">
                                        A-
                                    </td>

                                </tr>


                                <tr>

                                    <td class="fw-semibold">
                                        CS103
                                    </td>

                                    <td>
                                        Web Development
                                    </td>

                                    <td>
                                        Mrs. Brown
                                    </td>

                                    <td>

                                        <div class="progress"
                                             role="progressbar"
                                             aria-label="Web Development progress"
                                             aria-valuenow="80"
                                             aria-valuemin="0"
                                             aria-valuemax="100">

                                            <div class="progress-bar bg-primary"
                                                 style="width: 80%">
                                            </div>

                                        </div>

                                        <small class="text-secondary">
                                            80%
                                        </small>

                                    </td>

                                    <td class="fw-bold">
                                        B+
                                    </td>

                                </tr>


                                <tr>

                                    <td class="fw-semibold">
                                        MATH201
                                    </td>

                                    <td>
                                        Discrete Mathematics
                                    </td>

                                    <td>
                                        Dr. Wilson
                                    </td>

                                    <td>

                                        <div class="progress"
                                             role="progressbar"
                                             aria-label="Mathematics progress"
                                             aria-valuenow="75"
                                             aria-valuemin="0"
                                             aria-valuemax="100">

                                            <div class="progress-bar bg-primary"
                                                 style="width: 75%">
                                            </div>

                                        </div>

                                        <small class="text-secondary">
                                            75%
                                        </small>

                                    </td>

                                    <td class="fw-bold">
                                        B+
                                    </td>

                                </tr>


                                <tr>

                                    <td class="fw-semibold">
                                        ENG101
                                    </td>

                                    <td>
                                        Technical Writing
                                    </td>

                                    <td>
                                        Ms. Davis
                                    </td>

                                    <td>

                                        <div class="progress"
                                             role="progressbar"
                                             aria-label="Technical Writing progress"
                                             aria-valuenow="70"
                                             aria-valuemin="0"
                                             aria-valuemax="100">

                                            <div class="progress-bar bg-primary"
                                                 style="width: 70%">
                                            </div>

                                        </div>

                                        <small class="text-secondary">
                                            70%
                                        </small>

                                    </td>

                                    <td class="fw-bold">
                                        B
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    
                    <a href="{{ route('student.courses') }}"
                    class="btn btn-light w-100 text-primary">
                        View All Courses
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>

            </div>

        </div>


        {{-- RECENT ACTIVITIES --}}
        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex
                                justify-content-between
                                align-items-center
                                mb-4">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-clock-history text-primary me-2"></i>

                            Recent Activities

                        </h5>

                        
                        <a href="{{ route('student.notifications') }}"
                        class="text-primary
                                  text-decoration-none
                                  small
                                  fw-semibold">
                            View All
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>

                    </div>


                    {{-- Activity 1 --}}
                    <div class="d-flex gap-3 mb-4">

                        <div class="rounded-circle
                                    bg-success-subtle
                                    text-success
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    flex-shrink-0"
                             style="width: 40px; height: 40px;">

                            <i class="bi bi-check-lg"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Assignment submitted
                            </div>

                            <small class="text-secondary">
                                Data Structures Assignment
                            </small>

                        </div>

                        <small class="text-secondary text-nowrap">
                            2 hours ago
                        </small>

                    </div>


                    {{-- Activity 2 --}}
                    <div class="d-flex gap-3 mb-4">

                        <div class="rounded-circle
                                    bg-primary-subtle
                                    text-primary
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    flex-shrink-0"
                             style="width: 40px; height: 40px;">

                            <i class="bi bi-question-lg"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Quiz completed
                            </div>

                            <small class="text-secondary">
                                Math Quiz 1
                            </small>

                        </div>

                        <small class="text-secondary text-nowrap">
                            5 hours ago
                        </small>

                    </div>


                    {{-- Activity 3 --}}
                    <div class="d-flex gap-3 mb-4">

                        <div class="rounded-circle
                                    bg-warning-subtle
                                    text-warning
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    flex-shrink-0"
                             style="width: 40px; height: 40px;">

                            <i class="bi bi-star-fill"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Grade updated
                            </div>

                            <small class="text-secondary">
                                Physics Quiz
                            </small>

                        </div>

                        <small class="text-secondary text-nowrap">
                            1 day ago
                        </small>

                    </div>


                    {{-- Activity 4 --}}
                    <div class="d-flex gap-3 mb-4">

                        <div class="rounded-circle
                                    bg-primary-subtle
                                    text-primary
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    flex-shrink-0"
                             style="width: 40px; height: 40px;">

                            <i class="bi bi-book"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                New course material
                            </div>

                            <small class="text-secondary">
                                Software Engineering
                            </small>

                        </div>

                        <small class="text-secondary text-nowrap">
                            2 days ago
                        </small>

                    </div>


                    {{-- Activity 5 --}}
                    <div class="d-flex gap-3">

                        <div class="rounded-circle
                                    bg-danger-subtle
                                    text-danger
                                    d-flex
                                    align-items-center
                                    justify-content-center
                                    flex-shrink-0"
                             style="width: 40px; height: 40px;">

                            <i class="bi bi-calendar-check"></i>

                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Attendance marked
                            </div>

                            <small class="text-secondary">
                                Web Development Class
                            </small>

                        </div>

                        <small class="text-secondary text-nowrap">
                            2 days ago
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection