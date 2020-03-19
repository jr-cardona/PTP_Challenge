@extends('layouts.show')
@section('Title', 'Ver Cliente')
@section('Back')
    <div>
        @can('index', $client)
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
            </a>
        @endcan
    </div>
    <div>
        @can('create', App\Client::class)
            <a class="btn btn-success" href="{{ route('clients.create') }}">
                <i class="fa fa-plus"></i> {{ __("Crear nuevo cliente") }}
            </a>
        @endcan
    </div>
@endsection
@section('Name')
    {{ $client->user->fullname }}
@endsection
@section('Buttons')
    @include('clients._buttons')
@endsection
@section('Body')
    <div class="shadow">
        <div class="card-header text-center"><h3>{{ __("Datos generales") }}</h3></div>
        <table class="table border-rounded table-sm">
            <tr>
                <td class="table-dark td-title">{{ __("Tipo de documento:") }}</td>
                <td class="td-content">{{ $client->type_document->fullname }}</td>

                <td class="table-dark td-title">{{ __("Número de documento:") }}</td>
                <td class="td-content">{{ $client->document }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Fecha de creación:")}}</td>
                <td class="td-content">{{ $client->created_at->isoFormat('Y-MM-DD hh:mma') }}</td>

                <td class="table-dark td-title">{{ __("Fecha de modificación:")}}</td>
                <td class="td-content">{{ $client->updated_at->isoFormat('Y-MM-DD hh:mma') }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Número telefónico:")}}</td>
                <td class="td-content">{{ $client->phone }}</td>

                <td class="table-dark td-title">{{ __("Celular:")}}</td>
                <td class="td-content">{{ $client->cellphone }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Dirección:")}}</td>
                <td class="td-content">{{ $client->address }}</td>

                <td class="table-dark td-title">{{ __("Correo electrónico:")}}</td>
                <td class="td-content">{{ $client->user->email }}</td>
            </tr>
            <tr>
                <td class="table-dark td-title">{{ __("Creado por:")}}</td>
                <td class="td-content">{{ $client->user->creator->fullname }}</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="shadow">
        <div class="card-header justify-content-between d-flex">
            <div class="col-md-1"></div>
            <h3 class="col-md-3">{{ __("Facturas asociadas") }}</h3>
            @can('create', App\Invoice::class)
                <a class="btn btn-success"
                   href="{{ route('invoices.create', ["client_id" => $client->id, "client" => $client->user->fullname]) }}" >
                    <i class="fa fa-plus"></i>
                </a>
            @else
                <div class="col-md-1"></div>
            @endcan
        </div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>{{ __("Título") }}</th>
                    <th>{{ __("Fecha de expedición") }}</th>
                    <th>{{ __("Fecha de vencimiento") }}</th>
                    <th>{{ __("Valor") }}</th>
                    <th>{{ __("Estado") }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($client->invoices as $invoice)
                @can('view', $invoice)
                    <tr>
                        <td>
                            <a @can('view', $invoice)
                                href="{{ route('invoices.show', $invoice) }}" target="_blank"
                                @endcan>
                                {{ __("Factura de venta No.")}} {{ $invoice->id }}
                            </a>
                        </td>
                        <td>{{ $invoice->issued_at->toDateString() }}</td>
                        <td>{{ $invoice->expires_at->toDateString() }}</td>
                        <td>${{ number_format($invoice->total, 2) }}</td>
                        @include('invoices.status_label')
                    </tr>
                @endcan
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
