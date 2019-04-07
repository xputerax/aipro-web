@extends('backend-layout')

@section('title', 'Customer List')
@section('breadcrumbs', Breadcrumbs::render('customer-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped" id="customers_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>IC/Passport</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>

    </div> <!-- end col -->
</div> <!-- end row -->
@endsection

@section('scripts')
@parent
<script>
$(function () {
    $('#customers_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.customers.index') }}',
        columns: [
            { data: 'full_name' },
            { data: 'phone' },
            {
                data: 'ic_number',
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/customers/${row.id}/select" class="btn btn-primary">Select</a>`;
                }
            }
        ]
    });
});
</script>
@endsection