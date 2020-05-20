@extends('layouts.index')
@section('Title', 'Clientes')
@section('Left-buttons')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
        <i class="fa fa-filter"></i> {{ __("Filtrar") }}
    </button>
    <a href="{{ route('clients.index') }}" class="btn btn-danger">
        <i class="fa fa-undo"></i> {{ __("Limpiar") }}
    </a>
    @include('clients.__search_modal')
@endsection
@section('Name')
    {{ __("Clientes") }}
@endsection
@section('Right-buttons')
    @can('export', App\Entities\Client::class)
        <button type="button" class="btn btn-success"
                data-toggle="modal"
                data-target="#exportModal"
                data-route="{{ route('clients.export') }}">
            <i class="fa fa-file-download"></i> {{ __("Exportar") }}
        </button>
    @endcan
@endsection
@section('Paginator')
    @include('partials.__pagination', [
        'from'  => $clients->firstItem() ?? 0,
        'to'    => $clients->lastItem() ?? 0,
        'total' => $clients->total(),
    ])
@endsection
@section('Links')
    {{ $clients->appends($request->all())->links() }}
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
                <a href="{{ route('clients.show', $client) }}">{{ $client->fullname }}</a>
            </td>
            <td>{{ $client->type_document->name . ". " . $client->document }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->cellphone }}</td>
            <td>{{ $client->creator->fullname }}</td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('clients.__buttons')
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
