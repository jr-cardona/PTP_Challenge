<?php

namespace App\Http\Controllers;

use App\State;
use App\Client;
use App\Seller;
use App\Invoice;
use App\Product;
use App\Http\Requests\SaveInvoiceRequest;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices = Invoice::paginate(10);
        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }

    public function create()
    {
        return view('invoices.create', [
            'invoice' => new Invoice,
            'clients' => Client::all(),
            'states' => State::all(),
            'sellers' => Seller::all()
        ]);
    }

    public function store(SaveInvoiceRequest $request)
    {
        Invoice::create($request->validated());

        return redirect()->route('invoices.index')->with('message', 'Factura creada satisfactoriamente');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', [
            'invoice' => $invoice
        ]);
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', [
            'invoice' => $invoice,
            'clients' => Client::all(),
            'sellers' => Seller::all(),
            'states' => State::all()
        ]);
    }

    public function update(SaveInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Factura actualizada satisfactoriamente');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('message', 'Factura eliminada satisfactoriamente');
    }

    public function storeDetail(Invoice $invoice)
    {
        $invoice->products()->attach(request('product_id'), [
            'quantity' => request('quantity'),
            'unit_price' => request('unit_price'),
            'total_price' => request('quantity') * request('unit_price')
        ]);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle creado satisfactoriamente');
    }

    public function editDetail(Invoice $invoice){

    }

    public function updateDetail(Invoice $invoice){

    }

    public function destroyDetail(Invoice $invoice, Product $product){
        $invoice->products()->detach($product->id);
    }
}
