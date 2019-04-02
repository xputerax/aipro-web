@extends('backend-layout')

@if(isset($branch))
    @section('title', 'Editing Branch'.$branch->name)
    @section('breadcrumbs', Breadcrumbs::render('branch-edit', $branch))
@else
    @section('title', 'Create New Branch')
    @section('breadcrumbs', Breadcrumbs::render('branch-create'))
@endif

@section('content')
@yield('breadcrumbs')

@if(isset($branch))
<form action="{{ route('branches.update', compact('branch')) }}" class="form-horizontal form-label-left" method="post">
@method('PUT')
@else
<form action="{{ route('branches.store') }}" class="form-horizontal form-label-left" method="post">
@endif

    @csrf

    <!-- start name section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input type="text" name="name" value="@if(isset($branch)){{ $branch->name }}@endif" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end name section -->

    <!-- start address section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input type="text" name="address" value="@if(isset($branch)){{ $branch->address }}@endif" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end address section -->

    <!-- start phone section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Telephone</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input type="text" name="phone" value="@if(isset($branch)){{ $branch->phone }}@endif" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end phone section -->

    <!-- start email section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
        <div class="col-md-6 col-sm-9 col-xs-12">
            <input type="email" name="email" value="@if(isset($branch)){{ $branch->email }}@endif" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end email section -->

    <!-- start button section -->
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
            @if(isset($branch))
            <input type="submit" value="Save Branch" class="btn btn-primary">
            @else
            <input type="submit" value="Add Branch" class="btn btn-primary">
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
@endsection