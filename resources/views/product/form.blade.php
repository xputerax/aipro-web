@extends('backend-layout')

@if(isset($product))
    @section('title', 'Editing Product '.$product->name)
    @section('breadcrumbs', Breadcrumbs::render('product-edit', $product))
@else
    @section('title', 'Add New Product')
    @section('breadcrumbs', Breadcrumbs::render('product-create'))
@endif

@section('content')
@yield('breadcrumbs')

@if(isset($product))
<form action="{{ route('products.update', compact('product')) }}" class="form-horizontal form-label-left" method="post">
@method('PUT')
@else
<form action="{{ route('products.store') }}" class="form-horizontal form-label-left" method="post">
@endif

    @csrf

    <!-- start brand section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">
            Brand <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
        @if($brands->count())
            <select name="brand_id" class="select2 form-control" id="brand_select">
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}"
                    {{ (isset($product) && $product->brand->id == $brand->id) ? ' selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
            </select>
        @else
            No brand available
        @endif
        </div>
    </div>
    <!-- end description section -->

    <!-- start model section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="model">
            Model <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="model_id" id="model_select" class="form-control">
            </select>
        </div>
    </div>
    <!-- end model section -->

    <!-- start name section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Name <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="name" value="@if(isset($product)){{ $product->name }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end name section -->

    <!-- start description section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Description
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="description" cols="30" rows="10" class="form-control col-md-7 col-xs-12">@if(isset($product)){{ $product->description }}@endif</textarea>
        </div>
    </div>
    <!-- end description section -->

    <!-- start min price section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="min_price">
            Minimum Price <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="min_price" value="@if(isset($product)){{ $product->min_price }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end min price section -->

    <!-- start max price section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="max_price">
            Maximum Price <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="max_price" value="@if(isset($product)){{ $product->max_price }}@endif" class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end max price section -->

    <!-- start stock section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">
            Stock <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="stock" value="@if(isset($product)){{ $product->stock }}@endif"
                class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end stock section -->

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Type">
            Type <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="type" class="form-control">
                <option value="product" {{ isset($product) && $product->type == 'product' ? 'selected' : '' }}>Product</option>
                <option value="service" {{ isset($product) && $product->type == 'service' ? 'selected' : '' }}>Service</option>
            </select>
        </div>
    </div>

    <!-- start button section-->
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
            <input type="submit" value="{{ isset($product) ? 'Save' : 'Add Product'}}" class="btn btn-primary">
        </div>
    </div>
    <!-- end button section -->

    </form>

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

<script>
$(function() {

    var current_model_id = "{{ isset($product) ? $product->model_id : 0 }}";

    var refresh_model_list = function () {

        var selected_brand = $("#brand_select > option:selected");

        $.ajax({
            url: "{{ route('api.product_models.index') }}",
            data: {
                columns: [
                    {
                        data: 'brand.name',
                        name: '',
                        searchable: true,
                        orderable: true,
                        search: {
                            value: selected_brand.text(),
                            regex: false
                        }
                    },
                ],
            },
            success: function (response, status) {
                let models = response.data;

                if (models.length > 0) {
                    models.forEach(function (model) {
                        let modelOption = document.createElement('option');
                        modelOption.value = model.id;
                        modelOption.text = model.name;
                        modelOption.selected = model.id == current_model_id;

                        $("#model_select").append(modelOption);
                    });
                } else {
                    let noModelOption = document.createElement('option');
                    noModelOption.text = 'No model exist for this brand';
                    noModelOption.selected = true;

                    $("#model_select").append(noModelOption).attr('disabled', true);
                }
            }
        });

    };

    refresh_model_list();

    $("#brand_select").on('change', function(e) {
        $("#model_select").removeAttr('disabled').children().remove();
        refresh_model_list();
    });

});
</script>
@endsection