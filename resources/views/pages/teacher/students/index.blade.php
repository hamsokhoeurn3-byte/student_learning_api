@extends('layouts.teacher')
@section('title', 'Students · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Students', 'description' => 'Monitor your class roster and student learning progress.', 'action' => 'Add Student'])
@endsection
