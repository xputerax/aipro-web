@extends('backend-layout')

@section('title', 'Product List')
@section('breadcrumbs', Breadcrumbs::render('product-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
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
    </div>
</div>
@endsection

@section('scripts')
@parent
@include('datatables')

<script>
$(function () {

    var columns = [
        {
            data: 'name',
            render: function (data, type, row, meta) {
                return `<a href="{{ url('/') }}/products/${row.id}/edit">${row.name}</a>`;
            }
        },
        {
            data: 'brand_id',
            render: function (data, type, row, meta) {
                return `<a href="{{ url('/') }}/brands/${data}">${row.brand.name}</a>`;
            }
        },
        {
            data: 'min_price',
        },
        {
            data: 'max_price'
        },
        { data: 'stock' },
        { data: 'type' },
    ];

    @if(session('customer'))
    columns.push({
        data: null,
        searchable: false,
        render: function (data, type, row, meta) {
            return `
            <form action="{{ url('/') }}/products/${row.id}/add_to_cart" class="form-inline" method="post">
                @csrf

                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="price">Price</label>
                            <input type="text" name="price" value="${row.min_price}"
                                style="width: 20%;" class="form-control">

                            <label for="quantity">Quantity</label>
                            <input type="text" name="quantity" value="1"
                                style="width: 20%;" class="form-control">

                            <input type="submit" value="Add to Cart" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
            `;
        },
        orderable: false
    })
    @endif

    $("#product_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.products.index') }}',
        columns: columns
    });
});
</script>
@endsection