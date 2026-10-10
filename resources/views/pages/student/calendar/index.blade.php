@extends('layouts.student')

@section('title', 'Calendar · SLAS')

@section('content')
@php
    $eventStyles = [
        'class' => 'bg-primary-subtle text-primary',
        'assignment' => 'bg-warning-subtle text-warning',
        'quiz' => 'bg-danger-subtle text-danger',
    ];
    $eventIcons = [
        'class' => 'mortarboard-fill',
        'assignment' => 'journal-text',
        'quiz' => 'question-circle',
    ];
@endphp
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Calendar', 'subtitle' => 'Your class schedule and upcoming assignment deadlines.', 'action' => ''])

    <div class="row g-3 mb-4">
        @foreach ([['Classes today', $classesToday, 'mortarboard-fill'], ['Upcoming assignments', $upcomingAssignments, 'journal-text'], ['Upcoming quizzes', $upcomingQuizzes, 'question-circle'], ['Events this month', $classEventCount + $assignmentEventCount, 'calendar-event']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="student-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div><h5 class="fw-bold mb-1">{{ $monthLabel }}</h5><small class="text-muted">Classes repeat weekly; deadlines show on their due date.</small></div>
            <div class="d-flex gap-2">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('student.calendar', ['month' => $previousMonth]) }}"><i class="bi bi-chevron-left"></i></a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('student.calendar') }}">Today</a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('student.calendar', ['month' => $nextMonth]) }}"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex gap-3 flex-wrap mb-3">
                <span class="small"><span class="legend-dot bg-primary d-inline-block rounded-circle me-1" style="width:9px;height:9px"></span>Class</span>
                <span class="small"><span class="legend-dot bg-warning d-inline-block rounded-circle me-1" style="width:9px;height:9px"></span>Assignment</span>
                <span class="small"><span class="legend-dot bg-danger d-inline-block rounded-circle me-1" style="width:9px;height:9px"></span>Quiz</span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0 text-center" style="table-layout:fixed">
                    <thead class="table-light"><tr>@foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)<th>{{ $day }}</th>@endforeach</tr></thead>
                    <tbody>
                        @foreach(array_chunk($days, 7) as $week)
                            <tr>
                                @foreach($week as $day)
                                    <td class="align-start text-start {{ $day['isCurrentMonth'] ? '' : 'bg-body-tertiary text-muted' }}" style="height:110px;vertical-align:top">
                                        <div class="d-flex justify-content-between align-items-center px-1">
                                            <span class="small fw-semibold {{ $day['isToday'] ? 'badge bg-primary rounded-circle' : '' }}">{{ $day['date']->day }}</span>
                                        </div>
                                        <div class="mt-1 d-flex flex-column gap-1">
                                            @foreach($day['events'] as $event)
                                                <span class="badge {{ $eventStyles[$event['type']] ?? 'bg-secondary-subtle text-secondary' }} text-start w-100 text-truncate" title="{{ $event['title'] }} · {{ $event['detail'] }}">
                                                    <i class="bi bi-{{ $eventIcons[$event['type']] ?? 'circle' }} me-1"></i>{{ $event['time'] ? $event['time'] . ' ' : '' }}{{ $event['title'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection