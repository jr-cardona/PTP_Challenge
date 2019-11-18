@extends('layouts.app')
@section('title', 'Ver Cliente')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Cliente: {{ $client->id }}</h1>
        </div>
        <div class="card-body">
            @include('clients._buttons')
            <p></p>
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Nombre:</td>
                    <td>{{ $client->name }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Documento:</td>
                    <td>{{ $client->type_document }} {{ $client->sic_code }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Creado:</td>
                    <td>{{ $client->created_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Modificado:</td>
                    <td>{{ $client->updated_at }}</td>

                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Número telefónico:</td>
                    <td>{{ $client->phone_number }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Celular:</td>
                    <td>{{ $client->cell_phone_number }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Dirección:</td>
                    <td>{{ $client->address }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Correo electrónico:</td>
                    <td>{{ $client->email }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Facturas:</td>
                    <td>
                        @if($client->invoices->isEmpty())
                            Sin facturas asociadas
                        @else
                            <ul>
                                @foreach($client->invoices as $invoice)
                                    <li>
                                        <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                                            Factura de venta No. {{ $invoice->number }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endisset
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
