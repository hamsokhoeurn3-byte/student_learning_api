@extends('layouts.student')

@section('title', 'Notifications')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- =========================
        PAGE HEADER
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">Notifications</h1>

            <p class="text-muted mb-0">
                Stay updated with your academic activities.
            </p>
        </div>

        <button class="btn btn-light border rounded-3 px-4">
            <i class="bi bi-check2-all me-2 text-primary"></i>
            Mark all as read
        </button>

    </div>


    {{-- =========================
        NOTIFICATION SUMMARY
    ========================== --}}
    <div class="row g-4 mb-4">

        {{-- Total --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-muted mb-2">
                            Total Notifications
                        </div>

                        <h2 class="fw-bold mb-1">
                            12
                        </h2>

                        <small class="text-muted">
                            This month
                        </small>
                    </div>

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="
                            width:55px;
                            height:55px;
                            background:#eee9ff;
                        "
                    >
                        <i class="bi bi-bell-fill fs-4 text-primary"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Unread --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-muted mb-2">
                            Unread
                        </div>

                        <h2 class="fw-bold mb-1">
                            3
                        </h2>

                        <small class="text-danger">
                            Requires attention
                        </small>
                    </div>

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="
                            width:55px;
                            height:55px;
                            background:#ffe9ec;
                        "
                    >
                        <i class="bi bi-envelope-fill fs-4 text-danger"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Academic --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-muted mb-2">
                            Academic
                        </div>

                        <h2 class="fw-bold mb-1">
                            8
                        </h2>

                        <small class="text-success">
                            Assignments & quizzes
                        </small>
                    </div>

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="
                            width:55px;
                            height:55px;
                            background:#e6f8ef;
                        "
                    >
                        <i class="bi bi-mortarboard-fill fs-4 text-success"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- System --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="text-muted mb-2">
                            System
                        </div>

                        <h2 class="fw-bold mb-1">
                            4
                        </h2>

                        <small class="text-primary">
                            General updates
                        </small>
                    </div>

                    <div
                        class="rounded-4 d-flex align-items-center justify-content-center"
                        style="
                            width:55px;
                            height:55px;
                            background:#e8f3ff;
                        "
                    >
                        <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        MAIN NOTIFICATION AREA
    ========================== --}}
    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                {{-- Card Header --}}
                <div class="card-body p-4">

                    <div
                        class="d-flex justify-content-between align-items-center mb-4"
                    >

                        <div>
                            <h4 class="fw-bold mb-1">
                                Recent Notifications
                            </h4>

                            <p class="text-muted mb-0">
                                Your latest updates and activities.
                            </p>
                        </div>

                        <span
                            class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2"
                        >
                            3 Unread
                        </span>

                    </div>


                    {{-- =====================
                        NOTIFICATION 1
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4 mb-3 unread"
                    >

                        <div class="d-flex">

                            {{-- Icon --}}
                            <div
                                class="notification-icon bg-warning-subtle text-warning"
                            >
                                <i class="bi bi-journal-text fs-5"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        Assignment Reminder
                                    </h6>

                                    <small class="text-muted">
                                        2 min ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    Your Data Structures Assignment is due
                                    in 2 days.
                                </p>

                                <span
                                    class="badge bg-warning-subtle text-warning rounded-pill"
                                >
                                    Assignment
                                </span>

                            </div>

                            <div class="notification-dot"></div>

                        </div>

                    </div>


                    {{-- =====================
                        NOTIFICATION 2
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4 mb-3 unread"
                    >

                        <div class="d-flex">

                            <div
                                class="notification-icon bg-info-subtle text-info"
                            >
                                <i class="bi bi-question-circle-fill fs-5"></i>
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        Quiz Reminder
                                    </h6>

                                    <small class="text-muted">
                                        1 hour ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    Math Quiz 2 is scheduled for tomorrow.
                                    Make sure you are prepared.
                                </p>

                                <span
                                    class="badge bg-info-subtle text-info rounded-pill"
                                >
                                    Quiz
                                </span>

                            </div>

                            <div class="notification-dot"></div>

                        </div>

                    </div>


                    {{-- =====================
                        NOTIFICATION 3
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4 mb-3 unread"
                    >

                        <div class="d-flex">

                            <div
                                class="notification-icon bg-success-subtle text-success"
                            >
                                <i class="bi bi-check-circle-fill fs-5"></i>
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        Grade Updated
                                    </h6>

                                    <small class="text-muted">
                                        3 hours ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    Your grade for Database Systems has
                                    been updated.
                                </p>

                                <span
                                    class="badge bg-success-subtle text-success rounded-pill"
                                >
                                    Grade
                                </span>

                            </div>

                            <div class="notification-dot"></div>

                        </div>

                    </div>


                    {{-- =====================
                        NOTIFICATION 4
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4 mb-3"
                    >

                        <div class="d-flex">

                            <div
                                class="notification-icon bg-primary-subtle text-primary"
                            >
                                <i class="bi bi-book-fill fs-5"></i>
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        New Course Material
                                    </h6>

                                    <small class="text-muted">
                                        6 hours ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    New lecture notes have been uploaded
                                    for Web Development.
                                </p>

                                <span
                                    class="badge bg-primary-subtle text-primary rounded-pill"
                                >
                                    Course
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =====================
                        NOTIFICATION 5
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4 mb-3"
                    >

                        <div class="d-flex">

                            <div
                                class="notification-icon bg-danger-subtle text-danger"
                            >
                                <i class="bi bi-exclamation-circle-fill fs-5"></i>
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        Attendance Alert
                                    </h6>

                                    <small class="text-muted">
                                        1 day ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    Your attendance was recorded as absent
                                    on May 18, 2024.
                                </p>

                                <span
                                    class="badge bg-danger-subtle text-danger rounded-pill"
                                >
                                    Attendance
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =====================
                        NOTIFICATION 6
                    ====================== --}}
                    <div
                        class="notification-item p-3 rounded-4"
                    >

                        <div class="d-flex">

                            <div
                                class="notification-icon bg-purple-subtle text-primary"
                            >
                                <i class="bi bi-megaphone-fill fs-5"></i>
                            </div>

                            <div class="flex-grow-1 ms-3">

                                <div
                                    class="d-flex justify-content-between"
                                >

                                    <h6 class="fw-bold mb-1">
                                        System Announcement
                                    </h6>

                                    <small class="text-muted">
                                        2 days ago
                                    </small>

                                </div>

                                <p class="text-muted mb-2">
                                    The system will be under maintenance
                                    on May 30, 2024.
                                </p>

                                <span
                                    class="badge bg-secondary-subtle text-secondary rounded-pill"
                                >
                                    System
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Pagination --}}
                    <div
                        class="d-flex justify-content-center mt-4 pt-4 border-top"
                    >

                        <nav>

                            <ul class="pagination mb-0">

                                <li class="page-item disabled">
                                    <a class="page-link rounded-3 me-2">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                <li class="page-item active">
                                    <a class="page-link rounded-3 me-2">
                                        1
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link rounded-3 me-2">
                                        2
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link rounded-3">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>

                            </ul>

                        </nav>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
            RIGHT SIDEBAR
        ========================== --}}
        <div class="col-lg-4">

            {{-- Notification Settings --}}
            <div
                class="card border-0 shadow-sm rounded-4 p-4 mb-4"
            >

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="fw-bold mb-0">
                        Notification Settings
                    </h5>

                    <i class="bi bi-gear text-muted"></i>

                </div>


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <strong class="d-block">
                            Assignment Reminders
                        </strong>

                        <small class="text-muted">
                            Get reminders before deadlines
                        </small>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            checked
                        >
                    </div>

                </div>


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <strong class="d-block">
                            Quiz Reminders
                        </strong>

                        <small class="text-muted">
                            Get notified about upcoming quizzes
                        </small>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            checked
                        >
                    </div>

                </div>


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <strong class="d-block">
                            Grade Updates
                        </strong>

                        <small class="text-muted">
                            Notify when grades are updated
                        </small>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            checked
                        >
                    </div>

                </div>


                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <strong class="d-block">
                            System Notifications
                        </strong>

                        <small class="text-muted">
                            Important system announcements
                        </small>
                    </div>

                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            checked
                        >
                    </div>

                </div>

            </div>


            {{-- Upcoming --}}
            <div
                class="card border-0 shadow-sm rounded-4 p-4 mb-4"
            >

                <div
                    class="d-flex justify-content-between align-items-center mb-4"
                >

                    <h5 class="fw-bold mb-0">
                        Upcoming
                    </h5>

                    <a
                        href="#"
                        class="text-primary text-decoration-none small"
                    >
                        View Calendar
                    </a>

                </div>


                {{-- Event --}}
                <div class="d-flex align-items-center mb-4">

                    <div
                        class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center"
                        style="width:45px;height:45px;"
                    >
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div class="ms-3">

                        <strong class="d-block">
                            Data Structures
                        </strong>

                        <small class="text-muted">
                            Assignment • May 22
                        </small>

                    </div>

                </div>


                <div class="d-flex align-items-center mb-4">

                    <div
                        class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center"
                        style="width:45px;height:45px;"
                    >
                        <i class="bi bi-question-circle"></i>
                    </div>

                    <div class="ms-3">

                        <strong class="d-block">
                            Math Quiz 2
                        </strong>

                        <small class="text-muted">
                            Quiz • May 23
                        </small>

                    </div>

                </div>


                <div class="d-flex align-items-center">

                    <div
                        class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center"
                        style="width:45px;height:45px;"
                    >
                        <i class="bi bi-easel"></i>
                    </div>

                    <div class="ms-3">

                        <strong class="d-block">
                            Web Development
                        </strong>

                        <small class="text-muted">
                            Class • May 24
                        </small>

                    </div>

                </div>

            </div>


            {{-- Quick Tip --}}
            <div
                class="card border-0 rounded-4 p-4"
                style="
                    background:linear-gradient(
                        135deg,
                        #f1edff,
                        #e8e0ff
                    );
                "
            >

                <div class="text-center">

                    <div
                        class="mx-auto mb-3 rounded-circle bg-white d-flex align-items-center justify-content-center"
                        style="
                            width:65px;
                            height:65px;
                        "
                    >
                        <i
                            class="bi bi-bell-fill fs-3 text-primary"
                        ></i>
                    </div>

                    <h5 class="fw-bold">
                        Stay Updated!
                    </h5>

                    <p class="text-muted small mb-0">
                        Check your notifications regularly
                        so you never miss an important
                        academic update.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================
     CUSTOM CSS
========================== --}}
<style>

    .notification-item {
        border: 1px solid #f0f0f5;
        transition: all 0.2s ease;
        background: #fff;
    }

    .notification-item:hover {
        background: #faf9ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(80, 60, 180, 0.06);
    }

    .notification-item.unread {
        background: #f8f7ff;
        border-color: #e8e2ff;
    }

    .notification-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-dot {
        width: 9px;
        height: 9px;

        background: #6935ff;

        border-radius: 50%;

        margin-top: 7px;
        margin-left: 10px;
    }

    .bg-purple-subtle {
        background: #eee9ff;
    }

    .form-check-input {
        width: 2.4em;
        height: 1.3em;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #6735f1;
        border-color: #6735f1;
    }

    .page-link {
        border: 0;
        color: #4d3bd8;
        background: #f5f3ff;
        min-width: 38px;
        text-align: center;
    }

    .page-item.active .page-link {
        background: #6735f1;
        border-color: #6735f1;
    }

</style>

@endsection