<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Exports\SellersExport;
use App\Exports\ProductsExport;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export a listing of the resource.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function invoices(){
        return Excel::download(new InvoicesExport, 'invoices-list.xlsx');
    }

    public function clients(){
        return Excel::download(new ClientsExport, 'clients-list.xlsx');
    }

    public function sellers(){
        return Excel::download(new SellersExport, 'sellers-list.xlsx');
    }

    public function products(){
        return Excel::download(new ProductsExport, 'products-list.xlsx');
    }
}
