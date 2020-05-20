<?php

namespace App\Actions\Clients;

use App\Actions\Action;
use App\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class GetClientsAction extends Action
{
    public function action(Model $client, array $request)
    {
        $authUser = auth()->user() ?? $request['authUser'];

        if ($authUser->can('viewAll', Client::class)) {
            $client = $client->id($request['id'] ?? '');
        } elseif ($authUser->can('viewAssociated', Client::class)) {
            $client = $client->creatorId($authUser);
        }

        return $client->with(['type_document', 'invoices', 'user', 'creator'])
            ->typedocument($request['type_document_id'] ?? '')
            ->document($request['document'] ?? '')
            ->email($request['email'] ?? '')
            ->cellphone($request['cellphone'] ?? '')
            ->orderBy('document');
    }
}
