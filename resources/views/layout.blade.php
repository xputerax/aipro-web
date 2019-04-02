@php
    $parse_body_tag = isset($parse_body_tag) ? $parse_body_tag : false;
@endphp
@push('stylesheets')
<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
@endpush
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ config('app.name') }}</title>
    @stack('stylesheets')
</head>

@if($parse_body_tag)
<body>
@endif

    @yield('content')
    @stack('scripts')

@if($parse_body_tag)
</body>
@endif

</html>