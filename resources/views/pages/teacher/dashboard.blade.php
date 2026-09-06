@extends('layouts.teacher')
@section('title', 'Teacher Dashboard · SLAS')
@section('content')
    @include('components.portal.dashboard-page', ['audience' => 'Teacher'])
@endsection
