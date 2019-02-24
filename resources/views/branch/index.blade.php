@extends('backend-layout')

@section('title', 'Branch List')

@section('content-1')
<div class="x_panel">
    <table class="table table-bordered table-striped" id="branches_table">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>

        <tbody></tbody>
    </table>
</div>
@endsection

@section('scripts')
@parent
@include('datatables')

<script>
$(function() {

    let table = $("#branches_table").DataTable({
        serverSide: true,
        ajax: "{{ url('api/branches') }}",
        dataSrc: 'data',
        columns: [
            {
                data: 'name',
                render: function (data, type, row) {
                    let url = `{{ url('branches') }}/${row.id}`;
                    return `<a href="${url}">${data}</a>`;
                }
            }
        ],
        paging: true,

    });

});
</script>
@endsection