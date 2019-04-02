@extends('backend-layout')

@section('title', 'Viewing Customer Cart')

@section('content')
@if(session('customer'))
<div class="row">
    <div class="col-md-12">
        <h4>
            Current customer is <a href="{{ route('customers.show', ['customer'=>session('customer')]) }}">
                {{ session('customer')->full_name }}
            </a>
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price/Qty</th>
                    <th>Total Price</th>
                </tr>
            </thead>

            <tbody>
            @if(session('customer')->carts)
                @foreach(session('customer')->carts as $cart)
                <tr>
                    <td>
                        <a href="{{ route('products.show', ['product' => $cart->product]) }}">
                        {{ $cart->product->name }}
                        </a>
                    </td>
                    <td>{{ $cart->quantity }}</td>
                    <td>{{ $cart->price }}</td>
                    <td>{{ $cart->total_price }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No Item</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        No customer selected
    </div>
</div>
@endif
@endsection