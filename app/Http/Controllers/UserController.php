<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Group;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withTrashed()->get();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        $branches = Branch::all();

        return view('user.form', compact('groups', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $user = new User($data);
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
    }

    /**
     * Returns the validation rules.
     *
     * @return array
     */
    public function validationRules()
    {
        return [
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users',
            ],
            'username' => [
                'required',
                'max:100',
                'unique:users',
            ],
            'full_name' => [
                'required',
                'max:100',
            ],
            'password' => [
                'required',
                'max:255',
                'string',
            ],
            'group_id' => [
                'required',
                'exists:groups,id',
            ],
            'branch_id' => [
                'required',
                'exists:branches,id',
            ],
        ];
    }

    /**
     * Validate the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function validateData($request)
    {
        return $request->validate($this->validationRules());
    }
}
