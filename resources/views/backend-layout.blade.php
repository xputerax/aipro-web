@extends('layout')

@php
    $parse_body_tag = false;
@endphp

@section('content')
<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            @include('sidebar')
            @include('navbar')

            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>@yield('title')</h3>
                        </div>
                    </div>
            
                    <div class="clearfix"></div>
            
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @yield('content-1')
                        </div> <!-- end column -->
                    </div> <!-- end .row -->
                </div>
            </div> <!-- end .right_col -->
                
            @yield('scripts-1')

            
        </div> <!-- end .main_container -->
    </div> <!-- end .container .body -->
</body>
@endsection

@section('scripts')
<script src="{{ mix('js/backend.js') }}"></script>
@endsection
