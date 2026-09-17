@php
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
    <div class="col-lg-8">
        <div class="card portal-card border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Personal information</h5>
                <form method="POST" action="{{ route($profileRoute) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label small fw-semibold">Full name</label><input
                                name="name" class="form-control" value="{{ Auth::user()->name ?? $audience }}"></div>
                        <div class="col-md-6"><label class="form-label small fw-semibold">Email address</label><input
                                name="email" class="form-control"
                                value="{{ Auth::user()->email ?? 'user@slas.edu' }}"></div>
                        <div class="col-md-12">
                            <div class="card border-0 bg-light-subtle">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle overflow-hidden border border-2 border-primary-subtle bg-white d-flex align-items-center justify-content-center"
                                            style="width: 72px; height: 72px;">
                                            @if (Auth::user()->profile_picture)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
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
                            checked><label class="form-check-label">Email notifications for deadlines and
                            updates</label></div>
                    <div class="form-check form-switch mt-2"><input class="form-check-input" type="checkbox"
                            checked><label class="form-check-label">Weekly progress summary</label></div>
                    <div class="text-end mt-4"><button type="submit" class="btn btn-primary px-4">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
</div>
