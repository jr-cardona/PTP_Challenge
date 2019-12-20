<?php

namespace App\Http\Controllers;

use App\Client;
use App\TypeDocument;
use Illuminate\Http\Request;
use App\Http\Requests\SaveClientRequest;

class ClientController extends Controller
{


    public function index(Request $request) {
        $clients = Client::orderBy('name')
            ->client($request->get('client_id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'))
            ->paginate(10);
        return view('clients.index', [
            'clients' => $clients,
            'request' => $request,
            'side_effect' => 'Se borrarán todas sus facturas asociadas'
        ]);
    }

    public function create() {
        return view('clients.create', [
            'client' => new Client,
        ]);
    }

    public function store(SaveClientRequest $request) {
        Client::create($request->validated());

        return redirect()->route('clients.index')->with('message', 'Cliente creado satisfactoriamente');
    }

    public function show(Client $client) {
        return view('clients.show', [
            'client' => $client,
            'side_effect' => 'Se borrarán todas sus facturas asociadas'
        ]);
    }

    public function edit(Client $client) {
        return view('clients.edit', [
            'client' => $client,
        ]);
    }

    public function update(SaveClientRequest $request, Client $client) {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)->with('message', 'Cliente actualizado satisfactoriamente');
    }

    public function destroy(Client $client) {
        $client->delete();

        return redirect()->route('clients.index')->with('message', 'Cliente eliminado satisfactoriamente');
    }

    public function search(Request $request) {
        $clients = Client::where('name', 'like', '%'. $request->name .'%')
            ->orderBy('name')
            ->limit('100')
            ->get();
        echo $clients;
    }
}
