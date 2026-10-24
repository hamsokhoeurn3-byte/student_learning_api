@extends('layouts.payroll')
@section('title', 'Salaries · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Salaries', 'description' => 'Base salary, allowances, and deductions per employee.', 'action' => 'Manage Allowances'])
@endsection
