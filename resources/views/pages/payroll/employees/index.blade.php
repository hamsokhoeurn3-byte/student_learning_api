@extends('layouts.payroll')
@section('title', 'Employees · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Employees', 'description' => 'Salary profiles for teachers, admins, and staff on the payroll.', 'action' => 'Add Salary Profile'])
@endsection
