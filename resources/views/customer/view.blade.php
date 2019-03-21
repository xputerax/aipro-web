@extends('backend-layout')

@section('title')
Viewing customer: {{ $customer->full_name }}
@endsection

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">
        <div class="form-horizontal form-label-left">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">Name</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->full_name }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->phone }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ic_number">IC/Password</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->ic_number }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sex">Sex</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->sex }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch">Branch</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->branch->name }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">User</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->user->full_name }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="source">Source</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $customer->source }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                    <form action="{{ route('customers.destroy', compact('customer')) }}" class="form-inline" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('customers.edit', compact('customer')) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('carts.viewByCustomer', compact('customer')) }}" class="btn btn-primary">View Cart</a>
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection