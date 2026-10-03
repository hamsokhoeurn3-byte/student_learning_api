@extends('layouts.student')

@section('title', 'Quizzes · SLAS')

@section('content')
@php
    $averageLabel = $averageScore !== null ? number_format((float) $averageScore, 0) . '%' : '—';
    $bestScoreLabel = $bestScore !== null ? number_format((float) $bestScore, 0) . '%' : '—';
@endphp
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Quizzes', 'subtitle' => 'Quizzes assigned to your enrolled courses by your teachers.'])

    <div class="row g-3 mb-4">
        @foreach ([['Assigned quizzes', $availableCount, 'patch-question'], ['Completed', $completedCount, 'check2-circle'], ['Average score', $averageLabel, 'graph-up-arrow'], ['Due this week', $dueThisWeek, 'calendar-event']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="student-card overflow-hidden">
                <div class="card-header"><h2 class="h5 fw-bold mb-1">Your quizzes</h2><small class="text-muted">Published quizzes from courses where you are enrolled.</small></div>
                <div class="table-responsive"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Quiz</th><th>Course</th><th>Questions</th><th>Due date</th><th>Status</th><th class="pe-4 text-end">Action</th></tr></thead><tbody>
                    @forelse($quizzes as $quiz)
                        @php
                            $attempts = $quiz->attempts;
                            $latestAttempt = $attempts->first();
                            $attemptLimit = $quiz->allow_retakes ? max(1, (int) $quiz->max_attempts) : 1;
                            $opensAt = $quiz->starts_at;
                            $closesAt = $quiz->ends_at ?? $quiz->due_date?->copy()->endOfDay();
                            $canStart = (!$opensAt || now()->gte($opensAt)) && (!$closesAt || now()->lte($closesAt)) && $attempts->count() < $attemptLimit;
                            $quizStatus = $canStart ? ($attempts->isNotEmpty() ? 'Retake available' : 'Ready') : ($latestAttempt ? 'Completed' : (($opensAt && now()->lt($opensAt)) ? 'Opens soon' : 'Closed'));
                        @endphp
                        <tr>
                            <td class="ps-4"><div class="d-flex align-items-center gap-3"><span class="student-icon" style="width:36px;height:36px;flex-basis:36px;border-radius:10px"><i class="bi bi-patch-question"></i></span><div><strong class="d-block">{{ $quiz->title }}</strong><small class="text-muted">{{ $quiz->description ?: 'True / false quiz' }}</small></div></div></td>
                            <td><strong class="d-block">{{ $quiz->course?->name ?? 'Course' }}</strong><small class="text-muted">{{ $quiz->course?->code }}</small></td>
                            <td>{{ $quiz->questions->count() }}</td>
                            <td>{{ $quiz->ends_at?->format('M d, Y') ?? $quiz->due_date?->format('M d, Y') ?? 'No due date' }}</td>
                            <td><span class="student-status {{ $quizStatus === 'Completed' ? 'bg-success-subtle text-success' : ($quizStatus === 'Closed' ? 'bg-secondary-subtle text-secondary' : 'portal-badge') }}">{{ $quizStatus }}</span></td>
                            <td class="pe-4 text-end">
                                @if($canStart)
                                    <a class="btn btn-sm btn-primary" href="{{ route('student.assignments.submit', $quiz) }}">{{ $attempts->isNotEmpty() ? 'Retake' : 'Start quiz' }}</a>
                                @elseif($latestAttempt)
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('student.assignments.result', $quiz) }}">View result</a>
                                @else
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('student.assignments.submit', $quiz) }}">View details</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">No published quizzes are assigned to your enrolled courses yet.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="student-card mb-4"><div class="card-body"><h2 class="h5 fw-bold mb-3">Quiz performance</h2><div class="student-metric"><span>Attempts submitted</span><strong>{{ $attemptCount }}</strong></div><div class="student-metric"><span>Auto-graded attempts</span><strong>{{ $gradedCount }}</strong></div><div class="student-metric"><span>Best score</span><strong>{{ $bestScoreLabel }}</strong></div></div></div>
            <div class="student-card"><div class="card-body"><h2 class="h5 fw-bold mb-3">Study tip</h2><div class="d-flex gap-3"><span class="student-icon"><i class="bi bi-lightbulb"></i></span><p class="small text-muted mb-0">Open a completed quiz result to review your answers and see which ones were correct.</p></div></div></div>
        </div>
    </div>
</div>
@endsection
