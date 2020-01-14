@extends('layouts.show')
@section('Title', 'Ver Factura')
@section('Back')
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> {{ __("Volver") }}
    </a>
    @if($invoice->state_id == "1")
        <a href="{{ route('invoices.payments.create', $invoice) }}" class="btn btn-success">
            <i class="fa fa-dollar-sign"></i> {{ __("Pagar") }}
        </a>
        @empty($invoice->received_at)
            <a href="{{ route('invoices.receivedCheck', $invoice) }}" class="btn btn-primary">
                <i class="fa fa-check"></i> {{ __("Marcar como recibida") }}
            </a>
        @endempty
    @endif
@endsection
@section('Name')
    {{ __("Factura de venta No.") }} {{$invoice->number }}
@endsection
@section('Buttons')
    @include('invoices._buttons')
@endsection
@section('Body')
    <table class="table border-rounded table-sm">
        <tr>
            <td class="table-dark td-title">{{ __("Fecha de recibo:") }}</td>
            <td class="td-content">{{ $invoice->received_at == '' ? "Sin fecha" : $invoice->received_at }}</td>

            <td class="table-dark td-title">{{ __("Estado:") }}</td>
            <td class="td-content">{{ $invoice->state->name }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Fecha de creación:") }}</td>
            <td class="td-content">{{ $invoice->created_at }}</td>

            <td class="table-dark td-title" nowrap>{{ __("Fecha de modificación:") }}</td>
            <td class="td-content">{{ $invoice->updated_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Fecha de expedición:") }}</td>
            <td class="td-content">{{ $invoice->issued_at }}</td>

            <td class="table-dark td-title">{{ __("Fecha de vencimiento:") }}</td>
            <td class="td-content">{{ $invoice->overdued_at }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("IVA:") }}</td>
            <td class="td-content">{{ $invoice->vat }}%</td>

            <td class="table-dark td-title">{{ __("Valor total:") }}</td>
            <td class="td-content">${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Vendedor:") }}</td>
            <td class="td-content">
                <a href="{{ route('sellers.show', $invoice->seller) }}" target="_blank">
                    {{ $invoice->seller->name }}
                </a>
            </td>

            <td class="table-dark td-title">{{ __("Cliente:") }}</td>
            <td class="td-content">
                <a href="{{ route('clients.show', $invoice->client) }}" target="_blank">
                    {{ $invoice->client->name }}
                </a>
            </td>
        </tr>
        <tr>
            <td class="table-dark td-title">{{ __("Descripción:") }}</td>
            <td class="td-content">{{ $invoice->description }}</td>
        </tr>
    </table>
    <br>
    <div class="col-md-12">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="text-center" nowrap>{{ __("CÓDIGO") }}</th>
                    <th class="text-center" nowrap>{{ __("NOMBRE") }}</th>
                    <th class="text-center" nowrap>{{ __("DESCRIPCIÓN") }}</th>
                    <th class="text-center" nowrap>{{ __("CANTIDAD") }}</th>
                    <th class="text-right" nowrap>{{ __("PRECIO UNITARIO") }}</th>
                    <th class="text-right" nowrap>{{ __("PRECIO TOTAL") }}</th>
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
                    <td class="text-right" colspan="5">{{ __("SUBTOTAL") }}</td>
                    <td class="text-right">${{ number_format($invoice->getSubtotalAttribute(), 2) }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5">{{ __("IVA") }} ({{ $invoice->vat }})% </td>
                    <td class="text-right">${{ number_format($invoice->getIvaAmountAttribute(), 2) }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5">{{ __("GRAN TOTAL") }}</td>
                    <td class="text-right">${{ number_format($invoice->getTotalAttribute(), 2) }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('invoiceDetails.create', $invoice) }}" class="btn btn-success btn-block">
            <i class="fa fa-plus"></i> {{ __("Agregar Detalle") }}
        </a>
    </div>
@endsection
