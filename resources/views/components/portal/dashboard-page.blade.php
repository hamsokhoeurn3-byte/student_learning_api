@php
    $isTeacher = $audience === 'Teacher';
    $stats = $dashboardStats ?? ($isTeacher
        ? [['Students', 'N/A', 'people'], ['Pending grading', 'N/A', 'clipboard-check'], ['Active assignments', 'N/A', 'journal-text'], ['Average attendance', 'N/A', 'calendar-check']]
        : [['Total students', 'N/A', 'mortarboard'], ['Teachers', 'N/A', 'person-workspace'], ['Active courses', 'N/A', 'book'], ['Completion rate', 'N/A', 'graph-up-arrow']]);
    $weekStart = now()->startOfWeek();
    $activity = collect(range(0, 6))->map(function ($offset) use ($weekStart, $activityByDay) {
        $day = $weekStart->copy()->addDays($offset);
        return ['label' => $day->format('D'), 'count' => (int) ($activityByDay[$day->toDateString()] ?? 0)];
    });
    $maxActivity = max($activity->pluck('count')->all() ?: [0]);
@endphp
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div><div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Overview</div><h1 class="h2 fw-bold mb-1">Good morning, {{ $audience }}</h1><p class="text-muted mb-0">Live records from the database.</p></div>
</div>
<div class="row g-3 mb-4">
    @foreach($stats as [$label, $value, $icon])
    <div class="col-sm-6 col-xl-3"><div class="card portal-card border-0 h-100"><div class="card-body p-3 d-flex justify-content-between align-items-start"><div><div class="small text-muted mb-2">{{ $label }}</div><div class="h3 fw-bold mb-1">{{ $value }}</div><small class="{{ $value === 'N/A' ? 'text-muted' : 'text-success' }}">{{ $value === 'N/A' ? 'No data available' : 'Live database' }}</small></div><div class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></div></div></div></div>
    @endforeach
</div>
<div class="row g-4">
    <div class="col-xl-7"><div class="card portal-card border-0 h-100"><div class="card-body p-4"><div class="d-flex justify-content-between mb-4"><div><h5 class="fw-bold mb-1">New account registrations</h5><small class="text-muted">User accounts created this week</small></div><span class="badge portal-badge rounded-pill">This week</span></div>@if($activity->sum('count') > 0)<div class="d-flex justify-content-between gap-2" style="height:190px">@foreach($activity as $day)<div class="d-flex flex-column align-items-center flex-fill"><div class="d-flex align-items-end justify-content-center w-100" style="height:150px"><div class="rounded-top bg-primary" style="height: {{ $maxActivity ? max(4, round($day['count'] / $maxActivity * 140)) : 0 }}px; width:20px" title="{{ $day['count'] }} registrations"></div></div><small class="text-muted d-block mt-2">{{ $day['label'] }}</small><small class="text-muted">{{ $day['count'] }}</small></div>@endforeach</div>@else<div class="d-flex align-items-center justify-content-center text-muted" style="height:190px">No accounts were created this week.</div>@endif</div></div></div>
    <div class="col-xl-5"><div class="card portal-card border-0 h-100"><div class="card-body p-4"><h5 class="fw-bold mb-1">Priority tasks</h5><p class="text-muted small mb-3">Task records</p><div class="d-flex align-items-center justify-content-center text-muted text-center" style="min-height:170px">No task data is available.</div></div></div></div>
</div>
