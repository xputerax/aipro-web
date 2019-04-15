@extends('backend-layout')

@section('title', 'Model List')
@section('breadcrumbs', Breadcrumbs::render('model-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="model_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent

<script>
$(function () {
    $("#model_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.product_models.index') }}',
        columns: [
            {
                data: 'name',
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/models/${row.id}/edit">${data}</a>`;
                }
            },
            {
                data: 'brand.name'
            },
            {
                data: 'description'
            }
        ],
        paging: true
    });
});
</script>
@endsection