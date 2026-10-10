@extends('layouts.student')

@section('title', 'Notifications · SLAS')

@section('content')
@php
    $typeStyles = [
        'assignment' => ['bg-warning-subtle text-warning', 'journal-text'],
        'quiz' => ['bg-info-subtle text-info', 'question-circle-fill'],
        'grade' => ['bg-success-subtle text-success', 'check-circle-fill'],
        'course' => ['bg-primary-subtle text-primary', 'book-fill'],
        'attendance' => ['bg-danger-subtle text-danger', 'exclamation-circle-fill'],
        'system' => ['bg-secondary-subtle text-secondary', 'megaphone-fill'],
    ];
@endphp
<div class="student-page">
    @include('components.student.page-header', ['title' => 'Notifications', 'subtitle' => 'Stay updated with your academic activities.', 'action' => '<form method="POST" action="' . route('student.notifications.read-all') . '">' . csrf_field() . '<button class="btn btn-outline-primary rounded-3"><i class="bi bi-check2-all me-2"></i>Mark all as read</button></form>'])

    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

    <div class="row g-3 mb-4">
        @foreach ([['Total notifications', $summary['total'], 'bell-fill'], ['Unread', $summary['unread'], 'envelope-fill'], ['Academic', $summary['academic'], 'mortarboard-fill'], ['System', $summary['system'], 'info-circle-fill']] as [$label, $value, $icon])
            <div class="col-6 col-xl-3"><div class="student-card student-stat d-flex justify-content-between align-items-start"><div><div class="stat-label">{{ $label }}</div><div class="stat-value mt-1">{{ $value }}</div></div><span class="student-icon"><i class="bi bi-{{ $icon }}"></i></span></div></div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="student-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><h5 class="fw-bold mb-1">Recent notifications</h5><small class="text-muted">Your latest updates and activities.</small></div>
                    @if($summary['unread'] > 0)<span class="badge portal-badge">{{ $summary['unread'] }} unread</span>@endif
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                        @php
                            [$badge, $icon] = $typeStyles[$notification->type] ?? ['bg-secondary-subtle text-secondary', 'bell-fill'];
                        @endphp
                        <div class="notification-item p-3 rounded-4 mb-3 {{ $notification->is_read ? '' : 'unread' }}">
                            <div class="d-flex">
                                <div class="notification-icon {{ $badge }}"><i class="bi bi-{{ $icon }} fs-5"></i></div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold mb-1">{{ $notification->title }}</h6>
                                        <small class="text-muted">{{ $notification->created_at?->diffForHumans() }}</small>
                                    </div>
                                    <p class="text-muted mb-2">{{ $notification->message }}</p>
                                    <span class="badge {{ $badge }} rounded-pill">{{ ucfirst($notification->type ?? 'general') }}</span>
                                </div>
                                @unless($notification->is_read)<div class="notification-dot"></div>@endunless
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
        </div>

        <div class="col-lg-4">
            <div class="student-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Upcoming</h5>
                        <a href="{{ route('student.calendar') }}" class="small">View calendar</a>
                    </div>
                    @forelse($upcoming as $item)
                        @php $isQuiz = $item->assignment_type === 'true_false'; @endphp
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-3 {{ $isQuiz ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }} d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                <i class="bi bi-{{ $isQuiz ? 'question-circle' : 'journal-text' }}"></i>
                            </div>
                            <div class="ms-3">
                                <strong class="d-block">{{ $item->title }}</strong>
                                <small class="text-muted">{{ $isQuiz ? 'Quiz' : 'Assignment' }} · {{ $item->due_date?->format('M d') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No upcoming deadlines.</p>
                    @endforelse
                </div>
            </div>

            <div class="student-card">
                <div class="card-body text-center">
                    <span class="student-icon mx-auto mb-3"><i class="bi bi-bell-fill"></i></span>
                    <h5 class="fw-bold">Stay Updated!</h5>
                    <p class="text-muted small mb-0">Check your notifications regularly so you never miss an important academic update.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .notification-item { border: 1px solid #f0f0f5; transition: all 0.2s ease; background: #fff; }
    .notification-item:hover { background: #faf9ff; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(80, 60, 180, 0.06); }
    .notification-item.unread { background: #f8f7ff; border-color: #e8e2ff; }
    .notification-icon { width: 48px; height: 48px; min-width: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; }
    .notification-dot { width: 9px; height: 9px; background: #6935ff; border-radius: 50%; margin-top: 7px; margin-left: 10px; }
</style>
@endsection