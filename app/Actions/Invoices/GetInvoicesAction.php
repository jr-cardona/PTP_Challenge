<?php

namespace App\Actions\Invoices;

use App\Actions\Action;
use App\Entities\Invoice;
use Illuminate\Database\Eloquent\Model;

class GetInvoicesAction extends Action
{
    public function action(Model $invoice, array $request)
    {
        $authUser = auth()->user() ?? $request['authUser'];

        if ($authUser->can('viewAll', Invoice::class)){
            $invoice = $invoice->allSellers($request['created_by'] ?? '')
                ->allClients($request['client_id'] ?? '');

        } elseif ($authUser->can('viewAssociated', Invoice::class)) {
            $invoice = $authUser->isClient() ? $invoice->clientId($authUser) : $invoice->sellerId($authUser);
        }

        return $invoice->with(['client.user', 'seller', 'updater', 'products'])
            ->number($request['number'] ?? '')
            ->product($request['product_id'] ?? '')
            ->issuedDate(
                $request['issued_init'] ?? '',
                $request['issued_final'] ?? ''
            )
            ->expiresDate(
                $request['expires_init'] ?? '',
                $request['expires_final'] ?? ''
            )
            ->state($request['state'] ?? '')
            ->orderBy('id', 'DESC');
    }
}
