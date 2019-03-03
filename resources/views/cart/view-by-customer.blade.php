@extends('backend-layout')

@php
    $parse_body_tag = false;
    $total_price = 0;
@endphp

@section('title')
Viewing Customer Cart: {{ $customer->full_name }}
@endsection

@section('content-1')
<div class="x_panel">
    <div class="x_content">

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
                    @if($customer->carts)
                        @foreach($customer->carts as $cart)

                        @php
                            $total_price += $cart->total_price;
                        @endphp

                        <tr data-cart-id="{{ $cart->id }}">
                            <td>
                                <a href="{{ route('products.show', ['product' => $cart->product]) }}">
                                {{ $cart->product->name }}
                                </a>
                            </td>
                            <td>
                                <a href="#" id="cart_{{ $cart->id }}_link" class="show">
                                    {{ $cart->quantity }}
                                </a>
                                <div id="cart_{{ $cart->id }}_form" class="hidden">
                                    <form action="{{ route('carts.modify', compact('cart')) }}" method="post" class="form-inline">
                                        @csrf
                                        @method('PUT')

                                        <input type="text" name="newQuantity" class="form-control" value="{{ $cart->quantity }}" style="width: 20%">
                                        <input type="submit" value="Save" class="btn btn-primary">
                                        <a href="#" id="cart_{{ $cart->id }}_cancel" class="btn btn-danger">Cancel</a>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $cart->price }}</td>
                            <td>{{ $cart->total_price }}</td>
                        </tr>
                        @endforeach

                        @php
                            $total_price = sprintf("%.2f", $total_price);
                        @endphp

                        <tr>
                            <td colspan="2"></td>
                            <td>Total:</td>
                            <td>{{ $total_price }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4">No Item</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div> <!-- end .col-md-12 -->
        </div> <!-- end .row -->

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('checkout', compact('customer')) }}" class="btn btn-primary">Checkout</a>
            </div>
        </div>

    </div> <!-- end .x_content -->
</div> <!-- end .x_panel -->
@endsection

@section('scripts')
@parent

<script>
$('a[id$=_link]').click(function (e) {

    let tr = $(this).parent().parent();
    let cart_id = tr.data('cart-id');

    // hide link
    $(this).toggleClass('show').toggleClass('hidden');

    // show form
    $('div#cart_' + cart_id + '_form').toggleClass('hidden');

});

$('a[id$=_cancel]').click(function (e) {

    let tr = $(this).parent().parent().parent().parent();
    let cart_id = tr.data('cart-id');
    let form = $('div#cart_' + cart_id + '_form');
    let link = $('a#cart_' + cart_id + '_link');


    form.toggleClass('hidden');
    link.toggleClass('hidden').toggleClass('show');

    console.log(link)
});
</script>
@endsection