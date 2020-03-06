<?php

namespace App\Http\Controllers;

use Config;
use App\Client;
use Illuminate\Http\Request;
use App\Exports\ClientsExport;
use App\Http\Requests\SaveClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::with(["type_document"])
            ->id($request->get('id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'))
            ->orderBy('name');
        if(! empty($request->get('format'))){
            return (new ClientsExport($clients->get()))
                ->download('clients-list.'.$request->get('format'));
        } else {
            $paginate = Config::get('constants.paginate');
            $count = $clients->count();
            $clients = $clients->paginate($paginate);

            return response()->view('clients.index', [
                'clients' => $clients,
                'request' => $request,
                'count' => $count,
                'paginate' => $paginate
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function store(SaveClientRequest $request)
    {
        $result = Client::create($request->validated());

        return redirect()->route('clients.show', $result->id)->withSuccess(__('Cliente creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
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
    public function edit(Client $client)
    {
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
    public function update(SaveClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)->withSuccess(__('Cliente actualizado satisfactoriamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Client $client)
    {
        if ($client->invoices->count() > 0){
            return redirect()->back()->withError(__('No se puede eliminar, tiene facturas asociadas'));
        } else{
            $client->delete();
            return redirect()->route('clients.index')->withSuccess(__('Cliente eliminado satisfactoriamente'));
        }
    }
}
