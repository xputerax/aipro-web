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
    </div>
</div>
@endsection

@push('scripts')
@include('datatables')

<script>
$(function() {
    $("#brand_table").DataTable();
});
</script>
@endpush