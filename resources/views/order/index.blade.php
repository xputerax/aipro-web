@extends('backend-layout')

@section('title', 'Order List')

@php
    $parse_body_tag = false;    
@endphp

@section('content-1')
<div class="x_panel">
    <table class="table table-bordered table-striped" id="orders_table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @if($orders->count())
            @foreach($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('orders.show', compact('order')) }}">
                        {{ $order->customer->full_name }}
                    </a>
                </td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{ route('orders.edit', compact('order')) }}" class="btn btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">No data</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
@parent
{{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script> --}}

<script>
$(document).ready( function () {

    // let dt = $('#orders_table').DataTable({
    //     serverSide: true,
    //     ajax: "{{ url('api/orders') }}",
    //     dataSrc: 'data',
    //     columns: [
    //         {
    //             data: 'id',
    //             render: function(data, type, row, meta) {

    //                 let url = "{{ url('api/orders') }}" + "/" + data + "/customer";
    //                 let request = fetch(url)
    //                     .then(response => { return response.json() })
    //                     .then(customer_info => { console.log(customer_info) })

    //             }
    //             // createdCell: function(cell, order_id, rowData, rowIndex, colIndex){
    //             //     let url = "{{ url('api/orders') }}" + "/" + order_id + "/customer";
    //             //     let request = fetch(url);
    //             //     let res = request
    //             //         .then(response => { return response.json() })
    //             //         .then(customer_info => console.log(customer_info))

    //             //     console.log(res)

    //             //     return "test";
    //             // }
    //         },
    //         { data: 'status' },
    //         { data: 'created_at' }
    //     ],
    //     paging: true,
    //     // order: [
    //     //     ['created_at', 'desc']
    //     // ]
    // });

});
</script>
@endsection