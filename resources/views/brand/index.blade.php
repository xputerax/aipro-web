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
    $("#brand_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.brands.index') }}',
        columns: [
            {
                data: 'name',
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/brands/${row.id}">${row.name}</a>`;
                }
            },
            { data: 'description', defaultContent: '-' }
        ],
        paging: true
    });
});
</script>
@endsection