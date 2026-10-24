@extends('layouts.payroll')
@section('title', 'Payroll Dashboard · SLAS')
@section('content')
    @include('components.portal.dashboard-page', ['audience' => 'Payroll Staff'])
@endsection
