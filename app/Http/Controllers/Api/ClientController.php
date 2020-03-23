<?php

namespace App\Http\Controllers\Api;

use App\Entities\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveClientRequest;
use App\Actions\Clients\GetClientsAction;
use App\Actions\Clients\StoreClientsAction;
use App\Actions\Clients\UpdateClientsAction;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Client::class);
    }

    public function index(GetClientsAction $action, Request $request)
    {
        $clients = $action->execute(new Client(), $request);
        return $clients->get();
    }

    public function store(StoreClientsAction $action, SaveClientRequest $request)
    {
        return $action->execute(new Client(), $request);
    }

    public function show(Client $client)
    {
        $client->load('invoices.products');
        return $client;
    }

    public function update(UpdateClientsAction $action, Client $client,
                           SaveClientRequest $request)
    {
        $client = $action->execute($client, $request);

        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente',
        ], 200);
    }
}
