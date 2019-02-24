@extends('backend-layout')

@section('title', 'Brand List')

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">
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