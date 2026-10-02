@extends('layouts.student')
@section('title', 'Courses · SLAS')
@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'My Courses', 'subtitle' => 'Courses you are enrolled in.', 'action' => ''])

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3"><div class="student-card student-stat"><div class="stat-label">Enrolled courses</div><div class="stat-value mt-1">{{ $courses->count() }}</div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="student-card student-stat"><div class="stat-label">Credits</div><div class="stat-value mt-1">{{ $courses->sum(fn ($course) => $course->credits ?? 0) }}</div></div></div>
    </div>

    <h2 class="h5 fw-bold mb-3">Current courses</h2>
    @if($courses->isEmpty())
        <div class="student-card p-4 text-center text-muted">You are not enrolled in any courses yet. Contact your administrator to be added to a class.</div>
    @else
        <div class="table-responsive student-card mb-4"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Course</th><th>Code</th><th>Teacher</th><th>Department</th><th>Credits</th><th>Term</th></tr></thead><tbody>
            @foreach($courses as $course)
                <tr><td class="ps-4"><strong>{{ $course->name }}</strong></td><td>{{ $course->code }}</td><td>{{ $course->teacher?->user?->name ?? 'Not assigned' }}</td><td>{{ $course->department ?? 'Not set' }}</td><td>{{ $course->credits ?? 'N/A' }}</td><td>{{ $course->pivot->academic_year ?? $course->academic_year ?? '—' }} · {{ $course->pivot->semester ?? $course->semester ?? '—' }}</td></tr>
            @endforeach
        </tbody></table></div>
    @endif

    <h2 class="h5 fw-bold mb-3">Course assignments</h2>
    @if($assignments->isEmpty())
        <div class="student-card p-4 text-center text-muted">No published assignments are available for your enrolled courses.</div>
    @else
        <div class="table-responsive student-card"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Assignment</th><th>Course</th><th>Availability</th><th>Status</th></tr></thead><tbody>
            @foreach($assignments as $assignment)
                <tr>
                    <td class="ps-4"><strong>{{ $assignment->title }}</strong></td>
                    <td>{{ $assignment->course?->code ?? '—' }}</td>
                    <td>
                        @if($assignment->starts_at)<small class="d-block">Starts {{ $assignment->starts_at->format('M d, Y H:i') }}</small>@endif
                        <small class="d-block">Due {{ $assignment->ends_at?->format('M d, Y H:i') ?? $assignment->due_date?->format('M d, Y') ?? 'No due date' }}</small>
                    </td>
                    <td>{{ ucfirst($assignment->status) }}</td>
                </tr>
            @endforeach
        </tbody></table></div>
    @endif
</div>
@endsection
