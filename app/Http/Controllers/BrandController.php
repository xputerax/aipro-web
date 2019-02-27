<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-brand', Brand::class) ?: abort(403);

        $brands = Brand::where('branch_id', Auth::user()->branch->id)
                ->latest()
                ->get();

        return view('brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-brand', Brand::class) ?: abort(403);

        return view('brand.form');
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
        Auth::user()->can('create-brand', Brand::class) ?: abort(403);

        $data = $this->validateData($request);
        $data['branch_id'] = Auth::user()->branch->id;
        $brand = new Brand($data);
        $brand->save();

        return redirect()->route('brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Brand $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        Auth::user()->can('view-brand', Brand::class) ?: abort(403);

        return view('brand.view', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Brand $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        Auth::user()->can('edit-brand', Brand::class) ?: abort(403);

        return view('brand.form', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Brand               $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        Auth::user()->can('edit-brand', Brand::class) ?: abort(403);

        $data = $this->validateData($request);
        $brand->update($data);

        return redirect()->route('brands.edit', compact('brand'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Brand $brand
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Auth::user()->can('delete-brand', Brand::class) ?: abort(403);
    }

    protected function validationRules()
    {
        return [
            'name' => [
                'required',
                'max:100',
                'alpha_dash',
            ],

            'description' => [
                'present',
            ],
        ];
    }

    protected function validateData($request)
    {
        return $request->validate($this->validationRules());
    }
}
