@extends('backend-layout')

@section('title', 'Branch List')
@section('breadcrumbs', Breadcrumbs::render('branch-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-6">
        <form action="{{ route('branches.index') }}" method="get" class="form-inline">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="name" class="form-control"
                        placeholder="Branch Name" value="{{ $request->name ?? '' }}">
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" value="Search">
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

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
                @if($branches->count())
                @foreach($branches as $branch)
                <tr>
                    <td>
                        <a href="{{ route('branches.show', compact('branch')) }}">
                            {{ $branch->name }}
                        </a>
                    </td>
                    @can('select-branch')
                    <td>
                        <a href="{{ route('branches.select', compact('branch')) }}" class="btn btn-primary">
                            Select
                        </a>
                    </td>
                    @endcan
                </tr>
                @endforeach
                @else
                <tr>
                    <td>No Data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {{ $branches->links() }}
    </div>
</div>
@endsection