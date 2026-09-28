@extends('layouts.admin')
@section('title', 'Edit ' . $assignment->title . ' · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('admin.assignments') }}" class="text-decoration-none">Assignments</a> <span class="text-muted mx-1">/</span> Edit</div>
        <h1 class="h2 fw-bold mb-1">Edit assignment</h1>
        <p class="text-muted mb-0">Update assignment details and course.</p>
    </div>
    <a href="{{ route('admin.assignments.show', $assignment) }}" class="btn btn-outline-primary">Cancel</a>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="card portal-card border-0">
    <form method="POST" action="{{ route('admin.assignments.update', $assignment) }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label for="title" class="form-label">Title</label><input id="title" name="title" value="{{ old('title', $assignment->title) }}" class="form-control" required maxlength="255"></div>
                <div class="col-md-6"><label for="course_id" class="form-label">Course</label><select id="course_id" name="course_id" class="form-select" required>@foreach($courses as $course)<option value="{{ $course->id }}" @selected((string) old('course_id', $assignment->course_id) === (string) $course->id)>{{ $course->name }} ({{ $course->code }})</option>@endforeach</select></div>
                <div class="col-md-6"><label for="due_date" class="form-label">Due date</label><input id="due_date" name="due_date" type="date" value="{{ old('due_date', $assignment->due_date?->format('Y-m-d')) }}" class="form-control"></div>
                <div class="col-md-6"><label for="status" class="form-label">Status</label><select id="status" name="status" class="form-select"><option value="draft" @selected(old('status', $assignment->status) === 'draft')>Draft</option><option value="published" @selected(old('status', $assignment->status) === 'published')>Published</option><option value="closed" @selected(old('status', $assignment->status) === 'closed')>Closed</option></select></div>
                <div class="col-12"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="4" maxlength="2000">{{ old('description', $assignment->description) }}</textarea></div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-end gap-2"><a href="{{ route('admin.assignments.show', $assignment) }}" class="btn btn-light">Cancel</a><button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-2"></i>Save changes</button></div>
    </form>
</div>
@endsection
