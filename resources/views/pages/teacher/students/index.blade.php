@extends('layouts.teacher')
@section('title', 'Students · Teacher · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Students</div>
        <h1 class="h2 fw-bold mb-1">Students</h1>
        <p class="text-muted mb-0">Find students enrolled in your assigned classes.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    @foreach($managementStats as [$label, $value, $icon])
        <div class="col-md-4">
            <div class="card portal-card border-0 h-100">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div><div class="small text-muted">{{ $label }}</div><div class="h3 fw-bold mb-0 mt-1">{{ $value }}</div></div>
                    <span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card portal-card border-0">
    <div class="card-body p-4 pb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h2 class="h5 fw-bold mb-0">Assigned student roster</h2>
        <form class="d-flex gap-2" method="GET" action="{{ route('teacher.students') }}" role="search">
            <label class="visually-hidden" for="studentSearch">Search students</label>
            <input class="form-control" id="studentSearch" name="search" value="{{ $search }}" placeholder="Search name, student ID, or class" maxlength="100">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i>Find</button>
            @if($search !== '')<a class="btn btn-outline-secondary" href="{{ route('teacher.students') }}" aria-label="Clear search" title="Clear search"><i class="bi bi-x-lg"></i></a>@endif
        </form>
    </div>
    <div class="table-responsive">
        <table class="table portal-table align-middle mb-0">
            <thead><tr><th class="ps-4">Student</th><th>Student ID</th><th>Assigned courses</th><th>Status</th><th class="text-end pe-4">Actions</th></tr></thead>
            <tbody>
                @forelse($managementRows as $row)
                    <tr>
                        <td class="ps-4 fw-semibold">{{ $row[0] }}</td>
                        <td>{{ $row[1] }}</td>
                        <td>{{ $row[2] }}</td>
                        <td><span class="badge portal-badge rounded-pill">{{ $row[3] }}</span></td>
                        <td class="text-end pe-4"><a class="btn btn-sm btn-outline-primary" href="{{ route('teacher.students.show', $row[4]) }}" aria-label="View {{ $row[0] }}" title="View student"><i class="bi bi-eye"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">{{ $search !== '' ? 'No assigned students match your search.' : 'No students are enrolled in your assigned classes yet.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 px-4 small text-muted border-top">Showing {{ $managementRows->firstItem() ?? 0 }}–{{ $managementRows->lastItem() ?? 0 }} of {{ number_format($managementCount) }} students</div>
    @if($managementRows->hasPages())<div class="px-4 pb-3">{{ $managementRows->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
