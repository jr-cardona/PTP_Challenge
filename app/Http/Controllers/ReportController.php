<?php

namespace App\Http\Controllers;

use App\Exports\DebtorClientsExport;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        return view('reports.index');
    }

    public function clients(Request $request){
        $vat = (Config::get('constants.vat') / 100) + 1;
        $clients = DB::table('clients as c')
            ->select(DB::raw('c.id, concat(c.name, " " ,c.surname) as fullname, c.cell_phone_number,
            c.phone_number, c.address, sum(ip.unit_price * ip.quantity) as total_due'))
            ->join('invoices as i', 'i.client_id', '=', 'c.id')
            ->join('invoice_product as ip', 'ip.invoice_id', '=', 'i.id')
            ->join('products as p', 'p.id', '=', 'ip.product_id')
            ->whereNull('i.paid_at')
            ->whereNull('i.annulled_at')
            ->groupBy('c.id')
            ->orderBy('total_due', 'desc')
            ->get();

        if(! empty($request->get('format'))){
            return (new DebtorClientsExport($clients, $vat))
                ->download('debtor-clients-list.'.$request->get('format'));
        } else {
            return view('reports.clients.debtors', [
                'clients' => $clients,
                'vat' => $vat
            ]);
        }
    }
}
