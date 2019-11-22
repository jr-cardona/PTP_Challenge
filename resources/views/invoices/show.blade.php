@extends('layouts.app')
@section('title', 'Ver Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Factura de venta No. {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            @include('invoices._buttons')
            <p></p>
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de recibo:</td>
                    <td>{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Estado:</td>
                    <td>{{ $invoice->status }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Creado:</td>
                    <td>{{ $invoice->created_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Modificado:</td>
                    <td>{{ $invoice->updated_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de expedición:</td>
                    <td>{{ $invoice->issued_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de vencimiento:</td>
                    <td>{{ $invoice->overdued_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">IVA:</td>
                    <td class="phone">{{ $invoice->vat }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Valor total:</td>
                    <td class="phone">${{ $invoice->total }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Descripción:</td>
                    <td>{{ $invoice->description }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Cliente:</td>
                    <td>
                        <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                            {{ $invoice->client->name }}
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <a href="{{ route('invoices.createDetail', $invoice) }}" class="btn btn-success">
            Agregar Detalle
        </a>
    </div>
@endsection
