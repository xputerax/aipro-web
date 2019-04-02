@extends('backend-layout')

@section('title', 'My Profile')
@section('breadcrumbs', Breadcrumbs::render('user-profile'))

@php
    $parse_body_tag = false;
@endphp

@section('content-1')
@yield('breadcrumbs')

<div class="x_panel">
    <form action="{{ route('profile') }}" method="post" class="form-horizontal form-label-left">
        @csrf

        @method('PUT')

        <!-- email section -->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
                Email <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" name="email" value="{{ Auth::user()->email }}" id="email" class="form-control col-md-7 col-xs-12" required>
            </div>
        </div>
        <!-- end email section -->

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="full-name">
                Full Name <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="full-name" name="full_name" value="{{ Auth::user()->full_name }}" class="form-control col-md-7 col-xs-12" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">
                Username <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="username" name="username" value="{{ Auth::user()->username }}" class="form-control col-md-7 col-xs-12" required>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="current-password">
                Current Password <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="current_password" name="current_password" class="form-control col-md-7 col-xs-12">
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="new-password">
                New Password
                 {{-- <span class="required">*</span> --}}
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="new_password" name="new_password" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password-confirmation">
                Confirm Password
                    {{-- <span class="required">*</span> --}}
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12">
                <input type="submit" value="Save Profile" class="btn btn-primary">
            </div>
        </div>

        @if(session('message'))
            {{ session('message') }}
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
        @endif
            

    </form>
</div>
@endsection