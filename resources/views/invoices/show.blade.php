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
                    <td style="width: 25%">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Estado:</td>
                    <td style="width: 25%">{{ $invoice->status }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de creación:</td>
                    <td style="width: 25%">{{ $invoice->created_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de modificación:</td>
                    <td style="width: 25%">{{ $invoice->updated_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de expedición:</td>
                    <td style="width: 25%">{{ $invoice->issued_at }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Fecha de vencimiento:</td>
                    <td style="width: 25%">{{ $invoice->overdued_at }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">IVA:</td>
                    <td class="phone">{{ $invoice->vat }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Valor total:</td>
                    <td style="width: 25%">${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                </tr>
                <tr>
                    <td class="table-dark" style="width: 15%; text-align: right">Descripción:</td>
                    <td style="width: 25%";>{{ $invoice->description }}</td>

                    <td class="table-dark" style="width: 15%; text-align: right">Cliente:</td>
                    <td style="width: 25%">
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
                        <th class="text-center">CANTIDAD</th>
                        <th>DESCRIPCIÓN</th>
                        <th class="text-right">PRECIO UNITARIO</th>
                        <th class="text-right">PRECIO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $subtotal = 0 }}
                    {{ $iva = $invoice->vat / 100 }}
                    @foreach($invoice->products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }}</td>
                            <td class="text-center">{{ $product->name }}</td>
                            <td class="text-center">{{ $product->pivot->quantity }}</td>
                            <td>{{ $product->description }}</td>
                            <td class="text-right">${{ number_format($product->pivot->unit_price, 2) }}</td>
                            <td class="text-right">${{ number_format($product->pivot->total_price, 2) }}</td>
                        </tr>
                        {{ $subtotal += $product->pivot->total_price }}
                   @endforeach
                    <tr>
                        <td class="text-right" colspan="5">SUBTOTAL</td>
                        <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">IVA ({{ $invoice->vat }})% </td>
                        <td class="text-right">${{ number_format($subtotal * $iva, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5">GRAN TOTAL</td>
                        <td class="text-right">${{ number_format($subtotal * ($iva + 1), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="{{ route('invoices.createDetail', $invoice) }}" class="btn btn-success">
            Agregar Detalle
        </a>
    </div>
@endsection
