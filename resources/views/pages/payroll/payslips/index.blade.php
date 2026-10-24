@extends('layouts.payroll')
@section('title', 'Payslips · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Payslips', 'description' => 'Generated payslips from approved payroll runs.', 'action' => 'View Runs'])
@endsection
