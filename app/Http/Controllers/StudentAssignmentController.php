<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentAttempt;
use App\Models\AssignmentQuestion;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StudentAssignmentController extends Controller
{
    public function index(): View
    {
        $student = Student::where('user_id', Auth::id())->first();
        $assignments = $student
            ? Assignment::with([
                'course',
                'attempts' => fn ($query) => $query
                    ->where('student_id', $student->id)
                    ->orderByDesc('attempt_number'),
            ])
                ->where('status', 'published')
                ->whereHas('course.students', fn ($query) => $query
                    ->where('students.id', $student->id)
                    ->where('course_enrollments.status', 'enrolled'))
                ->orderBy('ends_at')
                ->get()
            : collect();
        $attemptCount = $assignments->sum(fn (Assignment $assignment) => $assignment->attempts->count());
        $completedCount = $assignments->filter(fn (Assignment $assignment) => $assignment->attempts->isNotEmpty())->count();

        return view('pages.student.assignments.list', [
            'assignments' => $assignments,
            'totalCount' => $assignments->count(),
            'attemptCount' => $attemptCount,
            'completedCount' => $completedCount,
            'pendingCount' => $assignments->filter(fn (Assignment $assignment) => $assignment->attempts->isEmpty())->count(),
        ]);
    }

    public function take(Assignment $assignment): View
    {
        $student = $this->currentStudent();
        $assignment = $this->assignedPublishedAssignment($assignment, $student);
        $attempts = $assignment->attempts()->where('student_id', $student->id)->orderByDesc('attempt_number')->get();
        $canSubmit = $this->isWithinAvailability($assignment)
            && $attempts->count() < $this->attemptLimit($assignment);
        $availabilityMessage = $this->availabilityMessage($assignment, $attempts->count());
        $questions = $assignment->assignment_type === 'true_false'
            ? AssignmentQuestion::where('assignment_id', $assignment->id)->orderBy('position')->get(['id', 'prompt', 'position'])
            : collect();

        return view('pages.student.assignments.take', compact(
            'assignment',
            'attempts',
            'canSubmit',
            'availabilityMessage',
            'questions',
        ));
    }

    public function submit(Request $request, Assignment $assignment): RedirectResponse
    {
        $student = $this->currentStudent();
        $assignment = $this->assignedPublishedAssignment($assignment, $student);
        abort_unless($this->isWithinAvailability($assignment), 403);

        $attemptNumber = AssignmentAttempt::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->count() + 1;
        abort_if($attemptNumber > $this->attemptLimit($assignment), 403);

        $filePath = null;
        $fileName = null;
        $answers = null;
        $score = null;

        if ($assignment->assignment_type === 'file_upload') {
            $validated = $request->validate([
                'submission_file' => 'required|file|max:10240|mimes:pdf,doc,docx,zip,txt',
            ]);
            $uploadedFile = $validated['submission_file'];
            $filePath = $uploadedFile->store("assignment-submissions/{$assignment->id}/{$student->id}", 'local');
            $fileName = $uploadedFile->getClientOriginalName();
        } else {
            $questions = AssignmentQuestion::where('assignment_id', $assignment->id)->orderBy('position')->get();
            abort_if($questions->isEmpty(), 403);
            $validated = $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|in:true,false',
            ]);
            $submittedQuestionIds = array_map('intval', array_keys($validated['answers']));
            $expectedQuestionIds = $questions->pluck('id')->map(fn ($id) => (int) $id)->all();
            if (array_diff($expectedQuestionIds, $submittedQuestionIds) || array_diff($submittedQuestionIds, $expectedQuestionIds)) {
                throw ValidationException::withMessages(['answers' => 'Answer every question in this assignment.']);
            }

            $correctCount = 0;
            foreach ($questions as $question) {
                $submittedAnswer = $validated['answers'][$question->id];
                $isCorrect = ($submittedAnswer === 'true') === (bool) $question->correct_answer;
                $correctCount += $isCorrect ? 1 : 0;
                $answers[$question->id] = [
                    'prompt' => $question->prompt,
                    'answer' => $submittedAnswer,
                    'correct_answer' => (bool) $question->correct_answer,
                    'is_correct' => $isCorrect,
                ];
            }
            $score = round($correctCount / $questions->count() * 100, 2);
        }

        DB::transaction(function () use ($assignment, $student, $attemptNumber, $filePath, $fileName, $answers, $score) {
            AssignmentAttempt::create([
                'assignment_id' => $assignment->id,
                'student_id' => $student->id,
                'attempt_number' => $attemptNumber,
                'started_at' => now(),
                'submitted_at' => now(),
                'file_path' => $filePath,
                'file_name' => $fileName,
                'answers' => $answers,
                'score' => $score,
            ]);
        });

        return redirect()->route('student.assignments.result', $assignment)->with('status', 'Assignment submitted successfully.');
    }

    public function result(Assignment $assignment): View
    {
        $student = $this->currentStudent();
        $assignment = $this->assignedPublishedAssignment($assignment, $student);
        $attempt = $assignment->attempts()
            ->where('student_id', $student->id)
            ->orderByDesc('attempt_number')
            ->firstOrFail();

        return view('pages.student.assignments.attempt-result', compact('assignment', 'attempt'));
    }

    private function currentStudent(): Student
    {
        return Student::where('user_id', Auth::id())->firstOrFail();
    }

    private function assignedPublishedAssignment(Assignment $assignment, Student $student): Assignment
    {
        return Assignment::with('course')
            ->whereKey($assignment->id)
            ->where('status', 'published')
            ->whereHas('course.students', fn ($query) => $query
                ->where('students.id', $student->id)
                ->where('course_enrollments.status', 'enrolled'))
            ->firstOrFail();
    }

    private function attemptLimit(Assignment $assignment): int
    {
        return $assignment->allow_retakes ? max(1, (int) $assignment->max_attempts) : 1;
    }

    private function isWithinAvailability(Assignment $assignment): bool
    {
        $now = now();
        $endsAt = $assignment->ends_at ?? $assignment->due_date?->endOfDay();

        return (!$assignment->starts_at || $now->greaterThanOrEqualTo($assignment->starts_at))
            && (!$endsAt || $now->lessThanOrEqualTo($endsAt));
    }

    private function availabilityMessage(Assignment $assignment, int $attemptCount): ?string
    {
        if ($assignment->starts_at && now()->lt($assignment->starts_at)) {
            return 'This assignment opens on ' . $assignment->starts_at->format('M d, Y H:i') . '.';
        }

        $endsAt = $assignment->ends_at ?? $assignment->due_date?->endOfDay();
        if ($endsAt && now()->gt($endsAt)) {
            return 'The due date for this assignment has passed.';
        }

        if ($attemptCount >= $this->attemptLimit($assignment)) {
            return 'You have used all attempts allowed for this assignment.';
        }

        return null;
    }
}