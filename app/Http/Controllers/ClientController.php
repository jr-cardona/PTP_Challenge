<?php

namespace App\Http\Controllers;

use Config;
use App\User;
use Exception;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\ClientsExport;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SaveClientRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', new Client());

        $clients = Client::with(['type_document', 'invoices'])
            ->creator()
            ->id($request->get('id'))
            ->typedocument($request->get('type_document_id'))
            ->document($request->get('document'))
            ->email($request->get('email'));
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
     * @return Response
     * @throws AuthorizationException
     */
    public function create(Client $client)
    {
        $this->authorize('create', $client);

        return response()->view('clients.create', [
            'client' => $client,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaveClientRequest $request
     * @param Client $client
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SaveClientRequest $request, Client $client, User $user)
    {
        $this->authorize('create', $client);

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->password = bcrypt('secret');
        $user->creator_id = auth()->id();
        $user->save();

        $client->user_id = $user->id;
        $client->type_document_id = $request->input('type_document_id');
        $client->document = $request->input('document');
        $client->phone = $request->input('phone');
        $client->cellphone = $request->input('cellphone');
        $client->address = $request->input('address');
        $client->save();

        return redirect()->route('clients.show', $client->id)->withSuccess(__('Cliente creado satisfactoriamente'));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        return response()->view('clients.show', [
            'client' => $client,
            'side_effect' => __('Se borrarán todas sus facturas asociadas')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Client $client)
    {
        $this->authorize('edit', $client);

        return response()->view('clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaveClientRequest $request
     * @param Client $client
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(SaveClientRequest $request, Client $client)
    {
        $this->authorize('edit', $client);

        $user = User::find($client->user->id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->password = $request->input('document');
        $user->save();

        $client->type_document_id = $request->input('type_document_id');
        $client->document = $request->input('document');
        $client->phone = $request->input('phone');
        $client->cellphone = $request->input('cellphone');
        $client->address = $request->input('address');
        $client->save();

        return redirect()->route('clients.show', $client)->withSuccess(__('Cliente actualizado satisfactoriamente'));
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
        $this->authorize('delete', $client);

        if ($client->invoices->count() > 0){
            return redirect()->back()->withError(__('No se puede eliminar, tiene facturas asociadas'));
        } else{
            $client->delete();
            return redirect()->route('clients.index')->withSuccess(__('Cliente eliminado satisfactoriamente'));
        }
    }
}
