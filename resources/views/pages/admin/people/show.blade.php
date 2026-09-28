@extends('layouts.admin')
@section('title', $entity . ' Details · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ $backUrl }}" class="text-decoration-none">{{ $entity === 'Student' ? 'Students' : 'Teachers' }}</a> <span class="text-muted mx-1">/</span> Details</div>
        <h1 class="h2 fw-bold mb-1">{{ $details['Name'] }}</h1>
        <p class="text-muted mb-0">{{ $entity }} record details</p>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary" href="{{ $backUrl }}">Back to list</a>
        <a class="btn btn-primary" href="{{ $editUrl }}"><i class="bi bi-pencil me-2"></i>Edit {{ strtolower($entity) }}</a>
    </div>
</div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<div class="card portal-card border-0">
    <div class="card-body p-4">
        <dl class="row mb-0">
            @foreach($details as $label => $value)
                <dt class="col-sm-4 col-lg-3 py-2 text-muted">{{ $label }}</dt>
                <dd class="col-sm-8 col-lg-9 py-2 mb-0">{{ filled($value) ? $value : 'Not set' }}</dd>
            @endforeach
        </dl>
    </div>
</div>
<form class="mt-3" method="POST" action="{{ $deleteUrl }}" onsubmit="return confirm('Delete this {{ strtolower($entity) }} and linked login account?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-2"></i>Delete {{ strtolower($entity) }}</button>
</form>
@endsection
