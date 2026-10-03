@extends('layouts.admin')
@section('title', 'Assign Class · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">
            <a href="{{ route('admin.courses') }}" class="text-decoration-none">Courses</a>
            <span class="text-muted mx-1">/</span> Assign Class
        </div>
        <h1 class="h2 fw-bold mb-1">Assign Class</h1>
        <p class="text-muted mb-0">Assign a course, teacher, students, and class schedule for the active class setup.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-2"></i>Back to courses</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newClassModal"><i class="bi bi-plus-lg me-2"></i>Add New Class</button>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success mb-4">{{ session('status') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="modal fade" id="newClassModal" tabindex="-1" aria-labelledby="newClassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-sm">
            <form method="POST" action="{{ route('admin.courses.store') }}" id="newClassForm">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="newClassModalLabel">Add new class</h5>
                        <p class="small text-muted mb-0">Create a class and assign teacher and students in the next step.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-3">
                    <div class="wizard-step step-one">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="newClassName">Class name</label>
                                <input id="newClassName" name="name" class="form-control" required maxlength="255" value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassCode">Class code</label>
                                <input id="newClassCode" name="code" class="form-control" required maxlength="50" value="{{ old('code') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassDepartment">Department</label>
                                <input id="newClassDepartment" name="department" class="form-control" maxlength="255" value="{{ old('department') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassCredits">Credits</label>
                                <input id="newClassCredits" name="credits" type="number" min="1" max="30" value="{{ old('credits') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassAcademicYear">Academic year</label>
                                <input id="newClassAcademicYear" name="academic_year" class="form-control" maxlength="20" value="{{ old('academic_year') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassSemester">Semester</label>
                                <input id="newClassSemester" name="semester" class="form-control" maxlength="50" value="{{ old('semester') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="newClassStatus">Status</label>
                                <select id="newClassStatus" name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="newClassDescription">Description</label>
                                <textarea id="newClassDescription" name="description" class="form-control" rows="3" maxlength="2000">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-step step-two d-none">
                        <div class="mb-4">
                            <label class="form-label" for="assignTeacherId">Assign teacher</label>
                            <select id="assignTeacherId" name="teacher_id" class="form-select">
                                <option value="">Not assigned</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user?->name ?? trim($teacher->first_name . ' ' . $teacher->last_name) }} ({{ $teacher->teacher_id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="assignCourseId">Assign course</label>
                            <select id="assignCourseId" name="course_id" class="form-select">
                                <option value="">Select a course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Select students</label>
                            <div class="border rounded-3 p-3" style="max-height: 240px; overflow-y: auto;">
                                @if($students->isEmpty())
                                    <div class="text-muted">No students available.</div>
                                @else
                                    @foreach($students as $student)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="modal_student_{{ $student->id }}">
                                            <label class="form-check-label" for="modal_student_{{ $student->id }}">
                                                {{ $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name) }}
                                                <span class="text-muted">({{ $student->student_id }})</span>
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary d-none" id="prevStepBtn">Back</button>
                    <button type="button" class="btn btn-primary" id="nextStepBtn">Next</button>
                    <button type="submit" class="btn btn-primary d-none" id="submitClassBtn"><i class="bi bi-plus-lg me-2"></i>Create class</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card portal-card border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h2 class="h5 fw-bold mb-1">All classes</h2>
                <p class="small text-muted mb-0">List of available classes and their current assignment status.</p>
            </div>
            <div class="d-flex gap-2">
                <input id="classSearch" class="form-control form-control-sm" type="search" aria-label="Search classes" placeholder="Search classes" style="min-width: 180px;">
                <button id="classSearchFilter" class="btn btn-outline-primary btn-sm" type="button"><i class="bi bi-funnel"></i> Filter</button>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="text-center py-4 text-muted">No classes found yet.</div>
        @else
            <div class="table-responsive">
                <table class="table portal-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Code</th>
                            <th>Teacher</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td class="fw-semibold">{{ $course->name }}</td>
                                <td>{{ $course->code }}</td>
                                <td>{{ $course->teacher?->user?->name ?? ($course->teacher_id ? 'Assigned' : 'Not assigned') }}</td>
                                <td>
                                    @if($course->day_of_week || $course->start_time || $course->end_time || $course->room)
                                        {{ $course->day_of_week ?: 'Schedule' }}
                                        @if($course->start_time || $course->end_time)
                                            · {{ $course->start_time ? \Carbon\Carbon::parse($course->start_time)->format('H:i') : '--:--' }} - {{ $course->end_time ? \Carbon\Carbon::parse($course->end_time)->format('H:i') : '--:--' }}
                                        @endif
                                        @if($course->room)
                                            · {{ $course->room }}
                                        @endif
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark">{{ ucfirst($course->status) }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Delete this class and all linked assignments?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classSearch = document.getElementById('classSearch');
        const classTable = classSearch?.closest('.card')?.querySelector('table');
        const classTableBody = classTable?.querySelector('tbody');

        if (classSearch && classTableBody) {
            const classRows = Array.from(classTableBody.querySelectorAll('tr'));
            const noMatchRow = document.createElement('tr');
            noMatchRow.classList.add('d-none');
            const noMatchCell = document.createElement('td');
            noMatchCell.colSpan = classTable.querySelectorAll('thead th').length;
            noMatchCell.className = 'text-center text-muted py-4';
            noMatchCell.textContent = 'No matching classes.';
            noMatchRow.append(noMatchCell);
            classTableBody.append(noMatchRow);

            const filterClasses = function () {
                const term = classSearch.value.trim().toLocaleLowerCase();
                let visibleCount = 0;
                classRows.forEach(function (row) {
                    const matches = row.textContent.toLocaleLowerCase().includes(term);
                    row.classList.toggle('d-none', !matches);
                    visibleCount += matches ? 1 : 0;
                });
                noMatchRow.classList.toggle('d-none', term === '' || visibleCount > 0);
            };

            classSearch.addEventListener('input', filterClasses);
            document.getElementById('classSearchFilter').addEventListener('click', filterClasses);
        }

        const form = document.getElementById('newClassForm');
        if (!form) return;

        const steps = form.querySelectorAll('.wizard-step');
        const nextBtn = document.getElementById('nextStepBtn');
        const prevBtn = document.getElementById('prevStepBtn');
        const submitBtn = document.getElementById('submitClassBtn');
        let stepIndex = 0;

        function showStep(index) {
            stepIndex = index;
            steps.forEach((step, i) => {
                step.classList.toggle('d-none', i !== index);
            });

            prevBtn.classList.toggle('d-none', index === 0);
            nextBtn.classList.toggle('d-none', index !== 0);
            submitBtn.classList.toggle('d-none', index !== 1);
        }

        nextBtn.addEventListener('click', function () {
            const currentStep = steps[stepIndex];
            const requiredFields = currentStep.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach((field) => {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    isValid = false;
                    return;
                }
            });

            if (isValid) {
                showStep(stepIndex + 1);
            }
        });

        prevBtn.addEventListener('click', function () {
            showStep(stepIndex - 1);
        });

        showStep(0);
    });
</script>
@endsection
