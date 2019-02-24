<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()->get();

        return view('brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $data = $this->validateData($request);
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
