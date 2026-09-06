@extends('layouts.admin')
@section('title', 'Courses · Admin · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Courses', 'description' => 'Maintain the course catalog, subjects, and schedules.', 'action' => 'Add Course'])
@endsection
