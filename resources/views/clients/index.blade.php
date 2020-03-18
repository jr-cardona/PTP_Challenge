@extends('layouts.index')
@section('Title', 'Clientes')
@section('Name')
    {{ __("Clientes") }}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i>
    </button>
    <a href="{{ route('clients.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i>
    </a>
@endsection
@section('Actions')
    @can('export', App\Client::class)
        <button type="button" class="btn btn-warning" data-route="{{ route('clients.index') }}" data-toggle="modal" data-target="#exportModal">
            <i class="fa fa-file"></i> {{ __("Exportar") }}
        </button>
    @endcan
    @can('import', App\Client::class)
        <button type="button" class="btn btn-warning" data-route="{{ route('import.clients') }}" data-toggle="modal" data-target="#importModal">
            <i class="fa fa-file-excel"></i> {{ __("Importar desde Excel") }}
        </button>
    @endcan
    @can('create', App\Client::class)
        <a class="btn btn-success" href="{{ route('clients.create') }}">
            <i class="fa fa-plus"></i> {{ __("Crear nuevo cliente") }}
        </a>
    @endcan
@endsection
@section('Search')
    @include('clients.__search_modal')
@endsection
@section('Header')
    <th class="text-center" nowrap>{{ __("Nombre completo") }}</th>
    <th class="text-center" nowrap>{{ __("Documento") }}</th>
    <th class="text-center" nowrap>{{ __("Correo electrónico") }}</th>
    <th class="text-center" nowrap>{{ __("Celular") }}</th>
    <th class="text-center" nowrap>{{ __("Creado por") }}</th>
    <th></th>
@endsection
@section('Body')
    @forelse($clients as $client)
        <tr class="text-center">
            <td>
                <a href="{{ route('clients.show', $client) }}">{{ $client->user->fullname }}</a>
            </td>
            <td>{{ $client->type_document->name . ". " . $client->document }}</td>
            <td>{{ $client->user->email }}</td>
            <td>{{ $client->cellphone }}</td>
            <td>{{ $client->user->creator->fullname }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('clients._buttons')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="p-3">
                <p class="alert alert-secondary text-center">
                    {{ __('No se encontraron clientes') }}
                </p>
            </td>
        </tr>
    @endforelse
@endsection
@section('Links')
    {{ $clients->appends($request->all())->links() }}
@endsection
