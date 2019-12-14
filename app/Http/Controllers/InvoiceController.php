<?php

namespace App\Http\Controllers;

use App\State;
use App\Invoice;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use App\Imports\InvoicesImport;
use App\Http\Requests\SaveInvoiceRequest;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{


    public function index(Request $request)
    {
        $invoices = Invoice::orderBy('id', 'DESC')
            ->number($request->get('number'))
            ->state($request->get('state_id'))
            ->client($request->get('client_id'))
            ->seller($request->get('seller_id'))
            ->issuedDate($request->get('issued_init'), $request->get('issued_final'))
            ->overduedDate($request->get('overdued_init'), $request->get('overdued_final'))
            ->paginate(10);
        return view('invoices.index', [
            'invoices' => $invoices,
            'states' => State::all(),
            'request' => $request,
            'side_effect' => 'Se borrarán todos sus detalles asociados'
        ]);
    }

    public function create()
    {
        return view('invoices.create', [
            'invoice' => new Invoice,
            'states' => State::all(),
        ]);
    }

    public function store(SaveInvoiceRequest $request)
    {
        Invoice::create($request->validated());

        return redirect()->route('invoices.index')->with('message', 'Factura creada satisfactoriamente');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', [
            'invoice' => $invoice,
            'side_effect' => 'Se borrarán todos sus detalles asociados'
        ]);
    }

    public function edit(Invoice $invoice)
    {
        return view('invoices.edit', [
            'invoice' => $invoice,
            'states' => State::all()
        ]);
    }

    public function update(SaveInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoices.show', $invoice)->with('message', 'Factura actualizada satisfactoriamente');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('message', 'Factura eliminada satisfactoriamente');
    }

    public function exportExcel(){
        return Excel::download(new InvoicesExport, 'invoices-list.xlsx');
    }

    public function importExcel(Request $request){
        $this->validate($request, [
            'invoices' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('invoices');
        try {
            Excel::import(new InvoicesImport(), $file);
            return back()->with('message', 'Importación completada correctamente');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return view('invoices.importErrors', [
                'failures' => $failures_sorted,
            ]);
        }
    }
}
