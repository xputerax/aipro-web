@extends('backend-layout')

@section('title', 'User List')

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
<div class="x_panel">
    <div class="x_content">
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
                        <td><a href="{{ route('users.show', compact('user')) }}">{{ $user->full_name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->group->name }}</td>
                        <td><a href="{{ route('branches.show', ['branch' => $user->branch]) }}">{{ $user->branch->name }}</a></td>
                        <td>{{ isset($user->deleted_at) ? 'deleted' : 'active' }}</td>
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
@endsection

@section('scripts')
@parent
@include('datatables')

<script>
$(function () {
    
});
</script>
@endsection