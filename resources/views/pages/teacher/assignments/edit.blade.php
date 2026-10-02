@extends('layouts.teacher')
@section('title', 'Edit ' . $assignment->title . ' · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ route('teacher.assignments') }}" class="text-decoration-none">Assignments</a> <span class="text-muted mx-1">/</span> Edit</div>
        <h1 class="h2 fw-bold mb-1">Edit assignment</h1>
        <p class="text-muted mb-0">Update the assignment and its availability window.</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('teacher.assignments.show', $assignment) }}">Cancel</a>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@php($questionValues = old('questions', $assignment->questions->map(fn ($question) => ['prompt' => $question->prompt, 'correct_answer' => $question->correct_answer ? 'true' : 'false'])->all()))
<div class="card portal-card border-0">
    <form method="POST" action="{{ route('teacher.assignments.update', $assignment) }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="assignmentTitle">Assignment title</label><input class="form-control" id="assignmentTitle" name="title" value="{{ old('title', $assignment->title) }}" maxlength="255" required></div>
                <div class="col-md-6"><label class="form-label" for="assignmentCourse">Assigned class</label><select class="form-select" id="assignmentCourse" name="course_id" required>@foreach($courses as $course)<option value="{{ $course->id }}" @selected((string) old('course_id', $assignment->course_id) === (string) $course->id)>{{ $course->name }} ({{ $course->code }})</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label" for="assignmentDescription">Description</label><textarea class="form-control" id="assignmentDescription" name="description" rows="4" maxlength="2000">{{ old('description', $assignment->description) }}</textarea></div>
                <div class="col-md-6"><label class="form-label" for="assignmentStartsAt">Start date and time</label><input class="form-control" id="assignmentStartsAt" name="starts_at" type="datetime-local" value="{{ old('starts_at', $assignment->starts_at?->format('Y-m-d\\TH:i')) }}" required></div>
                <div class="col-md-6"><label class="form-label" for="assignmentEndsAt">Due date and time</label><input class="form-control" id="assignmentEndsAt" name="ends_at" type="datetime-local" value="{{ old('ends_at', $assignment->ends_at?->format('Y-m-d\\TH:i')) }}" required></div>
                <div class="col-md-6"><label class="form-label" for="assignmentType">Assignment type</label><select class="form-select" id="assignmentType" name="assignment_type" required><option value="file_upload" @selected(old('assignment_type', $assignment->assignment_type) === 'file_upload')>File upload</option><option value="true_false" @selected(old('assignment_type', $assignment->assignment_type) === 'true_false')>Questions and answers - True / False</option></select></div>
                <div class="col-md-6"><label class="form-label" for="assignmentStatus">Status</label><select class="form-select" id="assignmentStatus" name="status"><option value="draft" @selected(old('status', $assignment->status) === 'draft')>Draft</option><option value="published" @selected(old('status', $assignment->status) === 'published')>Published</option><option value="closed" @selected(old('status', $assignment->status) === 'closed')>Closed</option></select></div>
                <div class="col-12" id="editTrueFalseSection">
                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2"><div><h2 class="h6 fw-bold mb-0">True / false questions</h2><p class="small text-muted mb-0">Questions are graded automatically.</p></div><button class="btn btn-sm btn-outline-primary" id="addEditAssignmentQuestion" type="button"><i class="bi bi-plus-lg me-1"></i>Add question</button></div>
                    <div id="editAssignmentQuestions" data-next-index="{{ count($questionValues) }}">
                        @foreach($questionValues as $index => $question)
                            <div class="edit-question-row border rounded-3 p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2"><label class="form-label mb-0" for="editQuestion{{ $index }}">Question {{ $index + 1 }}</label><button class="btn btn-sm btn-outline-danger remove-edit-question" type="button" aria-label="Remove question"><i class="bi bi-trash"></i></button></div>
                                <textarea class="form-control mb-2 edit-question-prompt" id="editQuestion{{ $index }}" name="questions[{{ $index }}][prompt]" rows="2" maxlength="2000">{{ $question['prompt'] ?? '' }}</textarea>
                                <label class="form-label small" for="editAnswer{{ $index }}">Correct answer</label><select class="form-select edit-question-answer" id="editAnswer{{ $index }}" name="questions[{{ $index }}][correct_answer]"><option value="true" @selected(($question['correct_answer'] ?? 'true') === 'true')>True</option><option value="false" @selected(($question['correct_answer'] ?? '') === 'false')>False</option></select>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6"><div class="form-check form-switch mt-2"><input class="form-check-input" id="editAllowRetakes" name="allow_retakes" type="checkbox" value="1" @checked(old('allow_retakes', $assignment->allow_retakes))><label class="form-check-label fw-semibold" for="editAllowRetakes">Allow retakes</label></div></div>
                <div class="col-md-6" id="editMaxAttemptsWrap"><label class="form-label" for="editMaxAttempts">Maximum total attempts</label><select class="form-select" id="editMaxAttempts" name="max_attempts">@for($attemptLimit = 2; $attemptLimit <= 10; $attemptLimit++)<option value="{{ $attemptLimit }}" @selected((int) old('max_attempts', $assignment->max_attempts) === $attemptLimit)>{{ $attemptLimit }} attempts</option>@endfor</select></div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-end gap-2"><a class="btn btn-light" href="{{ route('teacher.assignments.show', $assignment) }}">Cancel</a><button class="btn btn-primary" type="submit"><i class="bi bi-check2 me-2"></i>Save changes</button></div>
    </form>
