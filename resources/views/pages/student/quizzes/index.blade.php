@extends('layouts.student')

@section('title', 'Quizzes')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Quizzes
            </h1>

            <div class="text-muted">
                Dashboard
                <span class="mx-2">/</span>
                Quizzes
            </div>
        </div>

        <button class="btn btn-primary px-4 py-2 rounded-3">
            <i class="bi bi-plus-lg me-2"></i>
            Take Quiz
        </button>

    </div>


    {{-- =========================================================
        TABS
    ========================================================== --}}
    <div class="border-bottom mb-4">

        <ul class="nav nav-tabs border-0">

            <li class="nav-item">
                <a class="nav-link active px-3" href="#">
                    All Quizzes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 text-dark" href="#">
                    My Quizzes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 text-dark" href="#">
                    Attempted
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link px-3 text-dark" href="#">
                    Upcoming
                </a>
            </li>

        </ul>

    </div>


    {{-- =========================================================
        STATISTICS CARDS
    ========================================================== --}}
    <div class="row g-3 mb-4">

        {{-- Total Quizzes --}}
        <div class="col-xl col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-primary-subtle text-primary
                                   d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-clipboard-check fs-4"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Total Quizzes
                            </div>

                            <h3 class="fw-bold mb-0">
                                28
                            </h3>

                            <small class="text-success">
                                ↑ 4 this month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Attempted --}}
        <div class="col-xl col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-info-subtle text-info
                                   d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-file-earmark-check fs-4"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Attempted
                            </div>

                            <h3 class="fw-bold mb-0">
                                16
                            </h3>

                            <small class="text-muted">
                                57% of total
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Average Score --}}
        <div class="col-xl col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-success-subtle text-success
                                   d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Average Score
                            </div>

                            <h3 class="fw-bold mb-0">
                                85%
                            </h3>

                            <small class="text-success">
                                ↑ 8% from last month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Best Score --}}
        <div class="col-xl col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-warning-subtle text-warning
                                   d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-trophy-fill fs-4"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Best Score
                            </div>

                            <h3 class="fw-bold mb-0">
                                98%
                            </h3>

                            <small class="text-muted">
                                Data Structures Quiz
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Time Spent --}}
        <div class="col-xl col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div
                            class="rounded-circle bg-danger-subtle text-danger
                                   d-flex align-items-center justify-content-center"
                            style="width:52px;height:52px;"
                        >
                            <i class="bi bi-clock fs-4"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Time Spent
                            </div>

                            <h3 class="fw-bold mb-0">
                                12h 45m
                            </h3>

                            <small class="text-muted">
                                This month
                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <div class="row g-4">


        {{-- =====================================================
            LEFT SIDE
        ====================================================== --}}
        <div class="col-xl-9">


            {{-- Quiz List --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-3">


                    {{-- SEARCH + FILTER --}}
                    <div class="row g-2 mb-3">

                        <div class="col-lg-4">

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search text-muted"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Search quizzes..."
                                >

                            </div>

                        </div>


                        <div class="col-lg-2">

                            <select class="form-select">
                                <option>All Courses</option>
                                <option>CS101</option>
                                <option>CS102</option>
                                <option>CS103</option>
                            </select>

                        </div>


                        <div class="col-lg-2">

                            <select class="form-select">
                                <option>All Types</option>
                                <option>Graded</option>
                                <option>Practice</option>
                            </select>

                        </div>


                        <div class="col-lg-2">

                            <select class="form-select">
                                <option>All Status</option>
                                <option>Completed</option>
                                <option>Upcoming</option>
                                <option>Not Started</option>
                            </select>

                        </div>


                        <div class="col-lg-2">

                            <select class="form-select">
                                <option>Sort by: Newest</option>
                                <option>Oldest</option>
                                <option>Highest Score</option>
                            </select>

                        </div>

                    </div>


                    {{-- TABLE --}}
                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr class="text-muted small">

                                    <th class="border-0">
                                        Quiz Title
                                    </th>

                                    <th class="border-0">
                                        Course
                                    </th>

                                    <th class="border-0">
                                        Type
                                    </th>

                                    <th class="border-0">
                                        Questions
                                    </th>

                                    <th class="border-0">
                                        Time Limit
                                    </th>

                                    <th class="border-0">
                                        Due Date
                                    </th>

                                    <th class="border-0">
                                        Status
                                    </th>

                                    <th class="border-0">
                                        Score
                                    </th>

                                    <th class="border-0">
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                {{-- Quiz 1 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-code-slash"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Data Structures Quiz
                                                </div>

                                                <small class="text-muted">
                                                    Chapters 1-3
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Graded
                                        </span>
                                    </td>

                                    <td>
                                        20
                                    </td>

                                    <td>
                                        30 min
                                    </td>

                                    <td>
                                        <div>May 20, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Completed
                                        </span>
                                    </td>

                                    <td>

                                        <strong>95%</strong>

                                        <div>
                                            <small class="text-muted">
                                                19 / 20
                                            </small>
                                        </div>

                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 2 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-info-subtle text-info">
                                                <i class="bi bi-list-ul"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Arrays and Linked Lists
                                                </div>

                                                <small class="text-muted">
                                                    Practice Quiz
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            Practice
                                        </span>
                                    </td>

                                    <td>15</td>

                                    <td>20 min</td>

                                    <td>-</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Completed
                                        </span>
                                    </td>

                                    <td>

                                        <strong>88%</strong>

                                        <div>
                                            <small class="text-muted">
                                                13 / 15
                                            </small>
                                        </div>

                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 3 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-danger-subtle text-danger">
                                                <i class="bi bi-stack"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Stack and Queue Quiz
                                                </div>

                                                <small class="text-muted">
                                                    Chapters 4-5
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Graded
                                        </span>
                                    </td>

                                    <td>20</td>

                                    <td>30 min</td>

                                    <td>
                                        <div>May 27, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Completed
                                        </span>
                                    </td>

                                    <td>

                                        <strong>90%</strong>

                                        <div>
                                            <small class="text-muted">
                                                18 / 20
                                            </small>
                                        </div>

                                    </td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 4 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-diagram-3"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Tree and Graph Quiz
                                                </div>

                                                <small class="text-muted">
                                                    Chapters 6-7
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Graded
                                        </span>
                                    </td>

                                    <td>25</td>

                                    <td>40 min</td>

                                    <td>
                                        <div>Jun 3, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            Upcoming
                                        </span>
                                    </td>

                                    <td>-</td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 5 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-success-subtle text-success">
                                                <i class="bi bi-diagram-3-fill"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Sorting Algorithms
                                                </div>

                                                <small class="text-muted">
                                                    Practice Quiz
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            Practice
                                        </span>
                                    </td>

                                    <td>15</td>

                                    <td>20 min</td>

                                    <td>-</td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Not Started
                                        </span>
                                    </td>

                                    <td>-</td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 6 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-warning-subtle text-warning">
                                                <i class="bi bi-trophy"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Final Comprehensive Quiz
                                                </div>

                                                <small class="text-muted">
                                                    All Chapters
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Graded
                                        </span>
                                    </td>

                                    <td>50</td>

                                    <td>60 min</td>

                                    <td>
                                        <div>Jun 15, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Not Started
                                        </span>
                                    </td>

                                    <td>-</td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 7 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-info-subtle text-info">
                                                <i class="bi bi-diagram-2"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Binary Tree Traversal
                                                </div>

                                                <small class="text-muted">
                                                    Practice Quiz
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            Practice
                                        </span>
                                    </td>

                                    <td>10</td>

                                    <td>15 min</td>

                                    <td>-</td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Not Started
                                        </span>
                                    </td>

                                    <td>-</td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>


                                {{-- Quiz 8 --}}
                                <tr>

                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="quiz-icon bg-primary-subtle text-primary">
                                                <i class="bi bi-diagram-3"></i>
                                            </div>

                                            <div>

                                                <div class="fw-semibold">
                                                    Graph Algorithms
                                                </div>

                                                <small class="text-muted">
                                                    Chapters 8-9
                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            CS101
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            Graded
                                        </span>
                                    </td>

                                    <td>20</td>

                                    <td>30 min</td>

                                    <td>
                                        <div>Jun 22, 2024</div>
                                        <small class="text-danger">
                                            11:59 PM
                                        </small>
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Not Started
                                        </span>
                                    </td>

                                    <td>-</td>

                                    <td>
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}
                    <div class="d-flex justify-content-center pt-4">

                        <nav>

                            <ul class="pagination mb-0">

                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                <li class="page-item active">
                                    <a class="page-link" href="#">
                                        1
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        2
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        3
                                    </a>
                                </li>

                                <li class="page-item disabled">
                                    <span class="page-link">
                                        ...
                                    </span>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        4
                                    </a>
                                </li>

                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>

                            </ul>

                        </nav>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            RIGHT SIDE
        ====================================================== --}}
        <div class="col-xl-3">


            {{-- Quiz Performance --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Quiz Performance
                        </h5>

                        <select class="form-select form-select-sm"
                                style="width:120px;">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>

                    </div>

                    <div id="quizPerformanceChart"></div>

                </div>

            </div>


            {{-- Performance by Type --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Performance by Type
                    </h5>

                    <div id="quizTypeChart"></div>

                    <div class="mt-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">
                                🟣 Graded Quizzes
                            </span>

                            <strong>86%</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">
                                🔵 Practice Quizzes
                            </span>

                            <strong>82%</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="small">
                                🟢 Timed Quizzes
                            </span>

                            <strong>88%</strong>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Recent Achievements --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-3">

                        <h5 class="fw-bold mb-0">
                            Recent Achievements
                        </h5>

                        <a href="#" class="text-primary small">
                            View All
                        </a>

                    </div>


                    <div class="d-flex gap-3 mb-3">

                        <div class="achievement-icon bg-primary-subtle text-primary">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                High Achiever
                            </div>

                            <small class="text-muted">
                                Scored above 90% in 3 quizzes
                            </small>

                        </div>

                    </div>


                    <div class="d-flex gap-3 mb-3">

                        <div class="achievement-icon bg-success-subtle text-success">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Consistent Learner
                            </div>

                            <small class="text-muted">
                                Completed quizzes for 7 days in a row
                            </small>

                        </div>

                    </div>


                    <div class="d-flex gap-3">

                        <div class="achievement-icon bg-warning-subtle text-warning">
                            <i class="bi bi-trophy-fill"></i>
                        </div>

                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                Perfect Score
                            </div>

                            <small class="text-muted">
                                Got 100% in Arrays Practice Quiz
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Tips --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Tips for Better Performance
                    </h5>

                    <div class="small text-muted mb-3">
                        <i class="bi bi-journal-check text-primary me-2"></i>
                        Review your mistakes and learn from them.
                    </div>

                    <div class="small text-muted mb-3">
                        <i class="bi bi-check2-circle text-primary me-2"></i>
                        Practice regularly to improve your skills.
                    </div>

                    <div class="small text-muted mb-3">
                        <i class="bi bi-clock text-primary me-2"></i>
                        Manage your time during quizzes.
                    </div>

                    <div class="small text-muted">
                        <i class="bi bi-lightbulb text-primary me-2"></i>
                        Focus on understanding, not memorizing.
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    CUSTOM CSS
============================================================= --}}
<style>

    .quiz-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .achievement-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .table > :not(caption) > * > * {
        padding: 14px 8px;
        border-bottom-color: #edf0f5;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: transparent;
    }

    .form-control,
    .form-select {
        border-color: #dee2e6;
        border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }

</style>


{{-- =============================================================
    APEXCHARTS
============================================================= --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       QUIZ PERFORMANCE
    ========================================================= */

    const performanceOptions = {

        chart: {
            type: 'line',
            height: 220,
            toolbar: {
                show: false
            }
        },

        series: [{
            name: 'Average Score',
            data: [72, 78, 85, 92]
        }],

        xaxis: {
            categories: [
                'Week 1',
                'Week 2',
                'Week 3',
                'Week 4'
            ],

            labels: {
                style: {
                    fontSize: '11px'
                }
            }
        },

        yaxis: {
            min: 0,
            max: 100,
            tickAmount: 4,

            labels: {
                formatter: function (value) {
                    return value + '%';
                }
            }
        },

        stroke: {
            curve: 'smooth',
            width: 3
        },

        markers: {
            size: 4
        },

        dataLabels: {
            enabled: true,

            formatter: function (value) {
                return value + '%';
            }
        },

        grid: {
            borderColor: '#eeeeee'
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return value + '%';
                }
            }
        }

    };


    const performanceChart =
        new ApexCharts(
            document.querySelector('#quizPerformanceChart'),
            performanceOptions
        );

    performanceChart.render();


    /* =========================================================
       PERFORMANCE BY TYPE
    ========================================================= */

    const typeOptions = {

        chart: {
            type: 'donut',
            height: 220
        },

        series: [
            86,
            82,
            88
        ],

        labels: [
            'Graded Quizzes',
            'Practice Quizzes',
            'Timed Quizzes'
        ],

        legend: {
            show: false
        },

        dataLabels: {
            enabled: false
        },

        plotOptions: {

            pie: {

                donut: {

                    size: '65%',

                    labels: {

                        show: true,

                        total: {

                            show: true,

                            label: 'Average',

                            formatter: function () {
                                return '85%';
                            }

                        }

                    }

                }

            }

        },

        stroke: {
            width: 3
        }

    };


    const typeChart =
        new ApexCharts(
            document.querySelector('#quizTypeChart'),
            typeOptions
        );

    typeChart.render();

});

</script>

@endpush

@endsection