@extends('backend-layout')

@php
    $parse_body_tag = false;
    $total_price = 0;
@endphp

@section('title', 'Viewing Customer Cart: '.$customer->full_name)
@section('breadcrumbs', Breadcrumbs::render('cart', $customer))

@section('content-1')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
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
                        <a href="#" id="cart_{{ $cart->id }}_description_link" data-cart-id="{{ $cart->id }}">

                    @if(isset($cart->description))
                        <pre>{{ $cart->description }}</pre>
                    @else
                        Add Description
                    @endif

                        </a>

                        <div id="cart_{{ $cart->id }}_description_form" class="hidden">
                            <form action="{{ route('carts.modifyDescription', compact('cart')) }}" method="post">
                                @csrf
                                @method('PUT')

                                <textarea name="description" cols="10" rows="5" class="form-control">{{ $cart->description }}</textarea>

                                <br>

                                <input type="submit" value="Save" class="btn btn-primary">
                                <a href="#" class="btn btn-danger"
                                id="cart_{{ $cart->id }}_description_cancel"
                                data-cart-id="{{ $cart->id }}">Cancel</a>
                            </form>
                        </div> <!-- end add description form -->
                    </td> <!-- end description column -->

                    <td>
                        <a href="#" id="cart_{{ $cart->id }}_quantity_link" data-cart-id="{{ $cart->id }}">
                            {{ $cart->quantity }}
                        </a>
                        <div id="cart_{{ $cart->id }}_quantity_form" class="hidden">
                            <form action="{{ route('carts.modifyQuantity', compact('cart')) }}" method="post" class="form-inline">
                                @csrf
                                @method('PUT')

                                <input type="text" name="quantity" class="form-control" value="{{ $cart->quantity }}" style="width: 20%">
                                <input type="submit" value="Save" class="btn btn-primary">
                                <a href="#" id="cart_{{ $cart->id }}_quantity_cancel" class="btn btn-danger" data-cart-id="{{ $cart->id }}">Cancel</a>
                            </form>
                        </div> <!-- end quantity form -->
                    </td> <!-- end quantity column -->

                    <td>{{ $cart->price }}</td>

                    <td>{{ $cart->total_price }}</td>
                </tr>
                @endforeach

                @php
                    $total_price = sprintf("%.2f", $total_price);
                @endphp

                <tr>
                    <td colspan="3"></td>
                    <td>Total:</td>
                    <td>{{ $total_price }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="5">No Item</td>
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
@endsection

@section('scripts')
@parent

<script>
$("a[id$='_description_link']").click(function (e) {
    let anchor = $(this);
    let cart_id = anchor.data('cart-id');
    let form = $("div#cart_" + cart_id + "_description_form");

    form.toggleClass('hidden');
    anchor.toggleClass('hidden');
});

$("a[id$='_description_cancel']").click(function (e) {
    let cart_id = $(this).data('cart-id');
    let anchor = $("a#cart_" + cart_id + "_description_link");
    let form = $(this).parent().parent();

    anchor.toggleClass('hidden');
    form.toggleClass('hidden');
});

$("a[id$='_quantity_link']").click(function (e) {
    let anchor = $(this);
    let cart_id = anchor.data('cart-id');
    let form = $("div#cart_" + cart_id + "_quantity_form");

    anchor.toggleClass('hidden');
    form.toggleClass('hidden');
});

$("a[id$='_quantity_cancel']").click(function (e) {
    let cart_id = $(this).data('cart-id');
    let anchor = $("a#cart_" + cart_id + "_quantity_link");
    let form = $(this).parent().parent();

    form.toggleClass('hidden');
    anchor.toggleClass('hidden');
});
</script>
@endsection