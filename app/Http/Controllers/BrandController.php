<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Branch;

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

        $brands = Brand::orderBy('name', 'ASC')
            ->where(function ($query) {
                if (Auth::user()->cannot('get-brands-all-branches')) {
                    $query->where('branch_id', Auth::user()->branch_id);
                }
            })
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

        $data = [];

        if (Auth::user()->can('add-brand-all-branches')) {
            $data['branches'] = Branch::all();
        }

        return view('brand.form', $data);
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

        try {
            Brand::create($data);
        } catch (QueryException $e) {
            report($e);
        }

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
        Auth::user()->can('view-brand', $brand) ?: abort(403);

        $products = Product::where('brand_id', $brand->id)->get();

        return view('brand.view', compact('brand', 'products'));
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
        Auth::user()->can('edit-brand', $brand) ?: abort(403);

        $data = [
            'brand' => $brand,
        ];

        if (Auth::user()->can('add-brand-all-branches')) {
            $data['branches'] = Branch::all();
        }

        return view('brand.form', $data);
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
        Auth::user()->can('edit-brand', $brand) ?: abort(403);

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
        Auth::user()->can('delete-brand', $brand) ?: abort(403);
    }

    /**
     * Returns the validation rules
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'name' => [
                'required',
                'max:100',
                'unique_with:brands,name,branch_id',
            ],
            'branch_id' => [
                'required',
            ],
            'description' => [
                'present',
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
        return $this->makeValidator($request)->validate();
    }

    /**
     * Returns the validation error message
     *
     * @return array
     */
    protected function validationMessages()
    {
        return ['name.unique_with' => 'Brand name already exist in the current branch'];
    }

    /**
     * Returns the request data with branch_id appended to it
     *
     * @param \Illuminate\Http|Request $request
     * @return array
     */
    protected function getRequestData($request)
    {
        return array_merge(
            $request->all(),
            Auth::user()->cannot('add-brand-all-branches') ? ['branch_id' => Auth::user()->branch_id] : []
        );
    }

    /**
     * Creates the validator instance
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Validation\Validator
     */
    protected function makeValidator($request)
    {
        return Validator::make(
            $this->getRequestData($request),
            $this->validationRules(),
            $this->validationMessages()
        );
    }
}
