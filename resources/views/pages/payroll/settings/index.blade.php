@extends('layouts.payroll')
@section('title', 'Payroll Settings · SLAS')
@section('content')
    @include('components.portal.settings-page', ['audience' => 'payroll'])
@endsection