</div>
<template id="editAssignmentQuestionTemplate">
    <div class="edit-question-row border rounded-3 p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2"><label class="form-label mb-0 edit-question-label">Question</label><button class="btn btn-sm btn-outline-danger remove-edit-question" type="button" aria-label="Remove question"><i class="bi bi-trash"></i></button></div>
        <textarea class="form-control mb-2 edit-question-prompt" rows="2" maxlength="2000" placeholder="Enter a true/false question"></textarea>
        <label class="form-label small edit-answer-label">Correct answer</label><select class="form-select edit-question-answer"><option value="true">True</option><option value="false">False</option></select>
    </div>
</template>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const type = document.getElementById('assignmentType');
        const questions = document.getElementById('editAssignmentQuestions');
        const template = document.getElementById('editAssignmentQuestionTemplate');
        const allowRetakes = document.getElementById('editAllowRetakes');
        const maxAttemptsWrap = document.getElementById('editMaxAttemptsWrap');
        const section = document.getElementById('editTrueFalseSection');

        function syncEditType() {
            const isQuiz = type.value === 'true_false';
            section.classList.toggle('d-none', !isQuiz);
            questions.querySelectorAll('.edit-question-prompt, .edit-question-answer').forEach((field) => {
                field.required = isQuiz;
                field.disabled = !isQuiz;
            });
            if (isQuiz && questions.children.length === 0) addQuestion();
        }

        function addQuestion(prompt = '', answer = 'true') {
            const index = Number(questions.dataset.nextIndex);
            const fragment = template.content.cloneNode(true);
            const row = fragment.querySelector('.edit-question-row');
            const label = row.querySelector('.edit-question-label');
            const promptField = row.querySelector('.edit-question-prompt');
            const answerLabel = row.querySelector('.edit-answer-label');
            const answerSelect = row.querySelector('.edit-question-answer');
            label.textContent = 'Question ' + (index + 1);
            label.htmlFor = 'editQuestion' + index;
            promptField.id = 'editQuestion' + index;
            promptField.name = 'questions[' + index + '][prompt]';
            promptField.value = prompt;
            answerLabel.htmlFor = 'editAnswer' + index;
            answerSelect.id = 'editAnswer' + index;
            answerSelect.name = 'questions[' + index + '][correct_answer]';
            answerSelect.value = answer;
            questions.append(fragment);
            questions.dataset.nextIndex = String(index + 1);
            syncEditType();
        }

        type.addEventListener('change', syncEditType);
        allowRetakes.addEventListener('change', () => maxAttemptsWrap.classList.toggle('d-none', !allowRetakes.checked));
        document.getElementById('addEditAssignmentQuestion').addEventListener('click', () => addQuestion());
        questions.addEventListener('click', function (event) {
            if (event.target.closest('.remove-edit-question')) event.target.closest('.edit-question-row').remove();
        });
        syncEditType();
        maxAttemptsWrap.classList.toggle('d-none', !allowRetakes.checked);
    });
</script>
@endsection