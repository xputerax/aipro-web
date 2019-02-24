@extends('backend-layout')

@if(isset($brand))
@section('title')
Editing Brand {{ $brand->name }}
@endsection
@else
@section('title', 'Add New Brand')
@endif

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">

        @if(isset($brand))
        <form action="{{ route('brands.update', compact('brand')) }}" class="form-horizontal form-label-left" method="post">
        @method('PUT')
        @else
        <form action="{{ route('brands.store') }}" class="form-horizontal form-label-left" method="post">
        @endif

        @csrf

            <!-- start name section-->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                    Name <span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="name" value="@if(isset($brand)){{ $brand->name }}@endif" class="form-control col-md-7 col-xs-12" required>
                </div>
            </div>
            <!-- end name section -->

            <!-- start description section-->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                    Description
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="description" cols="30" rows="10" class="form-control col-md-7 col-xs-12">@if(isset($brand)){{ $brand->description }}@endif</textarea>
                </div>
            </div>
            <!-- end description section -->

            <!-- start button section-->
            <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                    <input type="submit" value="{{ isset($brand) ? 'Save' : 'Add Brand'}}" class="btn btn-primary">
                </div>
            </div>
            <!-- end button section -->
            
        </form>

        @if($errors->any())
        @foreach($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif

        @if(session('message'))
        {{ session('message') }}
        @endif
    </div> <!-- end .x_content -->
</div> <!-- end .x_panel -->
@endsection
