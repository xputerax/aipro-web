@extends('backend-layout')

@if(Route::currentRouteName() == "branches.create")
@section('title', 'Create New Branch')
@elseif(Route::currentRouteName() == "branches.edit")
@section('title')
Editing Branch {{ $branch->name }}
@endsection
@endif

@section('content-1')
<div class="x_panel">
    <div class="x_content">

        @if(Route::currentRouteName() == "branches.create")
        <form action="{{ route('branches.store') }}" class="form-horizontal form-label-left" method="post">
        @elseif(Route::currentRouteName() == "branches.edit")
        <form action="{{ route('branches.update', compact('branch')) }}" class="form-horizontal form-label-left" method="post">
        @method('PUT')
        @endif

            @csrf

            <!-- start name section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" name="name" value="@if(isset($branch)){{ $branch->name }}@endif" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <!-- end name section -->

            <!-- start address section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" name="address" value="@if(isset($branch)){{ $branch->address }}@endif" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <!-- end address section -->

            <!-- start phone section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Telephone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" name="phone" value="@if(isset($branch)){{ $branch->phone }}@endif" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <!-- end phone section -->

            <!-- start email section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="email" name="email" value="@if(isset($branch)){{ $branch->email }}@endif" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <!-- end email section -->

            <!-- start button section -->
            <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                    @if(Route::currentRouteName() == "branches.create")
                    <input type="submit" value="Add Branch" class="btn btn-primary">
                    @elseif(Route::currentRouteName() == "branches.edit")
                    <input type="submit" value="Save Branch" class="btn btn-primary">
                    @endif
                </div>
            </div>
            <!-- end button section -->

        </form>

        @if($errors->any())
            @foreach($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
        @endif

        @if(session('message'))
        {{ session('message') }}
        @endif
    </div> <!-- end .x_content -->
</div> <!-- end .x_panel -->
@endsection