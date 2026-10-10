@php
    $typeStyles = [
        'assignment' => ['bg-warning-subtle text-warning', 'journal-text'],
        'quiz' => ['bg-info-subtle text-info', 'question-circle-fill'],
        'grade' => ['bg-success-subtle text-success', 'check-circle-fill'],
        'course' => ['bg-primary-subtle text-primary', 'book-fill'],
        'attendance' => ['bg-danger-subtle text-danger', 'exclamation-circle-fill'],
        'system' => ['bg-secondary-subtle text-secondary', 'megaphone-fill'],
    ];
    $readAllRoute = $readAllRoute ?? null;
@endphp

<div class="mb-4">
    <div class="small text-primary fw-semibold mb-1">Dashboard <span class="text-muted mx-1">/</span> Notifications</div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h1 class="h2 fw-bold mb-1">Notifications</h1>
            <p class="text-muted mb-0">Stay updated with your latest activities and alerts.</p>
        </div>
        @if($readAllRoute)
            <form method="POST" action="{{ route($readAllRoute) }}">
                @csrf
                <button class="btn btn-outline-primary rounded-3"><i class="bi bi-check2-all me-2"></i>Mark all as read</button>
            </form>
        @endif
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="row g-3 mb-4">
    @foreach ([['Total notifications', $summary['total'], 'bell-fill'], ['Unread', $summary['unread'], 'envelope-fill'], ['Academic', $summary['academic'], 'mortarboard-fill'], ['System', $summary['system'], 'info-circle-fill']] as [$label, $value, $icon])
        <div class="col-6 col-xl-3">
            <div class="card portal-card border-0">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small text-muted">{{ $label }}</div>
                        <div class="h4 fw-bold mb-0 mt-1">{{ $value }}</div>
                    </div>
                    <span class="portal-stat-icon"><i class="bi bi-{{ $icon }}"></i></span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card portal-card border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1">Recent notifications</h5>
            <small class="text-muted">Your latest updates and activities.</small>
        </div>
        @if($summary['unread'] > 0)<span class="badge text-bg-primary rounded-pill">{{ $summary['unread'] }} unread</span>@endif
    </div>
    <div class="card-body">
        @forelse($notifications as $notification)
            @php
                [$badge, $icon] = $typeStyles[$notification->type] ?? ['bg-secondary-subtle text-secondary', 'bell-fill'];
            @endphp
            <div class="border rounded-4 p-3 mb-3 {{ $notification->is_read ? '' : 'bg-light' }}">
                <div class="d-flex">
                    <div class="rounded-3 {{ $badge }} d-flex align-items-center justify-content-center" style="width:48px;height:48px;min-width:48px;">
                        <i class="bi bi-{{ $icon }} fs-5"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold mb-1">{{ $notification->title }}</h6>
                            <small class="text-muted">{{ $notification->created_at?->diffForHumans() }}</small>
                        </div>
                        <p class="text-muted mb-2">{{ $notification->message }}</p>
                        <span class="badge {{ $badge }} rounded-pill">{{ ucfirst($notification->type ?? 'general') }}</span>
                    </div>
                    @unless($notification->is_read)<span class="bg-primary rounded-circle ms-2 mt-2" style="width:9px;height:9px;min-width:9px;"></span>@endunless
                </div>
            </div>
        @empty
            <p class="text-center text-muted py-5 mb-0">You have no notifications yet.</p>
        @endforelse

        <div class="d-flex justify-content-center mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
</div>