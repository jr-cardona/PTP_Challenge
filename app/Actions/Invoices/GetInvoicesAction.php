<?php


namespace App\Actions\Invoices;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class GetInvoicesAction extends Action
{
    public function action(Model $invoice, Request $request)
    {
        return $invoice->with(['client', 'seller', 'updater', 'products'])
            ->number($request->get('number'))
            ->seller($request->get('created_by'))
            ->client($request->get('client_id'))
            ->product($request->get('product_id'))
            ->issuedDate(
                $request->get('issued_init'),
                $request->get('issued_final'))
            ->expiresDate(
                $request->get('expires_init'),
                $request->get('expires_final'))
            ->state($request->get('state'))
            ->orderBy('id', 'DESC');
    }
}
