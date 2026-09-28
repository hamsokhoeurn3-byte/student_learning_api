@extends('layouts.admin')
@section('title', 'Edit ' . $course->name . ' · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('admin.courses') }}" class="text-decoration-none">Courses</a> <span class="text-muted mx-1">/</span> Edit</div>
        <h1 class="h2 fw-bold mb-1">Edit course</h1>
        <p class="text-muted mb-0">Update course details and assignments.</p>
    </div>
    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-primary">Cancel</a>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="card portal-card border-0">
    <form method="POST" action="{{ route('admin.courses.update', $course) }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label for="name" class="form-label">Course name</label><input id="name" name="name" value="{{ old('name', $course->name) }}" class="form-control" required maxlength="255"></div>
                <div class="col-md-6"><label for="code" class="form-label">Course code</label><input id="code" name="code" value="{{ old('code', $course->code) }}" class="form-control" required maxlength="50"></div>
                <div class="col-md-6"><label for="department" class="form-label">Department</label><input id="department" name="department" value="{{ old('department', $course->department) }}" class="form-control" maxlength="255"></div>
                <div class="col-md-6"><label for="credits" class="form-label">Credits</label><input id="credits" name="credits" type="number" min="1" max="30" value="{{ old('credits', $course->credits) }}" class="form-control"></div>
                <div class="col-md-6"><label for="teacher_id" class="form-label">Teacher</label><select id="teacher_id" name="teacher_id" class="form-select"><option value="">Not assigned</option>@foreach($teachers as $teacher)<option value="{{ $teacher->id }}" @selected((string) old('teacher_id', $course->teacher_id) === (string) $teacher->id)>{{ $teacher->user?->name ?? trim($teacher->first_name . ' ' . $teacher->last_name) }} ({{ $teacher->teacher_id }})</option>@endforeach</select></div>
                <div class="col-md-6"><label for="academic_year" class="form-label">Academic year</label><input id="academic_year" name="academic_year" value="{{ old('academic_year', $course->academic_year) }}" class="form-control" maxlength="20"></div>
                <div class="col-md-6"><label for="semester" class="form-label">Semester</label><input id="semester" name="semester" value="{{ old('semester', $course->semester) }}" class="form-control" maxlength="50"></div>
                <div class="col-md-6"><label for="status" class="form-label">Status</label><select id="status" name="status" class="form-select"><option value="active" @selected(old('status', $course->status) === 'active')>Active</option><option value="inactive" @selected(old('status', $course->status) === 'inactive')>Inactive</option></select></div>
                <div class="col-12"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="4" maxlength="2000">{{ old('description', $course->description) }}</textarea></div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-end gap-2"><a href="{{ route('admin.courses.show', $course) }}" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-2"></i>Save changes</button></div>
    </form>
</div>
@endsection
