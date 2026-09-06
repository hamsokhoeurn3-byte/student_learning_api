@extends('layouts.teacher')
@section('title', 'Courses · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Courses', 'description' => 'Manage the courses and sections assigned to you.', 'action' => 'Manage Courses'])
@endsection
