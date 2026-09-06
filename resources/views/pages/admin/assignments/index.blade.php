@extends('layouts.admin')
@section('title', 'Assignments · Admin · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Assignments', 'description' => 'Review assignments across all courses and teachers.', 'action' => 'Manage Assignments'])
@endsection
