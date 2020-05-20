<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveInvoiceRequest;
use App\Http\Requests\IndexInvoiceRequest;
use App\Http\Requests\AnnulInvoiceRequest;
use App\Actions\Invoices\GetInvoicesAction;
use App\Actions\Invoices\StoreInvoicesAction;
use App\Actions\Invoices\UpdateInvoicesAction;
use Illuminate\Auth\Access\AuthorizationException;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }

    /**
     * Display a listing of the resource.
     * @param GetInvoicesAction $action
     * @param IndexInvoiceRequest $request
     * @return Response
     */
    public function index(GetInvoicesAction $action, IndexInvoiceRequest $request)
    {
        $invoices = $action->execute(new Invoice(), $request->all())
            ->paginate($request->get('per_page'));

        return response()->view('invoices.index', compact('invoices', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Invoice $invoice
     * @return Response
     */
    public function create(Request $request, Invoice $invoice)
    {
        return response()->view('invoices.create', compact('request', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveInvoiceRequest $request
     * @param StoreInvoicesAction $action
     * @return RedirectResponse
     */
    public function store(SaveInvoiceRequest $request, StoreInvoicesAction $action)
    {
        $invoice = $action->execute(new Invoice(), $request->validated());
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Factura creada satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('products', 'paymentAttempts');

        return response()->view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @param Request $request
     * @return Response
     */
    public function edit(Invoice $invoice, Request $request)
    {
        return response()->view('invoices.edit', compact('invoice', 'request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveInvoiceRequest $request
     * @param Invoice $invoice
     * @param UpdateInvoicesAction $action
     * @return RedirectResponse
     */
    public function update(
        SaveInvoiceRequest $request,
        Invoice $invoice,
        UpdateInvoicesAction $action
    ) {
        $invoice = $action->execute($invoice, $request->validated());

        return redirect()->route('invoices.show', $invoice)
            ->with('success', ('Factura actualizada satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @param AnnulInvoiceRequest $request
     * @return RedirectResponse
     */
    public function destroy(Invoice $invoice, AnnulInvoiceRequest $request)
    {
        $invoice->annulled_at = Carbon::now();
        $invoice->annulment_reason = $request->input('annulment_reason');
        $invoice->update();

        return redirect()->back()
            ->with('success', ('Anulada correctamente'));
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     * @throws AuthorizationException
     */
    public function receivedCheck(Invoice $invoice)
    {
        $this->authorize('receive', $invoice);

        $invoice->received_at = Carbon::now();
        $invoice->update();

        return redirect()->route('invoices.show', $invoice)
            ->with('success', ('Marcada correctamente'));
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     * @throws AuthorizationException
     */
    public function print(Invoice $invoice)
    {
        $this->authorize('print', $invoice);

        $pdf = \PDF::loadView('invoices.print', compact('invoice'));
        return $pdf->stream();
    }
}
