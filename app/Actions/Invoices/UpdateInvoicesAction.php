<?php


namespace App\Actions\Invoices;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class UpdateInvoicesAction extends Action
{
    public function action(Model $invoice, array $request): Model
    {
        $invoice->update($request);
        return $invoice;
    }
}
