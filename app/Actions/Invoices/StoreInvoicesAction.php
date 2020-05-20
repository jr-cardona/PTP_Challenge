<?php

namespace App\Actions\Invoices;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StoreInvoicesAction extends Action
{
    public function action(Model $invoice, array $request)
    {
        return $invoice->create($request);
    }
}
