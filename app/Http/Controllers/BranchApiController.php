<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Http\Resources\BranchResource;
use Yajra\DataTables\DataTables;

class BranchApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $branches = Branch::get();
        $resource = BranchResource::collection($branches);

        return DataTables::of($resource)
            ->with('can_select_branch', $request->user()->can('select-branch'))
            ->toJson();
    }
}
