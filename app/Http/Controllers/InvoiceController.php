<?php

namespace App\Http\Controllers;

use Config;
use Carbon\Carbon;
use App\Entities\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\InvoicesExport;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveInvoiceRequest;
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
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(GetInvoicesAction $action, Request $request)
    {
        $invoices = $action->execute(new Invoice(), $request);

        if($format = $request->get('format')){
            $this->authorize('export', Invoice::class);
            return (new InvoicesExport($invoices->get()))
                ->download('invoices-list.' . $format);
        }

        $paginate = Config::get('constants.paginate');
        $count = $invoices->count();
        $invoices = $invoices->paginate($paginate);

        return response()->view('invoices.index', compact(
            'invoices', 'request', 'count', 'paginate')
        );
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
        $invoice = $action->execute(new Invoice(), $request);

        return redirect()->route('invoices.show', $invoice)
            ->withSuccess(__('Factura creada satisfactoriamente'));
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
     * @return Response | RedirectResponse
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
    public function update(SaveInvoiceRequest $request, Invoice $invoice,
                           UpdateInvoicesAction $action)
    {
        $invoice = $action->execute($invoice, $request);

        return redirect()->route('invoices.show', $invoice)
            ->withSuccess(__('Factura actualizada satisfactoriamente'));
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
            ->withSuccess(__('Anulada correctamente'));
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
            ->withSuccess(__('Marcada correctamente'));
    }
}
