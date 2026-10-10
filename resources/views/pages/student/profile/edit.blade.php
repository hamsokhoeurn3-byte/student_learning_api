@extends('layouts.student')

@section('title', 'Edit Profile - SLAS')

@section('content')

@php
    $user = Auth::user();
    $student = $student ?? \App\Models\Student::where('user_id', $user->id)->first();
    $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $displayName = $fullName !== '' ? $fullName : ($user->name ?? 'Student');
    $initials = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $displayName), 0, 2) ?: 'ST');
@endphp

<div class="container-fluid bg-light min-vh-100 px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="text-primary small fw-semibold mb-2">
                Dashboard
                <span class="text-muted mx-2">/</span>
                Profile
                <span class="text-muted mx-2">/</span>
                Edit Profile
            </div>

            <h1 class="h2 fw-bold mb-1">Edit Profile</h1>
            <p class="text-secondary mb-0">You can update your profile picture. Contact an administrator to change other information.</p>
        </div>

        <a href="{{ route('student.profile') }}" class="btn btn-outline-primary px-4 rounded-3">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Profile
        </a>
    </div>

    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="text-primary fs-2 me-3"><i class="bi bi-person-circle"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1">Personal Information</h4>
                                <p class="text-secondary mb-0">Keep your personal details up to date.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-person text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $user->name ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-envelope text-primary"></i></span>
                                    <input type="email" class="form-control" value="{{ $user->email ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Student ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-card-text text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->student_id ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-telephone text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->phone ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-calendar3 text-primary"></i></span>
                                    <input type="date" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Gender</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-gender-male text-primary"></i></span>
                                    <select class="form-select" disabled>
                                        <option selected>{{ $student->gender ?? 'Not set' }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-geo-alt text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->address ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex align-items-center mb-4">
                            <div class="text-primary fs-2 me-3"><i class="bi bi-mortarboard"></i></div>
                            <div>
                                <h4 class="fw-bold mb-1">Academic Information</h4>
                                <p class="text-secondary mb-0">Admin-managed academic details for your student record.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-building text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->department?->name ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Year Level</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-layers text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->year_level ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Major</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-code-slash text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->major ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Semester</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-book text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->semester ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Academic Year</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-calendar3 text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->academic_year ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Advisor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-person-badge text-primary"></i></span>
                                    <input type="text" class="form-control" value="{{ $student->advisor ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('student.profile') }}" class="btn btn-light border px-4 rounded-3">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-3">
                                <i class="bi bi-save me-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-camera fs-3 text-primary me-3"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Profile Picture</h5>
                                <p class="text-secondary small mb-0">Upload a new profile picture.</p>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="bg-primary-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3 overflow-hidden" style="width: 140px; height: 140px;">
                                @if($user->profile_picture_url)
                                    <img src="{{ $user->profile_picture_url }}" alt="{{ $displayName }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <span class="display-5 fw-bold text-primary">{{ $initials }}</span>
                                @endif
                            </div>

                            <p class="text-secondary small mb-1">Recommended size: 400 � 400px</p>
                            <p class="text-secondary small mb-3">Max file size: 2MB (JPG, PNG)</p>

                            <input type="file" name="profile_picture" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection


