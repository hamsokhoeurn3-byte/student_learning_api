<div class="student-page-heading">
    <div>
        <div class="student-breadcrumb">Student Portal <span>/</span> {{ $title }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
    </div>
    @isset($action)
        <div>{!! $action !!}</div>
    @endisset
</div>
