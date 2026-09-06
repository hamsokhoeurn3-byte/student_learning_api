<header class="student-global-header">
    <div class="student-search"><i class="bi bi-search"></i><input aria-label="Search" placeholder="Search courses, assignments, quizzes..."></div>
    <div class="d-flex align-items-center gap-3">
        <span class="d-none d-md-inline small text-muted"><i class="bi bi-calendar3 me-1"></i>{{ now()->format('M d, Y') }}</span>
        <button class="student-header-icon" aria-label="Notifications"><i class="bi bi-bell"></i><span></span></button>
        <a href="{{ route('student.profile') }}" class="student-header-user text-decoration-none"><span class="d-none d-sm-block text-end"><strong>{{ Auth::user()->name ?? 'Student' }}</strong><small>Student</small></span><b>{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}</b></a>
    </div>
</header>
