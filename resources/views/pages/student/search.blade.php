@extends('layouts.student')
@section('title', 'Search · SLAS')
@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Search results', 'subtitle' => 'Results for "' . $term . '" in your enrolled courses and published work.'])

    @if($courses->isNotEmpty())
        <section class="mb-4">
            <h2 class="h5 fw-bold mb-3">Courses</h2>
            <div class="student-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table student-table align-middle mb-0">
                        <thead><tr><th class="ps-4">Course</th><th>Code</th><th>Teacher</th><th class="pe-4">Action</th></tr></thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $course->name }}</td>
                                    <td>{{ $course->code }}</td>
                                    <td>{{ $course->teacher?->user?->name ?? 'Not assigned' }}</td>
                                    <td class="pe-4"><a class="btn btn-sm btn-outline-primary" href="{{ route('student.courses') }}">View courses</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif

    @if($assignments->isNotEmpty())
        <section>
            <h2 class="h5 fw-bold mb-3">Assignments and quizzes</h2>
            <div class="student-card overflow-hidden">
                <div class="table-responsive">
                    <table class="table student-table align-middle mb-0">
                        <thead><tr><th class="ps-4">Title</th><th>Type</th><th>Course</th><th>Status</th><th class="pe-4">Action</th></tr></thead>
                        <tbody>
                            @foreach($assignments as $assignment)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $assignment->title }}</td>
                                    <td>{{ $assignment->assignment_type === 'true_false' ? 'Quiz' : 'Assignment' }}</td>
                                    <td>{{ $assignment->course?->name }}</td>
                                    <td>{{ ucfirst($assignment->status) }}</td>
                                    <td class="pe-4"><a class="btn btn-sm btn-outline-primary" href="{{ route('student.assignments.submit', $assignment) }}">Open</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endif

    @if($courses->isEmpty() && $assignments->isEmpty())
        <div class="student-card text-center p-5">
            <i class="bi bi-search fs-2 text-muted"></i>
            <p class="text-muted mb-0 mt-2">No results found for “{{ $term }}”.</p>
        </div>
    @endif
</div>
@endsection