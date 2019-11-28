@extends('layouts.show')
@section('Title', 'Ver Factura')
@section('Back')
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
@endsection
@section('Name')
    Factura de venta No. {{ str_pad($invoice->id, 3, "0", STR_PAD_LEFT) }}
@endsection
@section('Buttons')
    @include('invoices._buttons')
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">Fecha de recibo:</td>
            <td class="td-content">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at }}</td>

            <td class="table-dark td-title">Estado:</td>
            <td class="td-content">{{ $invoice->state->name }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">Fecha de creación:</td>
            <td class="td-content">{{ $invoice->created_at }}</td>

            <td class="table-dark td-title" nowrap>Fecha de modificación:</td>
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
            <td class="table-dark td-title">Vendedor:</td>
            <td class="td-content">
                <a href="{{ route('sellers.show', $invoice->seller) }}" target="_blank">
                    {{ $invoice->seller->name }}
                </a>
            </td>

            <td class="table-dark td-title">Cliente:</td>
            <td class="td-content">
                <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                    {{ $invoice->client->name }}
                </a>
            </td>
        </tr>
        <tr>
            <td class="table-dark td-title">Descripción:</td>
            <td class="td-content">{{ $invoice->description }}</td>
        </tr>
    </table>
    <br>
    <div class="col-md-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="text-center" nowrap>CÓDIGO</th>
                    <th class="text-center" nowrap>NOMBRE</th>
                    <th class="text-center" nowrap>DESCRIPCIÓN</th>
                    <th class="text-center" nowrap>CANTIDAD</th>
                    <th class="text-right" nowrap>PRECIO UNITARIO</th>
                    <th class="text-right" nowrap>PRECIO TOTAL</th>
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
                        <td class="text-right">${{ number_format($product->pivot->unit_price * $product->pivot->quantity, 2) }}</td>
                        <td class="text-right">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('invoiceDetails.edit', [$invoice, $product]) }}" class="btn btn-link" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" form="deleteDetail{{ $product->id }}" class="btn btn-link text-danger" title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <form id="deleteDetail{{ $product->id }}" action="{{ route('invoiceDetails.destroy', [$invoice, $product]) }}" method="post">
                                @method('DELETE')
                                @csrf()
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
        <a href="{{ route('invoiceDetails.create', $invoice) }}" class="btn btn-success btn-block">
            Agregar Detalle
        </a>
    </div>
@endsection
