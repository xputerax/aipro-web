@extends('backend-layout')

@section('title', 'User List')
@section('breadcrumbs', Breadcrumbs::render('user-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="user_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Group</th>
                    <th>Branch</th>
                    <th>Status</th>
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
    $("#user_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.users.index') }}',
        columns: [
            {
                data: 'full_name',
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/users/${row.id}/edit">${row.full_name}</a>`;
                }
            },
            {
                data: 'email',
            },
            {
                data: 'username',
            },
            {
                data: 'group.name',
                render: function (data, type, row, meta) {
                    return `${row.group.name}`;
                }
            },
            {
                data: 'branch.name',
                render: function (data, type, row, meta) {
                    return `<a href="{{ url('/') }}/branches/${row.branch.id}">${row.branch.name}</a>`;
                }
            },
            {
                data: 'deleted_at',
                render: function (data, type, row, meta) {
                    return (data == null) ? 'active' : 'disabled';
                }
            },
        ],
        paging: true
    });
});
</script>
@endsection