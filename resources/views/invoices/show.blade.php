@extends('layouts.app')
@section('title', 'Ver Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Factura de venta No. {{ $invoice->number }}</h1>
        </div>
        <div class="card-body">
            @include('invoices._buttons')
            <p></p>
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de facturación:</td>
                    <td>{{ $invoice->invoice_date }}</td>

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
                    <td>{{ $invoice->expedition_date }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de vencimiento:</td>
                    <td>{{ $invoice->due_date }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">IVA:</td>
                    <td class="phone">{{ $invoice->vat }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Valor total:</td>
                    <td class="phone">${{ $invoice->total }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Cliente:</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}" target="_blank">
                            {{ $invoice->client->name }}
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
