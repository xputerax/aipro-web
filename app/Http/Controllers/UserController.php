<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    const USERS_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-user', User::class) ?: abort(403);

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-user', User::class) ?: abort(403);

        $groups = Group::all();

        return view('user.form', compact('groups'));
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
        Auth::user()->can('create-user', User::class) ?: abort(403);

        $data = $this->validateData($request, $user = null);

        $user = User::create($data);

        if ('disabled' === $data['status']) {
            $user->delete();
        }

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
        Auth::user()->can('view-user', $user) ?: abort(403);

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
        Auth::user()->can('edit-user', $user) ?: abort(403);

        $groups = Group::all();

        return view('user.form', compact('user', 'groups'));
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
        Auth::user()->can('edit-user', $user) ?: abort(403);

        $data = $this->validateData($request, $user);

        $user->update($data);

        if ('active' === $data['status']) {
            $user->restore();
        } else {
            $user->delete();
        }

        return redirect()->route('users.edit', compact('user'));
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
        Auth::user()->can('delete-user', $user) ?: abort(403);
    }

    /**
     * Returns the validation rules.
     *
     * @param null|\App\User $user
     *
     * @return array
     */
    public function validationRules($user)
    {
        $rules = [
            'email' => [
                'required',
                'email',
                'max:100',
            ],
            'username' => [
                'required',
                'max:100',
            ],
            'full_name' => [
                'required',
                'max:100',
            ],
            'password' => [
                'sometimes',
                'max:255',
            ],
            'group_id' => [
                'required',
                'exists:groups,id',
            ],
            'status' => [
                'required',
                'in:active,disabled',
            ],
            'branch_id' => [
                'required',
                'exists:branches,id'
            ]
        ];

        if (isset($user)) {
            $rules['email'][] = Rule::unique('users')->ignore($user->id);
            $rules['username'][] = Rule::unique('users')->ignore($user->id);
        } else {
            $rules['email'][] = 'unique:users';
            $rules['username'][] = 'unique:users';
            $rules['password'][] = 'required';
        }

        return $rules;
    }

    /**
     * Validate the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param null|\App\User           $user
     *
     * @return array
     */
    public function validateData($request, $user = null)
    {
        $validator = $this->makeValidator($request, $user);

        $data = $validator->validate();

        if ($data['password'] === null) {
            unset($data['password']);
        }

        return $data;
    }

    /**
     * Get the request data with branch id
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function requestData($request)
    {
        return array_merge(
            $request->all(),
            ['branch_id' => $request->session()->get('selected_branch_id')]
        );
    }

    /**
     * Make the validator instance
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User|null $user
     * @return \Illuminate\Validation\Validator
     */
    protected function makeValidator($request, $user = null)
    {
        return Validator::make(
            $this->requestData($request),
            $this->validationRules($user)
        );
    }
}
