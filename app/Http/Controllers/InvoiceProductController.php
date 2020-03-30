<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Entities\Invoice;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveInvoiceProductRequest;
use Illuminate\Auth\Access\AuthorizationException;

class InvoiceProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Invoice $invoice
     * @return Response | RedirectResponse
     * @throws AuthorizationException
     */
    public function create(Invoice $invoice)
    {
        $this->authorize('update', $invoice);
        return response()->view('invoices.products.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Invoice $invoice
     * @param SaveInvoiceProductRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Invoice $invoice, SaveInvoiceProductRequest $request)
    {
        $this->authorize('update', $invoice);
        $product = Product::find($request->input('product_id'));
        $invoice->products()->attach(
            $product->id,
            array_merge(
            $request->validated(),
            ['unit_price' => $product->price]
        )
        );

        return redirect()->route('invoices.show', $invoice)
            ->with('success', ('Detalle creado satisfactoriamente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return Response | RedirectResponse
     * @throws AuthorizationException
     */
    public function edit(Invoice $invoice, Product $product)
    {
        $this->authorize('update', $invoice);
        return response()->view('invoices.products.edit', compact('invoice', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @param SaveInvoiceProductRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Invoice $invoice, Product $product, SaveInvoiceProductRequest $request)
    {
        $this->authorize('update', $invoice);
        $invoice->products()->updateExistingPivot($product->id, $request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', ('Detalle actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Invoice $invoice, Product $product)
    {
        $this->authorize('update', $invoice);
        $invoice->products()->detach($product->id);

        return redirect()->route('invoices.show', $invoice)->with('success', ('Detalle eliminado satisfactoriamente'));
    }
}
