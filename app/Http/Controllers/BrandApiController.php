<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Http\Resources\BrandResource;
use Yajra\DataTables\DataTables;

class BrandApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $brands = Brand::where('branch_id', $request->session()->get('selected_branch_id'))->get();
        $resource = BrandResource::collection($brands);

        return DataTables::of($resource)->toJson();
    }
}
