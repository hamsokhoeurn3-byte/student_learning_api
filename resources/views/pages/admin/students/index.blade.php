@extends('layouts.admin')
@section('title', 'Students · Admin · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Students', 'description' => 'Manage student accounts, enrollment, and progress.', 'action' => 'Add Student'])
@endsection
