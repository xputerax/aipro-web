@extends('backend-layout')

@section('title', 'Brand List')
@section('breadcrumbs', Breadcrumbs::render('brand-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="brand_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>
            @if($brands->count())
            @foreach($brands as $brand)
                <tr>
                    <td>
                        <a href="{{ route('brands.show', compact('brand')) }}">{{ $brand->name }}</a>
                    </td>
                    <td>{{ $brand->description ?? '-' }}</td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="2">No Data</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent

@include('datatables')

<script>
$(function() {
    $("#brand_table").DataTable();
});
</script>
@endsection