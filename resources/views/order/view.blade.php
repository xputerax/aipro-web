<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Order #{{ $order->id }} - {{ config('app.name') }}</title>
</head>
<body>
    <div class="container">

        <header>
            <div class="row">
                <div class="col-md-12">
                    <h1>Order #{{ $order->id }}</h1>
                </div>
            </div>
        </header>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <th class="text-right" scope="row" style="width: 20%;">Nama</th>
                            <td>{{ $order->customer->full_name }}</td>
                        </tr>

                        <tr>
                            <th class="text-right" scope="row">No. Tel</th>
                            <td>{{ $order->customer->phone }}</td>
                        </tr>
                        
                        <tr>
                            <th class="text-right" scope="row">No. KP</th>
                            <td>{{ $order->customer->ic_number }}</td>
                        </tr>

                        <tr>
                            <th class="text-right" scope="row">Sumber</th>
                            <td>{{ $order->customer->source ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- end column -->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-md-12">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                    @php
                        $price_sum = (float) 0.00;
                    @endphp

                    @foreach($order->order_products as $order_product)
                        @php
                            $total_price = sprintf("%.2f", (float) $order_product->price * $order_product->quantity);
                            $price_sum += $total_price;
                        @endphp

                        <tr>
                            <td>{{ $order_product->product->name }}</td>
                            <td>{{ $order_product->description ?? '-' }}</td>
                            <td>{{ $order_product->price }}</td>
                            <td>{{ $order_product->quantity }}</td>
                            <td class="text-right">{{ $total_price }}</td>
                        </tr>
                    @endforeach

                    @php
                        $price_sum = sprintf("%.2f", $price_sum);
                    @endphp


                        <tr>
                            <td colspan="3" class="border-top-0"></td>
                            <td style="border-top: 2px solid black;">Subtotal:</td>
                            <td class="text-right" style="border-top: 2px solid black;">{{ $price_sum }}</td>
                        </tr>

                        <tr>
                            <td colspan="3" class="border-top-0"></td>
                            <td>Deposit:</td>
                            <td class="text-right">- {{ $order->deposit }}</td>
                        </tr>

                        <tr>
                            <td colspan="3" class="border-top-0"></td>
                            <td>Total:</td>
                            <td class="text-right">{{ sprintf("%.2f", $price_sum - $order->deposit) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- end column -->
        </div> <!-- .row -->
    </div> <!-- end .container -->
</body>
</html>