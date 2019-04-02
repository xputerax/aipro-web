@extends('backend-layout')

@section('title', 'Customer List')
@section('breadcrumbs', Breadcrumbs::render('customer-index'))

@section('content')
@yield('breadcrumbs')

<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12">
        <form action="{{ route('customers.index') }}" method="get">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="full_name" class="form-control"
                        placeholder="Customer Name" value="{{ $request->full_name ?? '' }}">
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" value="Search">
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped" id="customers_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>IC/Passport</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @if($customers->count())
            @foreach($customers as $customer)
                <tr>
                    <td>
                        <a href="{{ route('customers.show', compact('customer')) }}">
                            {{ $customer->full_name }}
                        </a>
                    </td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->ic_number }}</td>
                    <td>
                        <a href="{{ route('customers.select', compact('customer')) }}" class="btn btn-primary">Select Customer</a>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="4">No data</td>
                </tr>
            @endif
            </tbody>
        </table>

    </div> <!-- end col -->
</div> <!-- end row -->

<div>
    {{ $customers->links() }}
</div>
@endsection