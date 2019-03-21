<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    const CUSTOMERS_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Auth::user()->can('list-customer', Customer::class) ?: abort(403);

        $customers = Customer::where('branch_id', Auth::user()->branch->id);

        if($request->has('full_name')) {
            $full_name = $request->full_name;
            $customers = $customers->where('full_name', 'like', '%' . $full_name . '%');
        }

        $customers = $customers
            ->latest()
            ->paginate(self::CUSTOMERS_PER_PAGE);

        return view('customer.index', compact('customers', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-customer', Customer::class) ?: abort(403);

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
        $user = Auth::user();

        $user->can('create-customer', Customer::class) ?: abort(403);

        $validated_data = $this->validateData($request);
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
        Auth::user()->can('view-customer', $customer) ?: abort(403);

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
        Auth::user()->can('edit-customer', $customer) ?: abort(403);

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
        Auth::user()->can('edit-customer', $customer) ?: abort(403);

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
        Auth::user()->can('delete-customer', $customer) ?: abort(403);

        $customer->delete();

        return redirect()->route('customers.index');
    }

    /**
     * Store the selected customer into session
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Customer $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function select(Request $request, Customer $customer)
    {
        Auth::user()->can('select-customer') && Auth::user()->can('select-this-customer', $customer) ?: abort(403);

        $request->session()->put('customer', clone $customer);

        return redirect()->route('products.index');
    }

    /**
     * Remove the selected customer from session
     *
     * @return \Illuminate\Http\Response
     */
    public function deselect(Request $request)
    {
        Auth::user()->can('select-customer', Customer::class) ?: abort(403);

        $request->session()->forget('customer');

        return redirect()->route('customers.index');
    }

    /**
     * Show the confirm deselect customer page
     *
     * @return void
     */
    public function confirmDeselect()
    {
        Auth::user()->can('select-customer', Customer::class) ?: abort(403);

        return view('customer.deselect', [
            'customer' => session('customer')
        ]);
    }

    /**
     * View the selected customer
     *
     * @return \Illuminate\Http\Response
     */
    public function selected()
    {
        Auth::user()->can('select-customer', Customer::class) ?: abort(403);

        $customer = session('customer');

        return redirect()->route('customers.show', compact('customer'));
    }

    /**
     * Returns the validation rules for creating and editing customer
     *
     * @return array
     */
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

    /**
     * Returns the validated form input
     *
     * @param Request $request
     * @return array
     */
    protected function validateData(Request $request)
    {
        return $request->validate($this->validationRules());
    }
}
