@extends('layouts.admin')
@section('title', 'Reports · Admin · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Reports', 'description' => 'Generate academic and system-wide reports.', 'action' => 'Export Report'])
@endsection
