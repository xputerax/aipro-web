@extends('backend-layout')

@section('title', 'Viewing Brand '.$brand->name)
@section('breadcrumbs', Breadcrumbs::render('brand-show', $brand))

@section('content-1')
@yield('breadcrumbs')

<h4>Products</h4>
<table class="table table-bordered" id="products_table">
    <thead>
        <th>Name</th>
        <th>Min. Price</th>
        <th>Max. Price</th>
        <th>Stock</th>
        <th>Type</th>
    </thead>

    <tbody>
    @if($products->count())
    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->min_price }}</td>
            <td>{{ $product->max_price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->type }}</td>
        </tr>
    @endforeach
    @else
        <tr>
            <td colspan="5">No data</td>
        </tr>
    @endif
    </tbody>
</table>
@endsection