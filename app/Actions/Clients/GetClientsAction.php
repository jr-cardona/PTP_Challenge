<?php


namespace App\Actions\Clients;

use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class GetClientsAction extends Action
{
    public function action(Model $client, Request $request)
    {
        return $client->with(['type_document', 'invoices'])
            ->id($request->get('id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'))
            ->orderBy('document');
    }
}
