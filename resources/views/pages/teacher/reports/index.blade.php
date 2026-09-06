@extends('layouts.teacher')
@section('title', 'Reports · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Reports', 'description' => 'Use class insights to support every learner.', 'action' => 'Export Report'])
@endsection
