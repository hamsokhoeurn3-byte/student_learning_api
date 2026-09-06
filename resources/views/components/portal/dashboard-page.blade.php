@php
    $isTeacher = $audience === 'Teacher';
    $stats = $isTeacher
        ? [['Students', '124', 'people'], ['Pending grading', '18', 'clipboard-check'], ['Active assignments', '9', 'journal-text'], ['Average attendance', '91%', 'calendar-check']]
        : [['Total students', '1,248', 'mortarboard'], ['Teachers', '86', 'person-workspace'], ['Active courses', '42', 'book'], ['Completion rate', '88%', 'graph-up-arrow']];
@endphp
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div><div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Overview</div><h1 class="h2 fw-bold mb-1">Good morning, {{ $audience }}</h1><p class="text-muted mb-0">Here is what needs your attention today.</p></div>
    <button class="btn btn-primary rounded-3 px-3"><i class="bi bi-download me-2"></i>Export report</button>
</div>
<div class="row g-3 mb-4">
    @foreach($stats as [$label, $value, $icon])
    <div class="col-sm-6 col-xl-3"><div class="card portal-card border-0 h-100"><div class="card-body p-3 d-flex justify-content-between align-items-start"><div><div class="small text-muted mb-2">{{ $label }}</div><div class="h3 fw-bold mb-1">{{ $value }}</div><small class="text-success"><i class="bi bi-arrow-up-right"></i> Updated today</small></div><div class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></div></div></div></div>
    @endforeach
</div>
<div class="row g-4">
    <div class="col-xl-7"><div class="card portal-card border-0 h-100"><div class="card-body p-4"><div class="d-flex justify-content-between mb-4"><div><h5 class="fw-bold mb-1">Learning activity</h5><small class="text-muted">Semester progress and engagement</small></div><span class="badge portal-badge rounded-pill">This semester</span></div><div class="d-flex align-items-end justify-content-between" style="height:190px">@foreach([42,57,49,74,68,86,93] as $i => $height)<div class="text-center flex-fill"><div class="mx-auto rounded-top" style="height: {{ $height }}%; max-height:150px; width:20px; background:linear-gradient(#8b5cf6,#5b21b6)"></div><small class="text-muted d-block mt-2">{{ ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$i] }}</small></div>@endforeach</div></div></div></div>
    <div class="col-xl-5"><div class="card portal-card border-0 h-100"><div class="card-body p-4"><h5 class="fw-bold mb-1">Priority tasks</h5><p class="text-muted small mb-3">Keep the learning flow moving.</p>@foreach($isTeacher ? [['Grade database projects','12 submissions','warning'],['Publish quiz feedback','Due today','primary'],['Review attendance','CS101 · 3 absences','danger']] : [['Approve new teacher account','2 pending reviews','warning'],['Review course updates','5 changes submitted','primary'],['System backup completed','Today · 02:00 AM','success']] as [$task,$detail,$color])<div class="d-flex align-items-center gap-3 py-3 border-bottom"><span class="rounded-circle bg-{{ $color }}-subtle text-{{ $color }} d-grid" style="width:34px;height:34px;place-items:center"><i class="bi bi-check2"></i></span><div class="flex-grow-1"><div class="fw-semibold small">{{ $task }}</div><small class="text-muted">{{ $detail }}</small></div><i class="bi bi-chevron-right text-muted"></i></div>@endforeach</div></div></div>
</div>
