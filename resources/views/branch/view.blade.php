@extends('backend-layout')

@section('title', 'Viewing Branch '.$branch->name)
@section('breadcrumbs', Breadcrumbs::render('branch-show', $branch));

@section('content-1')
@yield('breadcrumbs')

<div class="x_panel">
    <div class="x_content">
        <div class="form-horizontal form-label-left">

            <!-- start name section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $branch->name }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            <!-- end name section -->

            <!-- start address section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $branch->address }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            <!-- end address section -->

            <!-- start phone section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Telephone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $branch->phone }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            <!-- end phone section -->

            <!-- start email section -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input type="text" value="{{ $branch->email }}" class="form-control col-md-7 col-xs-12" readonly>
                </div>
            </div>
            <!-- end email section -->

            <!-- start button section -->
            <div class="form-group">
                <div class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12">
                    <a href="{{ route('branches.edit', compact('branch')) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
            <!-- end button section -->

        </div> <!-- end .form-horizontal .form-label-left -->
    </div> <!-- end .x_content -->
</div> <!-- end .x_panel -->
        
</div>
@endsection