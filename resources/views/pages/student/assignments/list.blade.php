@extends('layouts.student')
@section('title', 'Assignments · SLAS')
@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Assignments', 'subtitle' => 'Published assignments for your enrolled classes.', 'action' => ''])
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="row g-3 mb-4">
        @foreach([['Assignments', $totalCount, 'journal-text'], ['Submitted', $completedCount, 'check2-circle'], ['Pending', $pendingCount, 'clock'], ['Attempts used', $attemptCount, 'arrow-repeat']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-center"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    @if($assignments->isEmpty())
        <div class="student-card p-4 text-center text-muted">No published assignments are available for your enrolled classes.</div>
    @else
        <div class="table-responsive student-card">
            <table class="table student-table align-middle mb-0">
                <thead><tr><th class="ps-4">Assignment</th><th>Class</th><th>Type</th><th>Availability</th><th>Attempts</th><th class="pe-4 text-end">Action</th></tr></thead>
                <tbody>
                    @foreach($assignments as $assignment)
                        @php
                            $latestAttempt = $assignment->attempts->first();
                            $usedAttempts = $assignment->attempts->count();
                            $attemptLimit = $assignment->allow_retakes ? $assignment->max_attempts : 1;
                            $opensAt = $assignment->starts_at;
                            $closesAt = $assignment->ends_at ?? $assignment->due_date?->endOfDay();
                            $isOpen = (!$opensAt || now()->gte($opensAt)) && (!$closesAt || now()->lte($closesAt)) && $usedAttempts < $attemptLimit;
                        @endphp
                        <tr>
                            <td class="ps-4"><strong>{{ $assignment->title }}</strong><small class="d-block text-muted">{{ $assignment->description }}</small></td>
                            <td>{{ $assignment->course?->name }}<small class="d-block text-muted">{{ $assignment->course?->code }}</small></td>
                            <td>{{ $assignment->assignment_type === 'true_false' ? 'True / False' : 'File upload' }}</td>
                            <td>
                                @if($opensAt)<small class="d-block">Opens {{ $opensAt->format('M d, Y H:i') }}</small>@endif
                                <small class="d-block">Due {{ $closesAt?->format('M d, Y H:i') ?? 'No deadline' }}</small>
                            </td>
                            <td>{{ $usedAttempts }} / {{ $attemptLimit }}</td>
                            <td class="pe-4 text-end">
                                @if($isOpen)
                                    <a class="btn btn-sm btn-primary" href="{{ route('student.assignments.submit', $assignment) }}">{{ $usedAttempts ? 'Retake' : 'Start' }}</a>
                                @elseif($latestAttempt)
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('student.assignments.result', $assignment) }}">View result</a>
                                @else
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('student.assignments.submit', $assignment) }}">View details</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection