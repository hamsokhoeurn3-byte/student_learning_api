@php
    $isStudent = strtolower($audience ?? '') === 'student';
    $studentProfile = $isStudent ? Auth::user()->student : null;
    $profileRoute = match (strtolower($audience ?? 'admin')) {
        'student' => 'student.profile.update',
        'teacher' => 'teacher.profile.update',
        default => 'admin.profile.update',
    };
@endphp

<div class="mb-4">
    <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Settings</div>
    <h1 class="h2 fw-bold mb-1">Settings</h1>
    <p class="text-muted mb-0">Manage your {{ strtolower($audience) }} preferences and account security.</p>
</div>

@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-{{ $isStudent ? 12 : 8 }}">
        <div class="card portal-card border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Personal information</h5>
                <form method="POST" action="{{ route($profileRoute) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label small fw-semibold">Full name</label><input
                            @unless($isStudent) name="name" @endunless class="form-control" value="{{ Auth::user()->name ?? $audience }}" @readonly($isStudent)></div>
                        <div class="col-md-6"><label class="form-label small fw-semibold">Email address</label><input
                            @unless($isStudent) name="email" @endunless class="form-control"
                            value="{{ Auth::user()->email ?? 'user@slas.edu' }}" @readonly($isStudent)></div>
                        @if($isStudent)
                            <div class="col-12 mt-4"><h6 class="fw-bold mb-0">Student information</h6><p class="small text-muted mb-0">These details are managed by your school administrator.</p></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Student ID</label><input class="form-control" value="{{ $studentProfile?->student_id ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Date of birth</label><input class="form-control" value="{{ $studentProfile?->date_of_birth ? \Carbon\Carbon::parse($studentProfile->date_of_birth)->format('M d, Y') : 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Gender</label><input class="form-control" value="{{ $studentProfile?->gender ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Nationality</label><input class="form-control" value="{{ $studentProfile?->nationality ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Phone</label><input class="form-control" value="{{ $studentProfile?->phone ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Address</label><input class="form-control" value="{{ $studentProfile?->address ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Department</label><input class="form-control" value="{{ $studentProfile?->department ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Major</label><input class="form-control" value="{{ $studentProfile?->major ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Year level</label><input class="form-control" value="{{ $studentProfile?->year_level ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Semester</label><input class="form-control" value="{{ $studentProfile?->semester ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Academic year</label><input class="form-control" value="{{ $studentProfile?->academic_year ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Advisor</label><input class="form-control" value="{{ $studentProfile?->advisor ?? 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Enrollment date</label><input class="form-control" value="{{ $studentProfile?->enrollment_date ? \Carbon\Carbon::parse($studentProfile->enrollment_date)->format('M d, Y') : 'Not set' }}" readonly></div>
                            <div class="col-md-6"><label class="form-label small fw-semibold">Status</label><input class="form-control" value="{{ $studentProfile?->status ? ucfirst($studentProfile->status) : 'Not set' }}" readonly></div>
                        @endif
                        <div class="col-md-12">
                            <div class="card border-0 bg-light-subtle">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle overflow-hidden border border-2 border-primary-subtle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 72px; height: 72px;">
                                            @if (Auth::user()->profile_picture_url)
                                                <img src="{{ Auth::user()->profile_picture_url }}"
                                                    alt="Profile"
                                                class="img-fluid w-100 h-100 object-fit-cover">@else<span
                                                    class="fw-bold text-primary fs-4">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Profile picture</div>
                                            <div class="small text-muted">Upload a JPG, PNG, or WEBP image up to 2MB.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3"><input name="profile_picture" type="file"
                                            class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <h6 class="fw-bold">Notifications</h6>
                        <div class="form-check form-switch mt-3"><input class="form-check-input" type="checkbox"
                            checked @disabled($isStudent)><label class="form-check-label">Email notifications for deadlines and
                            updates</label></div>
                    <div class="form-check form-switch mt-2"><input class="form-check-input" type="checkbox"
                            checked @disabled($isStudent)><label class="form-check-label">Weekly progress summary</label></div>
                    <div class="text-end mt-4"><button type="submit" class="btn btn-primary px-4">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @unless($isStudent)
    <div class="col-lg-4">
        <div class="card portal-card border-0">
            <div class="card-body p-4">
                <div class="portal-stat-icon mb-3"><i class="bi bi-shield-check"></i></div>
                <h5 class="fw-bold">Account security</h5>
                <p class="small text-muted">Keep your account protected with a strong password.</p><button
                    class="btn btn-outline-primary w-100">Change password</button>
            </div>
        </div>
    </div>
    @endunless
</div>
