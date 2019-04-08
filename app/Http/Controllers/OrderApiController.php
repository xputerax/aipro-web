<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Resources\OrderResource;
use Yajra\DataTables\DataTables;

class OrderApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $orders = Order::with('customer')
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->where('status', $request->has('status') &&
                in_array($request->query('status'), ['pending', 'delivered', 'resolved'])
                ? $request->query('status')
                : 'pending'
            )
            ->get();
        $resource = OrderResource::collection($orders);

        return DataTables::of($resource)->toJson();
    }
}
