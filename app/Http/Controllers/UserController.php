<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    const USERS_PER_PAGE = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Auth::user()->can('list-user', User::class) ?: abort(403);

        if(Auth::user()->can('search-users-across-branches')) {
            $users = new User();
        } else {
            $users = User::where('branch_id', Auth::user()->branch->id);
        }

        if($request->has('name')) {
            $users = $users->where('full_name', 'like', '%' . $request->name . '%');
        }

        $users = $users->withTrashed()->paginate(self::USERS_PER_PAGE);

        return view('user.index', compact('users', 'request'));
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
        Auth::user()->can('create-user', User::class) ?: abort(403);

        $data = $this->validateData($request, null);

        if ('disabled' === $data['status']) {
            $data['deleted_at'] = Carbon::now();
        }

        $user = User::create($data);

        if($data['status'] === "disabled") {
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
        $branches = Branch::all();

        return view('user.form', compact('user', 'groups', 'branches'));
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

        if($data['status'] === "active") {
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
     * @param \App\User|null $user
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
            'branch_id' => [
                'required',
                'exists:branches,id',
            ],
            'status' => [
                'required',
                'in:active,disabled'
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
     * @param \App\User|null $user
     *
     * @return array
     */
    public function validateData($request, $user = null)
    {
        $data = $request->validate($this->validationRules($user));

        if(!isset($data['password']))
            unset($data['password']);

        return $data;
    }
}
