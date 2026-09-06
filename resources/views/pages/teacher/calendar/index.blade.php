@extends('layouts.teacher')
@section('title', 'Calendar · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Calendar', 'description' => 'Plan lessons, assignment deadlines, and class events.', 'action' => 'Add Event'])
@endsection
