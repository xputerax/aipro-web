@extends('backend-layout')

@php
    $parse_body_tag = false
@endphp

@section('title')
Editing Order #{{ $order->id }}
@endsection

@section('content-1')
<div class="x_panel">
    <form action="{{ route('orders.update', compact('order')) }}" method="post" class="form-horizontal form-label-left">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch">
                Branch
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->branch->name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer">
                Customer
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->customer->full_name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="checkout">
                Checkout By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->checkout_user->full_name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resolved">
                Resolved By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->resolve_user->full_name ?? '-' }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="delivered">
                Delivered By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->delivery_user->full_name ?? '-' }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="status" class="form-control">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="resolved" {{ $order->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="delivered"{{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deposit">
                Deposit <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="deposit" value="{{ $order->deposit }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                <input type="submit" value="Save" class="btn btn-primary">
                <a href="{{ route('orders.show', compact('order')) }}" class="btn btn-primary">View</a>
            </div>
        </div>
    </form>
</div>

<h3>Add Payment</h3>

<div class="x_panel">
    <div class="x_content">
        <form action="{{ route('payments.create', compact('order')) }}" method="post" class="form-horizontal form-label-left">
            @csrf

            <div class="form-group">
                <label for="amount" class="control-label">Amount</label>
                <input type="text" name="amount" class="form-control">
            </div>

            <div class="form-group">
                <label for="deposit" class="control-label">Deposit?</label>
                <select name="deposit" class="form-control">
                    <option value="0">no</option>
                    <option value="1">yes</option>
                </select>
            </div>

            <input type="submit" value="Add Payment" class="btn btn-primary">
        </form>
    </div>
</div>
@endsection