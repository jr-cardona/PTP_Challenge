<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\InvoicesImport;
use App\Imports\ClientsImport;
use App\Imports\SellersImport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Imports a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function invoices(Request $request){
        $this->validate($request, [
            'invoices' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('invoices');
        try {
            Excel::import(new InvoicesImport(), $file);
            return redirect()->route('invoices.index')->withSuccess(__('Importación completada correctamente'));
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return response()->view('imports.invoices', [
                'failures' => $failures_sorted,
            ]);
        }
    }

    /**
     * Imports a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function clients(Request $request){
        $this->validate($request, [
            'clients' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('clients');
        try {
            Excel::import(new ClientsImport(), $file);
            return redirect()->route('clients.index')->withSuccess(__('Importación completada correctamente'));
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return response()->view('imports.clients', [
                'failures' => $failures_sorted,
            ]);
        }
    }

    public function sellers(Request $request){
        $this->validate($request, [
            'sellers' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('sellers');
        try {
            Excel::import(new SellersImport(), $file);
            return redirect()->route('sellers.index')->withSuccess(__('Importación completada correctamente'));
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return response()->view('imports.sellers', [
                'failures' => $failures_sorted,
            ]);
        }
    }

    public function products(Request $request){
        $this->validate($request, [
            'products' => 'required|mimes:xls,xlsx'
        ]);
        $file = $request->file('products');
        try {
            Excel::import(new ProductsImport(), $file);
            return redirect()->route('products.index')->withSuccess(__('Importación completada correctamente'));
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures_unsorted = $e->failures();
            $failures_sorted = array();
            foreach($failures_unsorted as $failure) {
                $failures_sorted[$failure->row()][$failure->attribute()] = $failure->errors()[0];
            }
            return response()->view('imports.products', [
                'failures' => $failures_sorted,
            ]);
        }
    }
}
