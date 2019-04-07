<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Customer;

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
        $customers = Customer::select(['id', 'full_name', 'phone', 'ic_number'])
            ->where('branch_id', session('selected_branch_id'));

        return DataTables::of($customers)->make(true);
    }
}
