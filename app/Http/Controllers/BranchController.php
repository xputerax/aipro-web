<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-branch') ?: abort(403);

        $branches = Branch::latest()->get();

        return view('branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-branch') ?: abort(403);

        return view('branch.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->can('create-branch') ?: abort(403);

        $branch = new Branch($this->validateData($request));
        $branch->save();

        return redirect()->route('branches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        Auth::user()->can('view-branch') ?: abort(403);

        return view('branch.view', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        Auth::user()->can('edit-branch') ?: abort(403);

        return view('branch.form', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        Auth::user()->can('edit-branch') ?: abort(403);

        $data = $this->validateData($request);
        $branch->update($data);

        return redirect()->route('branches.edit', compact('branch'))->with('message', 'Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        Auth::user()->can('delete-branch') ?: abort(403);
    }

    /**
     * Returns the form validation rules
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ],
            'phone' => [
                'required',
                'max:15'
            ],
            'email' => [
                'required',
                'email',
                'max:100'
            ],
        ];
    }

    /**
     * Returns the validated form data
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function validateData($request)
    {
        return $request->validate($this->validationRules());
    }
}
