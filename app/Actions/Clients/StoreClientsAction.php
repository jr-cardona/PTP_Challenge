<?php


namespace App\Actions\Clients;

use App\Entities\User;
use App\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class StoreClientsAction extends Action
{
    public function action(Model $client, Request $request): Model
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->save();
        $user->assignRole('Client');

        $client->id = $user->id;
        $client->type_document_id = $request->input('type_document_id');
        $client->document = $request->input('document');
        $client->phone = $request->input('phone');
        $client->cellphone = $request->input('cellphone');
        $client->address = $request->input('address');
        $client->save();

        return $client;
    }
}
