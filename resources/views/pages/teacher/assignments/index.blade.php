@extends('layouts.teacher')
@section('title', 'Assignments · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Assignments', 'description' => 'Create assignments, review submissions, and grade students.', 'action' => 'Create Assignment'])
@endsection
