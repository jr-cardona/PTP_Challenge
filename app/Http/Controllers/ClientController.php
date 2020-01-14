<?php

namespace App\Http\Controllers;

use App\Client;
use App\TypeDocument;
use Illuminate\Http\Request;
use App\Http\Requests\SaveClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $clients = Client::orderBy('name')
            ->client($request->get('client_id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'))
            ->paginate(10);
        return response()->view('clients.index', [
            'clients' => $clients,
            'request' => $request,
            'side_effect' => __('Se borrarán todas sus facturas asociadas')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return response()->view('clients.create', [
            'client' => new Client,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveClientRequest $request) {
        $result = Client::create($request->validated());

        return redirect()->route('clients.show', $result->id)->with('message', __('Cliente creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client) {
        return response()->view('clients.show', [
            'client' => $client,
            'side_effect' => __('Se borrarán todas sus facturas asociadas')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) {
        return response()->view('clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveClientRequest $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveClientRequest $request, Client $client) {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)->with('message', __('Cliente actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Client $client) {
        $client->delete();

        return redirect()->route('clients.index')->with('message', __('Cliente eliminado satisfactoriamente'));
    }

    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     */
    public function search(Request $request) {
        $clients = Client::where('name', 'like', '%'. $request->name .'%')
            ->orderBy('name')
            ->limit('100')
            ->get();
        echo $clients;
    }
}
