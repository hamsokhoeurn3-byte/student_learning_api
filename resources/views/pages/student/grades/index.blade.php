@extends('layouts.student')

@section('title', 'Grades · SLAS')

@section('content')
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Grades', 'subtitle' => 'A clear view of your academic results this semester.'])
    <div class="row g-3 mb-4">
        @foreach ([['Current GPA', '3.75', 'mortarboard'], ['Average score', '86%', 'graph-up-arrow'], ['Credits earned', '18 / 21', 'award'], ['Rank', 'Top 15%', 'trophy']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>
    <div class="row g-4">
        <div class="col-xl-8"><div class="student-card overflow-hidden"><div class="card-header d-flex justify-content-between align-items-center"><div><h5 class="fw-bold mb-1">Course grades</h5><small class="text-muted">Spring semester 2026</small></div><button class="btn btn-outline-primary btn-sm">Download report</button></div><div class="table-responsive"><table class="table student-table align-middle mb-0"><thead><tr><th class="ps-4">Course</th><th>Credits</th><th>Assignments</th><th>Quiz average</th><th>Final grade</th><th class="pe-4">Status</th></tr></thead><tbody>@foreach ([['Data Structures', '3', '88%', '90%', 'A-'], ['Database Systems', '3', '84%', '80%', 'B+'], ['Web Development', '3', '92%', '88%', 'A'], ['Algorithms', '3', '78%', '82%', 'B+']] as $grade)<tr><td class="ps-4"><strong>{{ $grade[0] }}</strong><small class="d-block text-muted">{{ $loop->iteration === 1 ? 'CS101' : 'Core module' }}</small></td><td>{{ $grade[1] }}</td><td>{{ $grade[2] }}</td><td>{{ $grade[3] }}</td><td><span class="h6 fw-bold text-primary">{{ $grade[4] }}</span></td><td class="pe-4"><span class="student-status bg-success-subtle text-success">Published</span></td></tr>@endforeach</tbody></table></div></div></div>
        <div class="col-xl-4"><div class="student-card mb-4"><div class="card-body"><h5 class="fw-bold mb-3">Grade distribution</h5>@foreach ([['A range', '45%', 45], ['B range', '38%', 38], ['C range', '14%', 14], ['Other', '3%', 3]] as [$label,$score,$progress])<div class="student-metric"><span class="small">{{ $label }}</span><div class="d-flex align-items-center gap-2" style="width:62%"><div class="student-progress flex-grow-1"><span style="width:{{ $progress }}%"></span></div><strong class="small">{{ $score }}</strong></div></div>@endforeach</div></div><div class="student-card"><div class="card-body"><h5 class="fw-bold mb-2">Academic insight</h5><p class="text-muted small mb-0"><i class="bi bi-stars text-primary me-2"></i>Your GPA improved by <strong>0.25</strong> this semester. Keep your assignment score above 85%.</p></div></div></div>
    </div>
</div>
@endsection
