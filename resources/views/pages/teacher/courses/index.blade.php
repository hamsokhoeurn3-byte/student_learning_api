@extends('layouts.teacher')
@section('title', 'Courses · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Courses', 'description' => 'View course details for classes assigned to you.', 'action' => 'Courses'])
@endsection
