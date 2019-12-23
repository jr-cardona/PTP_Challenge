<?php

namespace App\Http\Controllers;

use App\Product;
use App\Invoice;
use App\Http\Requests\StoreInvoiceDetailRequest;
use App\Http\Requests\UpdateInvoiceDetailRequest;

class InvoiceProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        return response()->view('invoices.details.create', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Invoice $invoice
     * @param StoreInvoiceDetailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Invoice $invoice, StoreInvoiceDetailRequest $request)
    {
        $invoice->products()->attach(request('product_id'), $request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle creado satisfactoriamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice, Product $product)
    {
        return response()->view('invoices.details.edit', [
            'invoice' => $invoice,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @param UpdateInvoiceDetailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Invoice $invoice, Product $product, UpdateInvoiceDetailRequest $request)
    {
        $invoice->products()->updateExistingPivot($product->id, $request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Invoice $invoice, Product $product)
    {
        $invoice->products()->detach($product->id);

        return redirect()->route('invoices.show', $invoice)->with('message', 'Detalle eliminado satisfactoriamente');
    }
}
