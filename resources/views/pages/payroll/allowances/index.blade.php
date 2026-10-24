@extends('layouts.payroll')
@section('title', 'Allowances · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Allowances', 'description' => 'Recurring and one-off allowance lines per employee.', 'action' => 'Add Allowance'])
@endsection
