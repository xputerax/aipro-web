<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductModel;
use App\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductModelController extends Controller
{
    /**
     * Display all models
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-model') ?: abort(403);

        return view('product_model.index');
    }

    /**
     * Display model creation form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-model') ?: abort(403);

        $brands = Brand::where('branch_id', session('selected_branch_id'))->get();

        return view('product_model.form', compact('brands'));
    }

    /**
     * Save the model into the database
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Auth::user()->can('create-model') ?: abort(403);

        $validator = $this->makeValidator($request);
        $data = $validator->validate();

        ProductModel::create($data);

        return redirect()->route('models.index');
    }

    /**
     * Display the edit form
     *
     * @param \App\ProductModel $model
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductModel $model)
    {
        Auth::user()->can('edit-model') ?: abort(403);

        $brands = Brand::where('branch_id', session('selected_branch_id'))->get();

        return view('product_model.form', compact('model', 'brands'));
    }

    /**
     * Save the model
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductModel $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductModel $model)
    {
        Auth::user()->can('edit-model') ?: abort(403);

        $validator = $this->makeValidator($request, $model);

        $data = $validator->validate();

        $model->update($data);

        return redirect()->route('models.edit', compact('model'));
    }

    /**
     * Returns the request data
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductModel|null $model
     * @return array
     */
    protected function getRequestData($request, $model)
    {
        return array_merge(
            $request->only('brand_id', 'name', 'description'),
            [ 'branch_id' => $request->session()->get('selected_branch_id') ]
        );
    }

    /**
     * Returns the validation rules
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductModel|null    $model
     * @return array
     */
    protected function validationRules($request, $model)
    {
        $rules = [
            'branch_id' => [
                'required',
                'exists:branches,id'
            ],
            'brand_id' => [
                'required',
                'exists:brands,id'
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'description' => [
                'present'
            ]
        ];

        if(!isset($model))
            $rules['name'][] = 'unique_with:product_models,name,branch_id';

        return $rules;
    }

    /**
     * Returns the validation error message
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\ProductModel|null    $model
     * @return array
     */
    protected function validationMessages($request, $model)
    {
        return ['name.unique_with' => 'Model name already exist in the current branch'];
    }


    /**
     * Creates the validator instance
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ProductModel|null $model
     * @return \Illuminate\Validation\Validator
     */
    protected function makeValidator($request, $model = null)
    {
        return Validator::make(
            $this->getRequestData($request, $model),
            $this->validationRules($request, $model),
            $this->validationMessages($request, $model)
        );
    }

}
