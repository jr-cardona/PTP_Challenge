@extends('layouts.index')
@section('Title', 'Facturas')
@section('Name', 'Facturas')
@section('Create')
    <a class="btn btn-success" href="{{ route('invoices.create') }}">Crear nueva factura</a>
@endsection
@section('Links')
    {{ $invoices->links() }}
@endsection
@section('Header')
    <th scope="col" nowrap>Título</th>
    <th scope="col" nowrap>Fecha de expedición</th>
    <th scope="col" nowrap>Fecha de vencimiento</th>
    <th scope="col" nowrap>Valor total</th>
    <th scope="col" nowrap>Estado</th>
    <th scope="col" nowrap>Cliente</th>
    <th scope="col" nowrap>Opciones</th>
@endsection
@section('Body')
    @foreach($invoices as $invoice)
        <tr class="text-center">
            <td nowrap>
                <a href="{{ route('invoices.show', $invoice) }}">
                    Factura de venta No. {{ str_pad($invoice->id, 3, "0", STR_PAD_LEFT) }}
                </a>
            </td>
            <td nowrap>{{ $invoice->issued_at }}</td>
            <td nowrap>{{ $invoice->overdued_at }}</td>
            <td nowrap>${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
            <td nowrap>{{ $invoice->state->name }}</td>
            <td nowrap>
                <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                    {{ $invoice->client->name }}
                </a>
            </td>
            <td class="btn-group btn-group-sm" nowrap>
                @include('invoices._buttons')
            </td>
        </tr>
    @endforeach
@endsection
