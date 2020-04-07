<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Client;
use App\Entities\Invoice;
use App\Entities\Product;
use App\Exports\UsersExport;
use Illuminate\Http\Response;
use App\Exports\ClientsExport;
use App\Exports\InvoicesExport;
use App\Exports\ProductsExport;
use App\Jobs\NotifyCompletedExport;
use App\Http\Requests\ExportRequest;
use Illuminate\Http\RedirectResponse;
use App\Actions\Users\GetUsersAction;
use App\Actions\Clients\GetClientsAction;
use App\Actions\Products\GetProductsAction;
use Illuminate\Auth\Access\AuthorizationException;

class ExportController extends Controller
{
    protected $extension;
    protected $filters;

    public function __construct(ExportRequest $request)
    {
        $this->extension = $request->get('extension');
        $this->filters = $request->get('filters', []);
    }

    /**
     * Exports a listing of the resource.
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function invoices(){
        $this->authorize('export', Invoice::class);

        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm-ss');
        $filePath = "invoices_$now.$this->extension";

        (new InvoicesExport($this->filters, auth()->user()))
            ->store($filePath)
            ->chain([new NotifyCompletedExport(auth()->user(), $filePath)]);

        return redirect()->back()
            ->with('success', 'Exportación iniciada, se le notificará cuando haya finalizado');
    }

    /**
     * Exports a listing of the resource.
     * @param GetClientsAction $action
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function clients(GetClientsAction $action){
        $this->authorize('export', Client::class);

        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm-ss');
        $filePath = "clients_$now.$this->extension";
        //$filePath = "test.$this->extension";

        (new ClientsExport($this->filters, auth()->user()))
            ->queue($filePath)
            ->chain([new NotifyCompletedExport(auth()->user(), $filePath)]);

        return redirect()->back()
            ->with('success', 'Exportación iniciada, se le notificará cuando haya finalizado');
    }

    /**
     * Exports a listing of the resource.
     * @param GetProductsAction $action
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function products(GetProductsAction $action){
        $this->authorize('export', Product::class);

        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm-ss');
        $filePath = "products_$now.$this->extension";

        (new ProductsExport($this->filters, auth()->user()))
            ->store($filePath)
            ->chain([new NotifyCompletedExport(auth()->user(), $filePath)]);

        return redirect()->back()
            ->with('success', 'Exportación iniciada, se le notificará cuando haya finalizado');
    }

    /**
     * Exports a listing of the resource.
     * @param GetUsersAction $action
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function users(GetUsersAction $action){
        $this->authorize('export', User::class);

        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm-ss');
        $filePath = "users_$now.$this->extension";

        (new UsersExport($this->filters, auth()->user()))
            ->store($filePath)
            ->chain([new NotifyCompletedExport(auth()->user(), $filePath)]);

        return redirect()->back()
            ->with('success', 'Exportación iniciada, se le notificará cuando haya finalizado');
    }
}
