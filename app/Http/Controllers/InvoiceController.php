<?php

namespace App\Http\Controllers;

use App\State;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use App\Imports\InvoicesImport;
use App\Http\Requests\SaveInvoiceRequest;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $invoices = Invoice::orderBy('id', 'DESC')
            ->number($request->get('number'))
            ->state($request->get('state_id'))
            ->client($request->get('client_id'))
            ->seller($request->get('seller_id'))
            ->product($request->get('product_id'))
            ->issuedDate($request->get('issued_init'), $request->get('issued_final'))
            ->overduedDate($request->get('overdued_init'), $request->get('overdued_final'))
            ->paginate(10);
        return response()->view('invoices.index', [
            'invoices' => $invoices,
            'request' => $request,
            'side_effect' => __('Se borrarán todos sus detalles asociados'),
            'states' => State::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return response()->view('invoices.create', [
            'invoice' => new Invoice,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveInvoiceRequest $request) {
        $result = Invoice::create(array_merge($request->validated(), ["state_id" => "1"]));

        return redirect()->route('invoices.show', $result->id)->with('message', __('Factura creada satisfactoriamente'));
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
            'side_effect' => __('Se borrarán todos sus detalles asociados')
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
            return redirect()->route('invoices.show', $invoice)->with('message', __("La factura ya se encuentra pagada y no se puede editar"));
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

        return redirect()->route('invoices.show', $invoice)->with('message', __('Factura actualizada satisfactoriamente'));
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

        return redirect()->route('invoices.index')->with('message', __('Factura eliminada satisfactoriamente'));
    }

    /**
     * Export a listing of the resource.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel() {
        return Excel::download(new InvoicesExport, 'invoices-list.xlsx');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function importExcel(Request $request) {
        $this->validate($request, [
            'invoices' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('invoices');
        try {
            Excel::import(new InvoicesImport(), $file);
            return redirect()->route('invoices.index')->with('message', __('Importación completada correctamente'));
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return response()->view('invoices.importErrors', [
                'failures' => $failures_sorted,
            ]);
        }
    }

    public function receivedCheck(Invoice $invoice){
        $now = Carbon::now();
        $invoice->update(["received_at" => $now]);

        return redirect()->route('invoices.show', $invoice)->with('message', __('Marcada correctamente'));
    }
}
