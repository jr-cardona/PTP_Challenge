@extends('layouts.show')
@section('Title', 'Ver Cliente')
@section('Back')
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
@endsection
@section('Name')
    {{ $client->name }}
@endsection
@section('Buttons')
    @include('clients._buttons')
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">{{ __("Nombre:") }}</td>
            <td class="td-content">{{ $client->name }}</td>

            <td class="table-dark td-title">{{ __("Documento:") }}</td>
            <td class="td-content">{{ $client->type_document->name }} {{ $client->document }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Creado:")}}</td>
            <td class="td-content">{{ $client->created_at }}</td>

            <td class="table-dark td-title">{{ __("Modificado:")}}</td>
            <td class="td-content">{{ $client->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Número telefónico:")}}</td>
            <td class="td-content">{{ $client->phone_number }}</td>

            <td class="table-dark td-title">{{ __("Celular:")}}</td>
            <td class="td-content">{{ $client->cell_phone_number }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Dirección:")}}</td>
            <td class="td-content">{{ $client->address }}</td>

            <td class="table-dark td-title">{{ __("Correo electrónico:")}}</td>
            <td class="td-content">{{ $client->email }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Facturas:")}}</td>
            <td class="td-content">
                @if($client->invoices->isEmpty())
                    {{ __("Sin facturas asociadas")}}
                @else
                    <ul>
                        @foreach($client->invoices as $invoice)
                            <li>
                                <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                                    {{ __("Factura de venta No.")}} {{ $invoice->id }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </td>
        </tr>
    </table>
@endsection
