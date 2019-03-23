<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Order;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    const ORDERS_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->can('list-order', Order::class) ?: abort(403);

        $orders = Order::where(function ($query) {
            if (Auth::user()->cannot('list-orders-all-branches')) {
                $query->where('branch_id', Auth::user()->branch->id);
            }
        })
            ->latest()
            ->paginate(self::ORDERS_PER_PAGE)
        ;

        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->can('create-order', Order::class) ?: abort(403);

        return view('order.create');
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
        Auth::user()->can('create-order', Order::class) ?: abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        Auth::user()->can('view-order', $order) ?: abort(403);

        return view('order.view', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        Auth::user()->can('edit-order', $order) ?: abort(403);

        $users = User::where('branch_id', $order->branch_id)->get();

        return view('order.edit', compact('order', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order               $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        Auth::user()->can('edit-order', $order) ?: abort(403);

        $data = $request->validate([
            'status' => [
                'required',
                'in:pending,resolved,delivered',
            ],
            'resolve_user_id' => [
                'sometimes',
            ],
            'delivery_user_id' => [
                'sometimes',
            ],
        ]);

        if (Auth::user()->cannot('change-resolve-user-id', $order)) {
            unset($data['resolve_user_id']);
        }

        if (Auth::user()->cannot('change-delivery-user-id', $order)) {
            unset($data['delivery_user_id']);
        }

        if (!isset($order->resolved_at) && isset($data['resolve_user_id'])) {
            $data['resolved_at'] = Carbon::now();
        }

        if (!isset($order->delivered_at) && isset($data['delivery_user_id'])) {
            $data['delivered_at'] = Carbon::now();
        }

        $order->update($data);

        return redirect()
            ->route('orders.edit', compact('order'))
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Auth::user()->can('delete-order', $order) ?: abort(403);
    }

    /**
     * Generates the order receipt.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function generateReceipt(Order $order)
    {
        $invoice = Invoice::where('order_id', $order->id)->first();

        // dd($invoice);

        if ($invoice) {
            $invoice_file = storage_path('invoices/'.$invoice->invoice_file);
            // dd(1);
            dd($invoice, $invoice_file, 1);
        // return PDF::stream(storage_path('invoices/' . $invoice->invoice_file));
        } else {
            $invoice = $this->createNewInvoice($order);
            $pdf = $this->writeInvoiceToFile($order);
            // dd($invoice, $pdf);
            return $pdf->stream();
        }
    }

    /**
     * Generate invoice file name for an order.
     *
     * @param \App\Order $order
     *
     * @return string
     */
    protected function getNewInvoiceFileName($order)
    {
        return str_slug(implode(' ', [
            'order',
            $order->id,
            $order->customer->full_name,
            $order->created_at->timestamp,
        ]), '-').'.pdf';
    }

    /**
     * Get the full invoice file name.
     *
     * @param \App\Order $order
     *
     * @return string
     */
    protected function getFullInvoiceFileName($order)
    {
        return storage_path('invoices/'.$order->invoice->invoice_file);
    }

    /**
     * Add a new invoice record.
     *
     * @param \App\Order $order
     *
     * @return \App\Invoice
     */
    protected function createNewInvoice($order)
    {
        $invoice = new Invoice();
        $invoice->order_id = $order->id;
        $invoice->invoice_file = $this->getNewInvoiceFileName($order);
        $invoice->save();

        return $invoice;
    }

    /**
     * Write the invoice content to file.
     *
     * @param \App\Order $order
     *
     * @return \Barryvdh\DomPDF\PDF
     */
    protected function writeInvoiceToFile($order)
    {
        $pdf = PDF::loadView('invoice-template', compact('order'));
        $pdf->save($this->getFullInvoiceFileName($order));

        return $pdf;
    }
}
