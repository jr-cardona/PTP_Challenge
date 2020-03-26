<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Entities\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveInvoiceRequest;
use App\Http\Requests\AnnulInvoiceRequest;
use App\Actions\Invoices\GetInvoicesAction;
use App\Actions\Invoices\StoreInvoicesAction;
use App\Actions\Invoices\UpdateInvoicesAction;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }

    public function index(GetInvoicesAction $action, Request $request)
    {
        $invoices = $action->execute(new Invoice(), $request);
        return $invoices->get();
    }

    public function store(StoreInvoicesAction $action, SaveInvoiceRequest $request)
    {
        return $action->execute(new Invoice(), $request);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('products', 'paymentAttempts');
        return $invoice;
    }

    public function update(
        UpdateInvoicesAction $action,
        Invoice $invoice,
        SaveInvoiceRequest $request
    ) {
        $invoice = $action->execute($invoice, $request);
        return $invoice;
    }

    public function destroy(Invoice $invoice, AnnulInvoiceRequest $request)
    {
        $invoice->annulled_at = Carbon::now();
        $invoice->annulment_reason = $request->input('annulment_reason');
        $invoice->update();

        return response()->json([
            'success' => true,
            'message' => 'Factura anulada correctamente',
        ], 200);
    }
}
