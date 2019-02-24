@extends('backend-layout')

@section('title', 'Dashboard')

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
{{-- <div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Dashboard</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12"> --}}
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Dashboard</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        test
                    </div> <!-- end .x_content -->

                    <div class="x_title">
                        <h2>test</h2>
                        <div class="clearfix"></div>
                    </div> <!-- end .x_title -->
                    <div class="x_content">
                        <h2></h2>
                    </div> <!-- end .x_content -->
                </div> <!-- end .x_panel -->
            {{-- </div> <!-- end column -->
        </div> <!-- end .row -->
    </div>
</div> <!-- end .right_col --> --}}
@endsection