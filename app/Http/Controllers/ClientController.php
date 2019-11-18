<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\SaveClientRequest;
use App\Http\Requests\SaveInvoiceRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index', [
            'clients' => Client::all()
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'client' => new Client
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
            'client' => $client
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

        return redirect('/clients')->with('message', 'Cliente eliminado satisfactoriamente');
    }
}
