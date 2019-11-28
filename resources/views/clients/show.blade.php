@extends('layouts.show')
@section('Title', 'Ver Cliente')
@section('Back')
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
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
            <td class="table-dark td-title">Nombre:</td>
            <td class="td-content">{{ $client->name }}</td>

            <td class="table-dark td-title">Documento:</td>
            <td class="td-content">{{ $client->type_document->name }} {{ $client->document }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Creado:</td>
            <td class="td-content">{{ $client->created_at }}</td>

            <td class="table-dark td-title">Modificado:</td>
            <td class="td-content">{{ $client->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Número telefónico:</td>
            <td class="td-content">{{ $client->phone_number }}</td>

            <td class="table-dark td-title">Celular:</td>
            <td class="td-content">{{ $client->cell_phone_number }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Dirección:</td>
            <td class="td-content">{{ $client->address }}</td>

            <td class="table-dark td-title">Correo electrónico:</td>
            <td class="td-content">{{ $client->email }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Facturas:</td>
            <td class="td-content">
                @if($client->invoices->isEmpty())
                    Sin facturas asociadas
                @else
                    <ul>
                        @foreach($client->invoices as $invoice)
                            <li>
                                <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                                    Factura de venta No. {{ $invoice->id }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endisset
            </td>
        </tr>
    </table>
@endsection
