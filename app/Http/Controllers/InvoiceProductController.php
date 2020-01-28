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
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function create(Invoice $invoice)
    {
        if ($invoice->isPaid()){
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        } else {
            return response()->view('invoices.details.create', [
                'invoice' => $invoice,
            ]);
        }
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

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle creado satisfactoriamente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function edit(Invoice $invoice, Product $product)
    {
        if ($invoice->isPaid()){
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        } else {
            return response()->view('invoices.details.edit', [
                'invoice' => $invoice,
                'product' => $product
            ]);
        }
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

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle actualizado satisfactoriamente'));
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

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle eliminado satisfactoriamente'));
    }
}
