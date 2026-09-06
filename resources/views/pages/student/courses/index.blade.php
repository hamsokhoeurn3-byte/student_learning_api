@extends('layouts.student')

@section('title', 'Courses · SLAS')

@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'My Courses', 'subtitle' => 'Everything you need for your enrolled courses in one place.', 'action' => '<button class="btn btn-outline-primary rounded-3"><i class="bi bi-calendar3 me-2"></i>Spring 2026</button>'])
    <div class="row g-3 mb-4">
        @foreach ([['Enrolled courses', '5', 'book'], ['Credits', '15', 'layers'], ['Average grade', 'B+', 'award'], ['Attendance', '92%', 'calendar-check']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3"><h5 class="fw-bold mb-0">Current courses</h5><div class="d-flex gap-2"><input class="form-control form-control-sm" placeholder="Search courses"><button class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel"></i> Filter</button></div></div>
    <div class="row g-4 mb-4">
        @foreach ([['Data Structures', 'CS101', 'Dr. Emily Johnson', '78%', '#6d28d9, #4338ca'], ['Database Systems', 'CS102', 'Dr. David Kim', '65%', '#0f766e, #0ea5e9'], ['Web Development', 'WD201', 'Ms. Sarah Lee', '82%', '#c2410c, #f59e0b']] as [$course,$code,$teacher,$progress,$gradient])
        <div class="col-md-6 col-xl-4"><div class="student-course-card" style="background:linear-gradient(135deg,{{ $gradient }})"><span class="course-code">{{ $code }}</span><h4 class="fw-bold mt-3 mb-1">{{ $course }}</h4><p class="small mb-4">{{ $teacher }}</p><div class="d-flex justify-content-between align-items-center small mb-2"><span>Course progress</span><strong>{{ $progress }}</strong></div><div class="progress" style="height:6px;background:rgba(255,255,255,.25)"><div class="progress-bar bg-white" style="width:{{ $progress }}%"></div></div><button class="btn btn-sm btn-light text-primary fw-semibold mt-3">Open course <i class="bi bi-arrow-right ms-1"></i></button></div></div>
        @endforeach
    </div>
    <div class="row g-4"><div class="col-xl-8"><div class="student-card overflow-hidden"><div class="card-header"><h5 class="fw-bold mb-1">Upcoming coursework</h5><small class="text-muted">Prioritize what is due next.</small></div><div class="table-responsive"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Task</th><th>Course</th><th>Due date</th><th>Status</th><th class="pe-4"></th></tr></thead><tbody>@foreach ([['Linked List Program', 'CS101', 'Sep 08, 11:59 PM', 'In progress'], ['Database Design Project', 'CS102', 'Sep 10, 11:59 PM', 'Not started'], ['Responsive Portfolio', 'WD201', 'Sep 15, 11:59 PM', 'In progress']] as $task)<tr><td class="ps-4"><strong>{{ $task[0] }}</strong></td><td><span class="badge portal-badge">{{ $task[1] }}</span></td><td>{{ $task[2] }}</td><td><span class="student-status {{ $task[3] === 'Not started' ? 'bg-warning-subtle text-warning' : 'portal-badge' }}">{{ $task[3] }}</span></td><td class="pe-4 text-end"><i class="bi bi-chevron-right text-primary"></i></td></tr>@endforeach</tbody></table></div></div></div><div class="col-xl-4"><div class="student-card"><div class="card-body"><h5 class="fw-bold mb-3">Course performance</h5>@foreach ([['Average GPA', '3.70 / 4.00'], ['Attendance rate', '92%'], ['Assignments', '89%'], ['Quiz average', '85%']] as [$label,$value])<div class="student-metric"><span class="small">{{ $label }}</span><strong>{{ $value }}</strong></div>@endforeach</div></div></div></div>
</div>
@endsection
