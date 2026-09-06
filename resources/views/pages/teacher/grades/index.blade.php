@extends('layouts.teacher')
@section('title', 'Grades · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Grades', 'description' => 'Enter, update, and publish grades for your classes.', 'action' => 'Enter Grades'])
@endsection
