@section('stylesheets')
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
@endsection

@section('scripts')
<script src="{{ mix('js/backend.js') }}"></script>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @yield('stylesheets')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            @include('sidebar')
            @include('navbar')

            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @yield('content')
                        </div> <!-- end column -->
                    </div> <!-- end .row -->
                </div>
            </div> <!-- end .right_col -->
        </div> <!-- end .main_container -->
    </div> <!-- end .container .body -->
</body>

@yield('scripts')
</html>