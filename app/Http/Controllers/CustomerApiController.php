<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Yajra\DataTables\DataTables;
use App\Http\Resources\UserResource;

class CustomerApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $customers = Customer::where('branch_id', session('selected_branch_id'))
            ->select(['id', 'full_name', 'phone', 'ic_number'])
            ->get();

        $resource = UserResource::collection($customers);

        return DataTables::of($resource)->make(true);
    }
}
