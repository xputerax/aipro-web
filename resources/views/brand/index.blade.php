@extends('backend-layout')

@section('title', 'Brand List')
@section('breadcrumbs', Breadcrumbs::render('brand-index'))

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
@yield('breadcrumbs')

<table class="table table-bordered table-striped" id="brand_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            @can('get-brands-all-branches')
            <th>Branch</th>
            @endcan
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
            @can('get-brands-all-branches')
            <td>{{ $brand->branch->name }}</td>
            @endcan
        </tr>
    @endforeach
    @else
        <tr>
            @can('get-brands-all-branches')
            <td colspan="3">No Data</td>
            @elsecan
            <td colspan="2">No Data</td>
            @endcan
        </tr>
    @endif
    </tbody>
</table>
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