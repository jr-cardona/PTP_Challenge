@extends('layouts.app')
@section('title', 'Facturas')
@section('content')
    <div class="row">
        <div class="col">
            <h1>Facturas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a class="btn btn-success" href="{{ route('invoices.create') }}">Crear nueva factura</a>
        </div>
    </div>
    <br>
    <table class="table border-rounded table-striped">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col">Título</th>
                <th scope="col" nowrap>Fecha de expedición</th>
                <th scope="col" nowrap>Fecha de vencimiento</th>
                <th scope="col">Valor total</th>
                <th scope="col">Estado</th>
                <th scope="col">Cliente</th>
                <th scope="col" colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr class="text-center">
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" target="_blank">
                            Factura de venta No. {{ $invoice->id }}
                        </a>
                    </td>
                    <td>{{ $invoice->issued_at }}</td>
                    <td>{{ $invoice->overdued_at }}</td>
                    <td>${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                    <td>{{ $invoice->state->name }}</td>
                    <td>
                        <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                            {{ $invoice->client->name }}
                        </a>
                    </td>
                    @include('invoices._buttons')
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
