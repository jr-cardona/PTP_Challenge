<?php

namespace App\Http\Controllers;

use App\Client;
use App\TypeDocument;
use Illuminate\Http\Request;
use App\Http\Requests\SaveClientRequest;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id = $request->get('client_id');
        $name = $request->get('client');
        $type_document_id = $request->get('type_document_id');
        $document = $request->get('document');
        $email = $request->get('email');

        $clients = Client::orderBy('name')
            ->client($id)
            ->typedocument($type_document_id)
            ->document($document)
            ->email($email)
            ->paginate(10);
        return view('clients.index', [
            'clients' => $clients,
            'type_documents' => TypeDocument::all(),
            'request' => $request,
            'side_effect' => 'Se borrarán todas sus facturas asociadas'
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
            'client' => $client,
            'side_effect' => 'Se borrarán todas sus facturas asociadas'
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
