<?php

namespace App\Http\Controllers;

use Config;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use App\Http\Requests\SaveInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::with(['client', 'owner', 'products'])
            ->owner($request->get('owner_id'))
            ->number($request->get('number'))
            ->client($request->get('client_id'))
            ->product($request->get('product_id'))
            ->issuedDate($request->get('issued_init'), $request->get('issued_final'))
            ->expiresDate($request->get('expires_init'), $request->get('expires_final'))
            ->state($request->get('state'))
            ->orderBy('id', 'DESC');
        if(! empty($request->get('format'))){
            return (new InvoicesExport($invoices->get()))
                ->download('invoices-list.'.$request->get('format'));
        } else {
            $paginate = Config::get('constants.paginate');
            $count = $invoices->count();
            $invoices = $invoices->paginate($paginate);

            return response()->view('invoices.index', [
                'invoices' => $invoices,
                'request' => $request,
                'count' => $count,
                'paginate' => $paginate
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return response()->view('invoices.create', [
            'invoice' => new Invoice(),
            'request' => $request
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->issued_at = $request->input('issued_at');
        $invoice->client_id = $request->input('client_id');
        $invoice->owner_id = auth()->id();
        $invoice->description = $request->input('description');
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)->withSuccess(__('Factura creada satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return response()->view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede editar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede editar"));
        }
        return response()->view('invoices.edit', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveInvoiceRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SaveInvoiceRequest $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        if ($invoice->isPaid()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra pagada y no se puede actualizar"));
        }
        if ($invoice->isAnnulled()) {
            return redirect()->route('invoices.show', $invoice)->withInfo(__("La factura ya se encuentra anulada y no se puede actualizar"));
        }
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
    public function destroy(Invoice $invoice, Request $request)
    {
        $this->authorize('delete', $invoice);

        if (! $invoice->isAnnulled()) {
            $now = Carbon::now();
            $invoice->update([
                "annulled_at" => $now,
                "annulment_reason" => $request->get('annulment_reason'),
            ]);
            return redirect()->back()->withSuccess(__('Anulada correctamente'));
        } else {
            return redirect()->route('invoices.show', $invoice)->withError(__('Ya se encuentra anulada'));
        }
    }

    public function receivedCheck(Invoice $invoice)
    {
        if (! $invoice->isPaid() && ! $invoice->isAnnulled() && empty($invoice->received_at)) {
            $now = Carbon::now();
            $invoice->update(["received_at" => $now]);
            return redirect()->route('invoices.show', $invoice)->withSuccess(__('Marcada correctamente'));
        } else {
            return redirect()->route('invoices.show', $invoice)->withError(__('No se puede marcar'));
        }
    }
}
