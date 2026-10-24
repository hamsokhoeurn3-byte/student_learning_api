@extends('layouts.payroll')
@section('title', 'Deductions · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Deductions', 'description' => 'Taxes, social security, and other deduction lines per employee.', 'action' => 'Add Deduction'])
@endsection
