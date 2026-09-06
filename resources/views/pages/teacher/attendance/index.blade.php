@extends('layouts.teacher')
@section('title', 'Attendance · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Attendance', 'description' => 'Record and review attendance for your classes.', 'action' => 'Take Attendance'])
@endsection
