@extends('backend-layout')

@if(isset($model))
    @section('title', 'Edit Model '.$model->name)
    @section('breadcrumbs', Breadcrumbs::render('model-edit', $model))
@else
    @section('title', 'Add Model')
    @section('breadcrumbs', Breadcrumbs::render('model-create'))
@endif

@section('content')
@yield('breadcrumbs')

@if(isset($model))
<form action="{{ route('models.update', compact('model')) }}" class="form-horizontal form-label-left" method="post">
@method('PUT')
@else
<form action="{{ route('models.store') }}" class="form-horizontal form-label-left" method="post">
@endif

@csrf

    <!-- start brand section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="brand">
            Brand <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="brand_id" id="brand_id" class="form-control" required>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}"
                    @if(isset($model) && $model->brand_id === $brand->id) {{ 'selected' }} @endif>{{ $brand->name }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <!-- start name section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Name <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="name" value="@if(isset($model)){{ $model->name }}@endif"
                class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>

    <!-- start description section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Description
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="description" cols="30" rows="10"
                class="form-control col-md-7 col-xs-12">@if(isset($model)){{$model->description}}@endif</textarea>
        </div>
    </div>

    <!-- start button section-->
    <div class="form-group">
        <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
            <input type="submit" value="{{ isset($model) ? 'Save' : 'Add Model'}}" class="btn btn-primary">
        </div>
    </div>
    <!-- end button section -->

</form>

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">
    {{ $error }}
</div>
@endforeach
@endif

@if(session('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif
@endsection

@section('scripts')
@parent

<script>
$(function () {
    $("#brand_id").select2();
})
</script>
@endsection