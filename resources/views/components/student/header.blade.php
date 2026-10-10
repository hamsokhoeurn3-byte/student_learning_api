<header class="student-global-header">
    <button type="button" class="portal-sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation menu" title="Show/hide navigation">
        <i class="bi bi-list"></i>
    </button>
    <div class="d-flex align-items-center gap-3">
        <x-language-switcher />
        <time class="d-none d-md-inline small text-muted text-nowrap" data-live-clock datetime="{{ now()->toIso8601String() }}" aria-label="Local date and time"><i class="bi bi-calendar3 me-1"></i>{{ now()->format('M d, Y h:i:s A') }}</time>
        @php $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count(); @endphp
        <a href="{{ route('student.notifications') }}" class="student-header-icon position-relative" aria-label="Notifications" title="Notifications">
            <i class="bi bi-bell"></i>
            @if($unreadCount > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>@endif
        </a>
        <details class="student-profile-menu">
            <summary class="student-header-user text-decoration-none">
                <span class="d-none d-sm-block text-end"><strong>{{ Auth::user()->name ?? __('Student') }}</strong><small>{{ __('Student') }}</small></span>
                <b>@if(Auth::user()->profile_picture_url)<img src="{{ Auth::user()->profile_picture_url }}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">@else{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}@endif</b>
            </summary>
            <div class="student-account-menu">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="student-account-avatar">@if(Auth::user()->profile_picture_url)<img src="{{ Auth::user()->profile_picture_url }}" alt="{{ Auth::user()->name }}">@else{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}@endif</span>
                    <span class="min-w-0"><strong class="d-block text-truncate">{{ Auth::user()->name }}</strong><small class="text-muted d-block text-truncate">{{ Auth::user()->email }}</small></span>
                </div>
                <div class="small text-muted border-top pt-3 mb-3">{{ __('Student') }}{{ Auth::user()->student?->student_id ? ' ID: ' . Auth::user()->student->student_id : '' }}</div>
                <a class="btn btn-outline-primary w-100 mb-2" href="{{ route('student.settings') }}"><i class="bi bi-person-gear me-2"></i>{{ __('My Account') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100" type="submit"><i class="bi bi-box-arrow-right me-2"></i>{{ __('Sign out') }}</button>
                </form>
            </div>
        </details>
    </div>
</header>
