@extends('layouts.teacher')
@section('title', 'Calendar · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Calendar</div>
        <h1 class="h2 fw-bold mb-1">Calendar</h1>
        <p class="text-muted mb-0">Your assigned class schedules and assignment due dates.</p>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
        <a class="btn btn-outline-secondary" href="{{ route('teacher.calendar', ['month' => $previousMonth]) }}" aria-label="Previous month" title="Previous month"><i class="bi bi-chevron-left"></i></a>
        <a class="btn btn-outline-secondary" href="{{ route('teacher.calendar', ['month' => now()->format('Y-m')]) }}">Today</a>
        <a class="btn btn-outline-secondary" href="{{ route('teacher.calendar', ['month' => $nextMonth]) }}" aria-label="Next month" title="Next month"><i class="bi bi-chevron-right"></i></a>
        <form class="d-flex gap-2 ms-md-2" method="GET" action="{{ route('teacher.calendar') }}">
            <label class="visually-hidden" for="calendarMonth">Select month</label>
            <input class="form-control" id="calendarMonth" type="month" name="month" value="{{ $monthValue }}" required>
            <button class="btn btn-primary" type="submit" aria-label="Show selected month" title="Show selected month"><i class="bi bi-calendar3"></i></button>
        </form>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h2 class="h4 fw-bold mb-0">{{ $monthLabel }}</h2>
    <div class="small text-muted">{{ $classEventCount }} class sessions · {{ $assignmentEventCount }} assignment deadlines</div>
</div>

@if($classEventCount === 0 && $assignmentEventCount === 0)
    <div class="alert alert-light border mb-3">No class schedules or assignment deadlines are recorded for this month.</div>
@endif

<div class="card portal-card border-0">
    <div class="calendar-scroll">
        <div class="teacher-calendar-grid">
            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $weekday)
                <div class="calendar-weekday">{{ $weekday }}</div>
            @endforeach
            @foreach($calendarDays as $calendarDay)
                <div class="calendar-day {{ $calendarDay['isCurrentMonth'] ? '' : 'calendar-day-outside' }}">
                    <div class="calendar-day-number">{{ $calendarDay['date']->format('j') }}</div>
                    @foreach($calendarDay['events'] as $event)
                        @if($event['type'] === 'Class' && $event['canTakeAttendance'])
                            <a class="calendar-event calendar-event-class calendar-event-link" href="{{ $event['attendanceUrl'] }}" aria-label="Take attendance for {{ $event['title'] }}">
                                <span class="calendar-event-type">Class · Take attendance</span>
                                <strong>{{ $event['title'] }}</strong>
                                <small>{{ $event['course'] }}@if($event['detail']) · {{ $event['detail'] }}@endif</small>
                            </a>
                        @else
                            <div class="calendar-event {{ $event['type'] === 'Class' ? 'calendar-event-class calendar-event-disabled' : 'calendar-event-assignment' }}" title="{{ $event['type'] === 'Class' && !$event['canTakeAttendance'] ? 'Attendance available at ' . ($event['attendanceOpensAt'] ?? 'the scheduled class time') : $event['title'] }}">
                                <span class="calendar-event-type">{{ $event['type'] }}</span>
                                <strong>{{ $event['title'] }}</strong>
                                <small>{{ $event['course'] }}@if($event['detail']) · {{ $event['detail'] }}@endif</small>
                                @if($event['type'] === 'Class' && !$event['canTakeAttendance'])<small>Attendance available at {{ $event['attendanceOpensAt'] ?? 'scheduled class time' }}</small>@endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .calendar-scroll { overflow-x: auto; }
    .teacher-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(120px, 1fr)); min-width: 840px; }
    .calendar-weekday { padding: 12px 10px; border-bottom: 1px solid #dee2e6; color: #667085; font-size: .8rem; font-weight: 700; text-align: center; }
    .calendar-day { min-height: 132px; padding: 8px; border-right: 1px solid #e9ecef; border-bottom: 1px solid #e9ecef; }
    .calendar-day-outside { background: #f8f9fa; color: #98a2b3; }
    .calendar-day-number { margin-bottom: 6px; font-size: .85rem; font-weight: 700; }
    .calendar-event { display: grid; gap: 2px; margin-bottom: 5px; padding: 6px; border-radius: 4px; font-size: .72rem; line-height: 1.3; overflow-wrap: anywhere; }
    .calendar-event-class { background: #eaf3ff; color: #214d7a; }
    .calendar-event-assignment { background: #fff3df; color: #79530b; }
    .calendar-event-link { color: inherit; text-decoration: none; }
    .calendar-event-link:hover { color: inherit; filter: brightness(.97); outline: 1px solid #8bb9ea; }
    .calendar-event-disabled { cursor: not-allowed; opacity: .82; }
    .calendar-event-type { font-size: .64rem; font-weight: 700; text-transform: uppercase; }
    .calendar-event small { color: inherit; opacity: .8; }
</style>
@endsection
