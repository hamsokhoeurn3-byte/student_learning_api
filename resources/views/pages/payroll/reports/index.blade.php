@extends('layouts.payroll')
@section('title', 'Reports · Payroll · SLAS')
@section('content')
    @include('components.portal.management-page', ['entity' => 'Reports', 'description' => 'Payroll totals grouped by staff type.', 'action' => 'Export'])
@endsection
