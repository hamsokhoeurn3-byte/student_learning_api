@extends('layouts.admin')
@section('title', $course->name . ' · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('admin.courses') }}" class="text-decoration-none">Courses</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $course->name }}</h1>
        <p class="text-muted mb-0">Course {{ $course->code }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses') }}" class="btn btn-outline-primary">Back to courses</a>
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Edit course</a>
    </div>
</div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card portal-card border-0">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Course name</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->name }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Course code</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->code }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Description</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->description ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Department</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->department ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Credits</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->credits ?? 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Teacher</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->teacher?->user?->name ?? ($course->teacher_id ? 'Teacher #' . $course->teacher_id : 'Not assigned') }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Academic year</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->academic_year ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Semester</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->semester ?: 'Not set' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Class schedule</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->day_of_week ? $course->day_of_week . ' · ' : '' }}{{ $course->start_time ? \Carbon\Carbon::parse($course->start_time)->format('H:i') : 'Not set' }}{{ $course->end_time ? ' - ' . \Carbon\Carbon::parse($course->end_time)->format('H:i') : '' }}{{ $course->room ? ' · ' . $course->room : '' }}{{ !$course->day_of_week && !$course->start_time && !$course->end_time && !$course->room ? 'Not set' : '' }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Status</dt><dd class="col-sm-8 col-lg-9 py-2">{{ ucfirst($course->status) }}</dd>
            <dt class="col-sm-4 col-lg-3 py-2 text-muted">Assignments</dt><dd class="col-sm-8 col-lg-9 py-2">{{ $course->assignments()->count() }}</dd>
        </dl>
    </div>
</div>
<section class="card portal-card border-0 mt-4">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-1">Assign class teacher</h2>
        <p class="small text-muted mb-3">Choose the teacher responsible for this class.</p>
        <form method="POST" action="{{ route('admin.courses.teacher.update', $course) }}" class="d-flex flex-wrap gap-2">
            @csrf
            @method('PUT')
            <select name="teacher_id" class="form-select" style="max-width: 420px" aria-label="Class teacher">
                <option value="">No teacher assigned</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected((string) $course->teacher_id === (string) $teacher->id)>{{ $teacher->user?->name ?? trim($teacher->first_name . ' ' . $teacher->last_name) }} · {{ $teacher->teacher_id }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary"><i class="bi bi-person-check me-2"></i>Save teacher</button>
            @if($teachers->isEmpty())<a href="{{ route('admin.teachers') }}" class="btn btn-outline-primary">Create teacher first</a>@endif
        </form>
    </div>
</section>
<section class="card portal-card border-0 mt-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div><h2 class="h5 fw-bold mb-1">Enrolled students</h2><p class="small text-muted mb-0">{{ $course->students->count() }} students enrolled in {{ $course->code }}</p></div>
            <form method="POST" action="{{ route('admin.courses.students.store', $course) }}" class="d-flex flex-wrap gap-2">
                @csrf
                <select name="student_ids[]" class="form-select form-select-sm" multiple size="5" style="min-width: 280px" aria-label="Choose students to enroll" required>
                    @foreach($availableStudents as $student)
                        <option value="{{ $student->id }}">{{ $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name) }} · {{ $student->student_id }}</option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary" type="submit" @disabled($availableStudents->isEmpty())><i class="bi bi-person-plus me-1"></i>Enroll students</button>
            </form>
        </div>
        @if($availableStudents->isEmpty())<p class="small text-muted mb-3">Every student is already enrolled in this course.</p>@endif
        @if($course->students->isEmpty())
            <p class="text-muted text-center py-4 mb-0">No students are enrolled yet.</p>
        @else
            <div class="table-responsive"><table class="table portal-table align-middle mb-0"><thead><tr><th>Student</th><th>Student ID</th><th>Enrollment status</th><th class="text-end">Actions</th></tr></thead><tbody>
                @foreach($course->students as $student)
                    <tr><td>{{ $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name) }}</td><td>{{ $student->student_id }}</td><td>{{ ucfirst($student->pivot->status) }}</td><td class="text-end"><form method="POST" action="{{ route('admin.courses.students.destroy', [$course, $student]) }}" onsubmit="return confirm('Remove this student from the course?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Remove {{ $student->student_id }}"><i class="bi bi-person-dash"></i></button></form></td></tr>
                @endforeach
            </tbody></table></div>
        @endif
    </div>
</section>
<section class="card portal-card border-0 mt-4">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-1">Add assignment to this class</h2>
        <p class="small text-muted mb-3">Assignments created here are linked to {{ $course->code }}.</p>
        <form method="POST" action="{{ route('admin.assignments.store') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="row g-3">
                <div class="col-md-6"><label for="classAssignmentTitle" class="form-label">Assignment title</label><input id="classAssignmentTitle" name="title" class="form-control" required maxlength="255"></div>
                <div class="col-md-3"><label for="classAssignmentDue" class="form-label">Due date</label><input id="classAssignmentDue" name="due_date" type="date" class="form-control"></div>
                <div class="col-md-3"><label for="classAssignmentStatus" class="form-label">Status</label><select id="classAssignmentStatus" name="status" class="form-select"><option value="published">Published</option><option value="draft">Draft</option><option value="closed">Closed</option></select></div>
                <div class="col-12"><label for="classAssignmentDescription" class="form-label">Description</label><textarea id="classAssignmentDescription" name="description" rows="3" maxlength="2000" class="form-control"></textarea></div>
                <div class="col-12"><button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Create assignment</button></div>
            </div>
        </form>
    </div>
</section>
<section class="card portal-card border-0 mt-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h5 fw-bold mb-0">Class assignments</h2><span class="small text-muted">{{ $course->assignments->count() }} total</span></div>
        @if($course->assignments->isEmpty())
            <p class="text-muted text-center py-4 mb-0">No assignments in this class yet.</p>
        @else
            <div class="table-responsive"><table class="table portal-table align-middle mb-0"><thead><tr><th>Assignment</th><th>Due date</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
                @foreach($course->assignments as $assignment)
                    <tr><td>{{ $assignment->title }}</td><td>{{ $assignment->due_date?->format('M d, Y') ?? 'No due date' }}</td><td>{{ ucfirst($assignment->status) }}</td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.assignments.show', $assignment) }}">View</a><a class="btn btn-sm btn-outline-secondary ms-1" href="{{ route('admin.assignments.edit', $assignment) }}">Edit</a></td></tr>
                @endforeach
            </tbody></table></div>
        @endif
    </div>
</section>
<form class="mt-3" method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Delete this course and all its linked assignments?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Delete course</button>
</form>
@endsection
