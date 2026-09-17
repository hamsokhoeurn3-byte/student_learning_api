@extends('layouts.admin')
@section('title', 'System Settings · SLAS')
@section('content')
    <div class="mb-4">
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Settings</div>
        <h1 class="h2 fw-bold mb-1">Admin Profile</h1>
        <p class="text-muted mb-0">Update your administrator account details and password.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card portal-card border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Personal information</h5>

                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-semibold">Full name</label>
                                <input id="name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold">Email address</label>
                                <input id="email" name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Admin ID</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->admin?->admin_id ?? 'ADM001' }}" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="card border-0 bg-light-subtle mb-4">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle overflow-hidden border border-2 border-primary-subtle bg-white d-flex align-items-center justify-content-center"
                                        style="width: 72px; height: 72px;">
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                                alt="Profile" class="img-fluid w-100 h-100 object-fit-cover">
                                        @else
                                            <span
                                                class="fw-bold text-primary fs-4">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Profile picture</div>
                                        <div class="small text-muted">Upload a JPG, PNG, or WEBP image up to 2MB.</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <input id="profile_picture" name="profile_picture" type="file"
                                        class="form-control @error('profile_picture') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    @error('profile_picture')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold">Change password</h6>
                        <p class="small text-muted">Leave these fields empty to keep the current password.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label small fw-semibold">New password</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label small fw-semibold">Confirm new
                                    password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Save changes</button>
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
                    <p class="small text-muted mb-0">Your administrator role and ID cannot be changed from this page.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
