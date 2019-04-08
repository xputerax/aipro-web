<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Yajra\DataTables\DataTables;
use App\Http\Resources\UserResource;

class UserApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $users = User::with(['branch', 'group'])
            ->where('branch_id', $request->session()->get('selected_branch_id'))
            ->withTrashed()
            ->get();
        $resource = UserResource::collection($users);

        return DataTables::of($resource)->toJson();
    }
}
