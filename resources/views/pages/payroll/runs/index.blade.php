@extends('layouts.payroll')
@section('title', 'Payroll Runs · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Payroll Runs', 'description' => 'Group salary periods into runs, approve, and mark as paid.', 'action' => 'New Payroll Run'])
@endsection
