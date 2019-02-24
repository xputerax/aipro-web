<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    const CUSTOMERS_PER_PAGE = 15;
    // const CUSTOMER_ID_SESSION_KEY = 'customer_id';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(self::CUSTOMERS_PER_PAGE);

        // dd($customers);

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.form');
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
        $validated_data = $this->validateData($request);
        $user = Auth::user();
        $branch = $user->branch;

        /**
         * Create customer instance.
         */
        $customer = new Customer($validated_data);

        // Link customer to current user
        $customer->user_id = $user->id;

        // Link customer to current branch
        $customer->branch_id = $branch->id;

        $customer->save();

        return redirect()->route('customers.show', compact('customer'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Customer $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer.view', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Customer $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.form', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Customer            $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validated_data = $this->validateData($request);
        $customer->update($validated_data);
        $request->session()->flash('message', 'Customer saved');

        return redirect()->route('customers.edit', compact('customer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Customer $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index');
    }

    public function select(Request $request, Customer $customer)
    {
        $request->session()->put('customer', clone $customer);

        return redirect()->route('products.index');
    }

    public function deselect()
    {
        return view('customer.deselect');
    }

    public function selected()
    {
        return view('customer.selected');
    }

    protected function validationRules()
    {
        return [
            'full_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'max:15',
            ],
            'ic_number' => [
                'required',
                'max:15',
            ],
            'sex' => [
                'required',
                'in:male,female,others',
            ],
            'source' => [
                'nullable',
                'max:255',
            ],
        ];
    }

    protected function validateData(Request $request)
    {
        return $request->validate($this->validationRules());
    }
}
