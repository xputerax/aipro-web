@extends('backend-layout')

@php
    $parse_body_tag = false
@endphp

@section('title', 'Editing Order #'.$order->id)
@section('breadcrumbs', Breadcrumbs::render('order-edit', $order))

@section('content-1')
@yield('breadcrumbs')

<div class="x_panel">
    <form action="{{ route('orders.update', compact('order')) }}" method="post" class="form-horizontal form-label-left">
        @csrf
        @method('PUT')

        {{-- start branch section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch">
                Branch
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->branch->name }}</p>
            </div>
        </div>
        {{-- end branch section --}}

        {{-- start customer name section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer">
                Customer
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <p class="form-control-static">{{ $order->customer->full_name }}</p>
            </div>
        </div>
        {{-- end customer name section --}}

        {{-- start checkout user section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="checkout">
                Checkout By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                @if(isset($order->checkout_user_id))
                    @if(Auth::user()->can('change-checkout-user-id', $order))
                    <select name="checkout_user_id" id="checkout_user_id" class="form-control">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"{{ $user->id === $order->checkout_user_id ? 'selected' : ''}}>
                            {{ $user->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <p class="form-control-static">{{ $order->checkout_user->full_name }}</p>
                    @endif
                @else
                <select name="checkout_user_id" id="checkout_user_id" class="form-control">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        {{-- end checkout user section --}}

        {{-- start resolve user section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resolved">
                Resolved By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                @if(isset($order->resolve_user_id))
                    @if(Auth::user()->can('change-resolve-user-id', $order))
                    <select name="resolve_user_id" id="resolve_user_id" class="form-control">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"{{ $user->id === $order->resolve_user_id ? 'selected' : ''}}>
                            {{ $user->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <p class="form-control-static">{{ $order->resolve_user->full_name }}</p>
                    @endif
                @else
                <select name="resolve_user_id" id="resolve_user_id" class="form-control">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        {{-- end resolve user section --}}

        {{-- start deliver user section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="delivered">
                Delivered By
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                @if(isset($order->delivery_user_id))
                    @if(Auth::user()->can('change-delivery-user-id', $order))
                    <select name="delivery_user_id" id="delivery_user_id" class="form-control">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}"{{ $user->id === $order->delivery_user_id ? 'selected' : ''}}>
                            {{ $user->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <p class="form-control-static">{{ $order->delivery_user->full_name }}</p>
                    @endif
                @else
                <select name="delivery_user_id" id="delivery_user_id" class="form-control">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
                @endif
            </div>
        </div>
        {{-- end deliver user section --}}

        {{-- start status section --}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">
                Status <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="status" class="form-control">
                    <option value="pending"{{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="resolved"{{ $order->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="delivered"{{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
            </div>
        </div>
        {{-- end status section --}}

        {{-- start deposit section --}}
        {{-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deposit">
                Deposit <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="deposit" value="{{ $order->deposit }}">
            </div>
        </div> --}}
        {{-- end deposit section --}}

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                <input type="submit" value="Save" class="btn btn-primary">
                <a href="{{ route('orders.show', compact('order')) }}" class="btn btn-primary">View</a>
                <a href="{{ route('orders.generateReceipt', compact('order')) }}" class="btn btn-primary">Generate Receipt</a>
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

            <div class="form-group">
                <label for="date" class="control-label">Date</label>
                <input type="datetime" name="created_at" class="form-control" value="{{ \Illuminate\Support\Carbon::now() }}">
            </div>

            <input type="submit" value="Add Payment" class="btn btn-primary">
        </form>
    </div>
</div>

<h3>Payments</h3>

<table class="table table-bordered">
    <thead>
        <th>Amount (RM)</th>
        <th>Date</th>
        <th>Action</th>
    </thead>

    <tbody>
    @if($order->payments->count())
        @foreach($order->payments as $payment)
        <tr>
            <td>{{ $payment->amount }} {{ $payment->deposit == "1" ? "(deposit)" : "" }}</td>
            <td>{{ $payment->created_at }}</td>
            <td>
                <form action="{{ route('payments.destroy', compact('payment')) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2">No data</td>
        </tr>
    @endif
    </tbody>
</table>
@endsection

@section('scripts')
@parent

<script>
    $("#checkout_user_id").select2();
    $("#resolve_user_id").select2();
    $("#delivery_user_id").select2();
</script>
@endsection