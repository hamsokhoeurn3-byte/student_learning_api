@extends('layouts.admin')
@section('title', 'Edit ' . $entity . ' · Admin · SLAS')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <div class="small text-primary fw-semibold mb-1"><a href="{{ $backUrl }}" class="text-decoration-none">{{ $entity === 'Student' ? 'Students' : 'Teachers' }}</a> <span class="text-muted mx-1">/</span> Edit</div>
        <h1 class="h2 fw-bold mb-1">Edit {{ $entity }}</h1>
        <p class="text-muted mb-0">Update profile and login account information.</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ $backUrl }}">Back to list</a>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="card portal-card border-0">
    <form method="POST" action="{{ $updateUrl }}">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($fields as $field)
                    <div class="col-md-6">
                        <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                        @if($field['type'] === 'select')
                            <select id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-select" @required($field['required'])>
                                @foreach($field['options'] as $option)
                                    <option value="{{ $option }}" @selected(old($field['name'], $field['value']) === $option)>{{ ucfirst($option) }}</option>
                                @endforeach
                            </select>
                        @elseif($field['type'] === 'textarea')
                            <textarea id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" @required($field['required'])>{{ old($field['name'], $field['value']) }}</textarea>
                        @else
                            <input id="{{ $field['name'] }}" name="{{ $field['name'] }}" type="{{ $field['type'] }}" value="{{ old($field['name'], $field['value']) }}" class="form-control" @required($field['required'])>
                        @endif
                    </div>
                @endforeach
                <div class="col-md-6">
                    <label for="password" class="form-label">New password <span class="text-muted">(leave blank to keep current)</span></label>
                    <input id="password" name="password" type="password" class="form-control" minlength="8" autocomplete="new-password">
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" minlength="8" autocomplete="new-password">
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-end gap-2">
            <a href="{{ $backUrl }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-2"></i>Save changes</button>
        </div>
    </form>
</div>
@endsection
