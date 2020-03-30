<?php


namespace App\Actions\Invoices;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class StoreInvoicesAction extends Action
{
    public function action(Model $invoice, Request $request): Model
    {
        return $invoice->create($request->validated());
    }
}
