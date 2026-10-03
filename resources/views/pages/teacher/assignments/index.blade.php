@extends('layouts.teacher')
@section('title', 'Assignments · Teacher · SLAS')
@section('content')
@php($isQuizPage = $isQuizPage ?? false)
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> {{ $isQuizPage ? 'Quizzes' : 'Assignments' }}</div>
        <h1 class="h2 fw-bold mb-1">{{ $isQuizPage ? 'Quizzes' : 'Assignments' }}</h1>
        <p class="text-muted mb-0">{{ $isQuizPage ? 'Create and manage true/false quizzes for your assigned classes.' : 'Create work for students in your assigned classes.' }}</p>
    </div>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createTeacherAssignment"><i class="bi bi-plus-lg me-2"></i>{{ $isQuizPage ? 'Create Quiz' : 'Create Assignment' }}</button>
</div>

@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

<div class="row g-3 mb-4">
    @foreach($managementStats as [$label, $value, $icon])
        <div class="col-md-4"><div class="card portal-card border-0 h-100"><div class="card-body p-3 d-flex justify-content-between align-items-center"><div><div class="small text-muted">{{ $label }}</div><div class="h3 fw-bold mb-0 mt-1">{{ $value }}</div></div><span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div></div>
    @endforeach
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3"><h2 class="h5 fw-bold mb-0">{{ $isQuizPage ? 'My quizzes' : 'My assignments' }}</h2></div>
    <div class="table-responsive">
        <table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Assignment</th><th>Course</th><th>Availability</th><th>Status</th><th class="text-end pe-4">Actions</th></tr></thead>
            <tbody>
                @forelse($managementRows as $row)
                    <tr>
                        <td class="ps-4 fw-semibold">{{ $row[0] }}</td>
                        <td>{{ $row[1] }}</td>
                        <td>{{ $row[2] }}</td>
                        <td>{{ $row[3] }}</td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('teacher.assignments.show', $row[4]) }}" title="View assignment" aria-label="View {{ $row[0] }}"><i class="bi bi-eye"></i></a>
                                @if($row[5])
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('teacher.assignments.edit', $row[4]) }}" title="Edit assignment" aria-label="Edit {{ $row[0] }}"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('teacher.assignments.destroy', $row[4]) }}" onsubmit="return confirm('Delete this assignment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete assignment" aria-label="Delete {{ $row[0] }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">{{ $isQuizPage ? 'No quizzes yet.' : 'No assignments yet.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 px-4 small text-muted border-top">Showing {{ $managementRows->firstItem() ?? 0 }}–{{ $managementRows->lastItem() ?? 0 }} of {{ number_format($managementCount) }} {{ $isQuizPage ? 'quizzes' : 'assignments' }}</div>
    @if($managementRows->hasPages())<div class="px-4 pb-3">{{ $managementRows->links('pagination::bootstrap-5') }}</div>@endif
</div>

<div class="modal fade" id="createTeacherAssignment" tabindex="-1" aria-labelledby="createTeacherAssignmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content border-0 rounded-4" method="POST" action="{{ route('teacher.assignments.store') }}">
            @csrf
            <div class="modal-header border-0">
                <div><h2 class="modal-title h5 fw-bold" id="createTeacherAssignmentLabel">Create assignment</h2><p class="small text-muted mb-0">The assignment will be available to all enrolled students in the selected class.</p></div>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="assignment-step assignment-step-one">
                <label class="form-label" for="teacherAssignmentCourse">Assigned class</label>
                <select id="teacherAssignmentCourse" name="course_id" class="form-select mb-3" required @disabled($courses->isEmpty())>
                    <option value="">Choose an assigned class</option>
                    @foreach($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->name }} ({{ $course->code }})</option>@endforeach
                </select>
                @if($courses->isEmpty())<p class="small text-muted">No assigned classes are available.</p>@endif

                <label class="form-label" for="teacherAssignmentTitle">Assignment title</label>
                <input id="teacherAssignmentTitle" name="title" value="{{ old('title') }}" class="form-control mb-3" required maxlength="255">

                <label class="form-label" for="teacherAssignmentDescription">Description</label>
                <textarea id="teacherAssignmentDescription" name="description" class="form-control mb-3" rows="3" maxlength="2000">{{ old('description') }}</textarea>

                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label" for="teacherAssignmentStartsAt">Start date and time</label><input id="teacherAssignmentStartsAt" name="starts_at" type="datetime-local" value="{{ old('starts_at') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="teacherAssignmentEndsAt">Due date and time</label><input id="teacherAssignmentEndsAt" name="ends_at" type="datetime-local" value="{{ old('ends_at') }}" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label" for="teacherAssignmentStatus">Status</label><select id="teacherAssignmentStatus" name="status" class="form-select"><option value="published" @selected(old('status', 'published') === 'published')>Published</option><option value="draft" @selected(old('status') === 'draft')>Draft</option><option value="closed" @selected(old('status') === 'closed')>Closed</option></select></div>
                </div>
                </div>

                <div class="assignment-step assignment-step-two d-none">
                    <input type="hidden" name="content_type" value="{{ $isQuizPage ? 'quiz' : 'assignment' }}">
                    <label class="form-label" for="teacherAssignmentType">{{ $isQuizPage ? 'Quiz type' : 'Assignment type' }}</label>
                    @if($isQuizPage)
                    <input id="teacherAssignmentType" type="hidden" name="assignment_type" value="true_false">
                    @else
                    <select id="teacherAssignmentType" name="assignment_type" class="form-select mb-3" required>
                        <option value="file_upload" @selected(old('assignment_type', 'file_upload') === 'file_upload')>File upload</option>
                        <option value="true_false" @selected(old('assignment_type') === 'true_false')>Questions and answers - True / False</option>
                    </select>
                    @endif

                    <div id="fileUploadInfo" class="alert alert-light border {{ $isQuizPage ? 'd-none' : '' }}">Students in the selected class will upload their completed work. Accepted formats: PDF, DOC, DOCX, ZIP, or TXT.</div>

                    <div id="trueFalseQuestions" class="{{ $isQuizPage ? '' : 'd-none' }}">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <div><h3 class="h6 fw-bold mb-0">True / false questions</h3><p class="small text-muted mb-0">Questions are graded automatically.</p></div>
                            <button class="btn btn-sm btn-outline-primary" id="addAssignmentQuestion" type="button"><i class="bi bi-plus-lg me-1"></i>Add question</button>
                        </div>
                        <div id="assignmentQuestions" data-next-index="{{ count(old('questions', [])) }}">
                            @foreach(old('questions', []) as $index => $question)
                                <div class="assignment-question border rounded-3 p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2"><label class="form-label mb-0" for="assignmentQuestion{{ $index }}">Question {{ $index + 1 }}</label><button class="btn btn-sm btn-outline-danger remove-assignment-question" type="button" aria-label="Remove question"><i class="bi bi-trash"></i></button></div>
                                    <textarea class="form-control mb-2 question-prompt" id="assignmentQuestion{{ $index }}" name="questions[{{ $index }}][prompt]" rows="2" maxlength="2000">{{ $question['prompt'] ?? '' }}</textarea>
                                    <label class="form-label small" for="assignmentAnswer{{ $index }}">Correct answer</label>
                                    <select class="form-select question-answer" id="assignmentAnswer{{ $index }}" name="questions[{{ $index }}][correct_answer]"><option value="true" @selected(($question['correct_answer'] ?? 'true') === 'true')>True</option><option value="false" @selected(($question['correct_answer'] ?? '') === 'false')>False</option></select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" id="allowAssignmentRetakes" name="allow_retakes" type="checkbox" value="1" @checked(old('allow_retakes'))>
                        <label class="form-check-label fw-semibold" for="allowAssignmentRetakes">Allow retakes</label>
                    </div>
                    <div id="maxAttemptsWrap" class="mt-3 d-none">
                        <label class="form-label" for="assignmentMaxAttempts">Maximum total attempts</label>
                        <select class="form-select" id="assignmentMaxAttempts" name="max_attempts">
                            @for($attemptLimit = 2; $attemptLimit <= 10; $attemptLimit++)<option value="{{ $attemptLimit }}" @selected((int) old('max_attempts', 2) === $attemptLimit)>{{ $attemptLimit }} attempts</option>@endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button><button class="btn btn-outline-primary d-none" id="previousAssignmentStep" type="button">Back</button><button class="btn btn-primary" id="nextAssignmentStep" type="button" @disabled($courses->isEmpty())>Next</button><button class="btn btn-primary d-none" id="saveTeacherAssignment" type="submit" @disabled($courses->isEmpty())>Save assignment</button></div>
        </form>
    </div>
</div>
<template id="assignmentQuestionTemplate">
    <div class="assignment-question border rounded-3 p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2"><label class="form-label mb-0 question-label">Question</label><button class="btn btn-sm btn-outline-danger remove-assignment-question" type="button" aria-label="Remove question"><i class="bi bi-trash"></i></button></div>
        <textarea class="form-control mb-2 question-prompt" rows="2" maxlength="2000" placeholder="Enter a true/false question"></textarea>
        <label class="form-label small question-answer-label">Correct answer</label>
        <select class="form-select question-answer"><option value="true">True</option><option value="false">False</option></select>
    </div>
</template>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#createTeacherAssignment form');
        if (!form) return;

        const steps = form.querySelectorAll('.assignment-step');
        const nextButton = document.getElementById('nextAssignmentStep');
        const previousButton = document.getElementById('previousAssignmentStep');
        const saveButton = document.getElementById('saveTeacherAssignment');
        const assignmentType = document.getElementById('teacherAssignmentType');
        const questionList = document.getElementById('assignmentQuestions');
        const questionTemplate = document.getElementById('assignmentQuestionTemplate');
        const retakeToggle = document.getElementById('allowAssignmentRetakes');
        const maxAttemptsWrap = document.getElementById('maxAttemptsWrap');

        function showStep(index) {
            steps.forEach((step, stepIndex) => step.classList.toggle('d-none', index !== stepIndex));
            nextButton.classList.toggle('d-none', index === 1);
            previousButton.classList.toggle('d-none', index === 0);
            saveButton.classList.toggle('d-none', index !== 1);
        }

        function addQuestion(prompt = '', answer = 'true') {
            const index = Number(questionList.dataset.nextIndex);
            const fragment = questionTemplate.content.cloneNode(true);
            const row = fragment.querySelector('.assignment-question');
            const label = row.querySelector('.question-label');
            const promptInput = row.querySelector('.question-prompt');
            const answerLabel = row.querySelector('.question-answer-label');
            const answerSelect = row.querySelector('.question-answer');
            label.textContent = 'Question ' + (index + 1);
            label.htmlFor = 'assignmentQuestion' + index;
            promptInput.id = 'assignmentQuestion' + index;
            promptInput.name = 'questions[' + index + '][prompt]';
            promptInput.value = prompt;
            answerLabel.htmlFor = 'assignmentAnswer' + index;
            answerSelect.id = 'assignmentAnswer' + index;
            answerSelect.name = 'questions[' + index + '][correct_answer]';
            answerSelect.value = answer;
            questionList.append(fragment);
            questionList.dataset.nextIndex = String(index + 1);
            syncAssignmentType();
        }

        function syncAssignmentType() {
            const isTrueFalse = assignmentType.value === 'true_false';
            document.getElementById('trueFalseQuestions').classList.toggle('d-none', !isTrueFalse);
            document.getElementById('fileUploadInfo').classList.toggle('d-none', isTrueFalse);
            questionList.querySelectorAll('.question-prompt, .question-answer').forEach((field) => {
                field.required = isTrueFalse;
                field.disabled = !isTrueFalse;
            });
            if (isTrueFalse && questionList.children.length === 0) addQuestion();
        }

        nextButton.addEventListener('click', function () {
            const currentStep = steps[0];
            const requiredFields = currentStep.querySelectorAll('[required]');
            for (const field of requiredFields) {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    return;
                }
            }
            showStep(1);
        });
        previousButton.addEventListener('click', () => showStep(0));
        assignmentType.addEventListener('change', syncAssignmentType);
        document.getElementById('addAssignmentQuestion').addEventListener('click', () => addQuestion());
        questionList.addEventListener('click', function (event) {
            if (event.target.closest('.remove-assignment-question')) {
                event.target.closest('.assignment-question').remove();
                questionList.querySelectorAll('.question-label').forEach((label, index) => label.textContent = 'Question ' + (index + 1));
            }
        });
        retakeToggle.addEventListener('change', () => {
            maxAttemptsWrap.classList.toggle('d-none', !retakeToggle.checked);
        });

        showStep(0);
        syncAssignmentType();
        maxAttemptsWrap.classList.toggle('d-none', !retakeToggle.checked);
    });
</script>
@endsection
