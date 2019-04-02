@extends('backend-layout')

@section('title', 'Order List')
@section('breadcrumbs', Breadcrumbs::render('order-'.$status))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
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
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {{ $orders->links() }}
    </div>
</div>
@endsection