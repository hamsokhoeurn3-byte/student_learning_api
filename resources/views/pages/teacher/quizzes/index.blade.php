@extends('layouts.teacher')
@section('title', 'Quizzes · Teacher · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Quizzes', 'description' => 'Create quizzes and review students\' results.', 'action' => 'Create Quiz'])
@endsection
