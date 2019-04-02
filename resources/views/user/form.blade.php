@extends('backend-layout')

@if(isset($user))
    @section('title', 'Edit User '.$user->full_name)
    @section('breadcrumbs', Breadcrumbs::render('user-edit', $user))
@else
    @section('title', 'Add New User')
    @section('breadcrumbs', Breadcrumbs::render('user-create'))
@endif

@section('content')
@yield('breadcrumbs')

@if(Route::currentRouteName() == "users.create")
<form action="{{ route('users.store') }}" class="form-horizontal form-label-left" method="post">
@elseif(Route::currentRouteName() == "users.edit")
<form action="{{ route('users.update', compact('user')) }}" class="form-horizontal form-label-left" method="post">
@method('PUT')
@endif

    @csrf

    <!-- start full name section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full_name">Full Name</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" name="full_name" class="form-control col-md-7 col-xs-12"
                value="@if(isset($user)){{ $user->full_name }}@endif">
        </div>
    </div>
    <!-- end full name section -->

    <!-- start username section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="text" name="username" class="form-control col-md-7 col-xs-12"
                value="@if(isset($user)){{ $user->username }}@endif">
        </div>
    </div>
    <!-- end username section -->

    <!-- start password section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="password" name="password" class="form-control col-md-7 col-xs-12">
        </div>
    </div>
    <!-- end password section -->

    <!-- start email section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <input type="email" name="email" class="form-control col-md-7 col-xs-12"
                value="@if(isset($user)){{ $user->email }}@endif">
        </div>
    </div>
    <!-- end email section -->

    <!-- start group section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="group">Group</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            @if($groups->count())
            <select name="group_id" id="group_select" class="form-control select2_single">
                @foreach($groups as $group)
                <option value="{{ $group->id }}"
                    {{ (isset($user) && $user->group_id === $group->id) ? 'selected' : '' }}
                >{{ $group->name }}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <!-- end group section -->

    @if(Auth::user()->can('create-user-all-branches'))
    <!-- start branch section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="branch_id">Branch</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            @if($branches->count())
            <select name="branch_id" id="branch_select" class="form-control select2_single">
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ (isset($user) && $user->branch_id === $branch->id) ? 'selected' : '' }}
                >{{ $branch->name }}
                </option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <!-- end branch section -->
    @endif

    <!-- start active/disabled section -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="disabled" {{ (isset($user->deleted_at)) ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>
    </div>
    <!-- end active/disabled section -->

    <!-- start button section -->
    <div class="form-group">
        <div class="col-md-offset-3 col-md-sm-3 col-xs-12 col-md-9 col-sm-9">
            @if(isset($user))
            <input type="submit" value="Save User" class="btn btn-primary">
            @else
            <input type="submit" value="Add User" class="btn btn-primary">
            @endif
        </div>
    </div>
    <!-- end button section -->

    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    @endif

</form>
@endsection

@push('scripts')
<script>
$(function() {
    let group_select = $("#group_select").select2();
    let branch_select = $("#branch_select").select2();
});
</script>
@endpush