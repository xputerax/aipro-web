@extends('backend-layout')

@section('title', 'Deselect Customer')
@section('breadcrumbs', Breadcrumbs::render('customer-deselect'))

@section('content')
@yield('breadcrumbs')

@if(isset($customer))
<form action="{{ route('customers.deselect') }}" method="get">
    <h4>Deselect customer {{ $customer->full_name }}</h4>
    <input type="submit" value="Confirm Deselect" class="btn btn-primary">
</form>
@else
<h4>
    No customer selected!
</h4>
@endif
@endsection