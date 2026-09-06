@extends('layouts.student')
@section('title', 'Settings · Student · SLAS')
@section('content')
    <div class="container-fluid px-4 py-4">@include('components.portal.settings-page', ['audience' => 'Student'])</div>
@endsection
