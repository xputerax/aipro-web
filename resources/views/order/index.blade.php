@extends('backend-layout')

@section('title', 'Order List')

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
<table class="table table-bordered table-striped" id="orders_table">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    @if($orders->count())
        @foreach($orders as $order)
        <tr>
            <td>
                <a href="{{ route('orders.show', compact('order')) }}">
                    {{ $order->customer->full_name }}
                </a>
            </td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                <a href="{{ route('orders.edit', compact('order')) }}" class="btn btn-primary">Edit</a>
            </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4">No data</td>
        </tr>
    @endif
    </tbody>
</table>

{{ $orders->links() }}
@endsection