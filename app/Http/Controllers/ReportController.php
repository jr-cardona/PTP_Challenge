<?php

namespace App\Http\Controllers;

use Config;
use App\Entities\Report;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\UtilitiesExport;
use Illuminate\Support\Facades\DB;
use App\Exports\DebtorClientsExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * @return Response
     * @throws AuthorizationException
     */
    public function general()
    {
        $this->authorize('viewGeneral', Report::class);
        return response()->view('reports.general');
    }

    /**
     * @param Request $request
     * @return Response|BinaryFileResponse
     * @throws AuthorizationException
     */
    public function debtorClients(Request $request)
    {
        $this->authorize('viewGeneral', Report::class);
        $vat = (Config::get('constants.vat') / 100) + 1;
        $clients = DB::table('users as u')
            ->select(DB::raw('c.id, concat(u.name, " " ,u.surname) as fullname, c.cellphone,
            c.phone, c.address, sum(ip.unit_price * ip.quantity) as total_due'))
            ->join('clients as c', 'c.id', '=', 'u.id')
            ->join('invoices as i', 'i.client_id', '=', 'c.id')
            ->join('invoice_product as ip', 'ip.invoice_id', '=', 'i.id')
            ->join('products as p', 'p.id', '=', 'ip.product_id')
            ->whereNull('i.paid_at')
            ->whereNull('i.annulled_at')
            ->groupBy('c.id')
            ->orderBy('total_due', 'desc')
            ->get();

        if (! empty($request->get('format'))) {
            return (new DebtorClientsExport($clients, $vat))
                ->download('debtor-clients-list.'.$request->get('format'));
        } else {
            return response()->view('reports.clients.debtors', [
                'clients' => $clients,
                'vat' => $vat
            ]);
        }
    }

    /**
     * @param Request $request
     * @return Response|BinaryFileResponse
     * @throws AuthorizationException
     */
    public function utilities(Request $request)
    {
        $this->authorize('viewGeneral', Report::class);
        $vat = (Config::get('constants.vat') / 100) + 1;
        $invoices = DB::table('invoices as i')
            ->select(DB::raw('i.id, c.id as client_id, concat(u.name, " " , u.surname) as client_fullname,
             SUM(p.price * ip.quantity) AS income, SUM(p.cost * ip.quantity) AS expenses,
             (SUM(p.price * ip.quantity) - SUM(p.cost * ip.quantity)) as utility, i.paid_at'))
            ->join('invoice_product as ip', 'ip.invoice_id', '=', 'i.id')
            ->join('products as p', 'p.id', '=', 'ip.product_id')
            ->join('clients as c', 'i.client_id', '=', 'c.id')
            ->join('users as u', 'u.id', '=', 'c.id')
            ->whereNotNull('i.paid_at')
            ->whereNull('i.annulled_at')
            ->groupBy('i.id')
            ->orderBy('utility', 'desc')
            ->get();

        if (! empty($request->get('format'))) {
            return (new UtilitiesExport($invoices, $vat))
                ->download('utilities-list.'.$request->get('format'));
        } else {
            return response()->view('reports.invoices.utilities', [
                'invoices' => $invoices,
                'vat' => $vat
            ]);
        }
    }

    /**
     * @return Response
     * @throws AuthorizationException
     */
    public function generated()
    {
        $this->authorize('viewGenerated', Report::class);
        $reports = Report::with('user');
        if (auth()->user()->can('reports.list.all')) {
            //
        } elseif (auth()->user()->can('reports.list.associated')) {
            $reports = $reports->where('created_by', auth()->user()->id);
        }
        $reports = $reports->paginate();

        return response()->view('reports.generated', compact('reports'));
    }

    /**
     * @param Report $report
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function download(Report $report)
    {
        $this->authorize('download', $report);

        return Storage::download($report->file_path, $report->file_name);
    }

    /**
     * @param Report $report
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);
        Storage::delete($report->file_path);
        $report->delete();

        return redirect()->back()->with('success', 'Borrado exitosamente');
    }
}
