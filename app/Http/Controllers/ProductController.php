<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::orderBy('name', 'asc')->get();

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
        $data = $this->validateData($request);
        $product = new Product($data);
        $product->save();

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
        $brands = Brand::latest()->get();

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
        $data = $this->validateData($request);

        if ($product->update($data)) {
            return redirect()->route('products.show', compact('product'))->with('message', 'The product has been updated');
        }

        return redirect()->route('products.show', compact('product'))->with('message', 'Failed to update product');
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
    }

    public function addToCart(Request $request, Product $product)
    {
        $quantity = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'lte:'.$product->stock,
            ],
        ]);

        $customer = session('customer');

        DB::transaction(function () use ($customer, $product, $quantity) {
            $cart = new Cart();
            $cart->branch_id = $customer->branch->id;
            $cart->customer_id = $customer->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price;
            $cart->quantity = $quantity;
            $cart->save();

            $product->stock -= $quantity;
            $product->save();
        });

        return redirect()->route('products.index');
    }

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
        ];
    }

    protected function validateData($request)
    {
        return $request->validate($this->validationRules());
    }
}
