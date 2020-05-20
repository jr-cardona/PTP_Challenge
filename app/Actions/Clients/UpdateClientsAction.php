<?php

namespace App\Actions\Clients;

use App\Entities\User;
use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class UpdateClientsAction extends Action
{
    public function action(Model $client, array $request): Model
    {
        $user = User::find($client->id);
        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->email = $request['email'];
        $user->update();

        $client->type_document_id = $request['type_document_id'];
        $client->document = $request['document'];
        $client->phone = $request['phone'] ?? '';
        $client->cellphone = $request['cellphone'];
        $client->address = $request['address'];
        $client->update();

        return $client;
    }
}
