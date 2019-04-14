@extends('backend-layout')

@section('title', 'Order List')
@section('breadcrumbs', Breadcrumbs::render('order-'.$status))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="orders_table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
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

<script>
$(function () {
    $("#orders_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.orders.index') }}?status={{ $status }}',
        columns: [
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    console.log(data, type, row, meta);
                    return `<a href="{{ url('/') }}/orders/${data}">${row.customer.full_name}</a>`;
                }
            },
            {
                data: 'status'
            },
            {
                data: 'created_at'
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/orders/${row.id}/edit" class="btn btn-primary">Edit</a>`;
                },
                orderable: false
            }
        ]
    });
});
</script>
@endsection