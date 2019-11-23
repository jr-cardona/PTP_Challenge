@extends('layouts.app')
@section('title', 'Ver Factura')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Factura de venta No. {{ $invoice->id }}</h1>
        </div>
        <div class="card-body">
            <div class="btn-group">
                @include('invoices._buttons')
            </div>
            <p></p>
            <table class="table border-rounded table-sm">
                <tr>
                    <td class="table-dark td-title">Fecha de recibo:</td>
                    <td class="td-content">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at }}</td>

                    <td class="table-dark td-title">Estado:</td>
                    <td class="td-content">{{ $invoice->status }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title">Fecha de creación:</td>
                    <td class="td-content">{{ $invoice->created_at }}</td>

                    <td class="table-dark td-title">Fecha de modificación:</td>
                    <td class="td-content">{{ $invoice->updated_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title">Fecha de expedición:</td>
                    <td class="td-content">{{ $invoice->issued_at }}</td>

                    <td class="table-dark td-title">Fecha de vencimiento:</td>
                    <td class="td-content">{{ $invoice->overdued_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title">IVA:</td>
                    <td class="td-content">{{ $invoice->vat }}%</td>

                    <td class="table-dark td-title">Valor total:</td>
                    <td class="td-content">${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                </tr>
                <tr>
                    <td class="table-dark td-title">Descripción:</td>
                    <td class="td-content";>{{ $invoice->description }}</td>

                    <td class="table-dark td-title">Cliente:</td>
                    <td class="td-content">
                        <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                            {{ $invoice->client->name }}
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="details" class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">CÓDIGO</th>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center">DESCRIPCIÓN</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-right">PRECIO UNITARIO</th>
                        <th class="text-right">PRECIO TOTAL</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td class="text-center">{{ $product->name }}</td>
                            <td class="text-center">{{ $product->description }}</td>
                            <td class="text-center">{{ $product->pivot->quantity }}</td>
                            <td class="text-right">${{ number_format($product->pivot->unit_price, 2) }}</td>
                            <td class="text-right">${{ number_format($product->pivot->total_price, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('invoices.editDetail', $invoice, $product) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" onclick="document.getElementById('delete-detail').submit()">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete-detail" method="POST" action="{{ route('invoices.destroyDetail', $invoice, $product->pivot->id) }}" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                   @endforeach
                    <tr>
                        <td class="text-right" colspan="5">SUBTOTAL</td>
                        <td class="text-right">${{ number_format($invoice->getSubtotalAttribute(), 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">IVA ({{ $invoice->vat }})% </td>
                        <td class="text-right">${{ number_format($invoice->getIvaAmountAttribute(), 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">GRAN TOTAL</td>
                        <td class="text-right">${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="{{ route('invoices.createDetail', $invoice) }}" class="btn btn-success">
            Agregar Detalle
        </a>
    </div>
@endsection
