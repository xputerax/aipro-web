@extends('backend-layout')

@if(isset($customer))
    @section('title', 'Edit customer '.$customer->full_name)
    @section('breadcrumbs', Breadcrumbs::render('customer-edit', $customer))
@else
    @section('title', 'Add New Customer')
    @section('breadcrumbs', Breadcrumbs::render('customer-create'))
@endif

@section('content')
@yield('breadcrumbs')

@if(isset($customer))

<form action="{{ route('customers.update', compact('customer')) }}" class="form-horizontal form-label-left" method="post">
@method('PUT')

@else

<form action="{{ route('customers.store') }}" class="form-horizontal form-label-left" method="post">

@endif

    @csrf

    <!-- start name section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">
            Full Name<span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="full_name" value="@if(isset($customer)){{ $customer->full_name }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end name section -->

    <!-- start phone section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">
            Phone <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="phone" value="@if(isset($customer)){{ $customer->phone }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end phone section -->

    <!-- start ic section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ic_number">
            IC/Passport no.<span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="ic_number" value="@if(isset($customer)){{ $customer->ic_number }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end ic section -->

    <!-- start sex section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sex">
            Sex <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="sex" id="sex" class="form-control col-md-7 col-xs-12">
                <option value="male"
                    @if(isset($customer) && $customer->sex === 'male'){{ 'selected' }}@endif
                >Male</option>
                <option value="female"
                    @if(isset($customer) && $customer->sex === 'female'){{ 'selected' }}@endif
                >Female</option>
                <option value="others"
                    @if(isset($customer) && $customer->sex === 'others'){{ 'selected' }}@endif
                >Others</option>
            </select>
        </div>
    </div>
    <!-- end sex section -->

    <!-- start source section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="source">
            Source
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="source" value="@if(isset($customer)){{ $customer->source }}@endif" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end source section -->

    <!-- start submit section -->
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
            @if(isset($customer))
            <input type="submit" value="Save Customer" class="btn btn-primary">
            @else
            <input type="submit" value="Add Customer" class="btn btn-primary">
            @endif
        </div>
    </div>
    <!-- end submit section -->

</form>

@if($errors->any())
    @foreach($errors->all() as $error)
    {{ $error }} <br>
    @endforeach
@endif

@if(session('message'))
{{ session('message') }} <br>
@endif
@endsection