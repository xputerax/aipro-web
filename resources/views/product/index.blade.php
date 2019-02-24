@extends('backend-layout')

@section('title', 'Product List')

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">
        <table class="table table-bordered table-striped" id="product_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Min. Price</th>
                    <th>Max. Price</th>
                    <th>Stock</th>
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
                    @if(session('customer'))
                    <td>
                        <form action="{{ route('products.addToCart', compact('product')) }}" class="form-inline" method="post">
                            @csrf
                            {{-- <div class="container"> --}}
                                <div class="row">
                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <input type="text" name="price" value="{{ $product->min_price }}" class="form-control">
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        <input type="text" name="quantity" value="1" class="form-control">
                                    </div>

                                    <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                                        {{-- <input type="submit" value="Add to Cart" class="btn btn-primary"> --}}
                                    </div>
                                </div>
                            {{-- </div> --}}
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="5">No data</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
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