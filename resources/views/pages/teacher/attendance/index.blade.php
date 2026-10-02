@extends('layouts.teacher')
@section('title', 'Attendance · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Attendance</div>
        <h1 class="h2 fw-bold mb-1">Attendance</h1>
        <p class="text-muted mb-0">Mark attendance for students enrolled in your assigned classes.</p>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@if($courses->isEmpty())
    <div class="card portal-card border-0"><div class="card-body text-center py-5 text-muted">No classes have been assigned to you yet.</div></div>
@else
    <form method="GET" action="{{ route('teacher.attendance') }}" class="card portal-card border-0 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label" for="attendanceCourse">Assigned class</label>
                    <select class="form-select" id="attendanceCourse" name="course_id" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" @selected($selectedCourse?->id === $course->id)>{{ $course->name }} ({{ $course->code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="attendanceDate">Date</label>
                    <input class="form-control" id="attendanceDate" type="date" name="date" value="{{ $attendanceDate }}" required>
                </div>
                <div class="col-md-2"><button class="btn btn-outline-primary w-100" type="submit">Show roster</button></div>
            </div>
        </div>
    </form>

    @if($selectedCourse)
        @if(!$canMarkAttendance)
            <div class="alert alert-info">{{ $attendanceAvailabilityMessage }}</div>
        @endif
        <form method="POST" action="{{ route('teacher.attendance.store') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
            <input type="hidden" name="attendance_date" value="{{ $attendanceDate }}">
            <div class="card portal-card border-0">
                <div class="card-body p-4 pb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h2 class="h5 fw-bold mb-1">{{ $selectedCourse->name }}</h2>
                        <p class="small text-muted mb-0">{{ $selectedCourse->code }} · {{ \Carbon\Carbon::parse($attendanceDate)->format('F j, Y') }}</p>
                    </div>
                    <button class="btn btn-primary" type="submit" @disabled(!$canMarkAttendance || $students->isEmpty())><i class="bi bi-check2-circle me-2"></i>Save attendance</button>
                </div>
                @if($students->isEmpty())
                    <div class="card-body text-center py-5 text-muted">No enrolled students are assigned to this class.</div>
                @else
                    <div class="table-responsive">
                        <table class="table portal-table align-middle mb-0">
                            <thead><tr><th class="ps-4">Student</th><th>Student ID</th><th class="pe-4" style="width: 220px">Attendance</th></tr></thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php($currentStatus = $attendanceByStudent->get($student->id)?->status)
                                    <tr>
                                        <td class="ps-4 fw-semibold">{{ $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name) }}</td>
                                        <td>{{ $student->student_id }}</td>
                                        <td class="pe-4">
                                            <select class="form-select" name="attendance[{{ $student->id }}]" aria-label="Attendance for {{ $student->user?->name ?? $student->student_id }}" required @disabled(!$canMarkAttendance)>
                                                <option value="" @selected(!$currentStatus)>Choose status</option>
                                                @foreach(['present' => 'Present', 'absent' => 'Absent', 'late' => 'Late', 'excused' => 'Excused'] as $status => $label)
                                                    <option value="{{ $status }}" @selected(old('attendance.' . $student->id, $currentStatus) === $status)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </form>
    @endif
@endif
@endsection
