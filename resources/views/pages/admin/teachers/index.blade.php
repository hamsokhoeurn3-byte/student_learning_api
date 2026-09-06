@extends('layouts.admin')
@section('title', 'Teachers · Admin · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Teachers', 'description' => 'Manage teaching staff and their course assignments.', 'action' => 'Add Teacher'])
@endsection
