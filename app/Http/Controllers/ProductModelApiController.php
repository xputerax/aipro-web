<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductModel;
use App\Http\Resources\ProductModelResource;
use Yajra\DataTables\DataTables;

class ProductModelApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $product_models = ProductModel::with('brand')
            ->where('branch_id', session('selected_branch_id'))
            ->get();

        $resource = ProductModelResource::collection($product_models);

        return DataTables::of($resource)->make(true);
    }
}
