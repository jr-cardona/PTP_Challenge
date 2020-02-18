<?php

namespace App\Http\Controllers;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\SaveInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $invoices = Invoice::with(["client", "seller", "products"])
            ->number($request->get('number'))
            ->client($request->get('client_id'))
            ->seller($request->get('seller_id'))
            ->product($request->get('product_id'))
            ->issuedDate($request->get('issued_init'), $request->get('issued_final'))
            ->expiresDate($request->get('expires_init'), $request->get('expires_final'))
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return response()->view('invoices.index', [
            'invoices' => $invoices,
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        return response()->view('invoices.create', [
            'invoice' => new Invoice,
            'request' => $request
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveInvoiceRequest $request) {
        $result = Invoice::create($request->validated());

        return redirect()->route('invoices.show', $result->id)->withSuccess(__('Factura creada satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice) {
        return response()->view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function edit(Invoice $invoice) {
        if ($invoice->isPaid()){
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        } elseif ($invoice->isExpired()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra vencida y no se puede editar"));
        } else {
            return response()->view('invoices.edit', [
                'invoice' => $invoice,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveInvoiceRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveInvoiceRequest $request, Invoice $invoice) {
        $invoice->update($request->validated());

        return redirect()->route('invoices.show', $invoice)->withSuccess(__('Factura actualizada satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Invoice $invoice) {
        $invoice->delete();

        return redirect()->route('invoices.index')->withSuccess(__('Factura eliminada satisfactoriamente'));
    }

    public function receivedCheck(Invoice $invoice){
        if ($invoice->isPending() && empty($invoice->received_at)) {
            $now = Carbon::now();
            $invoice->update(["received_at" => $now]);

            return redirect()->route('invoices.show', $invoice)->withSuccess(__('Marcada correctamente'));
        } else {
            return redirect()->route('invoices.show', $invoice)->withError(__('No se puede marcar'));
        }
    }
}
