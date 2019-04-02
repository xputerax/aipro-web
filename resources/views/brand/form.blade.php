@extends('backend-layout')

@if(isset($brand))
    @section('title', 'Editing Brand '.$brand->name)
    @section('breadcrumbs', Breadcrumbs::render('brand-edit', $brand))
@else
    @section('title', 'Add New Brand')
    @section('breadcrumbs', Breadcrumbs::render('brand-create'))
@endif

@section('content')
@yield('breadcrumbs')

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
            <input type="text" name="name" value="@if(isset($brand)){{ $brand->name }}@endif"
                class="form-control col-md-7 col-xs-12" required>
        </div>
    </div>
    <!-- end name section -->

    @if(Auth::user()->can('add-brand-all-branches'))
    <!-- start branch section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
            Branch <span class="required">*</span>
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="branch_id" id="branch_select" class="form-control">
            @foreach($branches as $branch)
                @php
                    if(Route::currentRouteName() === "brands.edit" && $brand->branch_id === $branch->id) {
                        $selected = "selected";
                    } elseif(Route::currentRouteName() === "brands.create" && Auth::user()->branch_id === $branch->id) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                @endphp
                <option value="{{ $branch->id }}" {{ $selected }}>
                    {{ $branch->name }}
                </option>
            @endforeach
            </select>
        </div>
    </div>
    <!-- end branch section -->
    @endif

    <!-- start description section-->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
            Description
        </label>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <textarea name="description" cols="30" rows="10"
                class="form-control col-md-7 col-xs-12">@if(isset($brand)){{ $brand->description }}@endif</textarea>
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
@endsection

@section('scripts')
@parent

@can('add-brand-all-branches')
<script>
    $("#branch_select").select2();
</script>
@endcan

@endsection