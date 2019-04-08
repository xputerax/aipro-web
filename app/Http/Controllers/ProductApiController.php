<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Resources\ProductResource;
use Yajra\DataTables\DataTables;

class ProductApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $users = Product::with('brand')
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->get();
        $resource = ProductResource::collection($users);

        return DataTables::of($resource)->toJson();
    }
}
