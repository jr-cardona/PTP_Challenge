<?php

namespace App\Http\Controllers;

use Exception;
use App\Product;
use App\Invoice;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveInvoiceProductRequest;

class InvoiceProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Invoice $invoice
     * @return Response | RedirectResponse
     */
    public function create(Invoice $invoice)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        return response()->view('invoices.products.create', [
                'invoice' => $invoice,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Invoice $invoice
     * @param SaveInvoiceProductRequest $request
     * @return RedirectResponse
     */
    public function store(Invoice $invoice, SaveInvoiceProductRequest $request)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        $product = Product::find($request->get('product_id'));
        $invoice->products()->attach($product->id, array_merge($request->validated(),
                ['unit_price' => $product->price]
            )
        );

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle creado satisfactoriamente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return Response | RedirectResponse
     */
    public function edit(Invoice $invoice, Product $product)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        return response()->view('invoices.products.edit', [
            'invoice' => $invoice,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @param SaveInvoiceProductRequest $request
     * @return RedirectResponse
     */
    public function update(Invoice $invoice, Product $product, SaveInvoiceProductRequest $request)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        $invoice->products()->updateExistingPivot($product->id, $request->validated());

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Invoice $invoice, Product $product)
    {
        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        $invoice->products()->detach($product->id);

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Detalle eliminado satisfactoriamente'));
    }
}
