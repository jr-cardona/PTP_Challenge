<?php

namespace App\Http\Controllers;

use Config;
use App\Entities\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Exports\UtilitiesExport;
use Illuminate\Support\Facades\DB;
use App\Exports\DebtorClientsExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(){
        return view('reports.index');
    }

    /**
     * @param Request $request
     * @return View|BinaryFileResponse
     */
    public function clients(Request $request){
        $vat = (Config::get('constants.vat') / 100) + 1;
        $clients = DB::table('users as u')
            ->select(DB::raw('c.id, concat(u.name, " " ,u.surname) as fullname, c.cellphone,
            c.phone, c.address, sum(ip.unit_price * ip.quantity) as total_due'))
            ->join('clients as c', 'c.user_id', '=', 'u.id')
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

    public function utilities(Request $request){
        $vat = (Config::get('constants.vat') / 100) + 1;
        $invoices = DB::table('invoices as i')
            ->select(DB::raw('i.id, c.id as client_id, concat(u.name, " " , u.surname) as client_fullname,
             SUM(p.price * ip.quantity) AS income, SUM(p.cost * ip.quantity) AS expenses,
             (SUM(p.price * ip.quantity) - SUM(p.cost * ip.quantity)) as utility, i.paid_at'))
            ->join('invoice_product as ip', 'ip.invoice_id', '=', 'i.id')
            ->join('products as p', 'p.id', '=', 'ip.product_id')
            ->join('clients as c', 'i.client_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'c.user_id')
            ->whereNotNull('i.paid_at')
            ->whereNull('i.annulled_at')
            ->groupBy('i.id')
            ->orderBy('utility', 'desc')
            ->get();

        if(! empty($request->get('format'))){
            return (new UtilitiesExport($invoices, $vat))
                ->download('utilities-list.'.$request->get('format'));
        } else {
            return view('reports.invoices.utilities', [
                'invoices' => $invoices,
                'vat' => $vat
            ]);
        }
    }
}
