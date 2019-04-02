@extends('backend-layout')

@section('title', 'Customer List')
@section('breadcrumbs', Breadcrumbs::render('customer-index'))

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
{{-- <div class="x_panel"> --}}

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

    <div>
        {{ $customers->links() }}
    </div>
{{-- </div> --}}
@endsection

@section('scripts')
@parent
@include('datatables')

{{-- <script type="text/javascript" src="{{ asset('js/datatables.js') }}"></script> --}}

<script>
$(document).ready( function () {
    // let dt = $('#customers_table').DataTable({
        // serverSide: true,
        // ajax: "{{ url('api/customers') }}",
        // dataSrc: 'data',
        // columns: [
        //     {
        //         data: 'full_name',
        //         render: function(data, type, row) {
        //             let url = "{{ url('customers') }}";
        //             return "<a href='" + url + '/' + row.id + "'>" + data + "</a>";
        //         }
        //     },
        //     { data: 'phone' },
        //     { data: 'ic_number' },
        // ],
        // paging: true,
    // });

} );
</script>
@endsection