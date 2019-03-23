@extends('backend-layout')

@section('title', 'Product List')

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
<table class="table table-bordered table-striped" id="product_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Brand</th>
            <th>Min. Price</th>
            <th>Max. Price</th>
            <th>Stock</th>
            <th>Type</th>
            @if(session('customer'))
            <th>Action</th>
            @endif
        </tr>
    </thead>

    <tbody>
    @if($products->count())
    @foreach($products as $product)
        <tr>
            <td>
                <a href="{{ route('products.edit', compact('product')) }}">{{ $product->name }}</a>
            </td>
            <td>
                <a href="{{ route('brands.show', ['brand'=>$product->brand]) }}">{{ $product->brand->name }}</a>
            </td>
            <td>{{ $product->min_price }}</td>
            <td>{{ $product->max_price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->type }}</td>
            @if(session('customer'))
            <td>
                <form action="{{ route('carts.addToCart', compact('product')) }}" class="form-inline" method="post">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" value="{{ $product->min_price }}" style="width: 20%;" class="form-control">

                                <label for="quantity">Quantity</label>
                                <input type="text" name="quantity" value="1" style="width: 20%;" class="form-control">

                                <input type="submit" value="Add to Cart" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </td>
            @endif
        </tr>
    @endforeach
    @else
        <tr>
            <td colspan="7">No data</td>
        </tr>
    @endif
    </tbody>
</table>

@if(session('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    @endforeach
@endif

@endsection

@section('scripts')
@parent
@include('datatables')

<script>
$(function () {
    $("#product_table").DataTable();
});
</script>
@endsection