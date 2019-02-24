@extends('backend-layout')

@if(isset($product))
    @section('title')
    Editing Product {{ $product->name }}
    @endsection
@else
    @section('title', 'Add New Product')
@endif

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">
        
    @if(isset($product))
    <form action="{{ route('products.update', compact('product')) }}" class="form-horizontal form-label-left" method="post">
    @method('PUT')
    @else
    <form action="{{ route('products.store') }}" class="form-horizontal form-label-left" method="post">
    @endif
    
        @csrf

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

        <!-- start brand section-->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">
                Brand <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
            @if($brands->count())
                <select name="brand_id" class="select2 form-control" id="brand_select">
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"{{ (isset($product) && $product->brand->id == $brand->id) ? ' selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
                </select>
            @else
                No brand available
            @endif
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
                <input type="text" name="stock" value="@if(isset($product)){{ $product->stock }}@endif" class="form-control col-md-7 col-xs-12" required>
            </div>
        </div>
        <!-- end stock section -->

        <!-- start button section-->
        <div class="form-group">
            <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                <input type="submit" value="{{ isset($product) ? 'Save' : 'Add Product'}}" class="btn btn-primary">
            </div>
        </div>
        <!-- end button section -->

        </form>

        @if(session('message'))
        {{ session('message') }}
        @endif

        @if($errors->any())
        @foreach($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif
    </div>
</div>
@endsection

@section('scripts')
@parent

<script>
$(function() {
    $("#brand_select").select2();
});
</script>
@endsection