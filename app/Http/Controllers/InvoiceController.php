<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index', [
            'invoices' => Invoice::all()
        ]);
    }

    public function create()
    {
        return view('invoices.create', [
            'invoice' => new Invoice,
            'clients' => Client::all()
        ]);
    }

    public function store(Request $request)
    {
        Invoice::create($request->all());

        return redirect('/invoices')->with('message', 'Factura creada satisfactoriamente');
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
            'clients' => Client::all()
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Factura actualizada satisfactoriamente');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('message', 'Factura eliminada satisfactoriamente');
    }
}
