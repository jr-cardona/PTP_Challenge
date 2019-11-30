<?php

namespace App\Http\Controllers;

use App\Product;
use App\Invoice;
use App\Http\Requests\StoreInvoiceDetailRequest;
use App\Http\Requests\UpdateInvoiceDetailRequest;

class InvoiceProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Invoice $invoice)
    {
        return view('invoices.details.create', [
            'invoice' => $invoice,
        ]);
    }

    public function store(Invoice $invoice, StoreInvoiceDetailRequest $request)
    {
        $invoice->products()->attach(request('product_id'), $request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle creado satisfactoriamente');
    }

    public function edit(Invoice $invoice, Product $product)
    {
        return view('invoices.details.edit', [
            'invoice' => $invoice,
            'product' => $product
        ]);
    }

    public function update(Invoice $invoice, Product $product, UpdateInvoiceDetailRequest $request)
    {
        $invoice->products()->updateExistingPivot($product->id, $request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle actualizado satisfactoriamente');
    }

    public function destroy(Invoice $invoice, Product $product)
    {
        $invoice->products()->detach($product->id);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle eliminado satisfactoriamente');
    }
}
