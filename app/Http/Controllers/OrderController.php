<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->get();

        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    }

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

    protected function writeInvoiceToFile($order)
    {
        $pdf = PDF::loadView('invoice-template', compact('order'));
        $pdf->save($this->getFullInvoiceFileName($order));

        return $pdf;
    }
}
