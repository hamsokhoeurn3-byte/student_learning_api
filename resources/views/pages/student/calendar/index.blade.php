@extends('layouts.student')

@section('title', 'Calendar')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Calendar
            </h1>

            <p class="text-muted mb-0">
                Manage your classes, assignments, quizzes and important events.
            </p>
        </div>

        <button
            class="btn btn-primary rounded-3 px-4"
            data-bs-toggle="modal"
            data-bs-target="#addEventModal"
        >
            <i class="bi bi-plus-lg me-2"></i>
            Add Event
        </button>

    </div>


    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">

        {{-- Classes --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex align-items-center">

                    <div class="calendar-icon bg-primary-subtle text-primary">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <div class="ms-3">

                        <p class="text-muted mb-1">
                            Classes Today
                        </p>

                        <h3 class="fw-bold mb-0">
                            3
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        {{-- Assignments --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex align-items-center">

                    <div class="calendar-icon bg-warning-subtle text-warning">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div class="ms-3">

                        <p class="text-muted mb-1">
                            Assignments
                        </p>

                        <h3 class="fw-bold mb-0">
                            2
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        {{-- Quizzes --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex align-items-center">

                    <div class="calendar-icon bg-danger-subtle text-danger">
                        <i class="bi bi-question-circle"></i>
                    </div>

                    <div class="ms-3">

                        <p class="text-muted mb-1">
                            Upcoming Quizzes
                        </p>

                        <h3 class="fw-bold mb-0">
                            1
                        </h3>

                    </div>

                </div>

            </div>

        </div>


        {{-- Events --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex align-items-center">

                    <div class="calendar-icon bg-success-subtle text-success">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                    <div class="ms-3">

                        <p class="text-muted mb-1">
                            Events This Month
                        </p>

                        <h3 class="fw-bold mb-0">
                            5
                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Calendar --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            {{-- Calendar Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h4 class="fw-bold mb-1">
                        Academic Calendar
                    </h4>

                    <p class="text-muted mb-0">
                        View your schedule and upcoming activities.
                    </p>

                </div>

                {{-- Legend --}}
                <div class="d-flex gap-3 flex-wrap">

                    <div class="d-flex align-items-center">
                        <span class="legend-dot bg-primary"></span>
                        <small>Class</small>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="legend-dot bg-warning"></span>
                        <small>Assignment</small>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="legend-dot bg-danger"></span>
                        <small>Quiz</small>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="legend-dot bg-success"></span>
                        <small>Event</small>
                    </div>

                </div>

            </div>


            {{-- FullCalendar --}}
            <div id="studentCalendar"></div>

        </div>

    </div>

</div>


{{-- Add Event Modal --}}
<div
    class="modal fade"
    id="addEventModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Add New Event
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Event Title
                    </label>

                    <input
                        type="text"
                        id="eventTitle"
                        class="form-control"
                        placeholder="Enter event title..."
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Date
                    </label>

                    <input
                        type="date"
                        id="eventDate"
                        class="form-control"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Event Type
                    </label>

                    <select
                        id="eventType"
                        class="form-select"
                    >

                        <option value="class">
                            Class
                        </option>

                        <option value="assignment">
                            Assignment
                        </option>

                        <option value="quiz">
                            Quiz
                        </option>

                        <option value="event">
                            Event
                        </option>

                    </select>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="saveEvent"
                    class="btn btn-primary"
                >
                    Save Event
                </button>

            </div>

        </div>

    </div>

</div>


{{-- FullCalendar CSS --}}
<style>

    #studentCalendar {
        min-height: 650px;
    }

    .fc {
        font-family: inherit;
    }

    .fc-toolbar-title {
        font-size: 1.35rem !important;
        font-weight: 700;
    }

    .fc-button {
        border-radius: 8px !important;
        padding: 8px 14px !important;
        box-shadow: none !important;
    }

    .fc-button-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
    }

    .fc-button-primary:hover {
        background-color: #0b5ed7 !important;
        border-color: #0a58ca !important;
    }

    .fc-daygrid-day-number {
        font-weight: 600;
        text-decoration: none;
        padding: 8px;
    }

    .fc-col-header-cell-cushion {
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        padding: 12px 0;
    }

    .fc-day-today {
        background-color: rgba(13, 110, 253, 0.05) !important;
    }

    .fc-event {
        border: none !important;
        border-radius: 6px !important;
        padding: 4px 6px !important;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .fc-daygrid-event {
        margin-top: 3px !important;
    }

    .calendar-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 22px;
    }

    .legend-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

</style>


{{-- FullCalendar JavaScript --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const calendarElement =
        document.getElementById('studentCalendar');


    const calendar = new FullCalendar.Calendar(
        calendarElement,
        {

            plugins: [
                FullCalendar.dayGridPlugin,
                FullCalendar.timeGridPlugin,
                FullCalendar.interactionPlugin
            ],

            initialView: 'dayGridMonth',

            height: 'auto',

            headerToolbar: {

                left: 'prev,next today',

                center: 'title',

                right: 'dayGridMonth,timeGridWeek,timeGridDay'

            },


            buttonText: {

                today: 'Today',

                month: 'Month',

                week: 'Week',

                day: 'Day'

            },


            selectable: true,

            editable: false,


            events: [

                {
                    title: 'Data Structures',
                    start: '2024-05-20T08:00:00',
                    end: '2024-05-20T09:30:00',
                    backgroundColor: '#0d6efd'
                },

                {
                    title: 'Database Systems',
                    start: '2024-05-20T10:00:00',
                    end: '2024-05-20T11:30:00',
                    backgroundColor: '#0d6efd'
                },

                {
                    title: 'Web Development Assignment',
                    start: '2024-05-22',
                    backgroundColor: '#ffc107',
                    textColor: '#212529'
                },

                {
                    title: 'Math Quiz',
                    start: '2024-05-24',
                    backgroundColor: '#dc3545'
                },

                {
                    title: 'Physics Class',
                    start: '2024-05-27T09:00:00',
                    end: '2024-05-27T10:30:00',
                    backgroundColor: '#0d6efd'
                },

                {
                    title: 'Project Presentation',
                    start: '2024-05-30',
                    backgroundColor: '#198754'
                }

            ],


            eventClick: function(info) {

                alert(
                    'Event: ' +
                    info.event.title
                );

            },


            dateClick: function(info) {

                document.getElementById('eventDate').value =
                    info.dateStr;

                const modal =
                    new bootstrap.Modal(
                        document.getElementById('addEventModal')
                    );

                modal.show();

            }

        }
    );


    calendar.render();


    // Save Event
    document.getElementById('saveEvent')
        .addEventListener('click', function () {

            const title =
                document.getElementById('eventTitle').value;

            const date =
                document.getElementById('eventDate').value;

            const type =
                document.getElementById('eventType').value;


            if (!title || !date) {

                alert('Please enter event title and date.');

                return;

            }


            let backgroundColor = '#0d6efd';


            if (type === 'assignment') {
                backgroundColor = '#ffc107';
            }

            if (type === 'quiz') {
                backgroundColor = '#dc3545';
            }

            if (type === 'event') {
                backgroundColor = '#198754';
            }


            calendar.addEvent({

                title: title,

                start: date,

                backgroundColor: backgroundColor,

                borderColor: backgroundColor

            });


            document.getElementById('eventTitle').value = '';


            bootstrap.Modal
                .getInstance(
                    document.getElementById('addEventModal')
                )
                .hide();

        });

});

</script>

@endsection