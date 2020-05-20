<?php

namespace App\Http\Controllers;

use Exception;
use App\Entities\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Display a listing of the resource.
     * @param GetClientsAction $action
     * @param Request $request
     * @return Response
     */
    public function index(GetClientsAction $action, Request $request)
    {
        $clients = $action->execute(new Client(), $request->all())
            ->paginate($request->get('per_page'));

        return response()->view('clients.index', compact('clients', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Client $client
     * @return Response
     */
    public function create(Client $client)
    {
        return response()->view('clients.create', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientsAction $action
     * @param SaveClientRequest $request
     * @return RedirectResponse
     */
    public function store(StoreClientsAction $action, SaveClientRequest $request)
    {
        $client = $action->execute(new Client(), $request->validated());

        return redirect()->route('clients.show', $client->id)
            ->with('success', ('Cliente creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return Response
     */
    public function show(Client $client)
    {
        $client->load('invoices.products');
        $invoices = $client->invoices()->simplePaginate();

        return response()->view('clients.show', compact('client', 'invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return Response
     */
    public function edit(Client $client)
    {
        return response()->view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientsAction $action
     * @param SaveClientRequest $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(
        UpdateClientsAction $action,
        Client $client,
        SaveClientRequest $request
    ) {
        $client = $action->execute($client, $request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', ('Cliente actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Client $client)
    {
        $client->user->delete();

        return redirect()->route('clients.index')->with('success', ('Cliente eliminado satisfactoriamente'));
    }
}
