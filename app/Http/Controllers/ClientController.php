<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\SaveClientRequest;
use App\TypeDocument;

class ClientController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', [
            'clients' => $clients
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Client,
            'type_documents' => TypeDocument::all()
        ]);
    }

    public function store(SaveClientRequest $request)
    {
        Client::create($request->validated());

        return redirect()->route('clients.index')->with('message', 'Cliente creado satisfactoriamente');
    }

    public function show(Client $client)
    {
        return view('clients.show', [
            'client' => $client
        ]);
    }

    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client' => $client,
            'type_documents' => TypeDocument::all()
        ]);
    }

    public function update(SaveClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)->with('message', 'Cliente actualizado satisfactoriamente');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('message', 'Cliente eliminado satisfactoriamente');
    }
}
