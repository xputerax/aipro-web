@extends('backend-layout')

@section('title', 'Branch List')
@section('breadcrumbs', Breadcrumbs::render('branch-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered table-striped" id="branches_table">
            <thead>
                <tr>
                    <th>Name</th>
                    @can('select-branch')
                    <th>Action</th>
                    @endcan
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
    var columns = [
        {
            data: 'name',
            render: function (data, type, row, meta) {
                return `<a href="{{ url('/') }}/branches/${row.id}">${row.name}</a>`;
            }
        },
    ];

    @can('select-branch')
    columns.push({
        data: null,
        render: function (data, type, row, meta) {
            if(!meta.settings.json.can_select_branch) return '';

            return `<a href="{{ url('/') }}/branches/${row.id}/select" class="btn btn-primary">Select</a>`;
        },
        searchable: false,
        orderable: false
    });
    @endcan

    $('#branches_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('api.branches.index') }}',
        columns: columns,
        paging: true
    });
});
</script>
@endsection