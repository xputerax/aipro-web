@extends('backend-layout')

@section('title', 'User List')
@section('breadcrumbs', Breadcrumbs::render('user-index'))

@section('content-1')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-6">
        <form action="{{ route('users.index') }}" method="get" class="form-inline">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="name" class="form-control"
                        placeholder="User Name" value="{{ $request->name ?? '' }}">
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
                @if($users->count() > 0)
                @foreach($users as $user)
                <tr>
                    <td><a href="{{ route('users.edit', compact('user')) }}">{{ $user->full_name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->group->name }}</td>
                    <td><a href="{{ route('branches.show', ['branch' => $user->branch]) }}">{{ $user->branch->name }}</a></td>
                    <td>{{ isset($user->deleted_at) ? 'disabled' : 'active' }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6">No data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {{ $users->links() }}
    </div>
</div>
@endsection

@section('scripts')
@parent
@include('datatables')

<script>
    $(function () {

    });

</script>
@endsection
