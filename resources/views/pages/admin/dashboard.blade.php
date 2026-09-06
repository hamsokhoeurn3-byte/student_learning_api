@extends('layouts.admin')
@section('title', 'Admin Dashboard · SLAS')
@section('content')
    @include('components.portal.dashboard-page', ['audience' => 'Administrator'])
@endsection
