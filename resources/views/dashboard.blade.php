@extends('backend-layout')

@section('title', 'Dashboard')

@section('breadcrumbs', Breadcrumbs::render('dashboard'))

@section('content')
@yield('breadcrumbs')

<div class="row tile_count">
    <div class="col-md-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-money"></i> Today</span>
        <div class="count">RM {{ $sales['day'] }}</div>
        <span class="count_bottom"></span>
    </div>

    <div class="col-md-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-money"></i> This Month</span>
        <div class="count">RM {{ $sales['month'] }}</div>
        <span class="count_bottom"></span>
    </div>

    <div class="col-md-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-money"></i> This Year</span>
        <div class="count">RM {{ $sales['year'] }}</div>
        <span class="count_bottom"></span>
    </div>
</div> <!-- end .row .tile_count -->
@endsection
