@extends('layouts.admin')
@section('title', 'System Settings · SLAS')
@section('content')
    @include('components.portal.settings-page', ['audience' => 'Administrator'])
@endsection
