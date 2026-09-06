@extends('layouts.student')

@section('title', 'Edit Profile - SLAS')

@section('content')

<div class="container-fluid bg-light min-vh-100 px-4 py-3">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <div class="text-primary small fw-semibold mb-2">
                Dashboard
                <span class="text-muted mx-2">/</span>
                Profile
                <span class="text-muted mx-2">/</span>
                Edit Profile
            </div>

            <h1 class="h2 fw-bold mb-1">
                Edit Profile
            </h1>

            <p class="text-secondary mb-0">
                Update your personal and academic information.
            </p>
        </div>

        <a href="{{ route('student.profile') }}"
           class="btn btn-outline-primary px-4 rounded-3">

            <i class="bi bi-arrow-left me-2"></i>

            Back to Profile

        </a>

    </div>


    {{-- Main Row --}}
    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4 p-lg-5">

                    {{-- Personal Information --}}
                    <div class="d-flex align-items-center mb-4">

                        <div class="text-primary fs-2 me-3">
                            <i class="bi bi-person-circle"></i>
                        </div>

                        <div>
                            <h4 class="fw-bold mb-1">
                                Personal Information
                            </h4>

                            <p class="text-secondary mb-0">
                                Keep your personal information up to date.
                            </p>
                        </div>

                    </div>


                    <div class="row g-4">

                        {{-- Full Name --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Full Name
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-person text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="John Doe"
                                    placeholder="Enter full name"
                                >

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Email Address
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>

                                <input
                                    type="email"
                                    class="form-control"
                                    value="john.doe@student.com"
                                    placeholder="Enter email"
                                >

                            </div>

                        </div>


                        {{-- Student ID --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Student ID
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-card-text text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="BSR181174"
                                    readonly
                                >

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-telephone text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="+855 12 345 678"
                                    placeholder="Enter phone number"
                                >

                            </div>

                        </div>


                        {{-- Date of Birth --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Date of Birth
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-calendar3 text-primary"></i>
                                </span>

                                <input
                                    type="date"
                                    class="form-control"
                                    value="2002-05-15"
                                >

                            </div>

                        </div>


                        {{-- Gender --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Gender
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-gender-male text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option selected>
                                        Male
                                    </option>

                                    <option>
                                        Female
                                    </option>

                                    <option>
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Address
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="Phnom Penh, Cambodia"
                                    placeholder="Enter address"
                                >

                            </div>

                        </div>

                    </div>


                    <hr class="my-5">


                    {{-- Academic Information --}}
                    <div class="d-flex align-items-center mb-4">

                        <div class="text-primary fs-2 me-3">
                            <i class="bi bi-mortarboard"></i>
                        </div>

                        <div>
                            <h4 class="fw-bold mb-1">
                                Academic Information
                            </h4>

                            <p class="text-secondary mb-0">
                                Your academic details and current status.
                            </p>
                        </div>

                    </div>


                    <div class="row g-4">

                        {{-- Department --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Department
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-building text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option selected>
                                        Computer Science
                                    </option>

                                    <option>
                                        Information Technology
                                    </option>

                                    <option>
                                        Computer Engineering
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Year Level --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Year Level
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-layers text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option>
                                        1st Year
                                    </option>

                                    <option>
                                        2nd Year
                                    </option>

                                    <option selected>
                                        3rd Year
                                    </option>

                                    <option>
                                        4th Year
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Major --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Major
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-code-slash text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option selected>
                                        Software Engineering
                                    </option>

                                    <option>
                                        Data Science
                                    </option>

                                    <option>
                                        Network Engineering
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Semester --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Semester
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-book text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option>
                                        Semester 1
                                    </option>

                                    <option>
                                        Semester 2
                                    </option>

                                    <option>
                                        Semester 3
                                    </option>

                                    <option>
                                        Semester 4
                                    </option>

                                    <option>
                                        Semester 5
                                    </option>

                                    <option selected>
                                        Semester 6
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Academic Year --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Academic Year
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-calendar3 text-primary"></i>
                                </span>

                                <select class="form-select">

                                    <option selected>
                                        2023 - 2024
                                    </option>

                                    <option>
                                        2024 - 2025
                                    </option>

                                    <option>
                                        2025 - 2026
                                    </option>

                                    <option>
                                        2026 - 2027
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Advisor --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Advisor
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-person-badge text-primary"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="Dr. Emily Johnson"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-5">

                        <a href="{{ route('student.profile') }}"
                           class="btn btn-light border px-4 rounded-3">

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary px-4 rounded-3">

                            <i class="bi bi-save me-2"></i>

                            Save Changes

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- RIGHT --}}
        <div class="col-lg-4">


            {{-- Profile Picture --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <i class="bi bi-camera fs-3 text-primary me-3"></i>

                        <div>

                            <h5 class="fw-bold mb-1">
                                Profile Picture
                            </h5>

                            <p class="text-secondary small mb-0">
                                Upload a new profile picture.
                            </p>

                        </div>

                    </div>


                    <div class="text-center">

                        <div class="bg-primary-subtle rounded-circle
                                    d-inline-flex align-items-center
                                    justify-content-center mb-3"
                             style="width: 140px; height: 140px;">

                            <span class="display-5 fw-bold text-primary">
                                JD
                            </span>

                        </div>


                        <p class="text-secondary small mb-1">
                            Recommended size: 400 × 400px
                        </p>

                        <p class="text-secondary small mb-3">
                            Max file size: 2MB (JPG, PNG)
                        </p>


                        <input
                            type="file"
                            class="form-control"
                            accept=".jpg,.jpeg,.png"
                        >

                    </div>

                </div>

            </div>


            {{-- Quick Settings --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <i class="bi bi-gear fs-3 text-primary me-3"></i>

                        <div>

                            <h5 class="fw-bold mb-1">
                                Quick Settings
                            </h5>

                            <p class="text-secondary small mb-0">
                                Manage your account settings.
                            </p>

                        </div>

                    </div>


                    <div class="list-group list-group-flush">


                        {{-- Change Password --}}
                        <a href="#"
                           class="list-group-item list-group-item-action
                                  border-0 px-0 py-3">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-lock fs-5 text-primary me-3"></i>

                                <div class="flex-grow-1">

                                    <div class="fw-semibold">
                                        Change Password
                                    </div>

                                    <small class="text-secondary">
                                        Update your account password
                                    </small>

                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </div>

                        </a>


                        {{-- Email Preferences --}}
                        <a href="#"
                           class="list-group-item list-group-item-action
                                  border-0 px-0 py-3">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-envelope fs-5 text-primary me-3"></i>

                                <div class="flex-grow-1">

                                    <div class="fw-semibold">
                                        Email Preferences
                                    </div>

                                    <small class="text-secondary">
                                        Manage notification settings
                                    </small>

                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </div>

                        </a>


                        {{-- Privacy --}}
                        <a href="#"
                           class="list-group-item list-group-item-action
                                  border-0 px-0 py-3">

                            <div class="d-flex align-items-center">

                                <i class="bi bi-shield-check fs-5 text-primary me-3"></i>

                                <div class="flex-grow-1">

                                    <div class="fw-semibold">
                                        Privacy Settings
                                    </div>

                                    <small class="text-secondary">
                                        Control your data visibility
                                    </small>

                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </div>

                        </a>


                    </div>


                    <hr>


                    {{-- Delete Account --}}
                    <button
                        type="button"
                        class="btn btn-outline-danger w-100 py-2 rounded-3">

                        <i class="bi bi-trash me-2"></i>

                        Delete Account

                    </button>

                    <p class="text-center text-secondary small mt-2 mb-0">
                        This action cannot be undone.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection