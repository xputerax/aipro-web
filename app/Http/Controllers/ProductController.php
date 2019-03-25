<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-product', Product::class) ?: abort(403);

        $products = Product::where('branch_id', Auth::user()->branch_id)
            ->latest()
            ->get()
        ;

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-product', Product::class) ?: abort(403);

        $brands = Brand::where('branch_id', Auth::user()->branch_id)
            ->orderBy('name', 'asc')
            ->get()
        ;

        return view('product.form', compact('brands'));
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
        Auth::user()->can('create-product', Product::class) ?: abort(403);

        $data = $this->validateData($request);
        $data['branch_id'] = Auth::user()->branch_id;

        Product::create($data);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Auth::user()->can('view-product', $product) ?: abort(403);

        return view('product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        Auth::user()->can('edit-product', $product) ?: abort(403);

        $brands = Brand::where('branch_id', Auth::user()->branch_id)
            ->latest()
            ->get()
        ;

        return view('product.form', compact('product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        Auth::user()->can('edit-product', $product) ?: abort(403);

        $data = $this->validateData($request);

        if ($product->update($data)) {
            return redirect()
                ->route('products.show', compact('product'))
                ->with('message', 'The product has been updated')
            ;
        }

        return redirect()
            ->route('products.show', compact('product'))
            ->with('message', 'Failed to update product')
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Auth::user()->can('delete-product', $product) ?: abort(403);
    }

    /**
     * Returns the validation rules.
     *
     * @return array
     */
    protected function validationRules()
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],

            'description' => [
                'present',
            ],

            'brand_id' => [
                'required',
                'exists:brands,id',
            ],

            'min_price' => [
                'required',
                'numeric',
            ],

            'max_price' => [
                'required',
                'numeric',
                'gte:min_price',
            ],

            'stock' => [
                'required',
                'integer',
            ],
            'type' => [
                'required',
                'in:product,service',
            ],
        ];
    }

    /**
     * Returns the validated form data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function validateData($request)
    {
        return $request->validate($this->validationRules());
    }
}
