@extends('layouts.student')

@section('title', 'Profile')

@section('content')

@php
    $user = Auth::user();
    $student = $student ?? \App\Models\Student::where('user_id', $user->id)->first();
    $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $displayName = $fullName !== '' ? $fullName : ($user->name ?? 'Student');
    $initials = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $displayName), 0, 2) ?: 'ST');
    $studentId = $student->student_id ?? 'N/A';
    $department = $student->department?->name ?? 'Not assigned';
    $major = $student->major ?? 'Not assigned';
    $yearLevel = $student->year_level ?? 'N/A';
    $semester = $student->semester ?? 'N/A';
    $phone = $student->phone ?? 'Not provided';
    $address = $student->address ?? 'Not provided';
    $gender = $student->gender ?? 'Not set';
    $dob = $student && $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'Not set';
@endphp

<div class="container-fluid px-lg-4 px-4 py-3">

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="text-primary small fw-semibold mb-1">Dashboard / Profile</div>
            <h1 class="h3 fw-bold text-dark mb-1">Student Profile</h1>
            <p class="text-secondary mb-0">Manage your personal and academic information.</p>
        </div>

        <a href="{{ route('student.profile.edit') }}" class="btn btn-outline-primary rounded-3 px-4">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Profile
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mx-auto mb-3 overflow-hidden" style="width: 100px; height: 100px;">
                        @if($user->profile_picture_url)
                            <img src="{{ $user->profile_picture_url }}" alt="{{ $displayName }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <span class="display-6 fw-bold">{{ $initials }}</span>
                        @endif
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $displayName }}</h4>

                    <div class="mb-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                            {{ $studentId }}
                        </span>
                    </div>

                    <p class="text-secondary mb-2">{{ $department }} Student</p>

                    <p class="small text-secondary mb-3">
                        {{ $yearLevel }}
                        <span class="mx-1">�</span>
                        {{ $semester }}
                    </p>

                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Active
                    </span>
                </div>
            </div>
        </div>

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
                                <div class="text-primary me-3"><i class="bi bi-person"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Full Name</div>
                                    <div class="fw-semibold text-dark">{{ $displayName }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-card-text"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Student ID</div>
                                    <div class="fw-semibold text-dark">{{ $studentId }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-envelope"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Email</div>
                                    <div class="fw-semibold text-dark">{{ $user->email ?? 'Not provided' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-telephone"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Phone</div>
                                    <div class="fw-semibold text-dark">{{ $phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-geo-alt"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Address</div>
                                    <div class="fw-semibold text-dark">{{ $address }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-mortarboard text-primary me-2"></i>
                        Academic Information
                    </h5>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-building"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Department</div>
                                    <div class="fw-semibold text-dark">{{ $department }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-code-slash"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Major</div>
                                    <div class="fw-semibold text-dark">{{ $major }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-layers"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Year Level</div>
                                    <div class="fw-semibold text-dark">{{ $yearLevel }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-book"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Semester</div>
                                    <div class="fw-semibold text-dark">{{ $semester }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-calendar3"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Date of Birth</div>
                                    <div class="fw-semibold text-dark">{{ $dob }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex">
                                <div class="text-primary me-3"><i class="bi bi-gender-male"></i></div>
                                <div class="flex-grow-1">
                                    <div class="small text-secondary">Gender</div>
                                    <div class="fw-semibold text-dark">{{ $gender }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


